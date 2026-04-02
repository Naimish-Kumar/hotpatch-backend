@extends('layouts.dashboard')

@section('page_title', 'Account Settings')

@section('content')
<div class="max-w-4xl space-y-12 pb-20">
    <!-- General Settings -->
    <div class="p-10 border border-white/5 rounded-[40px] bg-white/[0.02]">
        <div class="mb-10">
            <h4 class="text-2xl font-black font-syne mb-2">General Settings</h4>
            <p class="text-gray-500 text-sm">Update your application metadata and platform settings.</p>
        </div>

        <form action="{{ route('settings') }}" method="POST" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-2">App Name</label>
                    <input type="text" name="name" value="{{ $app->name }}" class="h-input">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-2">APP ID</label>
                    <div class="w-full bg-white/[0.03] border border-white/5 rounded-2xl px-6 py-4 text-gray-500 font-mono text-sm select-all">{{ $app->id }}</div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest pl-2">Platform Type</label>
                    <div class="flex items-center gap-2">
                        <span class="px-4 py-2 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-black rounded-xl uppercase tracking-widest">{{ $app->platform }}</span>
                        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest leading-none">Cannot change platform type.</p>
                    </div>
                </div>
            </div>
            
            <div class="pt-6">
                <button type="submit" class="px-8 py-3.5 bg-white text-black font-black text-sm rounded-full hover:bg-cyan-400 transition-all shadow-xl shadow-white/5">
                    SAVE CHANGES
                </button>
            </div>
        </form>
    </div>

    <!-- Webhooks -->
    <div class="p-10 border border-white/5 rounded-[40px] bg-white/[0.02]">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h4 class="text-2xl font-black font-syne mb-2">Webhooks</h4>
                <p class="text-gray-500 text-sm">Recieve real-time build notifications and deployment events.</p>
            </div>
            <button class="px-4 py-2 bg-white/5 border border-white/10 text-white font-black text-[10px] rounded-xl hover:bg-white/10 transition-all uppercase">ADD ENDPOINT</button>
        </div>

        <div class="space-y-4">
            @forelse($webhooks as $webhook)
            <div class="p-6 border border-white/5 rounded-[32px] bg-white/[0.01] flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold truncate max-w-md">{{ $webhook->url }}</p>
                    <p class="text-[10px] text-gray-600 font-black uppercase tracking-widest mt-1">Events: {{ $webhook->events }}</p>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 border border-white/5 rounded-lg hover:bg-white/5 text-gray-500 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <p class="text-gray-700 italic text-sm text-center py-4 border-2 border-dashed border-white/5 rounded-3xl">No webhooks configured yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="p-10 border border-red-500/10 rounded-[40px] bg-red-500/[0.01]">
        <div class="mb-8">
            <h4 class="text-2xl font-black font-syne mb-2 text-red-400">Danger Zone</h4>
            <p class="text-gray-500 text-sm">Destructive actions related to your application.</p>
        </div>
        <div class="flex items-center justify-between p-6 border border-white/5 rounded-3xl bg-black/40">
            <div>
                <p class="text-sm font-bold mb-1">Delete Application</p>
                <p class="text-xs text-gray-600">Once deleted, all your releases, patches, and logs will be permanently removed.</p>
            </div>
            <button class="px-6 py-2.5 bg-red-500/10 border border-red-500/20 text-red-500 font-black text-xs rounded-xl hover:bg-red-500 hover:text-white transition-all uppercase">DELETE APP</button>
        </div>
    </div>
</div>
@endsection
