@extends('layouts.dashboard')

@section('page_title', 'Control Center')

@section('content')
<div class="space-y-12 pb-32">
    <!-- Admin Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="p-8 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest pl-2 mb-2">Total Apps</p>
            <h3 class="text-4xl font-black font-syne">{{ number_format($stats['total_apps']) }}</h3>
        </div>
        <div class="p-8 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest pl-2 mb-2">Total Users</p>
            <h3 class="text-4xl font-black font-syne">{{ number_format($stats['total_users']) }}</h3>
        </div>
        <div class="p-8 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest pl-2 mb-2">Total Releases</p>
            <h3 class="text-4xl font-black font-syne">{{ number_format($stats['total_releases']) }}</h3>
        </div>
        <div class="p-8 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest pl-2 mb-2">Global Devices</p>
            <h3 class="text-4xl font-black font-syne">{{ number_format($stats['total_devices']) }}</h3>
        </div>
    </div>

    <!-- System Status -->
    <div class="p-10 border border-white/5 rounded-[40px] bg-white/[0.02]">
        <div class="flex items-center justify-between mb-10">
            <h4 class="text-2xl font-black font-syne">System Infrastructure</h4>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-green-400 font-bold uppercase tracking-widest text-xs">{{ strtoupper($stats['status']) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="p-6 border border-white/5 rounded-3xl bg-black/40">
                <p class="text-xs font-bold text-gray-500 mb-2 uppercase">CDN Performance</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black font-mono">14ms</span>
                    <span class="text-green-500 text-[10px] font-black">▲ 0.4%</span>
                </div>
            </div>
            <div class="p-6 border border-white/5 rounded-3xl bg-black/40">
                <p class="text-xs font-bold text-gray-500 mb-2 uppercase">S3 Storage Usage</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black font-mono">1.4 TB</span>
                    <span class="text-gray-600 text-[10px] font-black">OF 10 TB</span>
                </div>
            </div>
            <div class="p-6 border border-white/5 rounded-3xl bg-black/40">
                <p class="text-xs font-bold text-gray-500 mb-2 uppercase">API Response Time</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black font-mono">28ms</span>
                    <span class="text-green-500 text-[10px] font-black">▲ 1.2%</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
