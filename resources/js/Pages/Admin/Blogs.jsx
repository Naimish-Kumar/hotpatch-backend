import React, { useState, useMemo } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import { Plus, Search, Trash2, Edit2, Check, X, FileText, LayoutDashboard, Eye, EyeOff } from 'lucide-react';
import axios from 'axios';

export default function Blogs({ blogs = [] }) {
    const [search, setSearch] = useState('');
    const [editingPost, setEditingPost] = useState(null);
    const [isCreating, setIsCreating] = useState(false);
    const [toast, setToast] = useState('');

    const showToast = (msg) => { setToast(msg); setTimeout(() => setToast(''), 3000); };

    const filteredBlogs = useMemo(() => {
        return blogs.filter(b => b.title.toLowerCase().includes(search.toLowerCase()));
    }, [blogs, search]);

    const { data, setData, post, patch, delete: destroy, processing, reset } = useForm({
        title: '',
        content: '',
        author: 'HotPatch Admin',
        is_published: false,
    });

    const handleEdit = (blog) => {
        setEditingPost(blog);
        setIsCreating(false);
        setData({
            title: blog.title,
            content: blog.content,
            author: blog.author,
            is_published: blog.is_published,
        });
    };

    const handleCreate = () => {
        setEditingPost(null);
        setIsCreating(true);
        reset();
    };

    const handleSave = () => {
        if (isCreating) {
            post('/api/admin/blogs', {
                onSuccess: () => { showToast('Blog created'); setEditingPost(null); setIsCreating(false); router.reload(); }
            });
        } else {
            patch(`/api/admin/blogs/${editingPost.id}`, {
                onSuccess: () => { showToast('Blog updated'); setEditingPost(null); router.reload(); }
            });
        }
    };

    const handleDelete = (id) => {
        if (!confirm('Delete this blog?')) return;
        destroy(`/api/admin/blogs/${id}`, {
            onSuccess: () => { showToast('Blog deleted'); router.reload(); }
        });
    };

    const stripHtml = (html) => html.replace(/<[^>]*>?/gm, '');

    return (
        <div className="min-h-screen bg-navy text-white font-inter">
            <Head title="CMS Management | HotPatch Admin" />
            <Navbar />

            {toast && (
                <div className="fixed bottom-6 right-6 z-50 bg-navy2 border border-border2 rounded-xl px-5 py-3 text-sm font-bold shadow-2xl">
                    {toast}
                </div>
            )}

            <header className="border-b border-white/5 bg-black/20 backdrop-blur-md sticky top-16 z-30">
                <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-lg bg-cyan/10 border border-cyan/20 flex items-center justify-center">
                            <FileText className="text-cyan" size={18} />
                        </div>
                        <h1 className="text-lg font-bold font-syne">Blog Management</h1>
                    </div>
                    <button onClick={handleCreate} className="bg-cyan text-navy px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 hover:shadow-lg hover:shadow-cyan/20">
                        <Plus size={16} /> Create Article
                    </button>
                </div>
            </header>

            <main className="max-w-7xl mx-auto p-6">
                {(!editingPost && !isCreating) ? (
                    <>
                        <div className="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                            <div className="relative w-full md:w-96">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-muted" size={18} />
                                <input
                                    type="text"
                                    placeholder="Search by title..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="w-full bg-navy2 border border-border rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-cyan/50 transition-colors"
                                />
                            </div>
                            <div className="flex gap-6 text-sm font-bold">
                                <span className="text-muted">Total: <span className="text-white">{blogs.length}</span></span>
                                <span className="text-muted">Published: <span className="text-green">{blogs.filter(b => b.is_published).length}</span></span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {filteredBlogs.map(blog => (
                                <div key={blog.id} className="bg-navy2 border border-white/5 rounded-2xl p-6 hover:border-cyan/30 transition-all group relative">
                                    <div className="flex justify-between items-start mb-4">
                                        <div className={`px-2 py-0.5 rounded text-[10px] uppercase font-black tracking-widest ${blog.is_published ? 'bg-green/10 text-green' : 'bg-amber/10 text-amber'}`}>
                                            {blog.is_published ? 'Live' : 'Draft'}
                                        </div>
                                        <div className="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onClick={() => handleEdit(blog)} className="p-2 hover:bg-white/5 rounded-lg text-cyan transition-colors"><Edit2 size={16} /></button>
                                            <button onClick={() => handleDelete(blog.id)} className="p-2 hover:bg-red/10 rounded-lg text-red transition-colors"><Trash2 size={16} /></button>
                                        </div>
                                    </div>
                                    <h3 className="text-lg font-bold font-syne mb-2 line-clamp-2 leading-tight">{blog.title}</h3>
                                    <p className="text-sm text-muted mb-6 line-clamp-3 leading-relaxed">
                                        {stripHtml(blog.content).substring(0, 150)}...
                                    </p>
                                    <div className="flex items-center justify-between mt-auto pt-4 border-t border-white/5">
                                        <div className="text-xs font-medium text-muted">/{blog.slug}</div>
                                        <div className="text-xs font-bold text-muted2">{new Date(blog.created_at).toLocaleDateString()}</div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </>
                ) : (
                    <div className="max-w-4xl mx-auto space-y-8 animate-fade-up">
                        <div className="flex items-center justify-between">
                            <h2 className="text-2xl font-bold font-syne">{isCreating ? 'New Publication' : 'Edit Article'}</h2>
                            <div className="flex gap-3">
                                <button onClick={() => { setIsCreating(false); setEditingPost(null); }} className="px-5 py-2.5 rounded-xl text-sm font-bold border border-border hover:bg-white/5 transition-all flex items-center gap-2">
                                    <X size={16} /> Discard
                                </button>
                                <button onClick={handleSave} disabled={processing} className="px-6 py-2.5 rounded-xl text-sm text-navy font-black bg-cyan hover:shadow-lg hover:shadow-cyan/20 transition-all flex items-center gap-2">
                                    {processing ? <Loader2 className="animate-spin" size={16} /> : <Check size={16} />}
                                    {isCreating ? 'Publish Now' : 'Save Changes'}
                                </button>
                            </div>
                        </div>

                        <div className="bg-navy2 border border-border rounded-2xl p-8 space-y-8">
                            <div>
                                <label className="block text-xs font-black text-muted uppercase tracking-widest mb-3">Article Title</label>
                                <input
                                    type="text"
                                    value={data.title}
                                    onChange={(e) => setData('title', e.target.value)}
                                    className="w-full bg-navy border border-border rounded-xl px-4 py-3 font-syne text-lg font-bold focus:outline-none focus:border-cyan shadow-inner"
                                    placeholder="Enter a compelling title..."
                                />
                            </div>

                            <div className="grid md:grid-cols-2 gap-8">
                                <div>
                                    <label className="block text-xs font-black text-muted uppercase tracking-widest mb-3">Author Credit</label>
                                    <input
                                        type="text"
                                        value={data.author}
                                        onChange={(e) => setData('author', e.target.value)}
                                        className="w-full bg-navy border border-border rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-cyan"
                                    />
                                </div>
                                <div className="flex items-center gap-4 group cursor-pointer h-full pt-6" onClick={() => setData('is_published', !data.is_published)}>
                                    <div className={`w-12 h-6 rounded-full p-1 transition-colors relative ${data.is_published ? 'bg-green' : 'bg-white/10'}`}>
                                        <div className={`w-4 h-4 rounded-full bg-white transition-transform ${data.is_published ? 'translate-x-6' : 'translate-x-0'}`} />
                                    </div>
                                    <span className={`text-sm font-bold uppercase tracking-widest ${data.is_published ? 'text-green' : 'text-muted'}`}>
                                        {data.is_published ? 'Live' : 'Draft'}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label className="block text-xs font-black text-muted uppercase tracking-widest mb-3">Content (HTML Supported)</label>
                                <textarea
                                    value={data.content}
                                    onChange={(e) => setData('content', e.target.value)}
                                    className="w-full bg-navy border border-border rounded-xl px-4 py-4 min-h-[400px] text-sm font-mono leading-relaxed focus:outline-none focus:border-cyan resize-y"
                                    placeholder="Write your article here... HTML tags are supported."
                                />
                            </div>
                        </div>
                    </div>
                )}
            </main>
        </div>
    );
}
