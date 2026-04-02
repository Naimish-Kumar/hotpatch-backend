<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\HotpatchApp;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function webIndex(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        
        $query = Device::where('app_id', $app->id);

        if ($request->has('platform') && $request->platform !== 'all') {
            $query->where('platform', $request->platform);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('device_id', 'like', "%{$search}%")
                  ->orWhere('current_version', 'like', "%{$search}%");
            });
        }

        $devices = $query->orderBy('last_seen', 'desc')->paginate(50);

        return view('devices', [
            'devices' => $devices,
            'app' => $app,
            'initialPlatform' => $request->query('platform', 'all'),
            'initialSearch' => $request->query('search', ''),
        ]);
    }

    public function index(Request $request)
    {
        $appId = $request->input('app_id');
        $devices = Device::where('app_id', $appId)->get();
        return response()->json(['devices' => $devices]);
    }
}
