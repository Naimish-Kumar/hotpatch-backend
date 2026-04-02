<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\AuditLog;
use App\Models\HotpatchApp;
use App\Models\SigningKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SecurityController extends Controller
{
    public function webIndex(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();

        $apiKeys = ApiKey::where('app_id', $app->id)->get();
        $signingKeys = SigningKey::where('app_id', $app->id)->get();
        $auditLogs = AuditLog::where('app_id', $app->id)->orderBy('created_at', 'desc')->limit(50)->get();

        return view('security', [
            'apiKeys' => $apiKeys,
            'signingKeys' => $signingKeys,
            'auditLogs' => $auditLogs,
            'app' => $app,
        ]);
    }

    public function createApiKey(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();

        $rawKey = 'hp_' . Str::random(40);
        $prefix = substr($rawKey, 0, 8);
        $hashedKey = hash('sha256', $rawKey);

        $apiKey = ApiKey::create([
            'id' => (string) Str::uuid(),
            'app_id' => $app->id,
            'name' => $request->name,
            'key' => $hashedKey,
            'prefix' => $prefix,
        ]);

        $this->logAction($app->id, 'security.api_key.create', $apiKey->id, "Name: {$request->name}");

        return response()->json([
            'api_key' => $apiKey,
            'raw_key' => $rawKey,
        ], 201);
    }

    public function deleteApiKey($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();
        $this->logAction($apiKey->app_id, 'security.api_key.delete', $id);
        return response()->json(['message' => 'API Key revoked']);
    }

    public function createSigningKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'public_key' => 'required|string',
        ]);
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();

        $signingKey = SigningKey::create([
            'id' => (string) Str::uuid(),
            'app_id' => $app->id,
            'name' => $request->name,
            'public_key' => $request->public_key,
        ]);

        $this->logAction($app->id, 'security.signing_key.create', $signingKey->id, "Name: {$request->name}");

        return response()->json($signingKey, 201);
    }

    public function deleteSigningKey($id)
    {
        $signingKey = SigningKey::findOrFail($id);
        $signingKey->delete();
        $this->logAction($signingKey->app_id, 'security.signing_key.delete', $id);
        return response()->json(['message' => 'Signing Key deleted']);
    }

    private function logAction($appId, $action, $entityId = null, $metadata = null)
    {
        AuditLog::create([
            'id' => (string) Str::uuid(),
            'app_id' => $appId,
            'actor' => auth()->user()->display_name ?? auth()->user()->email,
            'action' => $action,
            'entity_id' => $entityId,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
        ]);
    }
}
