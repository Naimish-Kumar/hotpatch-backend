<?php

namespace App\Http\Controllers;

use App\Models\PricingPackage;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $packages = PricingPackage::where('is_active', true)->get();

        // Seed if empty
        if ($packages->isEmpty()) {
            $this->seedDefaults();
            $packages = PricingPackage::where('is_active', true)->get();
        }

        return view('pricing', [
            'packages' => $packages
        ]);
    }

    public function list()
    {
        return response()->json(PricingPackage::where('is_active', true)->get());
    }

    private function seedDefaults()
    {
        $defaults = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'price' => 0,
                'description' => 'For developers getting started.',
                'features' => 'Up to 50 active devices;1 App;Unlimited hotpatches;Community support',
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 49,
                'description' => 'For growing mobile teams.',
                'features' => 'Up to 5,000 active devices;Unlimited apps;Incremental rollouts;Priority email support',
                'stripe_price_id' => 'price_pro_monthly',
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 299,
                'description' => 'For mission-critical apps.',
                'features' => 'Custom device limits;SLA guarantees;On-premise edge nodes;24/7 Phone support',
                'stripe_price_id' => 'price_ent_monthly',
            ],
        ];

        foreach ($defaults as $d) {
            PricingPackage::create(array_merge($d, ['id' => (string) \Illuminate\Support\Str::uuid()]));
        }
    }
}
