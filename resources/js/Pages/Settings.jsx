import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import { Trash2, AlertTriangle, Loader2, Plus, Bell, Link2, Globe, Shield } from 'lucide-react';
import axios from 'axios';

export default function Settings({ app, webhooks = [] }) {
    const [appName, setAppName] = useState(app.name);
    const [saving, setSaving] = useState(false);
    const [toast, setToast] = useState('');
    const [webhookPayload, setWebhookPayload] = useState({ url: '', events: ['release.created', 'release.rolled_back'] });

    const showToast = (msg) => { setToast(msg); setTimeout(() => setToast(''), 3000); };

    const handleUpdateSettings = async () => {
        setSaving(true);
        try {
            await axios.patch('/api/settings/app', { name: appName });
            showToast('Settings saved');
            router.reload();
        } catch (err) {
            showToast('Update failed');
        } finally {
            setSaving(false);
        }
    };

    const handleAddWebhook = async () => {
        if (!webhookPayload.url) return;
        try {
            await axios.post('/api/settings/webhooks', webhookPayload);
            showToast('Webhook added');
            setWebhookPayload({ url: '', events: ['release.created', 'release.rolled_back'] });
            router.reload();
        } catch (err) {
            showToast('Failed to add webhook');
        }
    };

    const handleDeleteWebhook = async (id) => {
        if (!confirm('Delete this webhook?')) return;
        try {
            await axios.delete(`/api/settings/webhooks/${id}`);
            showToast('Webhook deleted');
            router.reload();
        } catch (err) {
            showToast('Failed to delete');
        }
    };

    return (
        <DashboardLayout title="Settings">
            <Head title="App Settings" />

            {toast && (
                <div style={{ position: 'fixed', bottom: '24px', right: '24px', zIndex: 1000, background: 'var(--navy2)', border: '1px solid var(--border2)', borderRadius: '10px', padding: '12px 20px', fontSize: '13px', fontWeight: 500 }}>{toast}</div>
            )}

            <div style={{ maxWidth: '800px' }}>
                <div style={{ marginBottom: '24px' }}>
                    <h2 style={{ fontFamily: 'Syne,sans-serif', fontSize: '20px', fontWeight: 800 }}>App Settings</h2>
                    <p style={{ fontSize: '12px', color: 'var(--muted)', marginTop: '4px' }}>Configure your application and notifications</p>
                </div>

                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '14px', padding: '24px', marginBottom: '20px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '18px' }}>
                        <Globe size={18} style={{ color: 'var(--cyan)' }} />
                        <span style={{ fontSize: '15px', fontWeight: 700 }}>General Information</span>
                    </div>

                    <div style={{ marginBottom: '16px' }}>
                        <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>App Name</label>
                        <input value={appName} onChange={e => setAppName(e.target.value)} style={{ width: '100%', padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'white' }} />
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '14px', marginBottom: '20px' }}>
                        <div>
                            <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>App ID</label>
                            <div style={{ padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'var(--muted)', fontSize: '12px', fontFamily: 'JetBrains Mono,monospace' }}>{app.id}</div>
                        </div>
                        <div>
                            <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>Platform</label>
                            <div style={{ padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'var(--muted)', textTransform: 'capitalize' }}>{app.platform}</div>
                        </div>
                    </div>

                    <button onClick={handleUpdateSettings} disabled={saving} style={{ padding: '10px 20px', borderRadius: '8px', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 700, cursor: 'pointer', border: 'none' }}>
                        {saving ? 'Saving...' : 'Save Settings'}
                    </button>
                </div>

                <div style={{ background: 'var(--navy2)', border: '1px solid var(--border)', borderRadius: '14px', padding: '24px', marginBottom: '20px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '18px' }}>
                        <Link2 size={18} style={{ color: 'var(--amber)' }} />
                        <span style={{ fontSize: '15px', fontWeight: 700 }}>Webhooks</span>
                    </div>

                    <div style={{ display: 'flex', gap: '10px', marginBottom: '20px' }}>
                        <input value={webhookPayload.url} onChange={e => setWebhookPayload({ ...webhookPayload, url: e.target.value })} placeholder="https://api.example.com/webhook" style={{ flex: 1, padding: '10px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '8px', color: 'white' }} />
                        <button onClick={handleAddWebhook} style={{ padding: '0 20px', borderRadius: '8px', background: 'var(--cyan)', color: 'var(--navy)', fontWeight: 700, cursor: 'pointer', border: 'none' }}>Add</button>
                    </div>

                    {webhooks.map(w => (
                        <div key={w.id} style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '12px', background: 'var(--navy)', border: '1px solid var(--border)', borderRadius: '10px', marginBottom: '8px' }}>
                            <div style={{ overflow: 'hidden', textOverflow: 'ellipsis' }}>{w.url}</div>
                            <Trash2 size={14} style={{ color: 'var(--red)', cursor: 'pointer' }} onClick={() => handleDeleteWebhook(w.id)} />
                        </div>
                    ))}
                </div>

                <div style={{ background: 'var(--navy2)', border: '1px solid rgba(255,77,106,.2)', borderRadius: '14px', padding: '24px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '10px', color: 'var(--red)' }}>
                        <AlertTriangle size={16} />
                        <span style={{ fontSize: '15px', fontWeight: 700 }}>Danger Zone</span>
                    </div>
                    <div style={{ display: 'flex', gap: '12px' }}>
                        <button style={{ padding: '10px 20px', borderRadius: '8px', border: '1px solid rgba(255,77,106,.3)', background: 'rgba(255,77,106,.1)', color: 'var(--red)', cursor: 'pointer' }}>Delete Application</button>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
