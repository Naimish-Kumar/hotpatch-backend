import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Footer from '@/Components/Footer';
import CtaSection from '@/Components/CtaSection';
import { Clock, Calendar, User, ArrowRight, Search, Tag, ChevronRight, Share2 } from 'lucide-react';

export default function Index({ posts = [] }) {
    const featured = posts[0];
    const others = posts.slice(1);
    const tagColors = ['var(--cyan)', 'var(--green)', 'var(--amber)', 'var(--purple)', 'var(--blue)'];

    const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    };

    const stripHtml = (html) => {
        return html.replace(/<[^>]+>/g, '');
    };

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title="Blog | Insights from the Edge" />
            <Navbar />
            
            <div className="hero-grid opacity-30 h-[50vh]" />

            <section className="relative z-10 px-6 py-40 max-w-7xl mx-auto -mt-[30vh]">
                <div className="text-center mb-20 animate-fade-up">
                    <div className="text-cyan text-xs font-bold tracking-[3px] uppercase mb-4">HotPatch Journal</div>
                    <h1 className="font-syne text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                        Insights from the <span className="text-cyan">Edge</span>
                    </h1>
                    <p className="text-muted text-lg max-w-2xl mx-auto">
                        Deep dives into mobile architecture, security, and the future of instant software delivery.
                    </p>
                </div>

                {featured && (
                    <Link href={`/blog/${featured.slug}`} className="block group">
                        <div className="bg-navy2 border border-border2 rounded-[24px] p-8 md:p-16 mb-16 grid lg:grid-cols-[1.2fr,1fr] gap-12 items-center transition-all hover:-translate-y-1 hover:border-cyan">
                            <div className="animate-fade-up">
                                <div className="flex items-center gap-3 mb-6">
                                    <span className="px-3 py-1 rounded-full bg-cdim text-cyan text-[11px] font-bold tracking-wider">FEATURED</span>
                                    <span className="text-muted text-sm">{formatDate(featured.created_at)}</span>
                                </div>
                                <h2 className="font-syne text-3xl md:text-4xl font-extrabold tracking-tight mb-6 leading-tight group-hover:text-cyan transition-colors">
                                    {featured.title}
                                </h2>
                                <p className="text-muted text-lg leading-relaxed mb-8">
                                    {stripHtml(featured.content).substring(0, 200)}...
                                </p>
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 rounded-full bg-blue flex items-center justify-center text-xs">{featured.author?.[0] || 'H'}</div>
                                    <span className="font-semibold text-sm">{featured.author || 'HotPatch Team'}</span>
                                </div>
                            </div>
                            <div className="hidden lg:flex h-80 bg-navy rounded-2xl border border-border relative overflow-hidden items-center justify-center">
                                <div className="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,var(--cyan),transparent_70%)]" />
                                <Search className="text-cyan opacity-10" size={64} />
                            </div>
                        </div>
                    </Link>
                )}

                <div className="grid md:grid-cols-2 gap-8">
                    {others.map((p, i) => (
                        <Link key={p.id} href={`/blog/${p.slug}`} className="group h-full">
                            <div className="bg-navy2 border border-border rounded-[20px] p-10 h-full flex flex-col transition-all hover:-translate-y-1 hover:border-cyan/40">
                                <div className="flex items-center justify-between mb-5">
                                    <span className="text-[11px] font-bold uppercase tracking-wider" style={{ color: tagColors[i % tagColors.length] }}>Article</span>
                                    <span className="text-muted text-xs">{formatDate(p.created_at)}</span>
                                </div>
                                <h3 className="font-syne text-2xl font-extrabold tracking-tight mb-4 flex-grow group-hover:text-cyan transition-colors">{p.title}</h3>
                                <p className="text-muted text-sm leading-relaxed mb-6">{stripHtml(p.content).substring(0, 120)}...</p>
                                <div className="flex items-center gap-3 pt-5 border-t border-white/[0.03]">
                                    <div className="w-6 h-6 rounded-full bg-navy3 flex items-center justify-center text-[10px]">{p.author?.[0] || 'H'}</div>
                                    <span className="text-sm font-medium">{p.author || 'HotPatch Team'}</span>
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>
            </section>

            <CtaSection />
            <Footer />
        </div>
    );
}
