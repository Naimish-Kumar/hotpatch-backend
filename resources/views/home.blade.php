@extends('layouts.main')

@section('title', 'HotPatch – Zero-Friction React Native OTA Architecture')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden">
    {{-- Immersive Backdrop --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-[1000px] h-[800px] bg-cyan-500/[0.04] blur-[180px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[600px] bg-purple-500/[0.03] blur-[150px] rounded-full -translate-x-1/2 translate-y-1/2"></div>
    </div>

    {{-- ─── HERO ELEMENT ─── --}}
    <section class="relative pt-24 pb-32 lg:pt-40 lg:pb-56 z-10">
        <div class="hero-grid absolute inset-0 opacity-40 mask-radial"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative text-center afu">
            <div class="mb-10 inline-flex items-center gap-4 px-6 py-2 bg-white/[0.03] border border-white/5 rounded-full shadow-[0_0_40px_rgba(0,212,255,0.05)] hover:border-cyan-400/20 transition-all group">
                <span class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse shadow-[0_0_10px_#00d4ff]"></span>
                <span class="text-[9px] font-black uppercase tracking-[4px] text-white opacity-60 font-heading group-hover:opacity-100 transition-opacity whitespace-nowrap">v3.4.1 Nexus Pulse · Initialized</span>
                <i data-lucide="arrow-right" class="w-3 h-3 text-cyan-400 group-hover:translate-x-1 transition-transform"></i>
            </div>

            <h1 class="font-heading text-5xl md:text-7xl lg:text-[9rem] font-black text-white leading-none tracking-[-4px] lg:tracking-[-8px] mb-10 uppercase">
                Ship at <br/>
                <span class="text-cyan-400 glow-cyan">Pulse Speed.</span>
            </h1>

            <p class="text-[clamp(15px,2vw,19px)] text-[#5c7a9e] max-w-xl mx-auto leading-relaxed mb-16 font-bold opacity-80 uppercase tracking-[3px] font-jakarta italic">
                Bypass the store review cycle. Deploy React Native updates <span class="text-white">instantly.</span>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 afu-1 font-heading">
                <a href="{{ route('register') }}" class="btn-primary px-10 py-4.5 text-[11px] relative group overflow-hidden">
                    <span class="relative z-10">Initialize Registry</span>
                    <i data-lucide="zap" class="w-4 h-4 relative z-10"></i>
                </a>
                <a href="{{ route('docs') }}" class="btn-secondary px-10 py-4.5 text-[11px] hover:border-cyan-400/20 group">
                    <span class="opacity-60 group-hover:opacity-100">Explore Nexus Docs</span>
                    <i data-lucide="chevrons-right" class="w-4 h-4 text-cyan-400 opacity-60 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>

            {{-- Floating Dashboard Preview --}}
            <div class="mt-24 relative group max-w-5xl mx-auto afu-2">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-[45px] blur-[30px] opacity-10"></div>
                <div class="authentic-card border-white/10 shadow-[0_60px_100px_rgba(0,0,0,0.8)] relative group-hover:border-cyan-400/30 transition-all">
                    <div class="bg-black/60 p-4 border-b border-white/5 flex items-center justify-between">
                        <div class="flex gap-2.5 px-4"><div class="w-2.5 h-2.5 rounded-full bg-red-400/20"></div><div class="w-2.5 h-2.5 rounded-full bg-amber-400/20"></div><div class="w-2.5 h-2.5 rounded-full bg-green-400/20"></div></div>
                        <div class="text-[8px] font-black text-white/20 uppercase tracking-[6px] font-heading">hotpatch.terminal</div>
                        <div class="w-16"></div>
                    </div>
                    <div class="p-8 lg:p-16 relative overflow-hidden bg-[#050505]">
                         <div class="flex flex-col md:flex-row items-center gap-12 text-left">
                            <div class="flex-1 space-y-8">
                                <div class="space-y-4">
                                    <h4 class="text-[9px] font-black text-cyan-400 uppercase tracking-[4px] font-heading">Current Telemetry</h4>
                                    <div class="h-16 flex items-center gap-6">
                                        <div class="h-full w-1 bg-cyan-400 rounded-full"></div>
                                        <div class="font-heading text-4xl font-black text-white uppercase tracking-tighter">98.2% <br/><span class="text-[10px] text-[#3a5a7a] tracking-[4px]">Adoption</span></div>
                                    </div>
                                </div>
                                <div class="ptrack h-1.5 bg-white/5"><div class="pfill bg-cyan-400" style="width: 98.2%"></div></div>
                            </div>
                            <div class="flex-1 flex justify-center lg:justify-end">
                                <div class="w-48 h-48 rounded-[35px] bg-white/[0.01] border border-white/5 flex items-center justify-center relative">
                                    <i data-lucide="layers" class="w-16 h-16 text-white/5"></i>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CORE VECTORS ─── --}}
    <section class="py-24 lg:py-40 relative z-10" id="experience">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="afu text-left">
                    <h2 class="font-heading text-4xl md:text-6xl font-black text-white tracking-[-2px] mb-10 uppercase leading-none">REINFORCED <br/><span class="text-cyan-400 glow-cyan">LOGISTICS.</span></h2>
                    <p class="text-[16px] text-[#5c7a9e] font-bold italic leading-relaxed mb-12 opacity-80 border-l border-white/10 pl-8">
                        Designed with compliance first. Our atomic deployment architecture handles versioning, rollout intensity, and instant regression.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 shadow-xl">
                                <i data-lucide="package-check" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-heading text-[15px] font-black text-white uppercase tracking-tight">Binary Hashing</h4>
                            <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70">Checksum-based integrity validation on every node.</p>
                        </div>
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-purple-400 shadow-xl">
                                <i data-lucide="history" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-heading text-[15px] font-black text-white uppercase tracking-tight">Rapid Rollback</h4>
                            <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70">Instant regression capability out of the box.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 afu-1">
                    <div class="space-y-6 translate-y-8">
                        <div class="glass-card p-8 bg-white/[0.02] border-white/5 shadow-2xl">
                            <i data-lucide="shield" class="w-10 h-10 text-cyan-400 mb-6 opacity-40"></i>
                            <h5 class="text-[9px] font-black uppercase tracking-[4px] text-white/40 mb-2 font-heading">Security Stream</h5>
                            <p class="text-[11px] text-[#5c7a9e] font-bold italic opacity-70">ED25519 signature encryption.</p>
                        </div>
                        <div class="glass-card p-8 bg-white/[0.02] border-white/5 shadow-2xl">
                            <i data-lucide="target" class="w-10 h-10 text-purple-400 mb-6 opacity-40"></i>
                            <h5 class="text-[9px] font-black uppercase tracking-[4px] text-white/40 mb-2 font-heading">Routing</h5>
                            <p class="text-[11px] text-[#5c7a9e] font-bold italic opacity-70">Precision version targeting.</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="glass-card p-8 bg-white/[0.02] border-white/5 shadow-2xl">
                             <i data-lucide="activity" class="w-10 h-10 text-emerald-400 mb-6 opacity-40"></i>
                             <h5 class="text-[9px] font-black uppercase tracking-[4px] text-white/40 mb-2 font-heading">Metrics</h5>
                             <p class="text-[11px] text-[#5c7a9e] font-bold italic opacity-70">Live adoption monitoring.</p>
                        </div>
                        <div class="glass-card p-8 bg-white/[0.02] border-white/5 shadow-2xl">
                             <i data-lucide="git-branch" class="w-10 h-10 text-emerald-400 mb-6 opacity-40"></i>
                             <h5 class="text-[9px] font-black uppercase tracking-[4px] text-white/40 mb-2 font-heading">Locks</h5>
                             <p class="text-[11px] text-[#5c7a9e] font-bold italic opacity-70">Isolated Stage/Beta/Prod channels.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── HOW IT WORKS ─── --}}
    <section class="py-24 lg:py-40 bg-white/[0.01] border-y border-white/[0.04] relative overflow-hidden" id="how-it-works">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24 afu">
                <h4 class="text-[9px] font-black text-cyan-400 uppercase tracking-[8px] mb-6 font-heading">Logic Cluster Flow</h4>
                <h2 class="font-heading text-4xl md:text-7xl font-black text-white leading-tight uppercase tracking-tight">3 Pulse <br/>Initialization.</h2>
            </div>

            <div class="grid lg:grid-cols-3 gap-12 relative afu-1 font-jakarta font-bold">
                <div class="glass-card p-10 bg-black/40 glow-cyan/5 border-white/5 hover:border-cyan-400/20 transition-all group">
                    <div class="text-4xl font-heading font-black text-white/5 mb-8 group-hover:text-cyan-400/10">01</div>
                    <h4 class="font-heading text-xl font-black text-white mb-4 uppercase tracking-tight">Bundle Synth.</h4>
                    <p class="text-[13px] text-[#5c7a9e] leading-relaxed italic opacity-80">Synthesize JS and assets into a signed digital pulse via CLI.</p>
                </div>
                <div class="glass-card p-10 bg-black/40 glow-cyan/5 border-white/5 hover:border-purple-400/20 transition-all group">
                    <div class="text-4xl font-heading font-black text-white/5 mb-8 group-hover:text-purple-400/10">02</div>
                    <h4 class="font-heading text-xl font-black text-white mb-4 uppercase tracking-tight">Tunnel.</h4>
                    <p class="text-[13px] text-[#5c7a9e] leading-relaxed italic opacity-80">Inject the pulse into the target cluster (Staging/Production).</p>
                </div>
                <div class="glass-card p-10 bg-black/40 glow-cyan/5 border-white/5 hover:border-emerald-400/20 transition-all group">
                    <div class="text-4xl font-heading font-black text-white/5 mb-8 group-hover:text-emerald-400/10">03</div>
                    <h4 class="font-heading text-xl font-black text-white mb-4 uppercase tracking-tight">Pulse.</h4>
                    <p class="text-[13px] text-[#5c7a9e] leading-relaxed italic opacity-80">Nodes receive a heartbeat and apply updates on tactical boot-up.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── GLOBAL COUNT SECT ─── --}}
    <section class="py-24 relative z-10" x-data="{ 
        observed: false,
        stats: {
            devices: { current: 0, target: 82400 },
            pulses: { current: 0, target: 1205400 },
            uptime: { current: 0, target: 99.9 }
        },
        startCounting() {
            if (this.observed) return;
            this.observed = true;
            this.animate('devices');
            this.animate('pulses');
            this.animate('uptime', 0.1);
        },
        animate(key, step = null) {
            let s = this.stats[key];
            let interval = setInterval(() => {
                if (s.current >= s.target) {
                    s.current = s.target;
                    clearInterval(interval);
                } else {
                    s.current += step || Math.ceil(s.target / 60);
                }
            }, 30);
        }
    }" x-init="
        let obs = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) startCounting();
        }, { threshold: 0.5 });
        obs.observe($el);
    ">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-16">
            <div class="text-center group">
                <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-400 mx-auto mb-6">
                    <i data-lucide="smartphone" class="w-7 h-7"></i>
                </div>
                <div class="font-heading text-5xl font-black text-white mb-2 tracking-tighter" x-text="stats.devices.current.toLocaleString()">0</div>
                <p class="text-[9px] font-black uppercase tracking-[4px] text-[#3a5a7a]">Active Nodes</p>
            </div>
            <div class="text-center group">
                <div class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 mx-auto mb-6">
                    <i data-lucide="zap" class="w-7 h-7"></i>
                </div>
                <div class="font-heading text-5xl font-black text-white mb-2 tracking-tighter" x-text="stats.pulses.current.toLocaleString()">0</div>
                <p class="text-[9px] font-black uppercase tracking-[4px] text-[#3a5a7a]">Logic Pulses</p>
            </div>
            <div class="text-center group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 mx-auto mb-6">
                    <i data-lucide="shield-check" class="w-7 h-7"></i>
                </div>
                <div class="font-heading text-5xl font-black text-white mb-2 tracking-tighter" x-text="stats.uptime.current.toFixed(1) + '%'">0%</div>
                <p class="text-[9px] font-black uppercase tracking-[4px] text-[#3a5a7a]">Integrity</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-32 lg:py-56 relative z-10 overflow-hidden">
        <div class="max-w-3xl mx-auto px-6 relative text-center afu">
            <div class="w-16 h-16 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 mx-auto mb-12">
                <i data-lucide="rocket" class="w-8 h-8"></i>
            </div>
            <h2 class="font-heading text-5xl md:text-7xl font-black text-white leading-none tracking-[-3px] mb-10 uppercase">Initialize <br/><span class="text-cyan-400">Production.</span></h2>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 font-heading">
                <a href="{{ route('register') }}" class="btn-primary px-12 py-5 text-[11px]">Access Console</a>
                <a href="{{ route('pricing') }}" class="btn-secondary px-12 py-5 text-[11px]">View Economics</a>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
