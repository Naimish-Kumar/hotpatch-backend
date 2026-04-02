import React, { useState, useEffect } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Logo } from '@/Components/Logo';
import { AlertTriangle, Loader2, Mail, Lock, ShieldCheck, ArrowRight } from 'lucide-react';

export default function Login({ verified: initiallyVerified }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [mode, setMode] = useState('email'); // 'email' | 'apikey'
    const [apiKey, setApiKey] = useState('');
    const [localError, setLocalError] = useState('');

    const handleEmailLogin = (e) => {
        e.preventDefault();
        post('/auth/login', {
            onError: (err) => {
                setLocalError(err.error || 'Login failed.');
            },
            onFinish: () => reset('password'),
        });
    };

    const handleApiKeyLogin = (e) => {
        e.preventDefault();
        // API key login would likely be a different endpoint or handled via headers
        setLocalError('API Key login not yet implemented in Laravel backend.');
    };

    return (
        <div style={{
            minHeight: '100vh',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            padding: '40px',
            position: 'relative',
            overflow: 'hidden',
        }}>
            <Head title="Login" />
            <div className="hero-grid" />

            <div className="afu" style={{
                position: 'relative',
                zIndex: 2,
                width: '100%',
                maxWidth: '420px',
            }}>
                <div style={{ textAlign: 'center', marginBottom: '40px' }}>
                    <Link href="/">
                        <Logo width={180} height={40} />
                    </Link>
                </div>

                <div style={{
                    background: 'var(--navy2)',
                    border: '1px solid var(--border2)',
                    borderRadius: '16px',
                    padding: '36px',
                    boxShadow: '0 24px 60px rgba(0,0,0,.4)',
                }}>
                    <h1 style={{
                        fontFamily: 'Syne, sans-serif',
                        fontSize: '24px',
                        fontWeight: 800,
                        letterSpacing: '-1px',
                        marginBottom: '6px',
                        textAlign: 'center',
                    }}>Welcome back</h1>
                    <p style={{
                        fontSize: '14px',
                        color: 'var(--muted)',
                        textAlign: 'center',
                        marginBottom: '28px',
                    }}>Sign in to manage your OTA updates</p>

                    {/* Google Login Button (Demo) */}
                    <button
                        onClick={() => window.location.href = `/auth/google/login`}
                        style={{
                            width: '100%',
                            padding: '12px',
                            background: 'white',
                            color: 'black',
                            border: 'none',
                            borderRadius: '9px',
                            fontSize: '14px',
                            fontWeight: 600,
                            cursor: 'pointer',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            gap: '10px',
                            marginBottom: '20px',
                        }}
                    >
                        Continue with Google
                    </button>

                    <div style={{ display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '20px' }}>
                        <div style={{ flex: 1, height: '1px', background: 'var(--border2)' }} />
                        <span style={{ fontSize: '11px', color: 'var(--muted2)', textTransform: 'uppercase' }}>or use email</span>
                        <div style={{ flex: 1, height: '1px', background: 'var(--border2)' }} />
                    </div>

                    {/* Tabs */}
                    <div style={{
                        display: 'flex',
                        background: 'var(--navy)',
                        padding: '4px',
                        borderRadius: '10px',
                        marginBottom: '24px',
                        border: '1px solid var(--border2)',
                    }}>
                        <button
                            onClick={() => setMode('email')}
                            style={{
                                flex: 1, padding: '8px', borderRadius: '7px', fontSize: '12px', fontWeight: 600, border: 'none',
                                background: mode === 'email' ? 'var(--cdim)' : 'transparent',
                                color: mode === 'email' ? 'var(--cyan)' : 'var(--muted)',
                                cursor: 'pointer'
                            }}>Email Login</button>
                        <button
                            onClick={() => setMode('apikey')}
                            style={{
                                flex: 1, padding: '8px', borderRadius: '7px', fontSize: '12px', fontWeight: 600, border: 'none',
                                background: mode === 'apikey' ? 'var(--cdim)' : 'transparent',
                                color: mode === 'apikey' ? 'var(--cyan)' : 'var(--muted)',
                                cursor: 'pointer'
                            }}>API Key</button>
                    </div>

                    {(localError || errors.email) && (
                        <div style={{
                            background: 'rgba(255,77,106,.1)',
                            border: '1px solid rgba(255,77,106,.25)',
                            borderRadius: '8px',
                            padding: '10px 14px',
                            fontSize: '13px',
                            color: 'var(--red)',
                            marginBottom: '18px',
                            display: 'flex',
                            alignItems: 'center',
                            gap: '8px',
                        }}>
                            <AlertTriangle size={14} /> {localError || errors.email}
                        </div>
                    )}

                    {mode === 'email' ? (
                        <form onSubmit={handleEmailLogin}>
                            <div style={{ marginBottom: '16px' }}>
                                <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>Email</label>
                                <div style={{ position: 'relative' }}>
                                    <Mail size={14} style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: 'var(--muted2)' }} />
                                    <input
                                        type="email"
                                        required
                                        value={data.email}
                                        onChange={e => setData('email', e.target.value)}
                                        placeholder="name@company.com"
                                        className="bg-transparent border border-gray-700 rounded-md w-full p-2 pl-9"
                                        style={{ width: '100%', padding: '11px 12px 11px 36px', background: 'var(--navy)', border: '1px solid var(--border2)', borderRadius: '9px', color: 'white', outline: 'none' }}
                                    />
                                </div>
                            </div>
                            <div style={{ marginBottom: '24px' }}>
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '6px' }}>
                                    <label style={{ fontSize: '12px', color: 'var(--muted)' }}>Password</label>
                                    <Link href="/forgot-password" style={{ fontSize: '11px', color: 'var(--cyan)', textDecoration: 'none' }}>
                                        Forgot password?
                                    </Link>
                                </div>
                                <div style={{ position: 'relative' }}>
                                    <Lock size={14} style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: 'var(--muted2)' }} />
                                    <input
                                        type="password"
                                        required
                                        value={data.password}
                                        onChange={e => setData('password', e.target.value)}
                                        placeholder="••••••••"
                                        style={{ width: '100%', padding: '11px 12px 11px 36px', background: 'var(--navy)', border: '1px solid var(--border2)', borderRadius: '9px', color: 'white', outline: 'none' }}
                                    />
                                </div>
                            </div>
                            <button
                                type="submit"
                                disabled={processing}
                                style={{
                                    width: '100%',
                                    padding: '12px',
                                    background: 'var(--cyan)',
                                    color: 'var(--navy)',
                                    border: 'none',
                                    borderRadius: '9px',
                                    fontWeight: 700,
                                    cursor: 'pointer',
                                }}
                            >
                                {processing ? <Loader2 size={16} className="animate-spin" /> : 'Sign In'}
                            </button>
                        </form>
                    ) : (
                        <form onSubmit={handleApiKeyLogin}>
                            <div style={{ marginBottom: '20px' }}>
                                <label style={{ display: 'block', fontSize: '12px', color: 'var(--muted)', marginBottom: '6px' }}>API Key</label>
                                <input
                                    type="password"
                                    required
                                    value={apiKey}
                                    onChange={e => setApiKey(e.target.value)}
                                    placeholder="hp_xxxxxxxxxxxxxxxxxxxx"
                                    style={{
                                        width: '100%',
                                        padding: '11px 14px',
                                        background: 'var(--navy)',
                                        border: '1px solid var(--border2)',
                                        borderRadius: '9px',
                                        color: 'white',
                                        outline: 'none',
                                        fontFamily: 'JetBrains Mono, monospace',
                                        fontSize: '13px'
                                    }}
                                />
                            </div>
                            <button
                                type="submit"
                                style={{
                                    width: '100%',
                                    padding: '12px',
                                    background: 'var(--cyan)',
                                    color: 'var(--navy)',
                                    border: 'none',
                                    borderRadius: '9px',
                                    fontWeight: 700,
                                    cursor: 'pointer',
                                }}
                            >
                                Login with Key
                            </button>
                        </form>
                    )}

                    <div style={{ marginTop: '24px', textAlign: 'center' }}>
                        <Link href="/register" style={{ fontSize: '13px', color: 'var(--cyan)', textDecoration: 'none' }}>
                            Don't have an account? Sign up
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
}
