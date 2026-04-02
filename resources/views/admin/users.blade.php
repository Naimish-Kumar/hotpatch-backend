@extends('layouts.dashboard')

@section('page_title', 'User Ecosystem')

@section('content')
<div class="space-y-8 pb-32">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-black font-syne mb-2">Global <span class="text-cyan-400">User</span> Ecosystem</h1>
        <p class="text-gray-500 font-medium">Monitoring and managing user accounts across all tiers.</p>
    </div>

    <!-- Users Table -->
    <div class="border border-white/5 rounded-[40px] bg-white/[0.02] overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-white/5 text-gray-600 font-black uppercase tracking-widest text-[9px] bg-white/[0.01]">
                    <th class="px-8 py-6">User Identity</th>
                    <th class="px-8 py-6">Verified</th>
                    <th class="px-8 py-6">Last Login</th>
                    <th class="px-8 py-6">Created At</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                <tr class="group hover:bg-white/[0.02] transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/5 rounded-2xl flex items-center justify-center font-bold text-xs uppercase tracking-tighter">{{ substr($user->email, 0, 1) }}</div>
                            <div>
                                <p class="font-black text-white text-base">{{ $user->display_name ?? 'N/A' }}</p>
                                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if($user->is_verified)
                        <span class="px-3 py-1 bg-green-500/10 border border-green-500/20 text-green-400 text-[10px] font-black rounded-full uppercase tracking-widest">VERIFIED</span>
                        @else
                        <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[10px] font-black rounded-full uppercase tracking-widest">PENDING</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-[10px] font-mono text-gray-500">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                    </td>
                    <td class="px-8 py-6 text-[10px] font-mono text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-6 text-right">
                        <button class="p-2.5 border border-white/5 rounded-xl hover:bg-white/10 text-gray-500 hover:text-white transition-all shadow-xl group/btn overflow-hidden relative">
                            <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center text-gray-700 italic">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>
@endsection
