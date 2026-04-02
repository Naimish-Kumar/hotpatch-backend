import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import { ShieldCheck, Key, Ticket, X, Plus, Trash2, Loader2, Copy } from 'lucide-react';
import axios from 'axios';

export default function Security({ apiKeys = [], signingKeys = [], auditLogs = [], app }) {
    const [toast, setToast] = useState('');
    const [newKeyModal, setNewKeyModal] = useState(null); // 'api' | 'signing'
    const [showApiKey, setShowApiKey] = useState(null);
    const [newSigningKey, setNewSigningKey] = useState({ name: '', public_key: '' });
    const [loading, setLoading] = useState(false);

    const showToast = (msg) => { setToast(msg); setTimeout(() => setToast(''), 3000); };

    const handleCreateApiKey = async () => {
        const name = prompt('Enter a name for the new API key:');
        if (!name) return;
        setLoading(true);
        try {
            const res = await axios.post('/api/security/api-keys', { name });
            showToast('API Key created successfully');
            setShowApiKey(res.data.raw_key);
            router.reload();
        } catch (err) {
            showToast('Failed to create key');
        } finally {
            setLoading(false);
        }
    };

    const handleCreateSigningKey = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            await axios.post('/api/security/signing-keys', newSigningKey);
            showToast('Signing key added');
            setNewKeyModal(null);
            setNewSigningKey({ name: '', public_key: '' });
            router.reload();
        } catch (err) {
            showToast('Failed to add signing key');
        } finally {
            setLoading(false);
        }
    };

    const handleDeleteApiKey = async (id) => {
        if (!confirm('Revoke this API Key?')) return;
        try {
            await axios.delete(`/api/security/api-keys/${id}`);
            showToast('API Key revoked');
            router.reload();
        } catch (err) {
            showToast('Failed to revoke key');
        }
    };

    const handleDeleteSigningKey = async (id) => {
        if (!confirm('Delete this Signing Key?')) return;
        try {
            await axios.delete(`/api/security/signing-keys/${id}`);
            showToast('Signing key deleted');
            router.reload();
        } catch (err) {
            showToast('Failed to delete key');
        }
    };

    return (
        <DashboardLayout title="Security">
            <Head title="Security & Signing" />

            {toast && (
                <div style={{ position: 'fixed', bottom: '24px', right: '24px', zIndex: 1000, background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '10px', padding: '12px 20px', fontSize: '13px', fontWeight: 500 }}>{toast}</div>
            )}

            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '24px' }}>
                <div>
                    <h2 style={{ fontFamily: 'Syne,sans-serif', fontSize: '20px', fontWeight: 800 }}>Security & Signing</h2>
                    <p style={{ fontSize: '12px', color: 'var(--muted)', marginTop: '4px' }}>Manage API keys and Ed25519 public keys</p>
                </div>
                <div style={{ display: 'flex', gap: '10px' }}>
                    <button onClick={handleCreateApiKey} style={{ padding: '8px 16px', borderRadius: '8px', background: 'var(--navy2)', border: '1px solid var(--border2)', color: 'var(--cyan)', fontSize: '13px', fontWeight: 600, cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '6px' }}>
                        <Plus size={14} /> New API Key
                    </button>
                    <button onClick={() => setNewKeyModal('signing')} style={{ padding: '8px 16px', borderRadius: '8px', background: 'var(--cyan)', color: 'var(--navy)', border: 'none', fontSize: '13px', fontWeight: 700, cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '6px' }}>
                        <Plus size={14} /> New Signing Key
                    </button>
                </div>
            </div>

            {showApiKey && (
                <div style={{ position: 'fixed', inset: 0, zIndex: 500, background: 'rgba(0,0,0,.8)', backdropFilter: 'blur(5px)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    <div style={{ background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '16px', padding: '32px', width: '450px' }}>
                        <h3 style={{ fontSize: '18px', fontWeight: 800, marginBottom: '12px' }}>New API Key Created</h3>
                        <p style={{ fontSize: '12px', color: 'var(--muted)', marginBottom: '20px' }}>Copy this key now. You won't be able to see it again.</p>
                        <div style={{ background: 'var(--navy)', padding: '14px', borderRadius: '10px', border: '1px solid var(--border)', fontFamily: 'JetBrains Mono,monospace', marginBottom: '20px' }}>{showApiKey}</div>
                        <button onClick={() => setShowApiKey(null)} style={{ width: '100%', padding: '12px', borderRadius: '8px', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 700, cursor: 'pointer' }}>I've saved it</button>
                    </div>
                </div>
            )}

            {newKeyModal === 'signing' && (
                <div style={{ position: 'fixed', inset: 0, zIndex: 500, background: 'rgba(0,0,0,.8)', backdropFilter: 'blur(5px)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    <form onSubmit={handleCreateSigningKey} style={{ background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '16px', padding: '32px', width: '500px' }}>
                        <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '20px' }}>
                            <h3 style={{ fontSize: '18px', fontWeight: 800 }}>Add Public Signing Key</h3>
                            <X size={18} style={{ cursor: 'pointer' }} onClick={() => setNewKeyModal(null)} />
                        </div>
                        <div style={{ marginBottom: '16px' }}>
                            <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>Key Name</label>
                            <input value={newSigningKey.name} onChange={e => setNewSigningKey({ ...newSigningKey, name: e.target.value })} required style={{ width: '100%', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', padding: '10px', color: 'white' }} />
                        </div>
                        <div style={{ marginBottom: '24px' }}>
                            <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>Public Key (Ed25519)</label>
                            <textarea value={newSigningKey.public_key} onChange={e => setNewSigningKey({ ...newSigningKey, public_key: e.target.value })} required style={{ width: '100%', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', padding: '10px', color: 'white', minHeight: '100px', fontFamily: 'JetBrains Mono,monospace' }} />
                        </div>
                        <button type="submit" disabled={loading} style={{ width: '100%', padding: '12px', borderRadius: '8px', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 700, cursor: 'pointer' }}>{loading ? 'Adding...' : 'Add Key'}</button>
                    </form>
                </div>
            )}

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '14px', marginBottom: '20px' }}>
                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '14px', padding: '24px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '18px' }}>
                        <Key size={18} style={{ color: 'var(--cyan)' }} />
                        <span style={{ fontSize: '14px', fontWeight: 700 }}>Signing Keys</span>
                    </div>
                    {signingKeys.map(k => (
                        <div key={k.id} style={{ background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '10px', padding: '14px', marginBottom: '10px' }}>
                            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '8px' }}>
                                <span style={{ fontSize: '13px', fontWeight: 600 }}>{k.name}</span>
                                <span style={{ fontSize: '10px', padding: '2px 8px', borderRadius: '4px', background: k.is_active ? 'rgba(0,229,160,.12)' : 'rgba(255,255,255,.05)', color: k.is_active ? '#00e5a0' : 'var(--muted)' }}>{k.is_active ? 'ACTIVE' : 'INACTIVE'}</span>
                            </div>
                            <div style={{ fontSize: '11px', color: 'var(--muted)', fontFamily: 'JetBrains Mono,monospace', marginBottom: '8px' }}>{k.public_key.substring(0, 32)}...</div>
                            <div style={{ display: 'flex', gap: '10px' }}>
                                <button onClick={() => { navigator.clipboard.writeText(k.public_key); showToast('Copied'); }} style={{ background: 'transparent', border: 'none', color: 'var(--cyan)', fontSize: '11px', cursor: 'pointer' }}>Copy</button>
                                <button onClick={() => handleDeleteSigningKey(k.id)} style={{ background: 'transparent', border: 'none', color: 'var(--red)', fontSize: '11px', cursor: 'pointer' }}>Delete</button>
                            </div>
                        </div>
                    ))}
                </div>

                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '14px', padding: '24px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '18px' }}>
                        <Ticket size={18} style={{ color: 'var(--amber)' }} />
                        <span style={{ fontSize: '14px', fontWeight: 700 }}>API Keys</span>
                    </div>
                    {apiKeys.map(k => (
                        <div key={k.id} style={{ background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '10px', padding: '14px', marginBottom: '10px' }}>
                            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '5px' }}>
                                <span style={{ fontSize: '13px', fontWeight: 600 }}>{k.name}</span>
                                <Trash2 size={13} style={{ color: 'var(--red)', cursor: 'pointer' }} onClick={() => handleDeleteApiKey(k.id)} />
                            </div>
                            <div style={{ fontSize: '12px', color: 'var(--muted)', fontFamily: 'JetBrains Mono,monospace' }}>{k.prefix}••••••••</div>
                            <div style={{ fontSize: '10px', color: 'var(--muted)', marginTop: '8px' }}>Created {new Date(k.created_at).toLocaleDateString()}</div>
                        </div>
                    ))}
                </div>
            </div>

            {/* AUDIT LOG */}
            <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '14px', overflow: 'hidden' }}>
                <div style={{ padding: '18px 24px', borderBottom: '1px solid var(--border)' }}>
                    <div style={{ fontSize: '14px', fontWeight: 700 }}>Audit Trail</div>
                </div>
                {auditLogs.map(log => (
                    <div key={log.id} style={{ display: 'flex', alignItems: 'center', gap: '14px', padding: '12px 24px', borderBottom: '1px solid rgba(0,212,255,.05)' }}>
                        <ShieldCheck size={14} style={{ color: 'var(--cyan)' }} />
                        <div style={{ flex: 1 }}>
                            <div style={{ fontSize: '13px' }}><b>{log.actor}</b> performed <span style={{ color: 'var(--cyan)' }}>{log.action}</span></div>
                            <div style={{ fontSize: '11px', color: 'var(--muted)' }}>IP: {log.ip_address} · {log.metadata}</div>
                        </div>
                        <span style={{ fontSize: '11px', color: 'var(--muted)' }}>{new Date(log.created_at).toLocaleString()}</span>
                    </div>
                ))}
            </div>
        </DashboardLayout>
    );
}
