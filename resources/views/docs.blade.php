@extends('layouts.main')

@section('title', 'Documentation – HotPatch Console')

@section('content')
<div class="relative min-h-screen bg-[#050505] font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200">
    {{-- Background Accents --}}
    <div class="fixed top-0 left-1/4 w-[600px] h-[600px] bg-cyan-500/[0.02] blur-[150px] rounded-full -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-8xl mx-auto px-6 lg:px-12 pt-12 pb-32">
        <div class="flex flex-col lg:flex-row gap-16">
            
            {{-- ─── SIDEBAR NAV ─── --}}
            <aside class="lg:w-72 flex-shrink-0 afu">
                <nav class="sticky top-28 space-y-10 scrollbar-hide">
                    {{-- Search Mockup --}}
                    <div class="relative group mb-10">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                        <input type="text" placeholder="Search docs..." class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-xs font-bold text-white focus:outline-none focus:border-cyan-400 focus:bg-white/[0.05] transition-all font-heading tracking-widest uppercase placeholder:opacity-30 shadow-inner">
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/30 mb-6 font-heading">Getting Started</h5>
                            <ul class="space-y-3 border-l border-white/5 ml-1">
                                <li class="border-l-2 border-cyan-400 -ml-[1px] pl-5"><a href="#introduction" class="text-white font-bold text-[13px] tracking-tight hover:text-cyan-400 transition-colors">Introduction</a></li>
                                <li class="pl-5"><a href="#installation" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Installation</a></li>
                                <li class="pl-5"><a href="#configuration" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Configuration</a></li>
                                <li class="pl-5"><a href="#first-deployment" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">First Deployment</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/30 mb-6 font-heading">Core Concepts</h5>
                            <ul class="space-y-3 border-l border-white/5 ml-1">
                                <li class="pl-5"><a href="#channels-logic" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Channels & Routing</a></li>
                                <li class="pl-5"><a href="#rollouts" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Atomic Rollouts</a></li>
                                <li class="pl-5"><a href="#binary-compatibility" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Binary Compatibility</a></li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="text-[10px] font-black uppercase tracking-[4px] text-white/30 mb-6 font-heading">Reference</h5>
                            <ul class="space-y-3 border-l border-white/5 ml-1">
                                <li class="pl-5"><a href="#cli-ref" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">CLI Commands</a></li>
                                <li class="pl-5"><a href="#api-ref" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Update API</a></li>
                                <li class="pl-5"><a href="#security" class="text-[#5c7a9e] font-bold text-[13px] tracking-tight hover:text-white transition-colors">Security Policy</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 glass-card border-white/5 mt-12 bg-cyan-500/[0.02]">
                        <p class="text-[11px] font-bold text-white mb-3 font-heading uppercase tracking-widest">Need Support?</p>
                        <p class="text-[11px] text-[#5c7a9e] leading-relaxed mb-5 italic font-medium">Get priority assistance from our core engineers.</p>
                        <a href="mailto:support@hotpatch.site" class="text-[10px] font-black text-cyan-400 uppercase tracking-[2px] flex items-center gap-2 group">
                            Contact Engineering
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </nav>
            </aside>

            {{-- ─── MAIN CONTENT ─── --}}
            <article class="flex-1 max-w-4xl afu-1">
                {{-- Breadcrumbs --}}
                <nav class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[3px] text-[#3a5a7a] mb-10 font-heading">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Nexus</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-white/40">Documentation</span>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-cyan-400">Introduction</span>
                </nav>

                <header class="mb-16">
                    <h1 id="introduction" class="font-heading text-6xl lg:text-7xl font-black text-white leading-none tracking-[-3px] mb-8 uppercase">Intelligence <br/><span class="text-cyan-400">Overview.</span></h1>
                    <p class="text-xl text-[#5c7a9e] leading-relaxed font-medium font-jakarta border-l-[3px] border-cyan-500/30 pl-8 py-2">
                        HotPatch is the enterprise-grade over-the-air (OTA) update infrastructure designed for high-velocity mobile teams. Ship JavaScript, assets, and logic changes directly to user devices in milliseconds.
                    </p>
                </header>

                {{-- Scope Card --}}
                <div class="glass-card p-10 border-white/10 mb-20 bg-gradient-to-br from-white/[0.03] to-transparent relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity"><i data-lucide="info" class="w-24 h-24 text-white"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-400">
                                <i data-lucide="scope" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-heading text-xl font-black text-white uppercase tracking-tight">Technical Scope</h4>
                        </div>
                        <div class="grid md:grid-cols-2 gap-10">
                            <div>
                                <h5 class="text-[10px] font-black text-[#00e5a0] uppercase tracking-[3px] mb-3">HotPatch Can Update:</h5>
                                <ul class="space-y-2 text-[13px] text-[#5c7a9e] font-bold">
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="check" class="w-3.5 h-3.5 text-[#00e5a0]"></i> React Native JavaScript Bundle</li>
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="check" class="w-3.5 h-3.5 text-[#00e5a0]"></i> Local Assets (Images, Fonts, JSON)</li>
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="check" class="w-3.5 h-3.5 text-[#00e5a0]"></i> Business Logic & State Rules</li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="text-[10px] font-black text-[#ff4d6a] uppercase tracking-[3px] mb-3">Manual Store Required:</h5>
                                <ul class="space-y-2 text-[13px] text-[#5c7a9e] font-bold opacity-70">
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="x" class="w-3.5 h-3.5 text-[#ff4d6a]"></i> Native Modules (Java/Obj-C/Swift)</li>
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="x" class="w-3.5 h-3.5 text-[#ff4d6a]"></i> app.json / Info.plist Changes</li>
                                    <li class="flex items-center gap-2 font-jakarta"><i data-lucide="x" class="w-3.5 h-3.5 text-[#ff4d6a]"></i> OS Permission Modifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section: Installation --}}
                <section id="installation" class="mb-24">
                    <h2 class="font-heading text-[32px] font-black text-white tracking-tight uppercase mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xs font-black">01</span>
                        Environment Setup
                    </h2>
                    <p class="text-[#5c7a9e] leading-relaxed mb-10 font-bold italic">
                        Initialize the client-side bridge to begin receiving firmware telemetry and update triggers.
                    </p>

                    <div class="space-y-8">
                        <div class="group">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">NPM Registry Distribution</span>
                                <span class="text-[9px] font-bold text-white/20 uppercase tracking-widest px-2 py-0.5 border border-white/10 rounded">stable 2.x</span>
                            </div>
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-cyan-400/20 rounded-2xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative bg-black/60 border border-white/10 rounded-2xl p-7 flex items-center justify-between group-hover:border-cyan-400/30 transition-all shadow-inner">
                                    <code class="font-mono text-sm text-cyan-400">npm install <span class="text-white">@hotpatch/react-native</span> --save</code>
                                    <button class="p-2.5 rounded-xl hover:bg-white/5 text-[#3a5a7a] hover:text-white transition-all"><i data-lucide="copy" class="w-4 h-4"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">Native Bridge Initialization</span>
                            </div>
                            <div class="bg-black/80 border border-white/5 rounded-3xl overflow-hidden shadow-2xl relative">
                                <div class="flex items-center gap-2 px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                                    <div class="flex gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-red-500/20"></div><div class="w-2.5 h-2.5 rounded-full bg-amber-500/20"></div><div class="w-2.5 h-2.5 rounded-full bg-green-500/20"></div></div>
                                    <div class="flex-1 text-center font-mono text-[9px] text-white/20 tracking-widest uppercase">App.tsx — HotPatch Entry</div>
                                </div>
                                <div class="p-8 font-mono text-[13.5px] leading-relaxed">
                                    <div class="flex gap-4"><span class="text-white/20">1</span><span class="text-purple-400 italic">import</span><span> { HotPatch } <span class="text-purple-400">from</span> <span class="text-emerald-400">'@hotpatch/react-native'</span>;</span></div>
                                    <div class="flex gap-4"><span class="text-white/20">2</span><span></span></div>
                                    <div class="flex gap-4"><span class="text-white/20">3</span><span class="text-purple-400 italic">const</span><span> hp = <span class="text-purple-400">new</span> <span class="text-cyan-400">HotPatch</span>({</span></div>
                                    <div class="flex gap-4"><span class="text-white/20">4</span><span>  appId: <span class="text-emerald-400">'HP_PROJECT_ID_64'</span>,</span></div>
                                    <div class="flex gap-4"><span class="text-white/20">5</span><span>  channel: <span class="text-emerald-400">__DEV__ ? 'staging' : 'production'</span></span></div>
                                    <div class="flex gap-4"><span class="text-white/20">6</span><span>});</span></div>
                                    <div class="flex gap-4"><span class="text-white/20">7</span><span></span></div>
                                    <div class="flex gap-4"><span class="text-white/20">8</span><span>hp.init();</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section: CLI --}}
                <section id="cli-ref" class="mb-24">
                    <h2 class="font-heading text-[32px] font-black text-white tracking-tight uppercase mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xs font-black">02</span>
                        Terminal Interface
                    </h2>
                    <p class="text-[#5c7a9e] leading-relaxed mb-10 font-bold">
                        Our CLI is the primary catalyst for bundle generation, optimization, and deployment.
                    </p>

                    <div class="grid md:grid-cols-2 gap-6">
                        @php
                        $commands = [
                            ['c' => 'hotpatch login', 'd' => 'Authorize your terminal with the cloud cluster.'],
                            ['c' => 'hotpatch bundle', 'd' => 'Synthesize a new JS bundle with optimized hashing.'],
                            ['c' => 'hotpatch deploy', 'd' => 'Atomic transition of current bundle to target channel.'],
                            ['c' => 'hotpatch rollback', 'd' => 'Instant regression to the previous known stable version.'],
                        ];
                        @endphp
                        @foreach($commands as $cmd)
                        <div class="p-8 glass-card border-white/5 hover:border-[#00d4ff]/30 transition-all group flex flex-col justify-between">
                            <div>
                                <div class="font-mono text-cyan-400 mb-4 text-sm font-bold tracking-tight group-hover:translate-x-1 transition-transform">$ {{ $cmd['c'] }}</div>
                                <p class="text-[12px] text-[#5c7a9e] leading-relaxed font-bold italic">{{ $cmd['d'] }}</p>
                            </div>
                            <div class="pt-6 flex justify-end">
                                <i data-lucide="terminal" class="w-4 h-4 text-white/10 group-hover:text-cyan-500/20 transition-colors"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                {{-- Alert: Store Policy --}}
                <div class="p-12 rounded-[40px] border border-amber-500/10 bg-amber-500/[0.02] mb-32 relative overflow-hidden font-jakarta">
                    <div class="absolute top-0 right-0 p-10 opacity-5"><i data-lucide="alert-triangle" class="w-32 h-32 text-amber-500"></i></div>
                    <div class="flex gap-8 relative z-10">
                        <div class="w-14 h-14 rounded-[22px] bg-amber-500/10 flex items-center justify-center text-amber-500 shrink-0 border border-amber-500/10 shadow-2xl">
                            <i data-lucide="shield-alert" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h4 class="font-heading text-2xl font-black text-amber-500 mb-4 tracking-tight uppercase">App Store Compliance</h4>
                            <p class="text-[#5c7a9e] leading-relaxed mb-6 font-medium italic">
                                Apple's developer guidelines (Section 3.3.2) and Google Play's policies allow for dynamically downloading updates for interpreting code (JS/Assets) as long as it does not change the <span class="text-white">primary purpose</span> of the app.
                            </p>
                            <p class="text-[11px] font-black text-[#5c7a9e] uppercase tracking-[3px] opacity-60">HOTPATCH ENFORCES CONTEXT-AWARE DEPLOYMENTS TO ENSURE POLICY ADHERENCE.</p>
                        </div>
                    </div>
                </div>

                {{-- Footer Docs --}}
                <footer class="pt-16 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-10 font-heading">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-[#00e5a0] rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-black text-[#3a5a7a] tracking-[4px] uppercase">Telemetry Stable · Last Mod Apr 02</span>
                    </div>
                    <div class="flex items-center gap-8">
                        <a href="#" class="text-[10px] font-black uppercase tracking-[3px] text-white/30 hover:text-cyan-400 transition-all flex items-center gap-3">
                            <i data-lucide="github" class="w-4 h-4"></i> Edit On GitHub
                        </a>
                        <a href="{{ route('home') }}#how-it-works" class="px-7 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white font-black text-[10px] uppercase tracking-[3px] hover:bg-white/10 transition-all shadow-sm">
                            Next: Architecture &rarr;
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
