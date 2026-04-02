@extends('layouts.main')

@section('title', 'Documentation Cluster – HotPatch Console')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden" 
     x-data="{ 
        activeSection: 'introduction',
        sections: [
            'introduction', 'installation', 'configuration', 'first-deployment',
            'channels-logic', 'rollouts', 'binary-compatibility', 'cli-ref', 'security'
        ],
        checkScroll() {
            let scrollPos = window.pageYOffset || document.documentElement.scrollTop;
            for (let id of this.sections) {
                let el = document.getElementById(id);
                if (el && scrollPos >= el.offsetTop - 150) {
                    this.activeSection = id;
                }
            }
        },
        scrollTo(id) {
            let el = document.getElementById(id);
            if (el) {
                window.scrollTo({ top: el.offsetTop - 100, behavior: 'smooth' });
                this.activeSection = id;
            }
        }
     }"
     @scroll.window="checkScroll()">
    
    {{-- Glow Aura Backgrounds --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-[10%] left-[20%] w-[600px] h-[600px] bg-cyan-500/[0.04] blur-[150px] rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-[20%] right-[10%] w-[500px] h-[500px] bg-purple-500/[0.04] blur-[150px] rounded-full translate-x-1/2 translate-y-1/2"></div>
    </div>

    <div class="max-w-8xl mx-auto px-6 lg:px-12 pt-12 pb-48 relative z-10">
        <div class="flex flex-col lg:flex-row gap-20">
            
            {{-- ─── SIDEBAR NAV ─── --}}
            <aside class="lg:w-72 flex-shrink-0 afu">
                <nav class="sticky top-28 space-y-10">
                    {{-- Search UI --}}
                    <div class="relative group mb-10">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                        <input type="text" placeholder="QUERY DOCUMENTATION..." class="w-full bg-white/[0.02] border border-white/5 rounded-2xl py-3.5 pl-11 pr-4 text-[10px] font-black text-white focus:outline-none focus:border-cyan-400 focus:bg-white/[0.04] transition-all font-heading tracking-[3px] uppercase placeholder:opacity-20 shadow-inner">
                    </div>

                    <div class="space-y-12 h-[calc(100vh-280px)] overflow-y-auto scrollbar-hide pr-2">
                        @php
                        $navGroups = [
                            'Getting Started' => [
                                ['id' => 'introduction', 'label' => 'Intel Overview', 'icon' => 'info'],
                                ['id' => 'installation', 'label' => 'Environment Setup', 'icon' => 'cpu'],
                                ['id' => 'configuration', 'label' => 'Bridge Config', 'icon' => 'settings'],
                                ['id' => 'first-deployment', 'label' => 'First Pulse', 'icon' => 'zap'],
                            ],
                            'Architecture' => [
                                ['id' => 'channels-logic', 'label' => 'Routing Logic', 'icon' => 'git-branch'],
                                ['id' => 'rollouts', 'label' => 'Atomic Rollouts', 'icon' => 'refresh-ccw'],
                                ['id' => 'binary-compatibility', 'label' => 'Binary Safety', 'icon' => 'shield-check'],
                            ],
                            'Reference' => [
                                ['id' => 'cli-ref', 'label' => 'CLI Registry', 'icon' => 'terminal'],
                                ['id' => 'api-ref', 'label' => 'Firmware API', 'icon' => 'database'],
                                ['id' => 'security', 'label' => 'Security Audit', 'icon' => 'lock'],
                            ]
                        ];
                        @endphp

                        @foreach($navGroups as $group => $items)
                        <div>
                            <h5 class="text-[9px] font-black uppercase tracking-[5px] text-[#3a5a7a] mb-6 font-heading flex items-center gap-3">
                                <span class="w-1.5 h-1.5 bg-[#3a5a7a]/30 rounded-full"></span>
                                {{ $group }}
                            </h5>
                            <ul class="space-y-1.5 border-l border-white/5 ml-0.5">
                                @foreach($items as $item)
                                <li class="group">
                                    <button 
                                        @click="scrollTo('{{ $item['id'] }}')" 
                                        class="w-full text-left pl-6 py-2.5 rounded-r-xl transition-all duration-300 relative font-heading"
                                        :class="activeSection === '{{ $item['id'] }}' ? 'text-white border-l-2 border-cyan-400 bg-cyan-400/[0.03] shadow-[inset_10px_0_15px_rgba(0,212,255,0.05)]' : 'text-[#5c7a9e] hover:text-white hover:bg-white/5 border-l-2 border-transparent'"
                                    >
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="{{ $item['icon'] }}" class="w-3.5 h-3.5" :class="activeSection === '{{ $item['id'] }}' ? 'text-cyan-400' : 'opacity-40 group-hover:opacity-70'"></i>
                                            <span class="text-[11px] font-black uppercase tracking-[1.5px] whitespace-nowrap">{{ $item['label'] }}</span>
                                        </div>
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>

                    <div class="pt-8 border-t border-white/[0.04] font-heading">
                        <div class="p-6 glass-card bg-cyan-500/[0.01] border-white/5 shadow-2xl relative overflow-hidden group">
                           <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity"><i data-lucide="heart" class="w-10 h-10"></i></div>
                           <p class="text-[11px] font-black text-white/80 mb-4 tracking-widest uppercase">Support Stream</p>
                           <a href="mailto:support@hotpatch.site" class="btn-outline w-full py-2.5 text-[9px] uppercase tracking-widest bg-cyan-500/5 group-hover:bg-cyan-500/10 border-cyan-500/20">Connect Dev</a>
                        </div>
                    </div>
                </nav>
            </aside>

            {{-- ─── CONTENT AREA ─── --}}
            <article class="flex-1 max-w-4xl afu-1 space-y-32">
                
                {{-- 0. INTRODUCTION --}}
                <section id="introduction" class="scroll-mt-32">
                    <nav class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[4px] text-[#3a5a7a] mb-12 font-heading">
                        <span class="text-cyan-400/80">Documentation</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-white/10"></i>
                        <span class="text-white/40">Nexus Hub</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-white/10"></i>
                        <span class="text-white">Overview</span>
                    </nav>

                    <h1 class="font-heading text-6xl md:text-8xl font-black text-white leading-none tracking-[-4px] mb-10 uppercase">Nexus <br/><span class="text-cyan-400 glow-cyan">Inteli.</span></h1>
                    <p class="text-xl text-[#5c7a9e] leading-relaxed font-bold font-jakarta border-l-[3px] border-cyan-500/30 pl-10 py-3 italic">
                        The ultimate infrastructure layer for Over-The-Air (OTA) distribution. Bypassing the friction of traditional store updates with sub-second synchronization and atomic rollback protection.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-20 font-jakarta">
                        <div class="p-8 glass-card bg-emerald-500/[0.01] border-emerald-500/10 group hover:border-emerald-500/30 glow-emerald/10 transition-all duration-700">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg">
                                <i data-lucide="zap" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-heading text-lg font-black text-white mb-3 uppercase tracking-tight">Rapid Pulse</h4>
                            <p class="text-xs text-[#5c7a9e] font-bold leading-relaxed opacity-80">Instant hotfixes for production-critical bugs. Zero store review delays. Deployment in <span class="text-emerald-400 font-black">400ms</span>.</p>
                        </div>
                        <div class="p-8 glass-card bg-amber-500/[0.01] border-amber-500/10 group hover:border-amber-500/30 glow-amber/10 transition-all duration-700">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-400 mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 shadow-lg">
                                <i data-lucide="shield" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-heading text-lg font-black text-white mb-3 uppercase tracking-tight">Atomic Safety</h4>
                            <p class="text-xs text-[#5c7a9e] font-bold leading-relaxed opacity-80">Built-in hash validation and checksum signatures ensures that only verified code pulses ever reach your client fleet.</p>
                        </div>
                    </div>
                </section>

                {{-- 1. INSTALLATION --}}
                <section id="installation" class="scroll-mt-32">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-14 h-14 rounded-[22px] bg-white/[0.03] border border-white/5 flex items-center justify-center text-white/20 text-xs font-black shadow-2xl">01</div>
                        <h2 class="font-heading text-4xl font-black text-white tracking-tight uppercase">Platform Onboarding</h2>
                    </div>
                    
                    <div class="space-y-12">
                        <p class="text-[#5c7a9e] text-lg font-bold italic leading-relaxed opacity-90 max-w-2xl">
                            Register the core HotPatch binary into your Node.js environment. We support React Native, Flutter, and Capacitor via specialized adapters.
                        </p>

                        <div class="bg-black/80 border border-white/10 rounded-[40px] overflow-hidden shadow-2xl relative group">
                            <div class="absolute inset-0 bg-cyan-500/[0.01] pointer-events-none group-hover:bg-cyan-500/[0.03] transition-colors duration-1000"></div>
                            <div class="flex items-center justify-between px-10 py-6 border-b border-white/[0.05] bg-white/[0.02]">
                                <div class="flex gap-2"><div class="w-3 h-3 rounded-full bg-red-500/40"></div><div class="w-3 h-3 rounded-full bg-amber-500/40"></div><div class="w-3 h-3 rounded-full bg-green-500/40"></div></div>
                                <div class="text-[9px] font-black text-white/30 uppercase tracking-[5px] font-heading group-hover:text-cyan-400/50 transition-colors">Bash Cluster — v2.4.0</div>
                            </div>
                            <div class="p-10 font-mono text-[15px] leading-relaxed relative z-10">
                                <div class="flex gap-6"><span class="text-white/10 select-none">1</span><span class="text-cyan-400 group-hover:translate-x-1 transition-transform">$</span><span class="text-white font-bold tracking-tight">npm install <span class="text-[#00e5a0]">@hotpatch/react-native</span> --global</span></div>
                                <div class="flex gap-6 mt-3"><span class="text-white/10 select-none">2</span><span class="text-cyan-400">$</span><span class="text-white/40 italic"># Initialize global firmware controller</span></div>
                                <div class="flex gap-6 mt-1"><span class="text-white/10 select-none">3</span><span class="text-cyan-400 group-hover:translate-x-1 transition-transform">$</span><span class="text-white font-bold tracking-tight">hotpatch <span class="text-[#ffb830]">init</span> --project my-awesome-app</span></div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 2. CONFIGURATION --}}
                <section id="configuration" class="scroll-mt-32">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-14 h-14 rounded-[22px] bg-white/[0.03] border border-white/5 flex items-center justify-center text-white/20 text-xs font-black shadow-2xl">02</div>
                        <h2 class="font-heading text-4xl font-black text-white tracking-tight uppercase">Firmware Context</h2>
                    </div>

                    <div class="space-y-12">
                        <div class="p-10 glass-card bg-cyan-900/[0.03] border-cyan-500/10 font-jakarta group transition-all duration-700 hover:border-cyan-400/30">
                            <h4 class="font-heading text-xl font-black text-white mb-6 uppercase tracking-tight flex items-center gap-4">
                                <i data-lucide="key" class="w-6 h-6 text-cyan-400"></i>
                                Application Identity
                            </h4>
                            <p class="text-[13px] text-[#5c7a9e] leading-relaxed mb-8 font-bold italic opacity-80">
                                Every pulse requires a unique <span class="text-white">API Key</span> and <span class="text-white">Project ID</span>. Locate these in your dashboard settings before initiating the tunnel.
                            </p>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-5 rounded-2xl bg-black/40 border border-white/5 group-hover:bg-black/60 transition-colors">
                                    <span class="text-[10px] font-black uppercase tracking-[3px] text-white/30">H-PROJECT-ID</span>
                                    <code class="text-xs font-mono text-cyan-400">c85-29fb-4a8e...</code>
                                </div>
                                <div class="flex items-center justify-between p-5 rounded-2xl bg-black/40 border border-white/5 group-hover:bg-black/60 transition-colors">
                                    <span class="text-[10px] font-black uppercase tracking-[3px] text-white/30">H-MASTER-KEY</span>
                                    <code class="text-xs font-mono text-purple-400">hp_live_9438...</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 3. CHANNELS LOGIC --}}
                <section id="channels-logic" class="scroll-mt-32">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-14 h-14 rounded-[22px] bg-white/[0.03] border border-white/5 flex items-center justify-center text-white/20 text-xs font-black shadow-2xl">03</div>
                        <h2 class="font-heading text-4xl font-black text-white tracking-tight uppercase">Clustered Channels</h2>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8 font-jakarta afu">
                        @php
                        $chans = [
                            ['t' => 'Production', 'd' => 'The public cluster. Verified, high-integrity firmware for all end-users.', 'c' => 'emerald'],
                            ['t' => 'Staging', 'd' => 'Candidate testing group. Identical to prod but isolated for dev verification.', 'c' => 'cyan'],
                            ['t' => 'Beta', 'd' => 'Early adopters cluster. Frequent pulses, telemetry-heavy monitoring.', 'c' => 'purple'],
                        ];
                        @endphp
                        @foreach($chans as $c)
                        <div class="p-8 glass-card border-white/5 hover:border-{{ $c['c'] }}-500/30 transition-all duration-700 group flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-2 h-2 rounded-full bg-{{ $c['c'] }}-400 animate-pulse shadow-[0_0_8px_{{ $c['c'] }}]"></div>
                                    <h4 class="font-heading text-sm font-black text-white uppercase tracking-widest">{{ $c['t'] }}</h4>
                                </div>
                                <p class="text-[11px] text-[#5c7a9e] leading-relaxed font-bold italic opacity-80">{{ $c['d'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                {{-- 4. SECURITY --}}
                <section id="security" class="scroll-mt-32">
                    <div class="p-16 rounded-[50px] border border-white/5 bg-gradient-to-tr from-cyan-600/[0.05] via-transparent to-purple-600/[0.05] relative overflow-hidden group font-jakarta afu">
                        <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-cyan-400 via-transparent to-purple-500 opacity-20"></div>
                        <div class="absolute -top-1/2 -right-1/4 w-[600px] h-[600px] bg-cyan-400/[0.02] blur-[150px] rounded-full group-hover:scale-110 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10 flex flex-col lg:flex-row gap-16 items-start">
                            <div class="w-20 h-20 rounded-[30px] bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 shadow-2xl group-hover:rotate-12 transition-transform duration-700 shrink-0">
                                <i data-lucide="shield-check" class="w-10 h-10"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-4xl font-black text-white mb-6 uppercase tracking-tight">Reinforced Encryption</h3>
                                <p class="text-[#5c7a9e] text-lg font-bold italic leading-relaxed mb-10 opacity-80">
                                    HotPatch utilizes <span class="text-white">ED25519 digital signatures</span> for every update bundle. The mobile client validates the signature locally before ever attempting to unarchive the assets.
                                </p>
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-10">
                                    <div>
                                        <h5 class="text-[9px] font-black text-cyan-400 uppercase tracking-[4px] mb-3">Transport</h5>
                                        <p class="text-[10px] text-[#3a5a7a] font-bold uppercase tracking-widest">TLS 1.3 + ChaCha20</p>
                                    </div>
                                    <div>
                                        <h5 class="text-[9px] font-black text-cyan-400 uppercase tracking-[4px] mb-3">Integrity</h5>
                                        <p class="text-[10px] text-[#3a5a7a] font-bold uppercase tracking-widest">SHA-512 Checksums</p>
                                    </div>
                                    <div>
                                        <h5 class="text-[9px] font-black text-cyan-400 uppercase tracking-[4px] mb-3">Storage</h5>
                                        <p class="text-[10px] text-[#3a5a7a] font-bold uppercase tracking-widest">AES-256-GCM At Rest</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Final Docs Footer --}}
                <footer class="pt-24 border-t border-white/[0.04] flex flex-col md:flex-row items-center justify-between gap-12 font-heading">
                    <div class="flex items-center gap-4">
                        <div class="w-2.5 h-2.5 bg-[#00e5a0] rounded-full shadow-[0_0_8px_#00e5a0]"></div>
                        <span class="text-[11px] font-black text-[#3a5a7a] tracking-[5px] uppercase">Nexus Telemetry: Operational</span>
                    </div>
                    <div class="flex items-center gap-10">
                        <a href="#" class="text-[10px] font-black uppercase text-white/30 hover:text-cyan-400 transition-all flex items-center gap-3 tracking-[3px] border-b border-transparent hover:border-cyan-400/20 pb-1">
                            <i data-lucide="github" class="w-4 h-4"></i> Edit Node
                        </a>
                        <a @click="scrollTo('first-deployment')" class="btn-primary pl-8 pr-12 py-4 relative group">
                            <i data-lucide="arrow-right" class="w-4 h-4 order-last absolute right-5 group-hover:translate-x-1 transition-transform"></i>
                            Initiate Pulse
                        </a>
                    </div>
                </footer>
            </article>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
