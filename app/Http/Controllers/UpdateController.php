<?php

namespace App\Http\Controllers;

use App\Models\Release;
use App\Models\HotpatchApp;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    /**
     * GET /update/check
     * High-performance endpoint for device update checks.
     */
    public function check(Request $request)
    {
        $appId = $request->input('appId');
        $deviceId = $request->input('deviceId');
        $version = $request->input('version');
        $platform = $request->input('platform');
        $channel = $request->input('channel', 'production');

        if (!$appId || !$deviceId || !$version || !$platform) {
            return response()->json(['error' => 'appId, deviceId, version, and platform are required'], 400);
        }

        // Try Cache first
        $cacheKey = "release:active:{$appId}:{$channel}";
        $release = Cache::remember($cacheKey, 60, function () use ($appId, $channel) {
            return Release::where('app_id', $appId)
                ->where('channel', $channel)
                ->where('is_active', true)
                ->with('patches')
                ->latest()
                ->first();
        });

        if (!$release) {
            return response()->json(['updateAvailable' => false]);
        }

        // Check version
        if (!$this->isVersionGreater($release->version, $version)) {
            return response()->json(['updateAvailable' => false]);
        }

        // Rollout check
        if ($release->rollout_percentage < 100) {
            if (!$this->isInRollout($deviceId, $release->rollout_percentage)) {
                return response()->json(['updateAvailable' => false]);
            }
        }

        // Handle patch vs full bundle
        $bestArtifact = [
            'bundle_url' => $release->bundle_url,
            'hash'       => $release->hash,
            'signature'  => $release->signature,
            'is_patch'   => $release->is_patch,
            'base_version' => $release->base_version,
        ];

        foreach ($release->patches as $patch) {
            if ($patch->base_version === $version) {
                $bestArtifact = [
                    'bundle_url' => $patch->patch_url,
                    'hash'       => $patch->hash,
                    'signature'  => $patch->signature,
                    'is_patch'   => true,
                    'base_version' => $patch->base_version,
                ];
                break;
            }
        }

        return response()->json([
            'id'              => $release->id,
            'updateAvailable' => true,
            'bundleUrl'       => $bestArtifact['bundle_url'],
            'hash'            => $bestArtifact['hash'],
            'signature'       => $bestArtifact['signature'],
            'mandatory'       => $release->mandatory,
            'version'         => $release->version,
            'isEncrypted'     => $release->is_encrypted,
            'isPatch'         => $bestArtifact['is_patch'],
            'baseVersion'     => $bestArtifact['base_version'],
        ]);
    }

    private function isInRollout($deviceId, $rolloutPct)
    {
        $hash = crc32($deviceId); // Using crc32 as a simpler PHP equivalent to FNV for stable bucketing
        $bucket = abs($hash % 100);
        return $bucket < $rolloutPct;
    }

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
