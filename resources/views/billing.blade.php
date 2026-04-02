@extends('layouts.dashboard')

@section('page_title', 'Billing & Subscription')

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-32">
    <!-- Subscription Plan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <div class="p-10 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <div class="mb-10">
                <h4 class="text-2xl font-black font-syne mb-2">Current Subscription</h4>
                <p class="text-gray-500 text-sm">Update your plan and manage your payment methods.</p>
            </div>

            <div class="flex items-center gap-6 mb-10">
                <div class="w-16 h-16 bg-gradient-to-tr from-cyan-500 to-purple-500 rounded-3xl flex items-center justify-center font-black text-2xl text-black uppercase">
                    {{ substr($app->tier, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-3xl font-black font-syne tracking-tighter uppercase">{{ $app->tier }}</h3>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Status: Active</p>
                </div>
            </div>

            <div class="space-y-6 pt-10 border-t border-white/5">
                <div class="flex justify-between items-center text-sm">
                    <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px]">Next Invoice</p>
                    <p class="text-white font-black">May 01, 2026</p>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px]">Amount</p>
                    <p class="text-white font-black">$49.00 / month</p>
                </div>
            </div>

            <div class="pt-10 flex gap-4">
                <button class="px-8 py-4 bg-white text-black font-black text-xs rounded-full hover:bg-cyan-400 transition-all uppercase">UPGRADE PLAN</button>
                <form action="{{ route('billing') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-black text-xs rounded-full hover:bg-white/10 transition-all uppercase">PORTAL ACCESS</button>
                </form>
            </div>
        </div>

        <!-- Usage Stats -->
        <div class="p-10 border border-white/5 rounded-[40px] bg-white/[0.02]">
            <div class="mb-10 text-center">
                <h4 class="text-2xl font-black font-syne mb-2">Usage Limits</h4>
                <p class="text-gray-500 text-sm">Month-to-date consumption of your resources.</p>
            </div>

            <div class="space-y-10">
                <div>
                    <div class="flex items-center justify-between mb-3 px-2">
                        <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Active Devices</span>
                        <span class="text-xs font-black text-white">480 / 5,000</span>
                    </div>
                    <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-cyan-500" style="width: 9.6%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-3 px-2">
                        <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Updates Delivered</span>
                        <span class="text-xs font-black text-white">1.2M / Unlimited</span>
                    </div>
                    <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
