import React, { useState, useEffect } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import { AlertTriangle, X, RotateCcw, UploadCloud, FileUp, Check, Loader2 } from 'lucide-react';

const chColor = {
    production: { bg: 'rgba(0,229,160,.12)', color: '#00e5a0' },
    staging: { bg: 'rgba(255,184,48,.12)', color: '#ffb830' },
    beta: { bg: 'rgba(0,212,255,.12)', color: '#00d4ff' },
};

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

export default function Releases({ releases: releasesPaginated, channels = [], app, initialFilter, initialStatus }) {
    const releaseList = releasesPaginated.data;
    const [filter, setFilter] = useState(initialFilter || 'all');
    const [statusFilter, setStatusFilter] = useState(initialStatus || 'all');
    const [selectedRelease, setSelectedRelease] = useState(null);
    const [rolloutValue, setRolloutValue] = useState(100);
    const [createModalOpen, setCreateModalOpen] = useState(false);
    const [toast, setToast] = useState('');

    const { data, setData, post, processing, errors, reset } = useForm({
        version: '',
        channel: channels[0]?.slug || 'production',
        mandatory: false,
        bundle: null,
        hash: 'placeholder_hash', // In a real CLI, this is calculated before upload.
        signature: 'placeholder_signature',
        size: 0,
    });

    const showToast = (msg) => { setToast(msg); setTimeout(() => setToast(''), 3000); };

    const fetchReleases = () => {
        router.get('/dashboard/releases', { channel: filter, status: statusFilter }, { preserveState: true });
    };

    useEffect(() => {
        if (filter !== initialFilter || statusFilter !== initialStatus) {
            fetchReleases();
        }
    }, [filter, statusFilter]);

    const handleCreateRelease = (e) => {
        e.preventDefault();
        // Constructing multipart form for the portal-based upload
        // Note: The metadata is typically passed as a JSON string in the multipart request in the original Go implementation
        const formData = new FormData();
        formData.append('bundle', data.bundle);
        formData.append('metadata', JSON.stringify({
            version: data.version,
            channel: data.channel,
            mandatory: data.mandatory,
            platform: app.platform || 'android',
            hash: 'manual-upload-hash',
            signature: 'manual-upload-sig',
            size: data.bundle?.size || 0,
        }));

        router.post('/api/releases', formData, {
            onSuccess: () => {
                showToast('Release published successfully');
                setCreateModalOpen(false);
                reset();
                router.reload();
            },
            onError: (err) => showToast(err.error || 'Upload failed'),
        });
    };

    const handleRolloutUpdate = (release, pct) => {
        router.patch(`/api/releases/${release.id}/rollout`, { rollout_percentage: pct }, {
            onSuccess: () => {
                showToast('Rollout updated');
                setSelectedRelease(null);
                router.reload();
            },
        });
    };

    const handleRollback = (release) => {
        router.patch(`/api/releases/${release.id}/rollback`, {}, {
            onSuccess: () => {
                showToast(`Rolled back to ${release.version}`);
                setSelectedRelease(null);
                router.reload();
            },
        });
    };

    return (
        <DashboardLayout title="Releases">
            <Head title="Manage Releases" />
            
            {toast && (
                <div style={{ position: 'fixed', bottom: '24px', right: '24px', zIndex: 1000, background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '10px', padding: '12px 20px', fontSize: '13px', fontWeight: 500, boxShadow: '0 12px 40px rgba(0,0,0,.5)' }}>{toast}</div>
            )}

            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
                <div>
                    <h2 style={{ fontFamily: 'Syne,sans-serif', fontSize: '20px', fontWeight: 800 }}>All Releases</h2>
                    <p style={{ fontSize: '12px', color: 'var(--muted)', marginTop: '4px' }}>{releasesPaginated.total} releases discovered</p>
                </div>
                <button onClick={() => setCreateModalOpen(true)} style={{ padding: '8px 18px', borderRadius: '8px', border: 'none', background: 'var(--cyan)', color: 'var(--navy)', fontSize: '13px', fontWeight: 700, cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <UploadCloud size={16} /> New Release
                </button>
            </div>

            {/* FILTERS */}
            <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '20px' }}>
                <button onClick={() => setFilter('all')} style={{ padding: '6px 14px', borderRadius: '7px', fontSize: '12px', fontWeight: 500, border: filter === 'all' ? '1px solid var(--cyan)' : '1px solid var(--border)', background: filter === 'all' ? 'var(--cdim)' : 'transparent', color: filter === 'all' ? 'var(--cyan)' : 'var(--muted)', cursor: 'pointer' }}>All Channels</button>
                {channels.map(ch => (
                    <button key={ch.id} onClick={() => setFilter(ch.slug)} style={{ padding: '6px 14px', borderRadius: '7px', fontSize: '12px', fontWeight: 500, border: filter === ch.slug ? '1px solid var(--cyan)' : '1px solid var(--border)', background: filter === ch.slug ? 'var(--cdim)' : 'transparent', color: filter === ch.slug ? 'var(--cyan)' : 'var(--muted)', cursor: 'pointer' }}>{ch.name}</button>
                ))}
                <div style={{ width: '1px', height: '20px', background: 'var(--border)', margin: '0 4px' }} />
                {['all', 'active', 'superseded'].map(s => (
                    <button key={s} onClick={() => setStatusFilter(s)} style={{ padding: '6px 14px', borderRadius: '7px', fontSize: '12px', fontWeight: 500, border: statusFilter === s ? '1px solid var(--cyan)' : '1px solid var(--border)', background: statusFilter === s ? 'var(--cdim)' : 'transparent', color: statusFilter === s ? 'var(--cyan)' : 'var(--muted)', cursor: 'pointer', textTransform: 'capitalize' }}>{s}</button>
                ))}
            </div>

            {/* RELEASE LIST */}
            <div style={{ display: 'grid', gap: '10px' }}>
                {releaseList.map(r => (
                    <div key={r.id} onClick={() => { setSelectedRelease(r); setRolloutValue(r.rollout_percentage) }} style={{ background: selectedRelease?.id === r.id ? 'rgba(0,212,255,.04)' : 'var(--navy2)', border: selectedRelease?.id === r.id ? '1px solid var(--border2)' : '1px solid var(--border)', borderRadius: '12px', padding: '18px 22px', cursor: 'pointer', display: 'grid', gridTemplateColumns: '1fr auto auto auto auto auto', alignItems: 'center', gap: '16px' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                            <span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '13px', padding: '3px 11px', borderRadius: '6px', background: 'var(--cdim)', color: 'var(--cyan)', border: '1px solid rgba(0,212,255,.18)', fontWeight: 500 }}>{r.version}</span>
                            {r.mandatory && <span style={{ fontSize: '10px', padding: '2px 6px', borderRadius: '4px', background: 'rgba(255,77,106,.12)', color: 'var(--red)', fontWeight: 600, display: 'flex', alignItems: 'center', gap: '3px' }}><AlertTriangle size={10} /> MANDATORY</span>}
                        </div>
                        <span style={{ fontSize: '10.5px', padding: '3px 9px', borderRadius: '5px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '.5px', background: (chColor[r.channel] || chColor.production).bg, color: (chColor[r.channel] || chColor.production).color }}>{r.channel}</span>
                        <span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '11px', color: 'var(--muted2)' }}>{r.hash.slice(0, 8)}...</span>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '7px', minWidth: '90px' }}>
                            <div className="ptrack"><div className="pfill" style={{ width: `${r.rollout_percentage}%` }} /></div>
                            <span style={{ fontSize: '11px', color: 'var(--muted)', fontFamily: 'JetBrains Mono,monospace' }}>{r.rollout_percentage}%</span>
                        </div>
                        <span className={`status-dot ${r.is_active ? 'on' : 'off'}`} style={{ fontSize: '12px' }}>{r.is_active ? 'Live' : 'Superseded'}</span>
                        <span style={{ fontSize: '11px', color: 'var(--muted)', minWidth: '60px', textAlign: 'right' }}>{timeAgo(r.created_at)}</span>
                    </div>
                ))}
            </div>

            {/* SIDE DRAWER */}
            {selectedRelease && (
                <div style={{ position: 'fixed', top: 0, right: 0, bottom: 0, width: '400px', zIndex: 100, background: 'var(--navy2)', borderLeft: '1px solid var(--border2)', boxShadow: '-20px 0 60px rgba(0,0,0,.5)', padding: '28px' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
                        <h3 style={{ fontFamily: 'Syne,sans-serif', fontSize: '18px', fontWeight: 800 }}>Release Details</h3>
                        <button onClick={() => setSelectedRelease(null)} style={{ background: 'transparent', border: 'none', color: 'var(--muted)', cursor: 'pointer' }}><X size={20} /></button>
                    </div>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                        <div style={{ fontSize: '10.5px', color: 'var(--muted)', textTransform: 'uppercase', letterSpacing: '1px' }}>Version</div>
                        <div style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '18px', color: 'var(--cyan)', fontWeight: 600 }}>{selectedRelease.version}</div>
                        
                        <div>
                            <div style={{ fontSize: '10.5px', color: 'var(--muted)', textTransform: 'uppercase', letterSpacing: '1px', marginBottom: '8px' }}>Rollout Percentage</div>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                                <input type="range" min={1} max={100} value={rolloutValue} onChange={e => setRolloutValue(Number(e.target.value))} style={{ flex: 1, accentColor: 'var(--cyan)' }} />
                                <span style={{ fontFamily: 'JetBrains Mono,monospace', fontSize: '14px', color: 'var(--cyan)', minWidth: '40px' }}>{rolloutValue}%</span>
                            </div>
                            {rolloutValue !== selectedRelease.rollout_percentage && (
                                <button onClick={() => handleRolloutUpdate(selectedRelease, rolloutValue)} style={{ marginTop: '12px', width: '100%', padding: '10px', borderRadius: '8px', border: 'none', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 700, cursor: 'pointer' }}>Update Rollout</button>
                            )}
                        </div>

                        {!selectedRelease.is_active && (
                            <button onClick={() => handleRollback(selectedRelease)} style={{ padding: '10px', borderRadius: '8px', border: '1px solid var(--amber)', background: 'rgba(255,184,48,.08)', color: 'var(--amber)', fontSize: '13px', fontWeight: 600, cursor: 'pointer' }}>Rollback to this version</button>
                        )}
                    </div>
                </div>
            )}

            {/* CREATE MODAL */}
            {createModalOpen && (
                <div style={{ position: 'fixed', inset: 0, zIndex: 200, background: 'rgba(0,0,0,.6)', backdropFilter: 'blur(5px)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    <form onSubmit={handleCreateRelease} style={{ background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '16px', padding: '32px', width: '480px' }}>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '24px' }}>
                            <h3 style={{ fontFamily: 'Syne,sans-serif', fontSize: '20px', fontWeight: 800 }}>Publish New Release</h3>
                            <button type="button" onClick={() => setCreateModalOpen(false)} style={{ background: 'transparent', border: 'none', color: 'var(--muted)', cursor: 'pointer' }}><X size={20} /></button>
                        </div>
                        
                        <div style={{ marginBottom: '20px' }}>
                            <label style={{ display: 'block', fontSize: '12px', fontWeight: 600, color: 'var(--muted)', marginBottom: '8px' }}>Version</label>
                            <input value={data.version} onChange={e => setData('version', e.target.value)} required style={{ width: '100%', padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'white' }} />
                        </div>

                        <div style={{ marginBottom: '20px' }}>
                            <label style={{ display: 'block', fontSize: '12px', fontWeight: 600, color: 'var(--muted)', marginBottom: '8px' }}>Channel</label>
                            <select value={data.channel} onChange={e => setData('channel', e.target.value)} style={{ width: '100%', padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'white' }}>
                                {channels.map(ch => <option key={ch.slug} value={ch.slug}>{ch.name}</option>)}
                            </select>
                        </div>

                        <div style={{ marginBottom: '24px' }}>
                            <label style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '10px', padding: '30px', border: '2px dashed var(--border2)', borderRadius: '12px', cursor: 'pointer' }}>
                                <input type="file" onChange={e => setData('bundle', e.target.files[0])} style={{ display: 'none' }} />
                                <FileUp size={24} style={{ color: 'var(--muted)' }} />
                                <span style={{ fontSize: '13px', color: 'var(--muted)' }}>{data.bundle ? data.bundle.name : 'Select bundle file'}</span>
                            </label>
                        </div>

                        <button type="submit" disabled={processing} style={{ width: '100%', padding: '12px', borderRadius: '10px', border: 'none', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 800, cursor: 'pointer' }}>
                            {processing ? <Loader2 size={16} className="spinning" /> : 'Deploy Release'}
                        </button>
                    </form>
                </div>
            )}
        </DashboardLayout>
    );
}
