import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Footer from '@/Components/Footer';
import { ArrowLeft, Calendar, User } from 'lucide-react';

export default function Show({ post, related = [] }) {
    const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    };

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title={`${post.title} | HotPatch Blog`} />
            <Navbar />
            
            <div className="hero-grid opacity-20 h-[40vh]" />

            <article className="relative z-10 px-6 py-32 max-w-3xl mx-auto -mt-[25vh]">
                <Link href="/blog" className="inline-flex items-center gap-2 text-cyan font-bold text-sm mb-10 transition-transform hover:-translate-x-1">
                    <ArrowLeft size={16} /> Back to Blog
                </Link>

                <h1 className="font-syne text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-8 animate-fade-up">
                    {post.title}
                </h1>

                <div className="flex items-center gap-6 mb-12 pb-8 border-b border-white/10 animate-fade-up" style={{ animationDelay: '0.1s' }}>
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-full bg-blue flex items-center justify-center text-sm font-bold">
                            {post.author?.[0] || 'H'}
                        </div>
                        <div>
                            <div className="font-bold text-base">{post.author || 'HotPatch Team'}</div>
                            <div className="text-muted text-xs flex items-center gap-1.5 mt-0.5">
                                <Calendar size={12} /> {formatDate(post.created_at)}
                            </div>
                        </div>
                    </div>
                </div>

                <div 
                    className="blog-content prose prose-invert prose-cyan max-w-none animate-fade-up"
                    style={{ animationDelay: '0.2s' }}
                    dangerouslySetInnerHTML={{ __html: post.content }}
                />
            </article>

            {related.length > 0 && (
                <section className="bg-navy2 py-24 px-6 border-t border-white/5">
                    <div className="max-w-5xl mx-auto">
                        <h2 className="font-syne text-3xl font-extrabold mb-12">Related Articles</h2>
                        <div className="grid md:grid-cols-3 gap-8">
                            {related.map(p => (
                                <Link key={p.id} href={`/blog/${p.slug}`} className="group">
                                    <div className="bg-navy border border-white/5 rounded-2xl p-6 h-full transition-all hover:border-cyan/30 hover:-translate-y-1">
                                        <div className="text-muted text-[10px] uppercase font-bold tracking-widest mb-3">{formatDate(p.created_at)}</div>
                                        <h3 className="font-syne text-lg font-bold mb-4 group-hover:text-cyan transition-colors">{p.title}</h3>
                                        <div className="flex items-center gap-2 mt-auto">
                                            <div className="w-5 h-5 rounded-full bg-navy3 text-[8px] flex items-center justify-center font-bold">{p.author?.[0] || 'H'}</div>
                                            <span className="text-[11px] font-medium text-muted">{p.author || 'HotPatch Team'}</span>
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            <Footer />

            <style dangerouslySetInnerHTML={{ __html: `
                .blog-content h2 { font-family: Syne, sans-serif; font-size: 2rem; font-weight: 800; letter-spacing: -0.05em; margin: 3rem 0 1.5rem; color: white; line-height: 1.2; }
                .blog-content h3 { font-family: Syne, sans-serif; font-size: 1.5rem; font-weight: 700; margin: 2.5rem 0 1rem; color: white; }
                .blog-content p { margin-bottom: 1.5rem; font-size: 1.125rem; line-height: 1.8; color: rgba(255,255,255,0.8); }
                .blog-content ul { list-style: disc; margin-bottom: 2rem; padding-left: 1.5rem; }
                .blog-content li { margin-bottom: 0.75rem; color: rgba(255,255,255,0.7); }
                .blog-content strong { color: white; font-weight: 700; }
                .blog-content a { color: var(--cyan); text-decoration: underline; font-weight: 600; }
                .blog-content pre { background: var(--navy2); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; overflow-x: auto; margin: 2rem 0; }
                .blog-content code { font-family: 'JetBrains Mono', monospace; font-size: 0.875rem; background: rgba(0,212,255,0.1); color: var(--cyan); padding: 0.2rem 0.4rem; border-radius: 0.4rem; }
                .blog-content pre code { background: transparent; color: rgba(255,255,255,0.9); padding: 0; }
                .blog-content blockquote { border-left: 4px solid var(--cyan); padding: 0.5rem 2rem; margin: 2.5rem 0; color: rgba(255,255,255,0.6); font-style: italic; font-size: 1.25rem; background: rgba(0,212,255,0.02); border-radius: 0 1rem 1rem 0; }
            `}} />
        </div>
    );
}
