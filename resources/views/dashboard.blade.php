@extends('layouts.dashboard')

@section('page_title', 'System Intelligence')

@section('content')
<div class="space-y-10 afu">
    {{-- KPI GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
        $kpis = [
            ['label' => 'Global Devices', 'val' => number_format($stats['total_devices']), 'delta' => $stats['devices_trend'] ?? 0, 'icon' => 'smartphone', 'color' => '#00d4ff'],
            ['label' => 'Total Deliveries', 'val' => number_format($stats['updates_delivered']), 'delta' => $stats['updates_trend'] ?? 0, 'icon' => 'rocket', 'color' => '#00e5a0'],
            ['label' => 'Health Index', 'val' => number_format($stats['success_rate'], 1) . '%', 'delta' => $stats['success_rate_delta'] ?? 0, 'icon' => 'shield-check', 'color' => '#ffb830'],
            ['label' => 'Deployment Count', 'val' => number_format($stats['total_releases'] ?? count($releases)), 'delta' => 0, 'icon' => 'package', 'color' => '#8b5cf6'],
        ];
        @endphp
        @foreach($kpis as $i => $k)
        <div class="glass-card p-7 border-white/[0.04] shadow-2xl hover:border-white/[0.1] transition-all group afu-{{ $i + 1 }}">
            <div class="flex items-center justify-between mb-5">
                <span class="text-[10px] text-[#5c7a9e] font-black uppercase tracking-[3px] opacity-70 font-heading">{{ $k['label'] }}</span>
                <div class="w-10 h-10 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-cyan-400 shadow-inner group-hover:scale-110 group-hover:bg-cyan-500/10 transition-all duration-500">
                    <i data-lucide="{{ $k['icon'] }}" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="font-heading text-4xl font-black tracking-[-2px] leading-none mb-4 text-white uppercase">{{ $k['val'] }}</div>
            <div class="flex items-center gap-2">
                <div class="px-2 py-1 rounded-lg text-[10px] font-black tracking-widest uppercase flex items-center gap-1.5 {{ $k['delta'] >= 0 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-500' }}">
                    @if($k['delta'] != 0)
                        <i data-lucide="{{ $k['delta'] > 0 ? 'arrow-up-right' : 'arrow-down-right' }}" class="w-3 h-3"></i>
                        <span>{{ number_format(abs($k['delta']), 1) }}%</span>
                    @else
                        <span>STABLE</span>
                    @endif
                </div>
                <span class="text-[9px] text-[#3a5a7a] font-black uppercase tracking-widest font-heading">vs prev period</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 afu-4">
        <div class="glass-card p-8 border-white/[0.04] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5"><i data-lucide="activity" class="w-32 h-32 text-white"></i></div>
            <div class="flex items-center justify-between mb-10 relative z-10">
                <div>
                    <div class="font-heading text-xl font-black uppercase tracking-tight text-white mb-1">Telemetry Stream</div>
                    <div class="text-[11px] text-[#5c7a9e] font-bold uppercase tracking-widest opacity-60">System-wide adoption rates over 30 days</div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/[0.03] border border-white/5">
                        <div class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_8px_rgba(0,212,255,1)]"></div>
                        <span class="text-[10px] font-black text-white/70 uppercase tracking-widest font-heading">Live Feed</span>
                    </div>
                </div>
            </div>
            <div class="h-[300px] relative"><canvas id="lineChart"></canvas></div>
        </div>
        
        <div class="glass-card p-8 border-white/[0.04] shadow-2xl flex flex-col">
            <div class="mb-12">
                <div class="font-heading text-xl font-black uppercase tracking-tight text-white mb-1">Fleet Distribution</div>
                <div class="text-[11px] text-[#5c7a9e] font-bold uppercase tracking-widest opacity-60">Live version spread across nodes</div>
            </div>
            <div class="flex-1 flex items-center justify-center relative scale-90 -mt-8">
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-4xl font-black text-white font-heading mb-1 uppercase">94%</span>
                    <span class="text-[10px] text-[#5c7a9e] font-black uppercase tracking-[3.5px] font-heading">Optimized</span>
                </div>
                <canvas id="donutChart"></canvas>
            </div>
            <div class="mt-10 space-y-3">
                <div class="flex items-center justify-between px-4 py-3 bg-white/[0.02] rounded-xl border border-white/5 group hover:border-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_8px_rgba(0,212,255,0.4)]"></div>
                        <span class="text-[11px] font-bold text-white/70 uppercase tracking-tight">v1.2.0 (Stable)</span>
                    </div>
                    <span class="text-[11px] font-mono text-cyan-400 font-bold">64.2%</span>
                </div>
                <div class="flex items-center justify-between px-4 py-3 bg-white/[0.02] rounded-xl border border-white/5 group hover:border-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_8px_rgba(139,92,246,0.4)]"></div>
                        <span class="text-[11px] font-bold text-white/70 uppercase tracking-tight">v1.1.5 (Legacy)</span>
                    </div>
                    <span class="text-[11px] font-mono text-purple-400 font-bold">20.8%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLES --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pb-20">
        {{-- Recent Releases --}}
        <div class="glass-card overflow-hidden border-white/[0.04] shadow-2xl">
            <div class="p-7 px-10 flex items-center justify-between border-b border-white/[0.04] bg-white/[0.01]">
                <div class="font-heading text-sm font-black uppercase tracking-[5px] text-white">Registry Log</div>
                <a href="{{ route('releases') }}" class="text-[10px] text-cyan-400 font-black hover:text-white transition-all uppercase tracking-[3px] border-b border-cyan-400/20 hover:border-white/40 pb-0.5 font-heading">Explore Registry <i data-lucide="arrow-right-circle" class="w-3.5 h-3.5 inline ml-1"></i></a>
            </div>
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full">
                    <thead>
                        <tr class="bg-black/20">
                            <th class="px-10 py-5 text-left text-[9px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">Bundle</th>
                            <th class="px-10 py-5 text-left text-[9px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">Channel</th>
                            <th class="px-10 py-5 text-left text-[9px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">Reach</th>
                            <th class="px-10 py-5 text-left text-[9px] font-black text-[#3a5a7a] uppercase tracking-[4px] font-heading">Signal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.03]">
                        @forelse($releases as $r)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-10 py-6">
                                <span class="font-mono text-[12px] font-black text-cyan-400 px-4 py-2 rounded-xl bg-cyan-500/10 border border-cyan-500/20 group-hover:shadow-[0_0_20px_rgba(0,212,255,0.2)] transition-all">{{ $r->version }}</span>
                            </td>
                            <td class="px-10 py-6 text-[10px] font-black text-white/50 uppercase tracking-[2px] font-heading">{{ $r->channel }}</td>
                            <td class="px-10 py-6 min-w-[150px]">
                                <div class="flex items-center gap-4">
                                    <div class="ptrack h-1.5 group-hover:shadow-[0_0_10px_rgba(0,212,255,0.2)] transition-all"><div class="pfill bg-gradient-to-r from-cyan-600 to-cyan-400" style="width:{{ $r->rollout_percentage }}%"></div></div>
                                    <span class="font-mono text-[10px] text-white/40">{{ $r->rollout_percentage }}%</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="status-dot {{ $r->is_active ? 'on' : 'off' }} text-[10px] font-black uppercase tracking-[4px] font-heading">{{ $r->is_active ? 'Active' : 'Superseded' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-32 text-center text-[#3a5a7a] font-black uppercase tracking-widest text-xs italic opacity-40">No cluster data available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Active Devices --}}
        <div class="glass-card overflow-hidden border-white/[0.04] shadow-2xl">
            <div class="p-7 px-10 flex items-center justify-between border-b border-white/[0.04] bg-white/[0.01]">
                <div class="font-heading text-sm font-black uppercase tracking-[5px] text-white">Active Nodes</div>
                <a href="{{ route('devices') }}" class="text-[10px] text-cyan-400 font-black hover:text-white transition-all uppercase tracking-[3px] border-b border-cyan-400/20 hover:border-white/40 pb-0.5 font-heading">Full Audit <i data-lucide="shield" class="w-3.5 h-3.5 inline ml-1"></i></a>
            </div>
            <div class="divide-y divide-white/[0.03] min-h-[400px]">
                @forelse($devices as $d)
                <div class="flex items-center gap-7 p-6 px-10 hover:bg-white/[0.02] transition-all group border-l-2 border-transparent hover:border-cyan-400">
                    <div class="w-12 h-12 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center text-cyan-400/70 shrink-0 shadow-inner group-hover:scale-110 group-hover:rotate-12 group-hover:bg-cyan-500/10 group-hover:text-cyan-400 transition-all duration-500">
                        @php $plat = strtolower($d->platform ?? ''); @endphp
                        @if(str_contains($plat, 'android')) <i data-lucide="smartphone" class="w-6 h-6"></i>
                        @elseif(str_contains($plat, 'ios') || str_contains($plat, 'apple')) <i data-lucide="phone-forwarded" class="w-6 h-6"></i>
                        @else <i data-lucide="monitor" class="w-6 h-6"></i> @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-mono text-[14px] font-black text-white/90 truncate tracking-tighter mb-1 opacity-90 group-hover:opacity-100 transition-opacity">{{ $d->device_id ?? $d->id }}</div>
                        <div class="text-[10px] text-[#3a5a7a] font-black uppercase tracking-[4px] font-heading">{{ $d->platform ?? 'unknown' }} · {{ $d->model ?? 'Virtual Terminal' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-mono text-[13px] font-black text-cyan-400 tracking-tighter mb-1">{{ $d->current_version ?? '0.0.0-null' }}</div>
                        <div class="text-[9px] text-[#3a5a7a] font-black uppercase tracking-[2px] opacity-70 font-heading">{{ $d->updated_at ? $d->updated_at->diffForHumans() : 'SIGNAL LOST' }}</div>
                    </div>
                </div>
                @empty
                <div class="py-32 text-center text-[#3a5a7a] font-black uppercase tracking-widest text-xs italic opacity-40 font-heading">Listening for signal heartbeats...</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();

    Chart.defaults.color = 'rgba(92, 122, 158, 0.6)';
    Chart.defaults.font.family = "'JetBrains Mono', monospace";
    Chart.defaults.font.size = 10;
    Chart.defaults.font.weight = 'bold';

    // Line
    const lc = document.getElementById('lineChart');
    if (lc) {
        const ctx = lc.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 212, 255, 0.2)');
        gradient.addColorStop(1, 'rgba(0, 212, 255, 0)');
        
        new Chart(lc, {
            type: 'line',
            data: {
                labels: ['01 MAR','05 MAR','10 MAR','15 MAR','20 MAR','25 MAR','30 MAR'],
                datasets: [{
                    data: [450, 680, 520, 890, 1100, 980, 1250],
                    borderColor: '#00d4ff',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    pointBackgroundColor: '#00d4ff',
                    pointBorderColor: '#050505',
                    pointBorderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(255,255,255, 0.03)', borderDash: [2, 2] } },
                    y: { grid: { color: 'rgba(255,255,255, 0.03)', borderDash: [2, 2] }, beginAtZero: true }
                }
            }
        });
    }

    // Donut
    const dc = document.getElementById('donutChart');
    if (dc) {
        new Chart(dc, {
            type: 'doughnut',
            data: {
                labels: ['v1.2.0', 'v1.1.5', 'v1.1.0', 'Other'],
                datasets: [{
                    data: [65, 20, 10, 5],
                    backgroundColor: ['#00d4ff', '#8b5cf6', '#3b82f6', '#1e293b'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { legend: { display: false } }
            }
        });
    }
});
</script>
@endsection
