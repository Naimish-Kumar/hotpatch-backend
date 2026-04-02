@extends('layouts.main')

@section('title', 'Predictable Economics – HotPatch Console')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200">
    {{-- Dynamic Background --}}
    <div class="hero-grid absolute inset-0 opacity-20"></div>
    <div class="fixed top-0 left-1/2 w-[1000px] h-[600px] bg-cyan-500/[0.03] blur-[180px] rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 pt-24 pb-48 relative z-10 text-center afu">
        <h1 class="font-heading text-6xl md:text-8xl font-black text-white leading-none tracking-[-4px] mb-8 uppercase">Ship at any <br/><span class="text-cyan-400">Scale.</span></h1>
        <p class="text-[clamp(16px,2vw,20px)] text-[#5c7a9e] max-w-xl mx-auto mb-24 leading-relaxed font-bold opacity-80 uppercase tracking-widest">Predictable economics for elite development teams.</p>

        <div class="grid md:grid-cols-3 gap-8 items-start afu-1">
            @foreach($packages as $package)
            <div class="p-12 glass-card border-white/5 relative flex flex-col h-full group hover:bg-white/[0.04] hover:border-white/10 transition-all duration-700 @if($package->slug === 'pro') border-cyan-500/20 shadow-[0_40px_100px_rgba(0,212,255,0.15)] scale-[1.05] z-20 bg-cyan-500/[0.02] @endif">
                @if($package->slug === 'pro')
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2 px-6 py-2 bg-gradient-to-r from-cyan-500 to-cyan-700 text-black font-black text-[10px] uppercase tracking-[4px] rounded-full shadow-2xl font-heading">Recommended Node</div>
                @endif
                
                <h3 class="font-heading text-4xl font-black text-white mb-3 tracking-tight uppercase group-hover:text-cyan-400 transition-colors">{{ $package->name }}</h3>
                <div class="flex items-baseline justify-center gap-1.5 mb-10">
                    <span class="text-5xl font-black text-white font-heading tracking-tighter">${{ $package->price }}</span>
                    <span class="text-[#3a5a7a] text-[11px] font-black uppercase tracking-[3px] font-heading">/ MONTHLY</span>
                </div>

                <p class="text-[#5c7a9e] text-[13px] font-bold italic mb-12 h-12 leading-relaxed opacity-80">{{ $package->description }}</p>

                <ul class="space-y-6 mb-12 text-left flex-grow font-jakarta">
                    @foreach(explode(';', $package->features) as $feature)
                    <li class="flex items-start gap-4 text-[13px] text-white/50 font-bold group-hover:text-white/80 transition-colors">
                        <div class="w-5 h-5 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0 shadow-inner group-hover:scale-110 transition-transform">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </div>
                        <span class="leading-relaxed tracking-tight">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="w-full py-5 rounded-2xl font-black text-[11px] uppercase tracking-[4px] transition-all duration-500 font-heading flex items-center justify-center gap-3 @if($package->slug === 'pro') bg-white text-black hover:bg-cyan-400 shadow-2xl @else bg-white/5 border border-white/10 text-white hover:bg-white/10 shadow-lg @endif">
                    Connect Platform
                    <i data-lucide="zap" class="w-4 h-4"></i>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Enterprise Alert --}}
        <div class="mt-32 p-12 lg:p-20 glass-card bg-gradient-to-tr from-cyan-600/[0.05] via-transparent to-purple-600/[0.04] border-white/10 flex flex-col lg:flex-row items-center justify-between gap-12 group hover:border-white/15 transition-all duration-700 afu-2">
            <div class="flex flex-col lg:flex-row items-center gap-10 text-center lg:text-left">
                <div class="w-20 h-20 rounded-[30px] bg-white/[0.03] border border-white/5 flex items-center justify-center text-white/10 group-hover:scale-110 group-hover:rotate-12 transition-all duration-700 group-hover:text-cyan-400/20 shadow-2xl">
                    <i data-lucide="globe-2" class="w-10 h-10"></i>
                </div>
                <div>
                    <h4 class="font-heading text-3xl font-black text-white mb-3 tracking-tight uppercase">Custom Enterprise Infrastructure</h4>
                    <p class="text-[#5c7a9e] font-bold italic leading-relaxed text-sm max-w-xl">Building for millions of users? Get dedicated deployment vectors, custom SLOs, and white-glove migration assistance.</p>
                </div>
            </div>
            <a href="mailto:sales@hotpatch.site" class="btn-primary py-5 px-12 text-[11px] font-black uppercase tracking-[4px] bg-white/5 text-white border border-white/10 hover:bg-white hover:text-black hover:border-transparent transition-all shadow-[0_20px_40px_rgba(0,0,0,0.4)] whitespace-nowrap font-heading flex items-center gap-3">
                Reach High Scale
                <i data-lucide="mail" class="w-4.5 h-4.5"></i>
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
