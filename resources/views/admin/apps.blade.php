@extends('layouts.dashboard')

@section('page_title', 'Application Fleet')

@section('content')
<div class="space-y-8 pb-32">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-black font-syne mb-2">Global <span class="text-cyan-400">Application</span> Fleet</h1>
        <p class="text-gray-500 font-medium">Monitoring all active applications across the HotPatch ecosystem.</p>
    </div>

    <!-- Apps Table -->
    <div class="border border-white/5 rounded-[40px] bg-white/[0.02] overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-white/5 text-gray-600 font-black uppercase tracking-widest text-[9px] bg-white/[0.01]">
                    <th class="px-8 py-6">Identity</th>
                    <th class="px-8 py-6">Owner</th>
                    <th class="px-8 py-6">Tier</th>
                    <th class="px-8 py-6">Created</th>
                    <th class="px-8 py-6 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($apps as $app)
                <tr class="group hover:bg-white/[0.02] transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/5 rounded-2xl flex items-center justify-center font-bold text-xs uppercase tracking-tighter">{{ substr($app->name, 0, 1) }}</div>
                            <div>
                                <p class="font-black text-white text-base">{{ $app->name }}</p>
                                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $app->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-white font-bold">{{ $app->owner->display_name ?? $app->owner->email }}</p>
                        <p class="text-[10px] text-gray-600 truncate max-w-[120px]">{{ $app->owner->email }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[10px] font-black rounded-full uppercase tracking-widest">{{ $app->tier }}</span>
                    </td>
                    <td class="px-8 py-6 text-[10px] font-mono text-gray-500">{{ $app->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-6 text-right">
                        <span class="px-2 py-0.5 bg-green-500/10 text-green-400 border border-green-500/20 text-[9px] font-black rounded-full uppercase tracking-tighter">OPERATIONAL</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center text-gray-700 italic">No applications found in the system.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
