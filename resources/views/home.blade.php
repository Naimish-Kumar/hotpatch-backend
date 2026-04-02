@extends('layouts.main')

@section('content')
{{-- ─── HERO ─── --}}
<section class="relative min-h-[92vh] flex items-center justify-center text-center px-6 pt-12 pb-32 overflow-hidden">
    <div class="hero-grid absolute inset-0 opacity-40"></div>
    <div class="absolute top-[40%] left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] rounded-full blur-[160px] pointer-events-none" style="background:radial-gradient(ellipse,rgba(0,212,255,.15),transparent 70%)"></div>

    <div class="relative z-10 max-w-5xl mx-auto afu font-jakarta">
        <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/[0.03] border border-white/5 rounded-full mb-10 group cursor-default shadow-xl">
            <span class="badge-dot"></span>
            <span class="text-[10px] font-black tracking-[3.5px] uppercase text-[#00d4ff] group-hover:tracking-[4.5px] transition-all font-heading">v2.0 Beta Live</span>
        </div>

        <h1 class="font-heading text-[clamp(48px,9vw,110px)] font-black leading-[0.85] tracking-[-5px] text-white mb-10">
            Ship. Learn.<br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-cyan-600">HotPatch It.</span>
        </h1>

        <p class="text-[clamp(16px,2vw,20px)] text-[#5c7a9e] max-w-2xl mx-auto mb-14 leading-relaxed font-medium">
            The instant OTA infrastructure for React Native, Flutter, and Capacitor. Skip store reviews and fix critical bugs in seconds.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-6 mb-24 afu-2 font-heading">
            <a href="{{ route('register') }}" class="btn-primary flex items-center gap-3 py-4 px-8 text-xs uppercase tracking-widest bg-cyan-400">
                <span>Start Deployment</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="#how-it-works" class="btn-secondary py-4 px-8 text-xs uppercase tracking-widest border-white/10 hover:border-white/20 flex items-center gap-2">
                <i data-lucide="play-circle" class="w-4 h-4"></i>
                Explore Workflow
            </a>
        </div>

        {{-- CLI Mockup --}}
        <div class="relative group max-w-[800px] mx-auto afu-3">
            <div class="absolute -inset-1 bg-gradient-to-r from-[#00d4ff]/20 to-purple-500/20 rounded-[32px] blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative glass-card overflow-hidden border-white/10 shadow-2xl">
                <div class="h-11 bg-white/[0.03] border-b border-white/5 flex items-center px-5 gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500/20 border border-red-500/30"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500/20 border border-amber-500/30"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/20 border border-green-500/30"></div>
                    <div class="flex-1 flex justify-center"><div class="text-[10px] uppercase font-black tracking-widest text-white/20 font-heading">hotpatch — bash</div></div>
                </div>
                <div class="p-8 text-left font-mono text-[13.5px] leading-relaxed space-y-3">
                    <div class="flex gap-4"><span class="text-white/20">1</span><span class="text-green-400">$</span><span>npm install <span class="text-white">@hotpatch/cli</span> -g</span></div>
                    <div class="flex gap-4"><span class="text-white/20">2</span><span class="text-green-400">$</span><span>hotpatch <span class="text-cyan-300">init</span></span></div>
                    <div class="flex gap-4"><span class="text-white/20">3</span><span class="text-white/20">... initializing project ...</span></div>
                    <div class="flex gap-4"><span class="text-white/20">4</span><span class="text-green-400">$</span><span>hotpatch <span class="text-amber-400">deploy</span> --target production</span></div>
                    <div class="flex gap-4 group/line"><span class="text-white/20">5</span><span class="text-green-400">✓</span><span class="text-white font-bold italic group-hover:translate-x-1 transition-transform">Bundle optimized (1.2MB &rarr; 44KB)</span></div>
                    <div class="flex gap-4"><span class="text-white/20">6</span><span class="text-green-400">✓</span><span class="text-[#00e5a0]">Update live on 14,290 devices!</span><span class="cursor-blink"></span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── TRUSTED BY ─── --}}
