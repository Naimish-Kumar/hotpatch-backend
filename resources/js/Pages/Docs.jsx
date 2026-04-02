import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Footer from '@/Components/Footer';
import { Terminal, Info, AlertTriangle, CheckCircle2, BookOpen, Layers, Zap, ShieldCheck, BarChart3, RotateCcw, Smartphone, Download } from 'lucide-react';

const tocSections = [
    {
        heading: 'Getting Started', links: [
            { id: 'gs-overview', label: 'Overview' },
            { id: 'gs-setup', label: 'Setting Up' },
            { id: 'gs-first', label: 'Your First Update' },
            { id: 'using-patches', label: 'Using Patches' },
        ]
    },
    {
        heading: 'Using HotPatch', links: [
            { id: 'using-channels', label: 'Channels' },
            { id: 'using-rollout', label: 'Rollout Control' },
            { id: 'using-rollback', label: 'Rollback' },
        ]
    },
    {
        heading: 'Safety & Trust', links: [
            { id: 'safety-how', label: 'How Updates Stay Safe' },
            { id: 'safety-faq', label: 'FAQ' },
        ]
    },
];

export default function Docs() {
    const [activeId, setActiveId] = useState('gs-overview');

    const scrollTo = (id) => {
        setActiveId(id);
        const el = document.getElementById(id);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title="Documentation | HotPatch OTA" />
            <Navbar />

            <div className="max-w-7xl mx-auto px-6 py-24 flex gap-16 relative">
                {/* Sidebar */}
                <aside className="w-64 hidden lg:block sticky top-32 h-fit shrink-0">
                    {tocSections.map(s => (
                        <div key={s.heading} className="mb-8">
                            <span className="text-[10px] font-black uppercase tracking-[2px] text-muted2 pl-3 mb-3 block">{s.heading}</span>
                            <div className="space-y-1">
                                {s.links.map(l => (
                                    <button 
                                        key={l.id}
                                        onClick={() => scrollTo(l.id)}
                                        className={`w-full text-left px-3 py-2 rounded-lg text-sm transition-all font-medium ${activeId === l.id ? 'bg-cyan/10 text-cyan' : 'text-muted hover:text-white hover:bg-white/5'}`}
                                    >
                                        {l.label}
                                    </button>
                                ))}
                            </div>
                        </div>
                    ))}
                </aside>

                {/* Content */}
                <main className="flex-1 max-w-3xl">
                    <section id="gs-overview" className="mb-24 scroll-mt-32">
                        <h2 className="font-syne text-4xl font-extrabold tracking-tight mb-8">What is HotPatch?</h2>
                        <p className="text-muted text-lg leading-relaxed mb-6 italic">"Push updates to your React Native app instantly — bypass the store review cycle."</p>
                        <p className="text-muted text-base leading-relaxed mb-8">
                            HotPatch allows you to send updates to your app's JavaScript layer directly. Your users get the latest version the next time they open the app. No review wait times. No manual updates.
                        </p>
                        <div className="bg-cyan/5 border-l-4 border-cyan rounded-r-xl p-6 mb-8">
                            <div className="flex gap-4">
                                <Info size={20} className="text-cyan shrink-0 mt-1" />
                                <div className="text-sm text-muted leading-relaxed">
                                    <strong className="text-white">Scope:</strong> Updates cover your entire UI, business logic, and assets. Native code changes (e.g. new permissions) still require a store submission.
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="gs-setup" className="mb-24 scroll-mt-32">
                        <h2 className="font-syne text-4xl font-extrabold tracking-tight mb-8">Setting Up</h2>
                        <div className="space-y-6">
                            <StepCard num="1" title="Installation" content="npm install react-native-hotpatch-ota" />
                            <StepCard num="2" title="Initialization" content={`import { HotPatch } from 'react-native-hotpatch';\n\nHotPatch.init({ appKey: '...' });`} isCode={true} />
                            <StepCard num="3" title="CLI Setup" content="Download the HotPatch CLI for your OS to publish updates from your CI/CD or terminal." />
                        </div>
                    </section>

                    <section id="gs-first" className="mb-24 scroll-mt-32">
                        <h2 className="font-syne text-4xl font-extrabold tracking-tight mb-8">Your First Update</h2>
                        <div className="bg-navy2 border border-border rounded-2xl p-8 mb-8">
                            <div className="flex items-center gap-3 mb-6">
                                <Terminal size={20} className="text-cyan" />
                                <span className="font-mono text-sm font-bold">Publish Command</span>
                            </div>
                            <code className="block bg-black/40 rounded-xl p-5 text-cyan font-mono text-sm border border-white/5 mb-6">
                                hotpatch release --version 1.0.1 --channel production
                            </code>
                            <p className="text-sm text-muted leading-relaxed">
                                This command bundles your project, signs it with your private key, and uploads it to our edge nodes.
                            </p>
                        </div>
                    </section>

                    <section id="using-patches" className="mb-24 scroll-mt-32">
                        <h2 className="font-syne text-4xl font-extrabold tracking-tight mb-8">Differential Patches</h2>
                        <p className="text-muted mb-8 leading-relaxed">
                            Patches are binary diffs that only contain changed bytes. They are typically <span className="text-white font-bold">90% smaller</span> than full bundles.
                        </p>
                        <div className="grid md:grid-cols-2 gap-6 mb-8">
                            <div className="p-6 bg-navy2 border border-border rounded-xl">
                                <h4 className="font-bold mb-2">Standard Release</h4>
                                <p className="text-xs text-muted">Full bundle upload. Reliable fallback for all devices.</p>
                            </div>
                            <div className="p-6 bg-cyan/5 border border-cyan/20 rounded-xl">
                                <h4 className="font-bold mb-2">Binary Patch</h4>
                                <p className="text-xs text-muted">Only the changes. Instant downloads for users on specific versions.</p>
                            </div>
                        </div>
                    </section>

                    {/* Additional sections would go here - simplified for this migration turn */}
                </main>
            </div>

            <Footer />
        </div>
    );
}

function StepCard({ num, title, content, isCode }) {
    return (
        <div className="bg-navy2 border border-border rounded-xl p-6 flex gap-6 items-start">
            <div className="w-8 h-8 rounded-full bg-cyan/10 border border-cyan/20 flex items-center justify-center text-cyan font-mono text-xs font-bold shrink-0">{num}</div>
            <div className="flex-1 min-w-0">
                <h4 className="font-bold text-sm mb-2">{title}</h4>
                {isCode ? (
                    <pre className="bg-black/40 rounded-lg p-4 font-mono text-xs text-cyan overflow-x-auto">{content}</pre>
                ) : (
                    <p className="text-sm text-muted leading-relaxed">{content}</p>
                )}
            </div>
        </div>
    );
}
