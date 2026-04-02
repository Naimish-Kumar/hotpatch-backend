@extends('layouts.main')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[90vh] flex items-center justify-center p-6 relative overflow-hidden" x-data="{ mode: 'email' }">
    <div class="hero-grid absolute inset-0 opacity-40"></div>
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-cyan-500/5 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[440px] afu font-jakarta">
        <div class="text-center mb-12">
            <a href="{{ route('home') }}" class="inline-block hover:scale-105 active:scale-95 transition-transform duration-300">
                <x-logo width="180" height="46" />
            </a>
        </div>

        <div class="glass-card shadow-2xl p-12 border-white/10 relative overflow-hidden group">
            <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-cyan-500/5 blur-[120px] rounded-full pointer-events-none group-hover:bg-cyan-500/10 transition-colors duration-1000"></div>
            
            <div class="relative z-10">
                <h1 class="font-heading text-4xl font-black text-white tracking-tight text-center mb-3 uppercase">Welcome Back.</h1>
                <p class="text-[11px] text-[#5c7a9e] text-center mb-12 font-black uppercase tracking-[4px] leading-none opacity-60">Console Authentication</p>

                {{-- Errors --}}
                @if($errors->any())
                <div class="mb-10 p-5 rounded-2xl text-[12px] font-bold text-[#ff4d6a] flex items-start gap-4 backdrop-blur-3xl bg-[#ff4d6a]/10 border border-[#ff4d6a]/20 shadow-xl afu font-jakarta">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="leading-relaxed italic">{{ $errors->first() }}</span>
                </div>
                @endif

                {{-- Tab Selection --}}
                <div class="flex p-1.5 rounded-2xl mb-10 bg-black/40 border border-white/5 backdrop-blur shadow-inner">
                    <button @click="mode = 'email'" :class="mode === 'email' ? 'bg-[#00d4ff] text-[#050505]' : 'text-[#5c7a9e] hover:text-white'" class="flex-1 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all duration-300 font-heading">Email Cloud</button>
                    <button @click="mode = 'apikey'" :class="mode === 'apikey' ? 'bg-[#00d4ff] text-[#050505]' : 'text-[#5c7a9e] hover:text-white'" class="flex-1 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all duration-300 font-heading">Local Key</button>
                </div>

                {{-- Email Login --}}
                <form x-show="mode === 'email'" method="POST" action="{{ route('login') }}" class="space-y-8" x-transition:enter.delay.100ms.duration.300ms>
                    @csrf
                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block mb-4 group-focus-within:text-cyan-400 transition-colors font-heading">Access Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4.5 pl-14 pr-5 text-[15px] text-white focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:text-[#3a203a20] placeholder:opacity-30 shadow-lg font-jakarta">
                        </div>
                    </div>
                    <div class="group font-jakarta">
                        <div class="flex justify-between items-center mb-4">
                            <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block group-focus-within:text-cyan-400 transition-colors font-heading">Credential Pass</label>
                            <a href="#" class="text-[9px] font-black uppercase tracking-widest text-[#5c7a9e] hover:text-white transition-colors">Forgot?</a>
                        </div>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#3a5a7a] group-focus-within:text-cyan-400 transition-colors"></i>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl py-4.5 pl-14 pr-5 text-[15px] text-white focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:text-[#3a203a20] placeholder:opacity-30 shadow-lg">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full py-5 text-xs text-black font-black uppercase tracking-[5px] bg-[#00d4ff] mt-4 shadow-[0_15px_30px_rgba(0,212,255,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-transform duration-300 font-heading flex items-center justify-center gap-3">
                        <span>Enter Console</span>
                        <i data-lucide="chevron-right" class="w-4.5 h-4.5"></i>
                    </button>
                    
                    <div class="relative py-8 flex items-center gap-6">
                        <div class="flex-1 h-px bg-white/5"></div>
                        <span class="text-[9px] font-black text-white/20 uppercase tracking-[4px]">Unified ID</span>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>

                    <a href="{{ route('auth.google') }}" class="btn-secondary w-full py-5 flex items-center justify-center gap-4 hover:border-cyan-400 group transition-all duration-700 font-heading">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        <span>OAuth Identity Center</span>
                    </a>
                </form>

                {{-- API Key Login --}}
                <form x-show="mode === 'apikey'" class="space-y-8" x-transition:enter.delay.100ms.duration.300ms>
                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[4px] block mb-4 group-focus-within:text-cyan-400 transition-colors font-heading">Master API Key</label>
                        <input type="password" placeholder="hp_live_xxxxxxxx" 
                            class="font-mono w-full bg-black/40 border border-white/10 rounded-2xl py-5 px-6 text-[14px] text-[#00d4ff] focus:outline-none focus:border-cyan-400 focus:bg-black/60 transition-all placeholder:text-cyan-900/40 shadow-lg">
                    </div>
                    <div class="p-6 glass-card bg-cyan-500/[0.03] border-cyan-500/10 mb-2">
                        <div class="flex items-start gap-4">
                            <i data-lucide="info" class="w-5 h-5 text-cyan-400 shrink-0"></i>
                            <p class="text-[11px] text-[#5c7a9e] italic leading-relaxed font-jakarta">Local API key authentication is only available for Enterprise plans with custom SSO integration.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-primary w-full py-5 text-xs text-black font-black uppercase tracking-[5px] bg-white/5 border-white/10 text-white/30 shadow-xl opacity-50 cursor-not-allowed font-heading">
                        Access Locked
                    </button>
                </form>

                <div class="mt-14 text-center">
                    <a href="{{ route('register') }}" class="inline-block py-2 text-[11px] font-black text-[#5c7a9e] hover:text-white transition-all duration-400 uppercase tracking-[4px] border-b-2 border-transparent hover:border-cyan-400/30 pb-1 font-heading">
                        Initialize Node <i data-lucide="arrow-right" class="w-3.5 h-3.5 inline ml-2 mb-0.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
