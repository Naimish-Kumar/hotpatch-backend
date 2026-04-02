<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HotPatch') }} – @yield('page_title', 'Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link.active { @apply bg-[#00d4ff] text-[#050505] shadow-[0_10px_30px_rgba(0,212,255,0.25)]; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#050505] text-[#f0f6ff] antialiased overflow-hidden h-screen flex font-jakarta selection:bg-cyan-500/30 selection:text-cyan-200" style="font-family: 'Inter', sans-serif;">

    {{-- 🔥 BACKGROUND EFFECTS --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-cyan-500/[0.03] blur-[150px] rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-500/[0.03] blur-[150px] rounded-full translate-x-1/2 translate-y-1/2"></div>
    </div>

    {{-- ─── SIDEBAR ─── --}}
    <aside class="w-[300px] border-r border-white/[0.05] bg-[#050505]/40 backdrop-blur-3xl flex flex-col shrink-0 relative z-50 shadow-2xl font-heading">
        <div class="p-10 pb-12">
            <a href="{{ route('home') }}" class="group/logo block transition-transform group-hover/logo:scale-[1.02]">
                <x-logo width="150" height="38" class="brightness-125" />
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto px-6 space-y-2 pt-2 pb-12 scrollbar-hide">
            <div class="text-[9px] font-black tracking-[5px] uppercase text-[#3a5a7a] px-5 mb-5 opacity-60">Fleet Intelligence</div>
            
            @php
            $links = [
                ['route' => 'dashboard', 'label' => 'Telemetry', 'icon' => 'activity'],
                ['route' => 'releases', 'label' => 'Releases', 'icon' => 'package'],
                ['route' => 'devices', 'label' => 'Metric Nodes', 'icon' => 'smartphone'],
            ];
            $mgmt = [
                ['route' => 'security', 'label' => 'Audit Log', 'icon' => 'shield-check'],
                ['route' => 'webhooks', 'label' => 'Webhooks', 'icon' => 'webhook'],
                ['route' => 'settings', 'label' => 'Registry Config', 'icon' => 'settings-2'],
            ];
            @endphp

            @foreach($links as $l)
            <a href="{{ route($l['route']) }}" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-[22px] transition-all duration-300 text-[11px] font-black uppercase tracking-[2.5px] border border-transparent @if(request()->routeIs($l['route'])) bg-[#00d4ff] text-[#050505] shadow-[0_12px_24px_rgba(0,212,255,0.25)] @else text-[#5c7a9e] hover:bg-white/5 hover:text-white @endif group">
                <i data-lucide="{{ $l['icon'] }}" class="w-5 h-5 group-hover:scale-110 group-hover:rotate-6 transition-all"></i>
                {{ $l['label'] }}
            </a>
            @endforeach

            <div class="pt-12 pb-5 px-5 text-[9px] font-black text-[#3a5a7a] uppercase tracking-[5px] opacity-60">Cluster Ops</div>

            @foreach($mgmt as $l)
            <a href="#" class="sidebar-link flex items-center gap-4 px-6 py-4 rounded-[22px] transition-all duration-300 text-[11px] font-black uppercase tracking-[2.5px] border border-transparent text-[#5c7a9e] hover:bg-white/5 hover:text-white group">
                <i data-lucide="{{ $l['icon'] }}" class="w-5 h-5 group-hover:scale-110 transition-all"></i>
                {{ $l['label'] }}
            </a>
            @endforeach

            @if(auth()->user()->is_super_admin ?? false)
            <div class="pt-12 pb-5 px-5 text-[9px] font-black text-purple-400 uppercase tracking-[5px] opacity-60">Super Administrator</div>
            <a href="#" class="flex items-center gap-4 px-6 py-4 rounded-[22px] bg-purple-500/10 border border-purple-500/20 text-purple-300 hover:bg-purple-500/20 transition-all text-[11px] font-black uppercase tracking-[2.5px] group shadow-[0_10px_20px_rgba(139,92,246,0.1)]">
                <i data-lucide="terminal" class="w-5 h-5 group-hover:scale-110 transition-all"></i>
                Command Deck
            </a>
            @endif
        </nav>

        {{-- Member Context --}}
        <div class="p-8 border-t border-white/[0.04] bg-black/40 backdrop-blur-3xl m-4 rounded-[32px] border border-white/[0.02]">
            @php $user = auth()->user(); @endphp
            <div class="flex items-center gap-4 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 shadow-inner group-hover:scale-110 transition-transform">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[11px] font-black truncate text-white leading-none mb-1.5 uppercase tracking-tight">{{ $user->display_name ?? 'Operator' }}</p>
                    <p class="text-[9px] text-[#3a5a7a] font-black truncate uppercase tracking-[2px] opacity-70">Cluster Leader</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full text-center px-4 py-3 text-[10px] font-black text-red-400/80 hover:text-red-400 hover:bg-red-400/5 rounded-[18px] border border-red-500/10 transition-all flex items-center justify-center gap-3 uppercase tracking-[3px] shadow-lg group">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    Disconnect
                </button>
            </form>
        </div>
    </aside>

    {{-- ─── DISPLAY VIEW ─── --}}
    <div class="flex-1 flex flex-col min-w-0 bg-[#050505] relative z-10 transition-all">
        <header class="h-20 border-b border-white/[0.04] flex items-center justify-between px-12 bg-[#050505]/40 backdrop-blur-3xl sticky top-0 z-[100] font-heading">
            <div class="flex items-center gap-6">
                <div class="relative flex items-center justify-center">
                    <div class="absolute w-4 h-4 bg-cyan-400 rounded-full animate-ping opacity-20"></div>
                    <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full shadow-[0_0_8px_rgba(0,212,255,1)]"></div>
                </div>
                <h2 class="text-[11px] font-black tracking-[6px] text-white/50 uppercase">@yield('page_title', 'Cluster Overview')</h2>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 px-6 py-2.5 bg-white/[0.02] border border-white/[0.06] rounded-2xl shadow-inner group cursor-pointer hover:border-[#00d4ff]/20 transition-all">
                    <div class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[3px]">ACTIVE NODE</div>
                    <div class="h-4 w-px bg-white/10"></div>
                    <div class="flex items-center gap-3 text-[11px] font-black uppercase text-white tracking-[2px]">
                        <i data-lucide="cpu" class="w-4 h-4 text-cyan-400"></i>
                        <span>EU-CENTRAL-1</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-white/30 group-hover:translate-y-0.5 transition-transform"></i>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-center justify-center text-[#5c7a9e] relative group cursor-pointer hover:bg-white/[0.05] hover:border-white/10 transition-all shadow-xl">
                    <i data-lucide="bell" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="absolute top-3 right-3 w-2 h-2 bg-[#00d4ff] rounded-full shadow-[0_0_10px_rgba(0,212,255,1)] border-2 border-[#050505]"></span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-12 scrollbar-hide afu">
            <div class="max-w-[1500px] mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.afu').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
