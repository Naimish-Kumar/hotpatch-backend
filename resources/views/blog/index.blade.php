@extends('layouts.main')

@section('title', 'Engineering Intelligence – HotPatch Console')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200">
    {{-- Background Accent --}}
    <div class="fixed top-0 left-0 w-[800px] h-[600px] bg-cyan-500/[0.02] blur-[200px] rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 pt-24 pb-48 relative z-10 afu">
        <div class="text-center mb-32">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/[0.03] border border-white/5 rounded-full mb-8 shadow-xl">
                <span class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black tracking-[4px] uppercase text-[#00d4ff] font-heading">Journal Cluster</span>
            </div>
            <h1 class="font-heading text-6xl md:text-8xl font-black text-white leading-none tracking-[-4px] mb-8 uppercase">Engineering <br/><span class="text-cyan-400">Intelligence.</span></h1>
            <p class="text-[clamp(16px,2vw,20px)] text-[#5c7a9e] max-w-2xl mx-auto leading-relaxed font-bold opacity-80 uppercase tracking-widest">Insights into React Native OTA architecture and fleet management.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-16 afu-1">
            @forelse($posts as $post)
            <article class="group relative flex flex-col h-full bg-white/[0.01] border border-white/[0.05] rounded-[40px] p-8 hover:bg-white/[0.02] hover:border-white/10 transition-all duration-700 hover:shadow-2xl hover:shadow-cyan-500/5">
                <div class="relative h-64 mb-10 overflow-hidden rounded-[32px] bg-black/60 shadow-inner group-hover:scale-[1.02] transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/10 to-purple-500/10 opacity-60 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-white/5 group-hover:text-cyan-400/20 transition-all group-hover:rotate-6 group-hover:scale-125">
                        <i data-lucide="newspaper" class="w-32 h-32"></i>
                    </div>
                    <div class="absolute bottom-6 left-6 flex items-center gap-2">
                        <span class="px-3 py-1.5 rounded-xl bg-black/80 backdrop-blur-md border border-white/10 text-[9px] font-black text-cyan-400 uppercase tracking-widest font-heading">Tech Stack</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-5 mb-6">
                    <div class="w-8 h-8 rounded-xl bg-white/[0.03] border border-white/5 flex items-center justify-center text-cyan-400/60 shadow-inner">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-widest font-heading mb-0.5">Engineering Team</div>
                        <div class="text-[9px] text-[#3a5a7a] font-black uppercase tracking-[2px] font-heading">{{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <h3 class="font-heading text-3xl font-black text-white mb-6 group-hover:text-cyan-300 transition-colors tracking-tight leading-[1.1] flex-grow">
                    <a href="{{ route('blog.show', $post->slug) }}" class="uppercase">{{ $post->title }}</a>
                </h3>
                
                <p class="text-[#5c7a9e] text-sm font-bold italic leading-relaxed mb-10 line-clamp-3 opacity-80 font-jakarta">
                    {{ Str::limit(strip_tags($post->content), 140) }}
                </p>

                <div class="pt-8 border-t border-white/[0.04]">
                    <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-4 text-[11px] font-black uppercase tracking-[3px] text-white hover:gap-6 transition-all font-heading group/btn">
                        READ FULL DATA
                        <i data-lucide="arrow-right" class="w-4.5 h-4.5 text-cyan-400 group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full py-40 text-center glass-card border-dashed border-white/5">
                <i data-lucide="archive" class="w-16 h-16 text-white/5 mx-auto mb-6"></i>
                <h3 class="font-heading text-2xl font-black text-white/30 uppercase tracking-tight">Signal Cache Empty</h3>
                <p class="text-[#3a5a7a] text-xs font-black uppercase tracking-[4px] mt-2 opacity-50">Checking for telemetry logs from the engineering team...</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
