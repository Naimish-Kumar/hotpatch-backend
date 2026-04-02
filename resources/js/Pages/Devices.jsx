import React, { useState, useEffect } from 'react';
import { Head, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import { Search, Monitor, Apple, Smartphone, Activity, Clock } from 'lucide-react';

function timeAgo(dateStr) {
    if (!dateStr) return 'never';
    const diff = Date.now() - new Date(dateStr).getTime();
    const mins = Math.floor(diff / 60000);
    if (mins < 1) return 'just now';
    if (mins < 60) return `${mins}m ago`;
    const hrs = Math.floor(mins / 60);
    if (hrs < 24) return `${hrs}h ago`;
    return `${Math.floor(hrs / 24)}d ago`;
}

export default function Devices({ devices: devicesPaginated, app, initialPlatform, initialSearch }) {
    const deviceList = devicesPaginated.data;
    const [platformFilter, setPlatformFilter] = useState(initialPlatform || 'all');
    const [search, setSearch] = useState(initialSearch || '');

    const androidCount = deviceList.filter(d => d.platform === 'android').length;
    const iosCount = deviceList.filter(d => d.platform === 'ios').length;

    const versionCounts = {};
    deviceList.forEach(d => { 
        versionCounts[d.current_version] = (versionCounts[d.current_version] || 0) + 1; 
    });
    const versionEntries = Object.entries(versionCounts).sort((a, b) => b[1] - a[1]);

    const handleFilterChange = (p) => {
        setPlatformFilter(p);
        router.get('/dashboard/devices', { platform: p, search }, { preserveState: true });
    };

    const handleSearch = (val) => {
        setSearch(val);
        // Debounce search in a real app, but for now direct
        router.get('/dashboard/devices', { platform: platformFilter, search: val }, { preserveState: true });
    };

    return (
        <DashboardLayout title="Devices">
            <Head title="Registered Devices" />

            {/* HEADER & FILTERS */}
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                <div>
                    <h2 style={{ fontFamily: 'Syne,sans-serif', fontSize: '20px', fontWeight: 800 }}>Registered Devices</h2>
                    <p style={{ fontSize: '12px', color: 'var(--muted)', marginTop: '4px' }}>{devicesPaginated.total} total discovered</p>
                </div>
                <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                    <div style={{ position: 'relative' }}>
                        <Search size={14} style={{ position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)', color: 'var(--muted)' }} />
                        <input
                            value={search} onChange={e => handleSearch(e.target.value)}
                            placeholder="Search device ID or version..."
                            style={{ padding: '7px 12px 7px 32px', fontSize: '12px', borderRadius: '7px', border: '1px solid var(--border)', background: 'var(--navy2)', color: 'var(--white)', outline: 'none', width: '200px' }}
                        />
                    </div>
                    {['all', 'android', 'ios'].map(p => (
                        <button key={p} onClick={() => handleFilterChange(p)} style={{ padding: '6px 14px', borderRadius: '7px', fontSize: '12px', fontWeight: 500, border: platformFilter === p ? '1px solid var(--cyan)' : '1px solid var(--border)', background: platformFilter === p ? 'var(--cdim)' : 'transparent', color: platformFilter === p ? 'var(--cyan)' : 'var(--muted)', cursor: 'pointer', textTransform: 'capitalize' }}>{p === 'all' ? 'All Platforms' : p}</button>
                    ))}
                </div>
            </div>

            {/* STATS CARDS */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '14px', marginBottom: '20px' }}>
                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '13px', padding: '18px 22px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '9px', marginBottom: '10px' }}>
                        <div style={{ width: '30px', height: '30px', borderRadius: '8px', background: 'rgba(0,212,255,.12)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Smartphone size={15} style={{ color: 'var(--cyan)' }} /></div>
                        <span style={{ fontSize: '11.5px', color: 'var(--muted)', fontWeight: 500 }}>Total Devices</span>
                    </div>
                    <div style={{ fontFamily: 'Syne,sans-serif', fontSize: '28px', fontWeight: 800, letterSpacing: '-1px' }}>{devicesPaginated.total.toLocaleString()}</div>
                </div>
                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '13px', padding: '18px 22px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '9px', marginBottom: '10px' }}>
                        <div style={{ width: '30px', height: '30px', borderRadius: '8px', background: 'rgba(0,229,160,.12)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Activity size={15} style={{ color: 'var(--green)' }} /></div>
                        <span style={{ fontSize: '11.5px', color: 'var(--muted)', fontWeight: 500 }}>Platform Split</span>
                    </div>
                    <div style={{ display: 'flex', gap: '14px' }}>
                        <div>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}><Monitor size={13} style={{ color: 'var(--green)' }} /><span style={{ fontFamily: 'Syne,sans-serif', fontSize: '22px', fontWeight: 800 }}>{androidCount}</span></div>
                            <div style={{ fontSize: '11px', color: 'var(--muted)' }}>Android</div>
                        </div>
                        <div style={{ width: '1px', background: 'var(--border)' }} />
                        <div>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}><Apple size={13} style={{ color: '#c8c8ff' }} /><span style={{ fontFamily: 'Syne,sans-serif', fontSize: '22px', fontWeight: 800 }}>{iosCount}</span></div>
                            <div style={{ fontSize: '11px', color: 'var(--muted)' }}>iOS</div>
                        </div>
                    </div>
                </div>
                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '13px', padding: '18px 22px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '9px', marginBottom: '10px' }}>
                        <div style={{ width: '30px', height: '30px', borderRadius: '8px', background: 'rgba(255,184,48,.12)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Clock size={15} style={{ color: 'var(--amber)' }} /></div>
                        <span style={{ fontSize: '11.5px', color: 'var(--muted)', fontWeight: 500 }}>Version Breakdown</span>
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '5px' }}>
                        {versionEntries.slice(0, 3).map(([ver, count]) => (
                            <div key={ver} style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                <span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '11.5px', color: 'var(--cyan)' }}>v{ver}</span>
                                <span style={{ fontSize: '11px', color: 'var(--muted)' }}>{count} devices</span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* DEVICE LIST */}
            <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '13px', overflow: 'hidden' }}>
                <table>
                    <thead>
                        <tr><th>Device ID</th><th>Platform</th><th>Current Version</th><th>Last Seen</th></tr>
                    </thead>
                    <tbody>
                        {deviceList.map(d => (
                            <tr key={d.id}>
                                <td>
                                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                        <div style={{ width: '28px', height: '28px', borderRadius: '7px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: d.platform === 'android' ? 'rgba(0,229,160,.1)' : 'rgba(200,200,255,.07)' }}>
                                            {d.platform === 'android' ? <Monitor size={13} style={{ color: 'var(--green)' }} /> : <Apple size={13} style={{ color: '#c8c8ff' }} />}
                                        </div>
                                        <span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '11.5px' }}>{d.device_id}</span>
                                    </div>
                                </td>
                                <td style={{ textTransform: 'capitalize', fontSize: '12px' }}>{d.platform}</td>
                                <td><span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '11.5px', color: 'var(--cyan)' }}>{d.current_version}</span></td>
                                <td style={{ fontSize: '11px', color: 'var(--muted)' }}>{timeAgo(d.last_seen)}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </DashboardLayout>
    );
}
