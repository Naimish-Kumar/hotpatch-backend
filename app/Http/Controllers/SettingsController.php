<?php

namespace App\Http\Controllers;

use App\Models\HotpatchApp;
use App\Models\Webhook;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function webIndex(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        $webhooks = Webhook::where('app_id', $app->id)->get();

        return view('settings', [
            'app' => $app,
            'webhooks' => $webhooks,
        ]);
    }

    public function updateApp(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        
        $oldName = $app->name;
        $app->update(['name' => $request->name]);

        $this->logAction($app->id, 'app.update', $app->id, "Name changed from {$oldName} to {$request->name}");

        return response()->json($app);
    }

    public function listWebhooks()
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        return response()->json(Webhook::where('app_id', $app->id)->get());
    }

    public function createWebhook(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'events' => 'required|array',
        ]);
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();

        $webhook = Webhook::create([
            'id' => (string) Str::uuid(),
            'app_id' => $app->id,
            'url' => $request->url,
            'events' => implode(',', $request->events),
            'secret' => 'whsec_' . Str::random(32),
        ]);

        $this->logAction($app->id, 'webhook.create', $webhook->id, $request->url);

        return response()->json($webhook, 201);
    }

    public function deleteWebhook($id)
    {
        $webhook = Webhook::findOrFail($id);
        $webhook->delete();
        $this->logAction($webhook->app_id, 'webhook.delete', $id);
        return response()->json(['message' => 'Webhook deleted']);
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
