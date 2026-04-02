<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HotPatch') }} – @yield('title', 'Next-Gen OTA Updates')</title>
    <meta name="description" content="HotPatch provides instantaneous, over-the-air updates for React Native, Flutter, and Capacitor apps with zero downtime and built-in rollbacks.">
    
    {{-- SEO --}}
    <meta property="og:title" content="HotPatch – Instant OTA Updates">
    <meta property="og:description" content="Ship features, fix bugs, and iterate faster with our unified OTA dashboard.">
    <meta property="og:image" content="/og-image.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .glass-nav {
            background: rgba(5, 5, 5, 0.7);
            backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="selection:bg-cyan-500/30 selection:text-cyan-200 antialiased overflow-x-hidden">

    {{-- ─── NAVIGATION ─── --}}
    <nav class="fixed top-0 left-0 right-0 z-[60] glass-nav h-20 transition-all duration-300" 
         x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="scrolled ? 'h-16 border-white/5' : 'h-20 border-transparent'">
        
        <div class="max-w-7xl mx-auto h-full px-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group transition-transform active:scale-95 duration-200 flex items-center gap-2">
                <x-logo width="160" height="40" class="group-hover:opacity-90 transition-opacity" />
            </a>

            <div class="hidden md:flex items-center gap-10">
                <div class="flex items-center gap-8 text-[12px] font-bold uppercase tracking-widest text-[#5c7a9e] font-heading">
                    <a href="{{ route('home') }}#features" class="hover:text-white transition-colors duration-200">Features</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-white transition-colors duration-200">Workflow</a>
                    <a href="{{ route('pricing') }}" class="hover:text-white transition-colors duration-200 @if(request()->routeIs('pricing')) text-white @endif">Pricing</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors duration-200 @if(request()->routeIs('blog.*')) text-white @endif">Blog</a>
                    <a href="{{ route('docs') }}" class="hover:text-white transition-colors duration-200">Docs</a>
                </div>
                
                <div class="h-5 w-px bg-white/10 mx-2"></div>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-white/[0.05] border border-white/10 text-white font-bold text-[12px] uppercase tracking-widest hover:bg-white/10 transition-all shadow-sm flex items-center gap-2 font-heading">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        Console
                    </a>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-[12px] font-bold uppercase tracking-widest text-[#5c7a9e] hover:text-white transition-colors font-heading">Sign In</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-[#00d4ff] text-[#050505] font-black text-[12px] uppercase tracking-widest hover:brightness-110 transition-all shadow-[0_4px_20px_rgba(0,212,255,0.25)] active:scale-95 font-heading">
                            Get Started
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Mobile toggle --}}
            <button class="md:hidden p-2 text-white/70 hover:text-white transition-colors">
                <i data-lucide="menu" class="w-7 h-7"></i>
            </button>
        </div>
    </nav>


    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    {{-- ─── FOOTER ─── --}}
    {{-- ─── FOOTER ─── --}}
    <footer class="bg-[#030303] border-t border-white/[0.04] pt-24 pb-12 overflow-hidden relative font-heading">
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-cyan-500/5 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-20">
                <div class="col-span-2">
                    <x-logo width="140" height="36" class="mb-8" />
                    <p class="text-[#5c7a9e] text-sm max-w-xs leading-relaxed font-jakarta">
                        Instant, over-the-air updates for cross-platform apps. Built by developers, for developers. Push confidence.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-[3px] mb-6">Product</h4>
                    <ul class="text-[#5c7a9e] text-sm space-y-4">
                        <li><a href="#features" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="layers" class="w-4 h-4"></i> Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="credit-card" class="w-4 h-4"></i> Pricing</a></li>
                        <li><a href="{{ route('releases') }}" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="package" class="w-4 h-4"></i> Releases</a></li>
                        <li><a href="{{ route('docs') }}" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="book-open" class="w-4 h-4"></i> Docs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-[3px] mb-6">Company</h4>
                    <ul class="text-[#5c7a9e] text-sm space-y-4">
                        <li><a href="{{ route('blog.index') }}" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="newspaper" class="w-4 h-4"></i> Blog</a></li>
                        <li><a href="{{ route('security') }}" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="shield-check" class="w-4 h-4"></i> Security</a></li>
                        <li><a href="mailto:hello@hotpatch.site" class="hover:text-[#00d4ff] transition-colors flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4"></i> Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-[3px] mb-6">Legal</h4>
                    <ul class="text-[#5c7a9e] text-sm space-y-4">
                        <li><a href="#" class="hover:text-[#00d4ff] transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-[#00d4ff] transition-colors">Terms</a></li>
                        <li><a href="#" class="hover:text-[#00d4ff] transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6 text-[12px] text-[#3a5a7a] font-bold uppercase tracking-widest font-heading">
                <div>© 2025 HotPatch Platform</div>
                <div class="flex items-center gap-10">
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2"><i data-lucide="twitter" class="w-4 h-4"></i> Twitter</a>
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2"><i data-lucide="github" class="w-4 h-4"></i> GitHub</a>
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2"><i data-lucide="gamepad-2" class="w-4 h-4"></i> Discord</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Global animations & icons logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = "1";
                        entry.target.style.transform = "translateY(0)";
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.afu, .afu-1, .afu-2, .afu-3').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
