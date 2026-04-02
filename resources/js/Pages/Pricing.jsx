import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Footer from '@/Components/Footer';
import { Check, ArrowRight } from 'lucide-react';

export default function Pricing({ packages = [] }) {
    const [period, setPeriod] = useState('monthly');
    const yearly = period === 'yearly';

    const getPrice = (pkg) => {
        if (pkg.price === 0) return '0';
        if (yearly) return Math.round(pkg.price * 0.75).toString();
        return pkg.price.toString();
    };

    const getSubtitle = (pkg) => {
        if (pkg.price === 0) return 'forever, no card needed';
        if (yearly) return 'per month, billed yearly';
        return 'per month · cancel anytime';
    };

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title="Pricing | Simple, Transparent Tiers" />
            <Navbar />
            
            <section className="pt-40 px-6 max-w-7xl mx-auto text-center">
                <div className="text-cyan text-xs font-bold tracking-[3px] uppercase mb-4">Pricing</div>
                <h1 className="font-syne text-4xl md:text-7xl font-extrabold tracking-tight mb-6">Simple, transparent pricing</h1>
                <p className="text-muted text-lg max-w-xl mx-auto leading-relaxed">
                    No charge per update. No surprise bills. Pay a flat monthly rate and ship as many updates as your users need.
                </p>

                <div className="inline-flex items-center gap-1 mt-10 p-1.5 bg-navy2 border border-border rounded-xl">
                    <button 
                        onClick={() => setPeriod('monthly')}
                        className={`px-6 py-2 rounded-lg text-sm font-bold transition-all ${!yearly ? 'bg-cyan text-navy shadow-lg shadow-cyan/20' : 'text-muted hover:text-white'}`}
                    >
                        Monthly
                    </button>
                    <button 
                        onClick={() => setPeriod('yearly')}
                        className={`px-6 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2 ${yearly ? 'bg-cyan text-navy shadow-lg shadow-cyan/20' : 'text-muted hover:text-white'}`}
                    >
                        Yearly <span className="text-[10px] bg-green/20 text-green px-1.5 py-0.5 rounded-full uppercase">Save 25%</span>
                    </button>
                </div>
            </section>

            <section className="py-20 px-6 max-w-7xl mx-auto">
                <div className="grid md:grid-cols-3 gap-8">
                    {packages.map((pkg, i) => {
                        const isPopular = pkg.slug === 'pro';
                        const features = pkg.features.split(';').filter(f => f.trim());

                        return (
                            <div key={pkg.id} className={`relative p-10 rounded-[24px] border transition-all hover:-translate-y-1 ${isPopular ? 'bg-gradient-to-br from-cyan/5 to-navy2 border-cyan shadow-xl shadow-cyan/5' : 'bg-navy2 border-border'}`}>
                                {isPopular && (
                                    <div className="absolute top-[-14px] left-1/2 -translate-x-1/2 px-4 py-1 bg-cyan text-navy text-[10px] font-black tracking-widest rounded-full shadow-lg shadow-cyan/20">MOST POPULAR</div>
                                )}
                                <div className="text-xs font-bold uppercase tracking-widest text-muted mb-8">{pkg.name}</div>
                                
                                <div className="font-syne flex items-start gap-1 mb-2">
                                    <span className="text-2xl text-muted font-bold mt-2">$</span>
                                    <span className="text-6xl font-black tracking-tighter">{getPrice(pkg)}</span>
                                </div>
                                <div className="text-sm font-medium text-muted mb-10">{getSubtitle(pkg)}</div>

                                <div className="space-y-4 mb-12">
                                    {features.map(f => (
                                        <div key={f} className="flex gap-3 text-sm text-muted">
                                            <div className="w-5 h-5 rounded-full bg-cyan/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <Check className="text-cyan" size={12} strokeWidth={3} />
                                            </div>
                                            {f}
                                        </div>
                                    ))}
                                </div>

                                <Link href="/register" className={`flex items-center justify-center gap-2 w-100 py-4 rounded-xl font-bold text-sm transition-all ${isPopular ? 'bg-cyan text-navy hover:shadow-cyan/40 hover:shadow-2xl' : 'bg-white/5 border border-border hover:bg-white/10'}`}>
                                    {pkg.slug === 'free' ? 'Get Started Free' : 'Start 14-Day Free Trial'} 
                                    <ArrowRight size={16} />
                                </Link>
                            </div>
                        );
                    })}
                </div>
            </section>

            <Footer />
        </div>
    );
}
