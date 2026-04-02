<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\HotpatchApp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@hotpatch.site'],
            [
                'id' => (string) Str::uuid(),
                'display_name' => 'HotPatch Admin',
                'password_hash' => Hash::make('admin123'),
                'is_super_admin' => true,
                'is_verified' => true,
            ]
        );

        // 2. Create Initial App for Admin
        $app = HotpatchApp::updateOrCreate(
            ['name' => 'Demo App'],
            [
                'id' => (string) Str::uuid(),
                'platform' => 'react_native',
                'api_key' => 'hp_live_' . Str::random(40),
                'owner_id' => $admin->id,
                'tier' => 'pro',
            ]
        );

        // 3. Create Pricing Packages
        $this->seedPricingPackages();

        // 4. Create Channels for the Demo App
        $this->seedChannels($app->id);

        // 5. Create Initial Blog Posts
        $this->seedBlogs();
    }

    private function seedPricingPackages()
    {
        $packages = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'Free',
                'slug' => 'free',
                'price' => 0,
                'description' => 'For independent developers and small trial apps.',
                'features' => '1,000 Active Devices;3 Projects;1 GB Monthly Bandwidth;Community Support'
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Pro',
                'slug' => 'pro',
                'price' => 49,
                'description' => 'Perfect for growing production apps with serious traffic.',
                'features' => '10,000 Active Devices;Unlimited Projects;10 GB Monthly Bandwidth;Priority Email Support'
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 299,
                'description' => 'Scale without limits. High availability for global fleets.',
                'features' => 'Unlimited Devices;Custom CDN;SLA & White-glove setup;Dedicated Support'
            ]
        ];

        foreach ($packages as $pkg) {
            \Illuminate\Support\Facades\DB::table('pricing_packages')->updateOrInsert(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }

    private function seedChannels($appId)
    {
        $channels = [
            ['id' => (string) Str::uuid(), 'app_id' => $appId, 'name' => 'Production', 'slug' => 'production'],
            ['id' => (string) Str::uuid(), 'app_id' => $appId, 'name' => 'Staging', 'slug' => 'staging'],
            ['id' => (string) Str::uuid(), 'app_id' => $appId, 'name' => 'Beta', 'slug' => 'beta'],
            ['id' => (string) Str::uuid(), 'app_id' => $appId, 'name' => 'Alpha', 'slug' => 'alpha'],
        ];

        foreach ($channels as $ch) {
            \Illuminate\Support\Facades\DB::table('channels')->updateOrInsert(
                ['app_id' => $appId, 'slug' => $ch['slug']],
                $ch
            );
        }
    }

    private function seedBlogs()
    {
        $posts = [
            [
                'id' => (string) Str::uuid(),
                'title' => 'Why OTA Updates are the Future of React Native',
                'slug' => 'why-ota-updates-are-the-future',
                'content' => '<h1>Efficiency and Speed.</h1><p>Bypassing the store review cycle with HotPatch allows you to iterate faster and fix critical bugs in seconds rather than days.</p>',
                'author' => 'HotPatch Engineering',
                'is_published' => true,
                'created_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'HotPatch v1.2: Introducing Atomic Rollouts',
                'slug' => 'hotpatch-v1-2-atomic-rollouts',
                'content' => '<h1>Safety first.</h1><p>Our new atomic rollout system ensures that your patches are either fully applied or not at all, preventing half-updated states.</p>',
                'author' => 'HotPatch Product Team',
                'is_published' => true,
                'created_at' => now()->subDay(),
            ]
        ];

        foreach ($posts as $post) {
            Blog::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
