@extends('layouts.dashboard')

@section('page_title', 'Security Center')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- API Keys -->
        <div class="p-8 border border-white/5 rounded-[32px] bg-white/[0.02] flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h4 class="text-xl font-bold font-syne">API Access Keys</h4>
                <button class="px-4 py-2 bg-white text-black font-black text-[10px] rounded-xl hover:bg-cyan-400 transition-all uppercase">NEW KEY</button>
            </div>
            <div class="space-y-4">
                @forelse($apiKeys as $key)
                <div class="flex items-center justify-between p-4 border border-white/5 rounded-2xl bg-white/[0.01]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-cyan-500/10 rounded-lg flex items-center justify-center text-cyan-400 text-xs">🔑</div>
                        <div>
                            <p class="text-sm font-bold">{{ $key->name }}</p>
                            <p class="text-[10px] font-mono text-gray-500">{{ $key->prefix }}••••••••••••••••</p>
                        </div>
                    </div>
                    <button class="text-red-500/50 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                @empty
                <p class="text-gray-600 text-xs text-center py-4 italic">No API keys generated.</p>
                @endforelse
            </div>
        </div>

        <!-- Signing Keys -->
        <div class="p-8 border border-white/5 rounded-[32px] bg-white/[0.02] flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h4 class="text-xl font-bold font-syne">Release Signing</h4>
                <button class="px-4 py-2 bg-white/5 border border-white/10 text-white font-black text-[10px] rounded-xl hover:bg-white/10 transition-all uppercase">IMPORT KEY</button>
            </div>
            <div class="space-y-4">
                @forelse($signingKeys as $key)
                <div class="flex items-center justify-between p-4 border border-white/5 rounded-2xl bg-white/[0.01]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-400 text-xs">🛡️</div>
                        <div>
                            <p class="text-sm font-bold">{{ $key->name }}</p>
                            <p class="text-[10px] font-mono text-gray-500">RSA-4096 Verified</p>
                        </div>
                    </div>
                    <button class="text-gray-600 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
                @empty
                <p class="text-gray-600 text-xs text-center py-4 italic">No signing keys added. We recommend Ed25519.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Audit Logs -->
    <div class="p-8 border border-white/5 rounded-[32px] bg-white/[0.02]">
        <h4 class="text-xl font-bold font-syne mb-8">Audit Logs</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/5 text-[9px] font-black text-gray-600 uppercase tracking-widest">
                    <tr>
                        <th class="pb-4">Action</th>
                        <th class="pb-4">Actor</th>
                        <th class="pb-4">Timestamp</th>
                        <th class="pb-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($auditLogs as $log)
                    <tr class="group hover:bg-white/[0.01]">
                        <td class="py-4">
                            <span class="text-white font-bold text-xs">{{ $log->action }}</span>
                            @if($log->metadata)
                            <p class="text-[10px] text-gray-600 font-mono mt-0.5">{{ $log->metadata }}</p>
                            @endif
                        </td>
                        <td class="py-4 text-xs text-gray-400">{{ $log->actor }}</td>
                        <td class="py-4 text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                        <td class="py-4 text-[10px] font-mono text-gray-700">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-700 italic">No audit logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
