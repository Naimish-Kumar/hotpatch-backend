@extends('layouts.dashboard')

@section('page_title', 'Content Management')

@section('content')
<div class="space-y-8 pb-32">
    <div class="flex items-center justify-between mb-16">
        <div class="text-left">
            <h1 class="text-4xl font-black font-syne mb-2">Content <span class="text-cyan-400">Hub.</span></h1>
            <p class="text-gray-500 font-medium">Managing blog posts and enterprise case studies.</p>
        </div>
        <button class="px-6 py-3 bg-white text-black font-black text-xs rounded-full hover:bg-cyan-400 transition-all uppercase shadow-2xl shadow-white/5">CREATE NEW ARTICLE</button>
    </div>

    <!-- Blogs Table -->
    <div class="border border-white/5 rounded-[40px] bg-white/[0.02] overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-white/5 text-gray-600 font-black uppercase tracking-widest text-[9px] bg-white/[0.01]">
                    <th class="px-8 py-6">Article Package</th>
                    <th class="px-8 py-6">Author</th>
                    <th class="px-8 py-6">Status</th>
                    <th class="px-8 py-6">Published</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($blogs as $blog)
                <tr class="group hover:bg-white/[0.02] transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white/5 rounded-2xl flex items-center justify-center font-bold text-xs uppercase tracking-tighter">📄</div>
                            <div>
                                <p class="font-black text-white text-base max-w-[240px] truncate">{{ $blog->title }}</p>
                                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $blog->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-xs text-white font-bold">{{ $blog->author }}</td>
                    <td class="px-8 py-6">
                        @if($blog->is_published)
                        <span class="px-3 py-1 bg-green-500/10 border border-green-500/20 text-green-400 text-[10px] font-black rounded-full uppercase tracking-widest">PUBLISHED</span>
                        @else
                        <span class="px-3 py-1 bg-white/5 border border-white/10 text-gray-500 text-[10px] font-black rounded-full uppercase tracking-widest">DRAFT</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-[10px] font-mono text-gray-500">{{ $blog->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-6 text-right space-x-2">
                        <button class="p-2 border border-white/5 rounded-lg hover:bg-white/5 text-gray-500 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button class="p-2 border border-white/5 rounded-lg hover:bg-red-500/10 text-gray-500 hover:text-red-400 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center text-gray-700 italic">No articles found. Ready to write the first story?</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
