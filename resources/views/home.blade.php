@extends('layouts.main')

@section('title', 'HotPatch – Zero-Friction React Native OTA Architecture')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden">
    {{-- Immersive Backdrop --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-[1000px] h-[800px] bg-cyan-500/[0.04] blur-[180px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[600px] bg-purple-500/[0.03] blur-[150px] rounded-full -translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-1/2 left-1/4 w-[600px] h-[600px] bg-cyan-400/[0.01] blur-[200px] rounded-full translate-y-[-50%]"></div>
    </div>

    {{-- ─── HERO ELEMENT ─── --}}
    <section class="relative pt-32 pb-48 lg:pt-56 lg:pb-72 z-10">
        <div class="hero-grid absolute inset-0 opacity-40 mask-radial"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative text-center afu">
            <div class="mb-12 inline-flex items-center gap-4 px-6 py-2.5 bg-white/[0.03] border border-white/5 rounded-full shadow-[0_0_40px_rgba(0,212,255,0.05)] hover:border-cyan-400/20 transition-all group">
                <span class="w-2.5 h-2.5 bg-cyan-400 rounded-full animate-pulse shadow-[0_0_10px_#00d4ff]"></span>
                <span class="text-[10px] font-black uppercase tracking-[4px] text-white opacity-60 font-heading group-hover:opacity-100 transition-opacity">v3.4.1 Nexus Pulse · Deployment Initialized</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-cyan-400 group-hover:translate-x-1 transition-transform"></i>
            </div>

            <h1 class="font-heading text-6xl md:text-8xl lg:text-[10rem] font-black text-white leading-none tracking-[-5px] lg:tracking-[-10px] mb-12 uppercase drop-shadow-[0_20px_50px_rgba(0,212,255,0.1)]">
                Ship at <br/>
                <span class="text-cyan-400 glow-cyan">Pulse Speed.</span>
            </h1>

            <p class="text-[clamp(16px,2.5vw,22px)] text-[#5c7a9e] max-w-2xl mx-auto leading-relaxed mb-20 font-bold opacity-80 uppercase tracking-[4px] font-jakarta italic">
                Bypass the store review cycle. Deploy React Native updates <span class="text-white">instantly.</span>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-10 afu-1 font-heading">
                <a href="{{ route('register') }}" class="btn-primary px-12 py-5 text-sm relative group overflow-hidden shadow-[0_20px_60px_rgba(0,212,255,0.4)]">
                    <span class="relative z-10">Initialize Registry</span>
                    <i data-lucide="zap" class="w-5 h-5 relative z-10 group-hover:scale-125 transition-transform"></i>
                    <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                </a>
                <a href="{{ route('docs') }}" class="btn-secondary px-12 py-5 text-sm hover:border-cyan-400/20 group">
                    <span class="opacity-60 group-hover:opacity-100 transition-opacity">Explore Nexus Docs</span>
                    <i data-lucide="chevrons-right" class="w-5 h-5 text-cyan-400 opacity-60 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>

            {{-- Floating Dashboard Preview --}}
            <div class="mt-40 relative group max-w-5xl mx-auto afu-2">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-[45px] blur-[30px] opacity-10 group-hover:opacity-20 transition-all duration-1000"></div>
                <div class="authentic-card border-white/10 shadow-[0_60px_100px_rgba(0,0,0,0.8)] relative group-hover:border-cyan-400/30 transition-all duration-700">
                    <div class="bg-black/60 p-4 border-b border-white/5 flex items-center justify-between">
                        <div class="flex gap-2.5 px-4"><div class="w-3 h-3 rounded-full bg-red-400/20"></div><div class="w-3 h-3 rounded-full bg-amber-400/20"></div><div class="w-3 h-3 rounded-full bg-green-400/20"></div></div>
                        <div class="text-[9px] font-black text-white/20 uppercase tracking-[6px] font-heading">hotpatch-v3.4.1.terminal</div>
                        <div class="w-20"></div>
                    </div>
                    <div class="p-10 lg:p-20 relative overflow-hidden bg-[#050505]">
                         <div class="flex flex-col md:flex-row items-center gap-16">
                            <div class="w-full md:w-1/2 space-y-10 text-left">
                                <div class="space-y-4">
                                    <h4 class="text-[10px] font-black text-cyan-400 uppercase tracking-[5px] font-heading">Current Telemetry</h4>
                                    <div class="h-20 flex items-center gap-6">
                                        <div class="h-full w-1.5 bg-gradient-to-b from-cyan-400 to-transparent rounded-full"></div>
                                        <div class="font-heading text-4xl font-black text-white uppercase tracking-tighter transition-all">98.2% <br/><span class="text-xs text-[#3a5a7a] tracking-[4px]">Pulse Adoption</span></div>
                                    </div>
                                </div>
                                <div class="ptrack h-2 bg-white/5"><div class="pfill bg-gradient-to-r from-cyan-600 to-cyan-400 glow-cyan" style="width: 98.2%"></div></div>
                                <div class="grid grid-cols-2 gap-8 pt-6">
                                    <div><div class="text-[9px] font-black text-[#3a5a7a] uppercase mb-2">Fleet Area</div><div class="text-lg text-white font-black uppercase font-heading">GLOBAL-US-1</div></div>
                                    <div><div class="text-[9px] font-black text-[#3a5a7a] uppercase mb-2">Protocol</div><div class="text-lg text-white font-black uppercase font-heading">ED25519-TLS</div></div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex justify-center lg:justify-end">
                                <div class="w-64 h-64 rounded-[40px] bg-white/[0.01] border border-white/5 flex items-center justify-center relative group/inner">
                                    <div class="absolute inset-4 rounded-[30px] border border-dashed border-white/10 group-hover/inner:border-cyan-400/20 transition-colors animate-[auraSpin_20s_linear_infinite]"></div>
                                    <i data-lucide="layers" class="w-24 h-24 text-white/5 group-hover/inner:text-cyan-400/10 transition-colors"></i>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CORE VECTORS ─── --}}
    <section class="py-32 lg:py-64 relative z-10" id="experience">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 items-center">
                <div class="afu">
                    <h2 class="font-heading text-5xl md:text-7xl font-black text-white tracking-[-3px] mb-12 uppercase leading-[1.05]">REINFORCED <br/><span class="text-cyan-400 glow-cyan">LOGISTICS.</span></h2>
                    <p class="text-lg text-[#5c7a9e] font-bold italic leading-relaxed mb-20 opacity-80 border-l-2 border-white/10 pl-10 max-w-xl">
                        Designed with compliance first. Our atomic deployment architecture handles versioning, rollout intensity, and instant regression out of the box.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-12">
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 shadow-xl group hover:scale-110 transition-all duration-500">
                                <i data-lucide="package-check" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-heading text-lg font-black text-white uppercase tracking-tight">Binary Hashing</h4>
                            <p class="text-[13px] text-[#5c7a9e] font-bold leading-relaxed italic opacity-70">Checksum-based integrity validation on every node before extraction.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-purple-400 shadow-xl group hover:scale-110 transition-all duration-500">
                                <i data-lucide="history" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-heading text-lg font-black text-white uppercase tracking-tight">Rapid Rollback</h4>
                            <p class="text-[13px] text-[#5c7a9e] font-bold leading-relaxed italic opacity-70">Instant regression capability in case of logical cluster failure.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 afu-1">
                    <div class="space-y-8 translate-y-12">
                        <div class="glass-card p-10 bg-white/[0.02] border-white/5 hover:border-cyan-400/20 glow-cyan/5 transition-all shadow-2xl">
                            <div class="font-heading text-4xl mb-6 opacity-40 grayscale group-hover:grayscale-0">
                                <i data-lucide="shield" class="w-12 h-12 text-cyan-400"></i>
                            </div>
                            <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/40 mb-3 font-heading">Security Stream</h5>
                            <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70 leading-relaxed">End-to-end ED25519 encryption signature.</p>
                        </div>
                        <div class="glass-card p-10 bg-white/[0.02] border-white/5 shadow-2xl">
                            <div class="font-heading text-4xl mb-6 opacity-40 grayscale">
                                <i data-lucide="target" class="w-12 h-12 text-purple-400"></i>
                            </div>
                            <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/40 mb-3 font-heading">Precision Routing</h5>
                            <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70 leading-relaxed">Target specific CPU architectures and versions.</p>
                        </div>
                    </div>
                    <div class="space-y-8">
                        <div class="glass-card p-10 bg-white/[0.02] border-white/5 shadow-2xl">
                             <div class="font-heading text-4xl mb-6 opacity-40 grayscale">
                                <i data-lucide="activity" class="w-12 h-12 text-emerald-400"></i>
                             </div>
                             <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/40 mb-3 font-heading">Real-time Metrics</h5>
                             <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70 leading-relaxed">Live adoption monitoring across global nodes.</p>
                        </div>
                        <div class="glass-card p-10 bg-white/[0.02] border-white/5 shadow-2xl group hover:border-[#00e5a0]/30 transition-all">
                             <div class="font-heading text-4xl mb-6 opacity-40 grayscale group-hover:grayscale-0 group-hover:text-emerald-400">
                                <i data-lucide="git-branch" class="w-12 h-12"></i>
                             </div>
                             <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/40 mb-3 font-heading">Environment Locks</h5>
                             <p class="text-[12px] text-[#5c7a9e] font-bold italic opacity-70 leading-relaxed">Isolated channels for Stage, Beta, and Prod.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── HOW IT WORKS ─── --}}
    <section class="py-32 lg:py-64 bg-white/[0.01] border-y border-white/[0.04] relative overflow-hidden" id="how-it-works">
        <div class="absolute top-0 left-1/4 w-[800px] h-[800px] bg-cyan-500/[0.02] blur-[180px] rounded-full -translate-y-1/2"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-40 afu">
                <h4 class="text-[10px] font-black text-cyan-400 uppercase tracking-[10px] mb-8 font-heading">Logic Cluster Flow</h4>
                <h2 class="font-heading text-6xl md:text-8xl font-black text-white leading-tight uppercase tracking-tight glow-cyan/10">3 Pulse <br/>Initialization.</h2>
            </div>

            <div class="grid lg:grid-cols-3 gap-20 relative afu-1 font-jakarta font-bold">
                <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/[0.06] to-transparent -translate-y-1/2 hidden lg:block"></div>
                
                <div class="relative group">
                    <div class="w-24 h-24 mask-radial absolute -top-12 -left-12 opacity-10 group-hover:opacity-30 transition-opacity">
                         <div class="absolute inset-0 border-[3px] border-cyan-400 rounded-full animate-ping"></div>
                    </div>
                    <div class="glass-card p-12 hover:border-cyan-400/30 transition-all duration-700 bg-black/40 glow-cyan/5">
                        <div class="text-[54px] font-heading font-black text-white/5 mb-10 group-hover:text-cyan-400/20 transition-colors">01</div>
                        <h4 class="font-heading text-2xl font-black text-white mb-5 uppercase tracking-tight">Bundle Synth.</h4>
                        <p class="text-[#5c7a9e] leading-relaxed italic opacity-80">Our CLI localizer synthesizes your JS and assets into a signed digital pulse. Optimized for low-bandwidth extraction.</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="glass-card p-12 hover:border-purple-400/30 transition-all duration-700 bg-black/40 glow-cyan/5">
                        <div class="text-[54px] font-heading font-black text-white/5 mb-10 group-hover:text-purple-400/20 transition-colors">02</div>
                        <h4 class="font-heading text-2xl font-black text-white mb-5 uppercase tracking-tight">Channel Tunnel.</h4>
                        <p class="text-[#5c7a9e] leading-relaxed italic opacity-80">Inject the pulse into the target cluster (Staging/Production). Atomic versioning ensures zero partial-update failure states.</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="glass-card p-12 hover:border-emerald-400/30 transition-all duration-700 bg-black/40 glow-cyan/5">
                        <div class="text-[54px] font-heading font-black text-white/5 mb-10 group-hover:text-emerald-400/20 transition-colors">03</div>
                        <h4 class="font-heading text-2xl font-black text-white mb-5 uppercase tracking-tight">Global Pulse.</h4>
                        <p class="text-[#5c7a9e] leading-relaxed italic opacity-80">Your client nodes receive a telemetry heartbeat. Updates are applied on the next tactical boot-up. Immediate reach.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── GLOBAL COUNT SECT ─── --}}
    <section class="py-32 lg:py-48 relative z-10" x-data="{ 
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
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-20">
            <div class="text-center group">
                <div class="w-16 h-16 rounded-[28px] bg-cyan-500/10 flex items-center justify-center text-cyan-400 mx-auto mb-8 shadow-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="smartphone" class="w-8 h-8"></i>
                </div>
                <div class="font-heading text-6xl font-black text-white mb-2 tracking-tighter" x-text="stats.devices.current.toLocaleString()">0</div>
                <p class="text-[10px] font-black uppercase tracking-[5px] text-[#3a5a7a]">Active Fleet Nodes</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 rounded-[28px] bg-purple-500/10 flex items-center justify-center text-purple-400 mx-auto mb-8 shadow-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="zap" class="w-8 h-8"></i>
                </div>
                <div class="font-heading text-6xl font-black text-white mb-2 tracking-tighter" x-text="stats.pulses.current.toLocaleString()">0</div>
                <p class="text-[10px] font-black uppercase tracking-[5px] text-[#3a5a7a]">OTA Logic Pulses</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 rounded-[28px] bg-emerald-500/10 flex items-center justify-center text-emerald-400 mx-auto mb-8 shadow-2xl group-hover:scale-110 transition-transform">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <div class="font-heading text-6xl font-black text-white mb-2 tracking-tighter" x-text="stats.uptime.current.toFixed(1) + '%'">0%</div>
                <p class="text-[10px] font-black uppercase tracking-[5px] text-[#3a5a7a]">Deployment Integrity</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-48 lg:py-72 relative z-10 overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center opacity-30 pointer-events-none">
            <div class="w-[800px] h-[800px] border border-white/[0.03] rounded-full animate-[auraSpin_30s_linear_infinite]"></div>
            <div class="absolute w-[600px] h-[600px] border border-white/[0.03] rounded-full animate-[auraSpin_20s_linear_infinite_reverse]"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-6 relative text-center afu">
            <div class="w-24 h-24 rounded-[32px] bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 mx-auto mb-16 shadow-2xl group transition-all duration-700 hover:rotate-[360deg] hover:bg-cyan-500/10">
                <i data-lucide="rocket" class="w-10 h-10"></i>
            </div>
            <h2 class="font-heading text-6xl md:text-8xl font-black text-white leading-none tracking-[-4px] mb-12 uppercase glow-cyan/10">Initialize <br/><span class="text-cyan-400">Production.</span></h2>
            <p class="text-xl text-[#5c7a9e] font-bold uppercase tracking-[6px] mb-20 opacity-80 italic">Start shipping at high velocity.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-10 font-heading">
                <a href="{{ route('register') }}" class="btn-primary px-16 py-6 text-sm glow-cyan">
                    Access Console
                    <i data-lucide="key" class="w-5 h-5"></i>
                </a>
                <a href="{{ route('pricing') }}" class="btn-secondary px-16 py-6 text-sm border-white/5">
                    View Economics
                    <i data-lucide="credit-card" class="w-5 h-5 text-cyan-400/60"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-24 border-t border-white/[0.04] relative z-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="flex flex-col items-center md:items-start gap-4">
                <x-logo width="140" height="36" class="opacity-80 grayscale hover:grayscale-0 transition-all cursor-pointer" />
                <p class="text-[9px] text-[#3a5a7a] font-black uppercase tracking-[5px] font-heading">&copy; 2026 HotPatch Platform · v3.4.1 Stable</p>
            </div>
            <div class="flex items-center gap-12 font-heading">
                <a href="{{ route('docs') }}" class="text-[10px] font-black uppercase text-[#5c7a9e] tracking-[3px] hover:text-white transition-colors">Documentation</a>
                <a href="{{ route('pricing') }}" class="text-[10px] font-black uppercase text-[#5c7a9e] tracking-[3px] hover:text-white transition-colors">Scaling</a>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-[#00e5a0] rounded-full animate-pulse shadow-[0_0_8px_#00e5a0]"></div>
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[4px]">Status: Locked</span>
                </div>
            </div>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
