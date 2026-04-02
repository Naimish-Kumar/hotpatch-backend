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