<section class="border-y border-white/[0.04] py-12 bg-white/[0.01]">
    <div class="max-w-7xl mx-auto px-6 overflow-hidden">
        <div class="flex items-center justify-between gap-12 opacity-40 grayscale group hover:opacity-100 transition-opacity font-heading font-black text-xl tracking-tighter uppercase">
            <span class="whitespace-nowrap">CloudScale</span>
            <span class="whitespace-nowrap">NitroDev</span>
            <span class="whitespace-nowrap">SwiftOps</span>
            <span class="whitespace-nowrap">HyperPort</span>
            <span class="whitespace-nowrap">VectorCore</span>
        </div>
    </div>
</section>

{{-- ─── FEATURES ─── --}}
<section id="features" class="max-w-7xl mx-auto px-6 py-32 font-jakarta">
    <div class="grid lg:grid-cols-2 gap-20 items-end mb-24 afu">
        <div>
            <p class="text-[11px] font-black tracking-[4.5px] text-[#00d4ff] uppercase mb-5 font-heading">Enterprise Power</p>
            <h2 class="font-heading text-[clamp(32px,5vw,64px)] font-black text-white tracking-[-3px] leading-[0.9] mb-8">
                The most reliable<br/>OTA infra ever built.
            </h2>
            <p class="text-lg text-[#5c7a9e] font-medium leading-relaxed max-w-md">
                We handle the complexity of diffs, caching, and atomic rollouts so you can focus on building features.
            </p>
        </div>
        <div class="flex gap-6 afu-2">
            <div class="flex-1 p-8 glass-card border-cyan-500/10">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center mb-6 text-cyan-400">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h4 class="font-bold text-white mb-2 font-heading tracking-tight">Atomic Rollouts</h4>
                <p class="text-xs text-[#5c7a9e] leading-relaxed italic">Never leave a user in a half-updated state. Automated self-healing ensures stability.</p>
            </div>
            <div class="flex-1 p-8 glass-card border-purple-500/10 mt-12">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center mb-6 text-purple-400">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                </div>
                <h4 class="font-bold text-white mb-2 font-heading tracking-tight">Smart Diffs</h4>
                <p class="text-xs text-[#5c7a9e] leading-relaxed italic">Our algorithm only sends modified bytes. Reduced 98% bandwidth usage in production.</p>
            </div>
        </div>
    </div>

    @php
    $features = [
        ['i' => 'trending-up', 't' => 'Gradual Rollouts', 'd' => 'Ship to 5% first, watch the metrics, and expand confidently with a single slider.'],
        ['i' => 'cpu', 't' => 'Plugin System', 'd' => 'Native plugins for Asset Management, Translation Keys, and dynamic JSON updates.'],
        ['i' => 'route', 't' => 'Smart Traffic', 'd' => 'Channel-based routing: Production, Staging, and Beta - all managed in one place.'],
        ['i' => 'pie-chart', 't' => 'Live Analytics', 'd' => 'Track adoption rates, version distribution, and potential issues in real-time.'],
        ['i' => 'globe', 't' => 'Global CDN', 'd' => '300+ Edge nodes worldwide ensure your updates are delivered closest to your users.'],
        ['i' => 'refresh-ccw', 't' => 'Instant Rollback', 'd' => 'Made a mistake? Roll back to any previous version across your entire fleet in milliseconds.'],
    ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 afu-3">
        @foreach($features as $f)
        <div class="p-10 glass-card glass-card-hover border-white/5 flex flex-col items-center text-center group">
            <div class="w-16 h-16 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center text-cyan-400 mb-8 group-hover:scale-110 transition-transform duration-500 shadow-xl group-hover:border-cyan-500/20">
                <i data-lucide="{{ $f['i'] }}" class="w-7 h-7"></i>
            </div>
            <h3 class="font-heading text-2xl font-bold text-white mb-4 tracking-tight">{{ $f['t'] }}</h3>
            <p class="text-sm text-[#5c7a9e] leading-relaxed">{{ $f['d'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ─── HOW IT WORKS ─── --}}
<section id="how-it-works" class="py-32 relative overflow-hidden font-jakarta">
    <div class="absolute -left-40 top-0 w-[400px] h-[400px] bg-purple-500/5 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-32 items-center">
            <div>
                <p class="text-[11px] font-black tracking-[4.5px] text-[#00d4ff] uppercase mb-8 font-heading">Architecture</p>
                <div class="space-y-12">
                    @php
                    $steps = [
                        ['n' => '01', 'i' => 'code-2', 't' => 'Integrate SDK', 'd' => 'Available for React Native, Flutter, and Capacitor. Just three lines of code to enable OTA power.'],
                        ['n' => '02', 'i' => 'terminal', 't' => 'Push with CLI', 'd' => 'Use our CLI or Dashboard to upload new versions. We handle delta generation automatically.'],
                        ['n' => '03', 'i' => 'rocket', 't' => 'Go Live Instantly', 'd' => 'Select your target channel and rollout percentage. Your users get the update on the next app open.'],
                    ];
                    @endphp
                    @foreach($steps as $s)
                    <div class="group flex gap-8 afu">
                        <div class="font-heading text-6xl font-black text-white/5 select-none transition-all group-hover:text-cyan-500/20 group-hover:scale-110">{{ $s['n'] }}</div>
                        <div class="pt-2">
                            <div class="flex items-center gap-3 mb-3">
                                <i data-lucide="{{ $s['i'] }}" class="w-5 h-5 text-cyan-400"></i>
                                <h4 class="font-heading text-2xl font-black text-white tracking-tight">{{ $s['t'] }}</h4>
                            </div>
                            <p class="text-[#5c7a9e] leading-relaxed text-[15px] max-w-sm">{{ $s['d'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="relative afu-2">
                <div class="absolute -inset-10 bg-cyan-500/10 blur-[100px] rounded-full"></div>
                <div class="glass-card p-10 border-white/10 shadow-2xl relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-10">
                        <div class="font-black text-[10px] uppercase tracking-[3px] text-white/30 font-heading">Analytics Engine</div>
                        <div class="status-dot on uppercase font-black text-[#00e5a0] text-[9px] tracking-widest font-heading">Processing</div>
                    </div>
                    
                    <div class="space-y-8">
                        <div>
                            <div class="flex justify-between items-end mb-3">
                                <span class="text-xs font-bold text-white font-heading tracking-tight">Production V1.0.4</span>
                                <span class="font-mono text-[10px] text-cyan-400">92%</span>
                            </div>
                            <div class="ptrack"><div class="pfill group-hover:bg-cyan-400 transition-colors" style="width:92%"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-3">
                                <span class="text-xs font-bold text-white font-heading tracking-tight">Staging V1.1.0-rc</span>
                                <span class="font-mono text-[10px] text-purple-400">100%</span>
                            </div>
                            <div class="ptrack"><div class="pfill bg-purple-500" style="width:100%"></div></div>
                        </div>
                        
                        <div class="pt-6 grid grid-cols-7 gap-1 h-32 items-end">
                            @php $bars = [30, 45, 40, 80, 100, 60, 85]; @endphp
                            @foreach($bars as $h)
                            <div class="flex-1 bg-white/5 rounded-t-lg group-hover:bg-cyan-500/20 transition-all duration-700" style="height:{{ $h }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── PRICING PREVIEW ─── --}}
<section class="py-32 bg-white/[0.01] border-y border-white/[0.04] font-jakarta">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="font-heading text-5xl font-black text-white mb-6 tracking-tight">Built for every <span class="text-amber-400">Scale.</span></h2>
        <p class="text-[#5c7a9e] mb-20 max-w-xl mx-auto font-medium">From solo devs to global fleets. Start for free. Scale when you're ready.</p>

        <div class="grid md:grid-cols-3 gap-8 items-start">
            @forelse($packages as $pkg)
            <div class="p-10 glass-card border-white/5 relative flex flex-col h-full group hover:border-white/10 transition-all {{ $pkg->slug === 'pro' ? 'border-cyan-500/20 shadow-2xl scale-[1.03] z-20' : '' }}">
                @if($pkg->slug === 'pro')
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-black font-black text-[9px] uppercase tracking-widest rounded-full shadow-lg font-heading">Recommended</div>
                @endif
                
                <h3 class="font-heading text-3xl font-black text-white mb-2 tracking-tight">{{ $pkg->name }}</h3>
                <div class="flex items-baseline justify-center gap-1 mb-8">
                    <span class="text-4xl font-black text-white font-heading">${{ $pkg->price }}</span>
                    <span class="text-[#5c7a9e] text-[10px] font-black uppercase tracking-widest font-heading">/ MONTH</span>
                </div>

                <ul class="space-y-4 mb-10 text-left flex-grow">
                    @foreach(explode(';', $pkg->features) as $f)
                    <li class="flex items-center gap-3 text-[13px] text-[#5c7a9e] font-semibold">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-[#00e5a0]"></i>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="w-full py-4 rounded-xl font-black text-xs uppercase tracking-[2px] transition-all font-heading {{ $pkg->slug === 'pro' ? 'bg-white text-black hover:bg-cyan-400' : 'bg-white/5 border border-white/10 text-white hover:bg-white/10' }}">
                    Get Started
                </a>
            </div>
            @empty
                <div class="col-span-3 text-[#5c7a9e] italic">No active plans found. Please check back later.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ─── FAQ ─── --}}
<section class="max-w-4xl mx-auto px-6 py-32 font-jakarta">
    <div class="text-center mb-20">
        <h2 class="font-heading text-5xl font-black text-white mb-6 tracking-tighter">Common <span class="text-purple-400">Questions</span></h2>
    </div>
    
    <div class="space-y-4" x-data="{ open: null }">
        @php
        $faqs = [
            ['q' => 'How does the pricing work?', 'a' => 'We charge based on active monthly devices. You only pay for what you use, starting with a generous free tier for smaller projects.'],
            ['q' => 'Is it compatible with EXPO?', 'a' => 'Yes! HotPatch works seamlessly with Expo development clients and bare workflows. No configuration required.'],
            ['q' => 'How secure are the updates?', 'a' => 'Every bundle is signed with a private key. We use AES-256 encryption for both transport and storage of your app assets.'],
            ['q' => 'Do I need to submit to App Store again?', 'a' => 'Only for native binary changes. JavaScript, images, and other assets can be updated instantly over-the-air through HotPatch.'],
        ];
        @endphp
        
        @foreach($faqs as $i => $faq)
        <div class="glass-card border-white/5 transition-all overflow-hidden group">
            <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full p-6 text-left flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                <span class="font-bold text-white group-hover:text-cyan-400 transition-colors font-heading text-lg tracking-tight">{{ $faq['q'] }}</span>
                <span class="text-cyan-500 transition-transform duration-300" :class="open === {{ $i }} ? 'rotate-180' : ''">
                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                </span>
            </button>
            <div x-show="open === {{ $i }}" x-collapse x-cloak>
                <div class="p-6 pt-0 text-[15px] text-[#5c7a9e] leading-relaxed italic border-t border-white/5 bg-black/20">
                    {{ $faq['a'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="max-w-7xl mx-auto px-6 pb-40 font-jakarta">
    <div class="p-20 glass-card bg-gradient-to-tr from-cyan-600/10 via-transparent to-purple-600/10 border-white/10 text-center relative overflow-hidden group">
        <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-cyan-500/5 blur-[120px] rounded-full animate-pulse"></div>
        <div class="relative z-10">
            <h2 class="font-heading text-5xl md:text-7xl font-black text-white mb-8 tracking-tighter leading-none group-hover:scale-[1.02] transition-transform duration-700">Ready to ship <br/>with total <span class="text-[#00e5a0]">control?</span></h2>
            <p class="text-lg text-[#5c7a9e] mb-12 max-w-xl mx-auto font-medium">Join 2,000+ engineers building the future of mobile apps.</p>
            <div class="flex items-center justify-center gap-10 flex-wrap font-heading">
                <a href="{{ route('register') }}" class="btn-primary py-4 px-10 text-xs uppercase tracking-widest shadow-2xl hover:scale-105 active:scale-95 transition-all">Start For Free</a>
                <a href="{{ route('docs') }}" class="text-white hover:text-[#00d4ff] font-bold text-xs tracking-[3px] transition-colors flex items-center gap-3 uppercase">
                    READ THE DOCS
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
