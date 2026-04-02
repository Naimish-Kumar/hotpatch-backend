import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import { CreditCard, Check, Shield, Zap, ExternalLink, Loader2, AlertCircle } from 'lucide-react';
import axios from 'axios';

export default function Billing({ app }) {
    const [loading, setLoading] = useState(false);
    const isPro = app.tier === 'pro';
    const isEnterprise = app.tier === 'enterprise';

    const handleUpgrade = async (tier) => {
        setLoading(true);
        try {
            const res = await axios.post('/api/billing/checkout', { tier });
            window.location.href = res.data.url;
        } catch (err) {
            console.error(err);
            setLoading(false);
        }
    };

    const handlePortal = async () => {
        setLoading(true);
        try {
            const res = await axios.post('/api/billing/portal');
            window.location.href = res.data.url;
        } catch (err) {
            console.error(err);
            setLoading(false);
        }
    };

    return (
        <DashboardLayout title="Billing">
            <Head title="Billing & Subscriptions" />

            <div className="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
                <div>
                    <h2 className="font-syne text-3xl font-extrabold tracking-tight">Billing & Subscriptions</h2>
                    <p className="text-muted text-sm mt-1">Manage your plan and billing preferences.</p>
                </div>
                {app.stripe_customer_id && (
                    <button 
                        onClick={handlePortal}
                        disabled={loading}
                        className="flex items-center gap-2 px-6 py-3 rounded-xl bg-navy2 border border-border text-sm font-bold transition-all hover:bg-navy3"
                    >
                        {loading ? <Loader2 size={16} className="animate-spin" /> : <ExternalLink size={16} />}
                        Stripe Customer Portal
                    </button>
                )}
            </div>

            <div className="grid lg:grid-cols-3 gap-6 mb-12">
                <PlanCard 
                    name="Free Tier" 
                    price="0" 
                    current={app.tier === 'free'}
                    features={['Up to 50 active devices', '1 App', 'Community Support']}
                    onSelect={() => {}}
                    disabled={true}
                />
                <PlanCard 
                    name="Pro Plan" 
                    price="49" 
                    current={isPro}
                    popular={true}
                    features={['Up to 5,000 active devices', 'Unlimited Apps', 'Priority Support']}
                    onSelect={() => handleUpgrade('pro')}
                    loading={loading && !isPro}
                />
                <PlanCard 
                    name="Enterprise" 
                    price="299" 
                    current={isEnterprise}
                    features={['Custom device limits', 'SLA guarantees', '24/7 Phone support']}
                    onSelect={() => handleUpgrade('enterprise')}
                    loading={loading && !isEnterprise}
                />
            </div>

            <div className="bg-navy2 border border-border rounded-[24px] p-8">
                <div className="flex items-center gap-3 mb-6">
                    <Shield className="text-cyan" size={20} />
                    <h3 className="font-syne text-xl font-bold">Billing Status</h3>
                </div>
                <div className="grid md:grid-cols-3 gap-8">
                    <div>
                        <div className="text-xs font-bold text-muted uppercase tracking-widest mb-2">Current Tier</div>
                        <div className="flex items-center gap-2">
                            <span className="text-lg font-black uppercase text-white">{app.tier}</span>
                            <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${app.subscription_status === 'active' ? 'bg-green/10 text-green' : 'bg-amber/10 text-amber'}`}>
                                {app.subscription_status.toUpperCase()}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div className="text-xs font-bold text-muted uppercase tracking-widest mb-2">Renewal Date</div>
                        <div className="text-lg font-bold text-white">
                            {app.subscription_end ? new Date(app.subscription_end).toLocaleDateString() : 'N/A'}
                        </div>
                    </div>
                    <div>
                        <div className="text-xs font-bold text-muted uppercase tracking-widest mb-2">Payment Method</div>
                        <div className="flex items-center gap-2 text-lg font-bold text-white">
                            <CreditCard size={18} className="text-muted" />
                            •••• {app.card_last4 || 'None'}
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}

function PlanCard({ name, price, current, popular, features, onSelect, loading, disabled }) {
    return (
        <div className={`relative p-8 rounded-[24px] border transition-all ${current ? 'border-cyan bg-cyan/5 shadow-2xl shadow-cyan/10' : 'bg-navy2 border-border'}`}>
            {popular && !current && (
                <div className="absolute top-[-12px] left-1/2 -translate-x-1/2 px-4 py-1 bg-cyan text-navy text-[10px] font-black tracking-widest rounded-full">RECOMMENDED</div>
            )}
            {current && (
                <div className="absolute top-[-12px] left-1/2 -translate-x-1/2 px-4 py-1 bg-green text-navy text-[10px] font-black tracking-widest rounded-full">CURRENT PLAN</div>
            )}
            
            <div className="text-xs font-bold text-muted uppercase tracking-widest mb-4">{name}</div>
            <div className="font-syne flex items-start gap-1 mb-6">
                <span className="text-xl font-bold mt-1 text-muted">$</span>
                <span className="text-5xl font-black">{price}</span>
                <span className="text-sm font-bold self-end mb-1 text-muted">/mo</span>
            </div>

            <div className="space-y-3 mb-8">
                {features.map(f => (
                    <div key={f} className="flex gap-2 text-sm text-muted">
                        <Check size={14} className="text-cyan shrink-0 mt-0.5" /> {f}
                    </div>
                ))}
            </div>

            <button 
                onClick={onSelect}
                disabled={current || loading || disabled}
                className={`w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all ${current ? 'bg-white/5 text-muted' : 'bg-cyan text-navy hover:shadow-cyan/20 hover:shadow-xl'}`}
            >
                {loading ? <Loader2 size={16} className="animate-spin" /> : null}
                {current ? 'Active' : `Get ${name}`}
            </button>
        </div>
    );
}
