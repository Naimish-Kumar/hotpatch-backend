@extends('layouts.main')

@section('title', $post->title . ' – HotPatch Intelligence')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200">
    {{-- Background Accents --}}
    <div class="fixed top-0 left-1/2 w-[800px] h-[600px] bg-cyan-500/[0.03] blur-[200px] rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 pt-24 pb-48 relative z-10 afu">
        {{-- Breadcrumbs & Metadata --}}
        <div class="flex flex-col items-center text-center mb-16">
            <nav class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[4px] text-[#3a5a7a] mb-12 font-heading">
                <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Journal</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-cyan-400">Engineering Detail</span>
            </nav>

            <div class="flex items-center justify-center gap-6 mb-10">
                <div class="flex items-center gap-2.5 px-4 py-1.5 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-[#00d4ff] font-black text-[10px] uppercase tracking-[3px] font-heading">
                    <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                    Verified Intel
                </div>
                <div class="w-px h-5 bg-white/10"></div>
                <div class="text-[10px] text-[#3a5a7a] font-black uppercase tracking-[3px] font-heading">{{ $post->created_at->format('F d, Y') }}</div>
            </div>

            <h1 class="font-heading text-5xl md:text-7xl font-black text-white leading-[1.05] tracking-[-3px] mb-12 uppercase">{{ $post->title }}</h1>
            
            <div class="w-16 h-1 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full mb-12"></div>
            
            <p class="text-xl text-[#5c7a9e] italic max-w-2xl mx-auto leading-relaxed font-jakarta font-medium opacity-80">
                Summary: {{ Str::limit(strip_tags($post->content), 120) }}
            </p>
        </div>

        {{-- Featured Visual --}}
        <div class="relative h-[560px] rounded-[50px] overflow-hidden border border-white/[0.08] bg-white/[0.01] mb-24 shadow-2xl group transition-all duration-1000 hover:border-cyan-500/20 p-8">
            <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/[0.05] via-purple-500/[0.05] to-amber-500/[0.05] opacity-50 blur-[100px] pointer-events-none group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="relative w-full h-full rounded-[35px] bg-black/60 shadow-inner flex items-center justify-center text-white/5 group-hover:text-cyan-400/20 transition-all group-hover:scale-[1.02] duration-700">
                <i data-lucide="component" class="w-48 h-48 group-hover:rotate-12 transition-transform duration-700"></i>
            </div>
            <div class="absolute top-12 left-12 px-5 py-2.5 rounded-2xl bg-black/80 backdrop-blur-xl border border-white/10 text-[10px] font-black text-white/50 uppercase tracking-[4px] font-heading flex items-center gap-2">
                <i data-lucide="image" class="w-4 h-4"></i>
                Visual Mockup v1.0
            </div>
        </div>

        {{-- Article Body --}}
        <article class="prose prose-invert prose-cyan lg:prose-2xl mx-auto leading-[1.8] text-[#5c7a9e] font-jakarta prose-headings:font-heading prose-headings:text-white prose-headings:font-black prose-headings:uppercase prose-headings:tracking-tight prose-a:text-cyan-400 prose-a:font-black prose-img:rounded-[40px] prose-code:text-cyan-300 prose-code:font-mono prose-code:bg-white/5 prose-code:px-2 prose-code:rounded-lg prose-strong:text-white/90">
            {!! $post->content !!}
        </article>

        {{-- Author Signature --}}
        <div class="mt-32 p-12 glass-card border-white/10 flex flex-col md:flex-row items-center justify-between gap-12 group transition-all duration-700 hover:bg-cyan-500/[0.02]">
            <div class="flex items-center gap-8">
                <div class="w-20 h-20 rounded-[30px] bg-gradient-to-tr from-cyan-500 to-cyan-700 flex items-center justify-center font-black text-black text-3xl shadow-2xl border border-white/20 group-hover:rotate-12 transition-transform duration-700">
                    {{ strtoupper(substr($post->author, 0, 1)) }}
                </div>
                <div>
                    <div class="text-[10px] font-black text-[#5c7a9e] uppercase tracking-[6px] mb-3 opacity-60 font-heading">PUBLISHED BY</div>
                    <div class="font-heading text-3xl font-black text-white uppercase tracking-tight">{{ $post->author }}</div>
                    <div class="text-[11px] text-cyan-400 font-bold uppercase tracking-widest mt-1">Core Intelligence Engineer</div>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <a href="#" class="w-14 h-14 rounded-2xl border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/5 hover:border-white/20 transition-all shadow-xl">
                    <i data-lucide="twitter" class="w-6 h-6"></i>
                </a>
                <a href="#" class="w-14 h-14 rounded-2xl border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/5 hover:border-white/20 transition-all shadow-xl">
                    <i data-lucide="linkedin" class="w-6 h-6"></i>
                </a>
                <a href="#" class="px-8 py-4.5 rounded-2xl bg-white/[0.03] border border-white/10 text-white font-black text-[10px] uppercase tracking-[3px] hover:bg-white hover:text-black transition-all shadow-inner font-heading">
                    Share Insight
                </a>
            </div>
        </div>

        {{-- Next Action --}}
        <div class="mt-24 text-center">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-4 text-[12px] font-black uppercase tracking-[5px] text-[#5c7a9e] hover:text-white transition-all font-heading group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-2 transition-transform"></i>
                Return To Journal
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
