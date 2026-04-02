@extends('layouts.main')

@section('title', 'Get Started')

@section('content')
<div class="min-h-[90vh] flex items-center justify-center p-6 relative overflow-hidden">
    <div class="hero-grid absolute inset-0 opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-cyan-500/5 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[480px] afu font-jakarta">
        <div class="text-center mb-12">
            <a href="{{ route('home') }}" class="inline-block hover:scale-105 active:scale-95 transition-transform duration-300">
                <x-logo width="180" height="46" />
            </a>
        </div>

        <div class="glass-card shadow-2xl p-12 border-white/10 relative overflow-hidden group">
            <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-cyan-500/5 blur-[120px] rounded-full pointer-events-none group-hover:bg-cyan-500/10 transition-colors duration-1000"></div>
            
            <div class="relative z-10">
                <h1 class="font-heading text-4xl font-black text-white tracking-tight text-center mb-3 uppercase">Boarding.</h1>
                <p class="text-[11px] text-[#5c7a9e] text-center mb-12 font-black uppercase tracking-[5px] leading-none opacity-60">Initialize Platform Account</p>

                {{-- Errors --}}
                @if($errors->any())
                <div class="mb-10 p-5 rounded-2xl text-[12px] font-bold text-[#ff4d6a] flex items-start gap-4 backdrop-blur-3xl bg-[#ff4d6a]/10 border border-[#ff4d6a]/20 shadow-xl afu">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="leading-relaxed italic">{{ $errors->first() }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-8">
                    @csrf
                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block mb-4 group-focus-within:text-cyan-400 transition-colors font-heading">Display Identity</label>
                        <div class="relative">
                            <i data-lucide="user" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                            <input type="text" name="display_name" value="{{ old('display_name') }}" placeholder="Operator Name" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4.5 pl-14 pr-5 text-[14px] text-white focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:opacity-20 shadow-lg">
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block mb-4 group-focus-within:text-cyan-400 transition-colors font-heading">Secure Communication</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4.5 pl-14 pr-5 text-[14px] text-white focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:opacity-20 shadow-lg">
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block mb-4 group-focus-within:text-cyan-400 transition-colors font-heading">Master Credential</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4.5 pl-14 pr-5 text-[14px] text-white focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:opacity-20 shadow-lg">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full py-5 text-xs text-black font-black uppercase tracking-[5px] bg-[#00d4ff] mt-4 shadow-[0_15px_30px_rgba(0,212,255,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-transform duration-300 font-heading flex items-center justify-center gap-3">
                        <span>Initialize Node</span>
                        <i data-lucide="zap" class="w-4.5 h-4.5"></i>
                    </button>

                    <div class="relative py-8 flex items-center gap-6">
                        <div class="flex-1 h-px bg-white/5"></div>
                        <span class="text-[9px] font-black text-white/20 uppercase tracking-[4px]">Unified ID</span>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>

                    <a href="{{ route('auth.google') }}" class="btn-secondary w-full py-5 flex items-center justify-center gap-4 hover:border-cyan-400 group transition-all duration-700 font-heading">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        <span>OAuth Identity Hub</span>
                    </a>
                </form>

                <div class="mt-14 pt-8 border-t border-white/5 text-center">
                    <p class="text-[11px] text-[#5c7a9e] uppercase tracking-[4px] font-black mb-4 font-heading">Already Verified?</p>
                    <a href="{{ route('login') }}" class="inline-block py-2 text-[11px] font-black text-cyan-400 hover:text-white transition-all duration-400 uppercase tracking-[4px] border-b-2 border-transparent hover:border-white/20 pb-1 font-heading">
                        Connect To Console <i data-lucide="arrow-right" class="w-3.5 h-3.5 inline ml-2 mb-0.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
