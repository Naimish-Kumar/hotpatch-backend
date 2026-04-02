@extends('layouts.dashboard')

@section('page_title', 'Release Registry')

@section('content')
<div x-data="{ 
    filter: 'all', 
    statusFilter: 'all',
    selectedRelease: null,
    createModalOpen: false,
    rolloutValue: 100
}" class="space-y-12 afu font-jakarta" x-init="lucide.createIcons()">

    <!-- HEADER & ACTION -->
    <div class="flex flex-col md:flex-row md:items-end justify-between items-start gap-10 mb-6">
        <div>
            <h2 class="font-heading text-4xl font-black text-white tracking-[-1.5px] mb-2 leading-none uppercase">Cluster Registry</h2>
            <p class="text-[11px] font-black uppercase text-[#3a5a7a] tracking-[5px] opacity-70 font-heading">{{ number_format($releases->total()) }} bundle deployments discovered</p>
        </div>
        <button @click="createModalOpen = true" class="btn-primary flex items-center gap-3 py-4 px-10 text-xs uppercase tracking-[4px] bg-[#00d4ff] text-black shadow-2xl group hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 font-heading">
            <i data-lucide="plus-circle" class="w-4.5 h-4.5 group-hover:rotate-90 transition-transform duration-500"></i>
            <span>Inject Release</span>
        </button>
    </div>

    <!-- FILTERS -->
    <div class="flex flex-wrap items-center gap-4 pb-4">
        <div class="flex p-1.5 rounded-2xl bg-white/[0.03] border border-white/5 shadow-inner">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-[#00d4ff] text-[#050505]' : 'text-[#5c7a9e] hover:text-white'" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-[2px] transition-all duration-300 font-heading">All Nodes</button>
            @foreach($channels as $ch)
                <button @click="filter = '{{ $ch->slug }}'" :class="filter === '{{ $ch->slug }}' ? 'bg-[#00d4ff] text-[#050505]' : 'text-[#5c7a9e] hover:text-white'" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-[2px] transition-all duration-300 whitespace-nowrap font-heading">{{ $ch->name }}</button>
            @endforeach
        </div>
        <div class="w-px h-8 bg-white/5 mx-2 hidden md:block"></div>
        <div class="flex p-1.5 rounded-2xl bg-white/[0.03] border border-white/5 shadow-inner">
            <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'text-[#00d4ff]' : 'text-[#3a5a7a] hover:text-white'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[2.5px] transition-all font-heading">All Status</button>
            <button @click="statusFilter = 'active'" :class="statusFilter === 'active' ? 'text-[#00d4ff]' : 'text-[#3a5a7a] hover:text-white'" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[2.5px] transition-all font-heading">Live Feed</button>
        </div>
    </div>

    <!-- RELEASE LIST -->
    <div class="space-y-5">
        @forelse($releases as $r)
        <div 
            x-show="(filter === 'all' || filter === '{{ $r->channel }}') && (statusFilter === 'all' || (statusFilter === 'active' && {{ $r->is_active ? 'true' : 'false' }}))"
            @click="selectedRelease = {{ json_encode($r) }}; rolloutValue = {{ $r->rollout_percentage }}" 
            :class="selectedRelease?.id === '{{ $r->id }}' ? 'border-[#00d4ff]/50 bg-[#00d4ff]/[0.05] ring-1 ring-[#00d4ff]/30 shadow-[0_0_50px_rgba(0,212,255,0.15)]' : 'border-white/[0.05] bg-white/[0.01] hover:border-white/[0.12] hover:bg-white/[0.02]'"
            class="group border rounded-[28px] p-8 px-12 cursor-pointer transition-all duration-500 flex flex-col lg:flex-row lg:items-center gap-10 shadow-sm relative overflow-hidden"
        >
            <div class="absolute inset-y-0 left-0 w-1.5 bg-gradient-to-b from-cyan-400 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity" :class="selectedRelease?.id === '{{ $r->id }}' ? 'opacity-100' : ''"></div>

            <div class="flex items-center gap-10 min-w-[220px]">
                <div class="font-mono text-[14px] font-black px-5 py-2.5 rounded-2xl bg-black/50 text-[#00d4ff] border border-white/5 group-hover:border-white/15 transition-colors shadow-inner flex items-center gap-2">
                    <i data-lucide="hash" class="w-4 h-4 opacity-40"></i>
                    {{ $r->version }}
                </div>
                @if($r->mandatory)
                    <div class="flex items-center gap-2.5 text-[10px] font-black tracking-[4px] text-[#ff4d6a] bg-[#ff4d6a]/10 px-4 py-2 rounded-xl uppercase border border-[#ff4d6a]/15 shadow-xl font-heading">
                        <span class="w-2 h-2 bg-[#ff4d6a] rounded-full animate-pulse shadow-[0_0_12px_#ff4d6a]"></span>
                        URGENT
                    </div>
                @endif
            </div>
            
            <div class="flex-1 flex flex-wrap items-center gap-8 lg:gap-16">
                <div class="min-w-[140px]">
                    <span class="text-[10px] px-4 py-2 rounded-xl font-black uppercase tracking-[4px] bg-white/[0.03] text-white/50 border border-white/5 group-hover:text-white/80 transition-colors font-heading flex items-center gap-2">
                        <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                        {{ $r->channel }}
                    </span>
                </div>

                <div class="hidden xl:block">
                    <div class="font-mono text-[11px] text-[#3a5a7a] font-bold uppercase tracking-[2px] break-all max-w-[140px] opacity-30 group-hover:opacity-100 transition-opacity flex items-center gap-2">
                        <i data-lucide="fingerprint" class="w-3.5 h-3.5"></i>
                        {{ substr($r->hash, 0, 16) }}...
                    </div>
                </div>

                <div class="flex items-center gap-6 min-w-[200px] flex-1 lg:flex-none">
                    <div class="ptrack h-2 group-hover:shadow-[0_0_15px_rgba(0,212,255,0.25)] transition-all"><div class="pfill bg-gradient-to-r from-cyan-600 to-cyan-400" style="width: {{ $r->rollout_percentage }}%"></div></div>
                    <span class="font-mono text-[12px] font-black text-cyan-400 opacity-60 group-hover:opacity-100">{{ $r->rollout_percentage }}%</span>
                </div>

                <div class="flex items-center gap-5">
                    <span class="status-dot {{ $r->is_active ? 'on shadow-emerald-400/50' : 'off' }} text-[11px] font-black uppercase tracking-[4px] font-heading">{{ $r->is_active ? 'Live Cluster' : 'Deprioritized' }}</span>
                </div>
            </div>

            <div class="text-[11px] text-[#3a5a7a] font-black uppercase tracking-[2.5px] text-right min-w-[130px] opacity-80 italic font-heading group-hover:text-white transition-colors">
                <i data-lucide="clock-3" class="w-3.5 h-3.5 inline mr-1 opacity-40"></i>
                {{ $r->created_at->diffForHumans() }}
            </div>
        </div>
        @empty
        <div class="py-40 text-center bg-white/[0.01] border border-white/[0.04] rounded-[40px] border-dashed group hover:border-[#00d4ff]/20 transition-colors">
            <div class="w-20 h-20 rounded-3xl bg-white/[0.02] border border-white/5 flex items-center justify-center text-white/10 text-4xl mx-auto mb-8 group-hover:scale-110 group-hover:rotate-12 group-hover:text-cyan-400/20 transition-all duration-700">
                <i data-lucide="package-search" class="w-10 h-10"></i>
            </div>
            <h3 class="font-heading text-2xl font-black text-white mb-4 tracking-tight uppercase">Registry Empty</h3>
            <p class="text-[#5c7a9e] text-xs uppercase font-black tracking-[4px] opacity-60 mb-10 max-w-xs mx-auto font-heading">Inject your first application update to initialize the registry cluster</p>
            <button @click="createModalOpen = true" class="btn-primary py-4 px-10 text-[11px] uppercase tracking-widest bg-white/5 border border-white/10 text-white hover:bg-[#00d4ff] hover:text-black hover:border-transparent transition-all font-heading">Initialize Cluster</button>
        </div>
        @endforelse
    </div>

    <!-- SIDE DRAWER -->
    <div 
        x-show="selectedRelease" 
        x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-700"
        x-transition:enter-start="translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition cubic-bezier(0.16, 1, 0.3, 1) duration-500"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0"
        class="fixed top-0 right-0 bottom-0 w-full md:w-[560px] z-[100] bg-[#050505]/98 backdrop-blur-3xl border-l border-white/10 shadow-[-50px_0_120px_rgba(0,0,0,0.9)] p-14 overflow-y-auto scrollbar-hide"
        x-cloak
    >
        <div class="absolute top-0 right-0 p-10">
            <button @click="selectedRelease = null" class="p-5 hover:bg-white/5 rounded-full transition-all group active:scale-90 shadow-2xl border border-transparent hover:border-white/15">
                <i data-lucide="x" class="w-6 h-6 text-white/30 group-hover:text-white"></i>
            </button>
        </div>

        <div class="space-y-14 pr-4 pt-4" x-if="selectedRelease">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[6px] text-[#00d4ff] mb-6 block opacity-60 font-heading">FIRMWARE TELEMETRY</span>
                <div class="font-heading text-6xl font-black text-white leading-none mb-3 tracking-[-3px] uppercase" x-text="selectedRelease.version"></div>
                <div class="font-mono text-[10px] text-[#3a5a7a] uppercase tracking-widest break-all pt-3 opacity-50 flex items-center gap-3">
                    <i data-lucide="terminal" class="w-4 h-4"></i>
                    <span x-text="selectedRelease.hash"></span>
                </div>
            </div>

            <div class="p-10 rounded-[32px] bg-white/[0.02] border border-white/10 grid grid-cols-2 gap-12 shadow-inner">
                <div>
                    <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[5px] block mb-4 font-heading">NODE CHANNEL</label>
                    <div class="text-sm font-black uppercase text-[#00d4ff] tracking-widest font-heading flex items-center gap-2">
                        <i data-lucide="git-branch" class="w-4 h-4"></i>
                        <span x-text="selectedRelease.channel"></span>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[5px] block mb-4 font-heading">STAMPED DATE</label>
                    <div class="text-sm font-black text-white uppercase tracking-widest font-heading flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-white/40"></i>
                        <span x-text="new Date(selectedRelease.created_at).toLocaleDateString(undefined, {year: 'numeric', month: 'short', day: 'numeric'})"></span>
                    </div>
                </div>
            </div>

            <div class="glass-card p-12 border-white/10 relative overflow-hidden group shadow-2xl">
                <div class="absolute inset-0 bg-cyan-500/[0.03] group-hover:bg-cyan-500/[0.06] transition-colors"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-8">
                        <label class="text-[10px] font-black uppercase text-[#3a5a7a] tracking-[6px] block font-heading">ROLLOUT INTENSITY</label>
                        <span class="font-heading text-3xl font-black text-cyan-400" x-text="rolloutValue + '%'"></span>
                    </div>
                    <input type="range" min="1" max="100" x-model="rolloutValue" class="w-full h-2.5 bg-black/60 border border-white/15 rounded-full appearance-none cursor-pointer accent-cyan-400 hover:accent-cyan-300 transition-all">
                    
                    <div class="pt-12">
                        <button 
                            x-show="rolloutValue != selectedRelease.rollout_percentage"
                            x-transition:enter="transition duration-500 transform scale-95 opacity-0"
                            x-transition:enter-end="scale-100 opacity-100"
                            class="w-full py-6 rounded-2xl bg-cyan-400 text-black font-black text-[12px] uppercase tracking-[5px] transition-all hover:scale-[1.03] active:scale-95 shadow-[0_20px_40px_rgba(0,212,255,0.4)] font-heading">
                            Synchronize Cluster
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-10 space-y-5 font-heading">
                 <button class="w-full py-6 rounded-2xl border border-white/15 text-white font-black text-[12px] uppercase tracking-[5px] transition-all hover:bg-white/5 hover:border-white/25 active:scale-98 shadow-2xl flex items-center justify-center gap-3">
                    <i data-lucide="download" class="w-4 h-4"></i> Retrieve Artifact
                 </button>
                 <template x-if="!selectedRelease.is_active">
                    <button class="w-full py-6 rounded-2xl border border-amber-500/20 bg-amber-500/5 text-amber-400 font-black text-[12px] uppercase tracking-[5px] transition-all hover:bg-amber-500/10 hover:border-amber-400/40 flex items-center justify-center gap-3">
                        <i data-lucide="history" class="w-4 h-4"></i> Atomic Rollback
                    </button>
                 </template>
                 <button class="w-full py-6 rounded-2xl border border-red-500/40 bg-red-500/5 text-red-500 font-black text-[12px] uppercase tracking-[5px] transition-all hover:bg-red-500/10 hover:border-red-400/60 flex items-center justify-center gap-3">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> WIPE PERMANENTLY
                 </button>
            </div>
        </div>
    </div>

    <!-- CREATE MODAL -->
    <div x-show="createModalOpen" class="fixed inset-0 z-[200] bg-[#050505]/95 backdrop-blur-3xl flex items-center justify-center p-10" x-transition:opacity x-cloak>
        <div @click.away="createModalOpen = false" class="glass-card border-white/15 rounded-[40px] w-full max-w-[620px] shadow-[0_60px_130px_rgba(0,0,0,1)] overflow-hidden afu" x-transition:scale>
             <div class="p-12 border-b border-white/[0.06] bg-white/[0.01] flex items-center justify-between">
                <h3 class="font-heading text-3xl font-black text-white tracking-tight uppercase">New Cluster Release</h3>
                <button @click="createModalOpen = false" class="text-white/20 hover:text-white transition-colors duration-400"><i data-lucide="x" class="w-8 h-8"></i></button>
             </div>
             
             <form class="p-12 space-y-10">
                <div class="grid grid-cols-2 gap-10">
                    <div>
                        <label class="text-[11px] font-black uppercase text-[#3a5a7a] tracking-[5px] block mb-5 font-heading">VERSION SEAL</label>
                        <input type="text" placeholder="e.g. 1.0.5" class="h-input font-mono">
                    </div>
                    <div>
                        <label class="text-[11px] font-black uppercase text-[#3a5a7a] tracking-[5px] block mb-5 font-heading">TARGET NODE</label>
                        <select class="h-input font-heading text-xs">
                            @foreach($channels as $ch)
                                <option value="{{ $ch->slug }}">{{ $ch->name }} ENV</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                     <label class="flex flex-col items-center justify-center gap-8 p-14 border-2 border-dashed border-white/10 rounded-[35px] hover:border-cyan-400/50 cursor-pointer group transition-all duration-700 bg-white/[0.01] hover:bg-cyan-500/[0.04]">
                        <input type="file" class="hidden">
                        <div class="w-20 h-20 rounded-[30px] bg-white/5 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:rotate-6 group-hover:bg-cyan-500/15 transition-all duration-500 shadow-2xl border border-white/10">
                            <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                        </div>
                        <div class="text-center font-heading">
                            <p class="text-xl font-black text-white tracking-tight uppercase group-hover:text-cyan-400 transition-colors">Select Artifact Bundle</p>
                            <p class="text-[11px] text-[#3a5a7a] mt-3 uppercase tracking-[4px] font-black">SHA-256 VALIDATED ZIP OR BIN ONLY</p>
                        </div>
                     </label>
                </div>
                <button type="submit" class="btn-primary w-full py-6 rounded-2xl bg-cyan-400 text-black font-black text-[12px] uppercase tracking-[6px] shadow-[0_25px_50px_rgba(0,212,255,0.3)] hover:scale-[1.02] active:scale-95 transition-all duration-500 font-heading">INITIATE CLUSTER DEPLOYMENT</button>
             </form>
        </div>
    </div>

</div>
@endsection
