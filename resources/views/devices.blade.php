@extends('layouts.dashboard')

@section('page_title', 'Device Fleet')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h3 class="text-2xl font-black font-syne text-white">Device Fleet</h3>
            <div class="px-2 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $devices->total() }} REPORTED</div>
        </div>
        <div class="flex gap-4">
            <form action="{{ route('devices') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ $initialSearch }}" placeholder="Search device ID..." class="h-input py-2.5 px-4 text-xs w-64 focus:w-80">
                <svg class="w-4 h-4 text-gray-600 absolute right-4 top-1/2 -translate-y-1/2 group-focus-within:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <select name="platform" class="h-input py-2.5 px-4 text-xs w-48">
                <option value="all" @if($initialPlatform === 'all') selected @endif>All Platforms</option>
                <option value="android" @if($initialPlatform === 'android') selected @endif>Android</option>
                <option value="ios" @if($initialPlatform === 'ios') selected @endif>iOS</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="border border-white/5 rounded-[32px] bg-white/[0.01] overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-white/5 text-gray-600 font-black uppercase tracking-widest text-[9px] bg-white/[0.01]">
                    <th class="px-8 py-5">Device Identity</th>
                    <th class="px-8 py-5 text-center">Version Map</th>
                    <th class="px-8 py-5">Last Activity</th>
                    <th class="px-8 py-5">Platform Metadata</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($devices as $device)
                <tr class="group hover:bg-white/[0.02]">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/5 rounded-2xl flex items-center justify-center font-black text-xs uppercase tracking-tighter text-cyan-400 border border-white/5 group-hover:border-cyan-500/20 transition-all font-mono">{{ substr($device->device_id, 0, 4) }}</div>
                            <div>
                                <p class="font-black text-white text-base font-mono tracking-tighter">{{ $device->device_id }}</p>
                                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $device->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex flex-col items-center gap-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ $device->base_version }}</span>
                                <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                <span class="text-xs font-black text-cyan-400 px-1.5 py-0.5 bg-cyan-500/10 rounded-md border border-cyan-500/20">{{ $device->current_version }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full @if($device->last_seen > now()->subMinutes(15)) animate-pulse @else grayscale brightness-50 @endif"></span>
                            <span class="text-xs font-bold text-white">{{ $device->last_seen->diffForHumans() }}</span>
                        </div>
                        <p class="text-[10px] text-gray-600 font-black uppercase tracking-widest">Seen at {{ $device->last_seen->format('H:i:s') }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-white/5 px-2 py-1 rounded w-fit mb-1 border border-white/5">{{ $device->platform }} {{ $device->os_version }}</p>
                        <p class="text-[10px] text-gray-600">{{ $device->model }} • {{ $device->bundle_id }}</p>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <button class="p-2.5 border border-white/5 rounded-xl hover:bg-white/10 text-gray-500 hover:text-white transition-all shadow-xl group/btn overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/0 via-cyan-500/0 to-cyan-500/20 group-hover/btn:scale-150 transition-transform"></div>
                            <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="text-4xl grayscale opacity-30 mb-6">📡</div>
                            <h4 class="text-xl font-bold font-syne mb-2 text-white/50 italic tracking-tighter">Radio Silence</h4>
                            <p class="text-gray-700 text-sm italic">Waiting for the first device to report in...</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $devices->appends(request()->query())->links() }}
    </div>
</div>
@endsection
