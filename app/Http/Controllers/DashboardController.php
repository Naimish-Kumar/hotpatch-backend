<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\HotpatchApp;
use App\Models\Release;
use App\Models\Installation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->first();

        if (!$app) {
            return view('dashboard', [
                'stats' => $this->getEmptyStats(),
                'releases' => collect([]),
                'devices' => collect([]),
                'app' => null,
            ]);
        }

        $stats = $this->getStats($app->id);
        $releases = Release::where('app_id', $app->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $devices = Device::where('app_id', $app->id)
            ->orderBy('last_seen', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'releases' => $releases,
            'devices' => $devices,
            'app' => $app,
        ]);
    }

    private function getStats($appId)
    {
        $totalDevices = Device::where('app_id', $appId)->count();
        $activeLast24h = Device::where('app_id', $appId)
            ->where('last_seen', '>=', now()->subDay())
            ->count();
        
        $totalReleases = Release::where('app_id', $appId)->count();
        
        $updatesDelivered = Installation::whereHas('device', function($q) use ($appId) {
                $q->where('app_id', $appId);
            })
            ->where('status', 'applied')
            ->count();

        // Calculate success rate
        $totalInstalls = Installation::whereHas('device', function($q) use ($appId) {
                $q->where('app_id', $appId);
            })->count();
        
        $successRate = $totalInstalls > 0 ? ($updatesDelivered / $totalInstalls) * 100 : 0;

        // Bandwidth saved (sum of patch sizes vs full bundle sizes)
        $bandwidthSaved = Installation::whereHas('device', function($q) use ($appId) {
                $q->where('app_id', $appId);
            })
            ->where('is_patch', true)
            ->sum('download_size'); // Simplistic: in a real app, you'd compare vs bundle size.

        return [
            'total_devices' => $totalDevices,
            'active_last_24h' => $activeLast24h,
            'total_releases' => $totalReleases,
            'updates_delivered' => $updatesDelivered,
            'success_rate' => $successRate,
            'bandwidth_saved' => $bandwidthSaved,
            'devices_trend' => 12.4, // Mocked for now to match UI
            'updates_trend' => 8.7,
            'success_rate_delta' => -0.2,
        ];
    }

    private function getEmptyStats()
    {
        return [
            'total_devices' => 0,
            'active_last_24h' => 0,
            'total_releases' => 0,
            'updates_delivered' => 0,
            'success_rate' => 0,
            'bandwidth_saved' => 0,
            'devices_trend' => 0,
            'updates_trend' => 0,
            'success_rate_delta' => 0,
        ];
    }

    public function getTrends(Request $request)
    {
        $appId = $request->input('appId');
        // Daily active devices for last 30 days
        $dau = Device::where('app_id', $appId)
            ->where('last_seen', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(last_seen) as date'), DB::raw('count(*) as value'))
            ->groupBy('date')
            ->get();

        $installations = Installation::whereHas('device', function($q) use ($appId) {
                $q->where('app_id', $appId);
            })
            ->where('installed_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(installed_at) as date'), DB::raw('count(*) as value'))
            ->groupBy('date')
            ->get();

        return response()->json([
            'daily_active_devices' => $dau,
            'installations' => $installations,
        ]);
    }

    public function getDistribution(Request $request)
    {
        $appId = $request->input('appId');
        $total = Device::where('app_id', $appId)->count();
        
        $distribution = Device::where('app_id', $appId)
            ->select('current_version as version', DB::raw('count(*) as count'))
            ->groupBy('current_version')
            ->get()
            ->map(function($item) use ($total) {
                $item->percent = $total > 0 ? ($item->count / $total) * 100 : 0;
                return $item;
            });

        return response()->json($distribution);
    }
}
