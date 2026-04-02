<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Release;
use App\Models\Patch;
use App\Models\HotpatchApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReleaseController extends Controller
{
    public function webIndex(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        
        $query = Release::where('app_id', $app->id);

        if ($request->has('channel') && $request->channel !== 'all') {
            $query->where('channel', $request->channel);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        $releases = $query->orderBy('created_at', 'desc')->paginate(50);
        $channels = Channel::where('app_id', $app->id)->get();

        // Create default channels if none exist (standard behavior for new apps)
        if ($channels->isEmpty()) {
            $defaults = [
                ['name' => 'Production', 'slug' => 'production'],
                ['name' => 'Staging', 'slug' => 'staging'],
                ['name' => 'Beta', 'slug' => 'beta'],
            ];
            foreach ($defaults as $d) {
                Channel::create(array_merge($d, ['id' => (string) Str::uuid(), 'app_id' => $app->id]));
            }
            $channels = Channel::where('app_id', $app->id)->get();
        }

        return view('releases', [
            'releases' => $releases,
            'channels' => $channels,
            'app' => $app,
            'initialFilter' => $request->query('channel', 'all'),
            'initialStatus' => $request->query('status', 'all'),
        ]);
    }
    /**
     * POST /releases
     * Multipart form: "bundle" file + "metadata" JSON field
     */
    public function store(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail(); // Simplified: assuming one app per user for now or app_id in metadata

        $metadata = json_decode($request->input('metadata'), true);
        if (!$metadata) {
            return response()->json(['error' => 'Invalid metadata JSON'], 400);
        }

        // Custom validation for metadata
        $request->merge($metadata);
        $validated = $request->validate([
            'version'            => 'required|string',
            'channel'            => 'nullable|string',
            'platform'           => 'required|string|in:android,ios',
            'mandatory'          => 'boolean',
            'rollout_percentage' => 'nullable|integer|min:0|max:100',
            'hash'               => 'required|string',
            'signature'          => 'required|string',
            'is_encrypted'       => 'boolean',
            'is_patch'           => 'boolean',
            'base_version'       => 'nullable|string',
            'key_id'             => 'nullable|string',
            'size'               => 'required|integer',
        ]);

        $channel = $validated['channel'] ?? 'production';
        $rollout = $validated['rollout_percentage'] ?? 100;

        // Monotonic version check
        $latest = Release::where('app_id', $app->id)
            ->where('channel', $channel)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latest && !$this->isVersionGreater($validated['version'], $latest->version)) {
            return response()->json([
                'error' => "Monotonic versioning enforced: new version {$validated['version']} must be greater than current active version {$latest->version}"
            ], 400);
        }

        // Check tier for phased rollout
        if ($app->tier === 'free' && $rollout < 100) {
            return response()->json(['error' => 'Phased rollout is a Pro feature.'], 403);
        }

        if (!$request->hasFile('bundle')) {
            return response()->json(['error' => 'bundle file is required'], 400);
        }

        $file = $request->file('bundle');
        $objectKey = "bundles/{$app->id}/{$validated['platform']}/{$channel}/{$validated['version']}.zip";

        // Upload to S3
        $path = Storage::disk('s3')->put($objectKey, file_get_contents($file->getRealPath()));
        $bundleUrl = Storage::disk('s3')->url($objectKey);

        return DB::transaction(function () use ($app, $validated, $channel, $rollout, $objectKey, $bundleUrl) {
            // Deactivate previous releases in this channel
            Release::where('app_id', $app->id)
                ->where('channel', $channel)
                ->update(['is_active' => false]);

            $release = Release::create([
                'id'                 => (string) Str::uuid(),
                'app_id'             => $app->id,
                'version'            => $validated['version'],
                'channel'            => $channel,
                'bundle_url'         => $bundleUrl,
                'object_key'         => $objectKey,
                'hash'               => $validated['hash'],
                'signature'          => $validated['signature'],
                'mandatory'          => $validated['mandatory'] ?? false,
                'rollout_percentage' => $rollout,
                'is_encrypted'       => $validated['is_encrypted'] ?? false,
                'is_patch'           => $validated['is_patch'] ?? false,
                'base_version'       => $validated['base_version'],
                'key_id'             => $validated['key_id'],
                'size'               => $validated['size'],
                'is_active'          => true,
            ]);

            return response()->json($release, 201);
        });
    }

    public function index(Request $request)
    {
        $query = Release::where('app_id', $request->input('app_id'));

        if ($request->has('channel')) {
            $query->where('channel', $request->input('channel'));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->input('is_active') === 'true');
        }

        return response()->json($query->paginate($request->input('per_page', 20)));
    }

    public function show($id)
    {
        return response()->json(Release::findOrFail($id));
    }

    public function rollback($id)
    {
        $target = Release::findOrFail($id);

        DB::transaction(function () use ($target) {
            Release::where('app_id', $target->app_id)
                ->where('channel', $target->channel)
                ->update(['is_active' => false]);

            $target->update(['is_active' => true]);
        });

        return response()->json(['message' => 'Rollback successful', 'release' => $target]);
    }

    public function updateRollout(Request $request, $id)
    {
        $request->validate(['rollout_percentage' => 'required|integer|min:0|max:100']);
        $release = Release::findOrFail($id);
        
        $release->update(['rollout_percentage' => $request->rollout_percentage]);
        return response()->json(['message' => 'Rollout updated', 'rollout_percentage' => $request->rollout_percentage]);
    }

    public function destroy($id)
    {
        $release = Release::findOrFail($id);
        $release->delete(); // Soft delete if trait added, else hard delete.
        return response()->json(['message' => 'Release archived']);
    }

    public function addPatch(Request $request, $id)
    {
        $release = Release::findOrFail($id);
        $metadata = json_decode($request->input('metadata'), true);
        
        $request->merge($metadata);
        $validated = $request->validate([
            'base_version' => 'required|string',
            'hash'         => 'required|string',
            'signature'    => 'required|string',
            'size'         => 'required|integer',
        ]);

        $file = $request->file('patch');
        $objectKey = "patches/{$release->app_id}/{$release->id}/from-{$validated['base_version']}.patch";
        
        Storage::disk('s3')->put($objectKey, file_get_contents($file->getRealPath()));
        $patchUrl = Storage::disk('s3')->url($objectKey);

        $patch = Patch::create([
            'id'           => (string) Str::uuid(),
            'release_id'   => $release->id,
            'base_version' => $validated['base_version'],
            'patch_url'    => $patchUrl,
            'object_key'   => $objectKey,
            'hash'         => $validated['hash'],
            'signature'    => $validated['signature'],
            'size'         => $validated['size'],
        ]);

        return response()->json($patch, 201);
    }

    /**
     * Semantic version comparison helper.
     */
    private function isVersionGreater($v1, $v2)
    {
        $p1 = $this->parseVersion($v1);
        $p2 = $this->parseVersion($v2);

        for ($i = 0; $i < max(count($p1), count($p2)); $i++) {
            $a = $p1[$i] ?? 0;
            $b = $p2[$i] ?? 0;
            if ($a > $b) return true;
            if ($a < $b) return false;
        }
        return false;
    }

    private function parseVersion($v)
    {
        $v = ltrim($v, 'vV');
        $parts = explode('.', $v);
        return array_map(function ($p) {
            return (int) preg_replace('/[^0-9]/', '', $p);
        }, $parts);
    }
}
