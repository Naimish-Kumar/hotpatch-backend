import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import { Activity, Globe, Package, Smartphone, Server, Shield, Users, FileText } from 'lucide-react';

export default function Dashboard({ stats }) {
    const kpis = [
        { label: 'Platform Apps', value: stats.total_apps, icon: Globe, color: 'var(--cyan)' },
        { label: 'Total Deployments', value: stats.total_releases, icon: Package, color: 'var(--blue)' },
        { label: 'Registered Nodes', value: stats.total_devices, icon: Smartphone, color: 'var(--purple)' },
        { label: 'System Health', value: stats.status.toUpperCase(), icon: Server, color: 'var(--green)' },
    ];

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title="Control Center | HotPatch Admin" />
            <Navbar />

            <div className="hero-grid opacity-10 h-[30vh]" />

            <main className="max-w-7xl mx-auto px-6 py-16 relative z-10">
                <div className="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-8">
                    <div className="animate-fade-up">
                        <h2 className="font-syne text-4xl font-extrabold tracking-tight mb-2">Control Center</h2>
                        <p className="text-muted text-lg">Global platform health and operational intelligence.</p>
                    </div>
                    <div className="flex flex-wrap gap-4">
                        <AdminActionLink href="/admin/apps" icon={Globe} label="View Apps" />
                        <AdminActionLink href="/admin/users" icon={Users} label="Directory" />
                        <AdminActionLink href="/admin/blogs" icon={FileText} label="CMS" />
                        <AdminActionLink href="/admin/settings" icon={Shield} label="Security" color="bg-red hover:bg-red-600" border="border-transparent" />
                    </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    {kpis.map((kpi, i) => (
                        <div key={i} className="bg-navy2 border border-border rounded-[20px] p-8 relative overflow-hidden group animate-fade-up" style={{ animationDelay: `${i * 0.1}s` }}>
                            <div className="absolute top-[-10px] right-[-10px] opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                                <kpi.icon size={120} style={{ color: kpi.color }} />
                            </div>
                            <div className="text-xs font-bold text-muted uppercase tracking-widest mb-4">{kpi.label}</div>
                            <div className="font-syne text-4xl font-extrabold leading-none">{kpi.value}</div>
                        </div>
                    ))}
                </div>

                <div className="grid lg:grid-cols-[1.6fr,1fr] gap-8">
                    <div className="bg-navy2 border border-border rounded-[24px] p-10 animate-fade-up" style={{ animationDelay: '0.4s' }}>
                        <div className="flex items-center justify-between mb-8">
                            <h3 className="text-xl font-bold font-syne">Infrastructure Heartbeat</h3>
                            <div className="flex items-center gap-2 text-green font-bold text-xs">
                                <div className="w-2 h-2 rounded-full bg-green shadow-[0_0_10px_var(--green)] animate-pulse" />
                                Operational
                            </div>
                        </div>
                        <div className="grid md:grid-cols-2 gap-6">
                            <HealthCard label="API Gateway (Laravel)" status="Active" ping="38ms" color="text-cyan" />
                            <HealthCard label="Storage Node (S3)" status="Connected" ping="112ms" color="text-blue" />
                            <HealthCard label="Main Bus (Redis)" status="Optimized" ping="1ms" color="text-purple" />
                            <HealthCard label="SQL Engine (MySQL)" status="Healthy" ping="2ms" color="text-green" />
                        </div>
                    </div>

                    <div className="bg-gradient-to-br from-white/[0.03] to-transparent border border-border rounded-[24px] p-10 flex flex-col justify-center animate-fade-up" style={{ animationDelay: '0.5s' }}>
                        <Shield className="text-red mb-6" size={32} />
                        <h3 className="text-xl font-bold font-syne mb-4">Security Perimeter</h3>
                        <p className="text-muted text-sm leading-relaxed mb-8">
                            All administrative actions are globally audited. Unauthorized access attempts are automatically intercepted and logged to the security service.
                        </p>
                        <button className="px-6 py-3 rounded-xl bg-white/5 border border-border text-sm font-bold transition-all hover:bg-white/10">
                            Download Global Audit Log
                        </button>
                    </div>
                </div>
            </main>
        </div>
    );
}

function AdminActionLink({ href, icon: Icon, label, color = "bg-navy2 hover:bg-navy3", border = "border-border" }) {
    return (
        <Link href={href} className={`px-6 py-3 rounded-xl border ${border} ${color} transition-all font-bold text-sm flex items-center gap-2`}>
            <Icon size={16} /> {label}
        </Link>
    );
}

function HealthCard({ label, status, ping, color }) {
    return (
        <div className="bg-black/20 border border-white/[0.03] rounded-2xl p-5">
            <div className="text-xs font-bold text-muted mb-2 tracking-wider">{label}</div>
            <div className="flex items-center justify-between">
                <span className={`text-lg font-extrabold ${color}`}>{status}</span>
                <span className="text-[10px] font-bold text-muted2 font-mono uppercase">{ping}</span>
            </div>
        </div>
    );
}
