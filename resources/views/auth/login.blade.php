@extends('layouts.app')

@section('title', 'Entrar - Mogram')

@section('content')
<div class="auth-container">
    <div class="auth-left">
        <div class="auth-back-btn">
            <a href="/" class="text-muted text-sm flex items-center gap-2" style="font-weight: 800; opacity: 0.8;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                VOLTAR
            </a>
        </div>
        
        <div style="display: inline-block; padding: 0.25rem 0.75rem; background: rgba(51, 144, 236, 0.1); border-radius: 99px; color: var(--primary-blue); font-size: 10px; font-weight: 800; text-transform: none; margin-bottom: 1.5rem;">
            Mogram Premium
        </div>
        
        <h1 style="font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 800; line-height: 1.2; margin-bottom: 1.5rem;">
            Monetize seu conteúdo <span class="grad-text">exclusivo</span> com simplicidade.
        </h1>
        
        <p class="text-light" style="font-size: clamp(0.95rem, 1.5vw, 1.05rem); max-width: 450px; margin-bottom: 2.5rem; line-height: 1.6;">
            Junte-se a milhares de criadores que estão transformando sua paixão em receita recorrente. Controle total, análises em tempo real e pagamentos seguros.
        </p>
        
        <div class="flex items-center gap-4">
            <div class="flex" style="margin-left: 0.5rem;">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #1a1a1a; object-fit: cover;">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #1a1a1a; margin-left: -12px; object-fit: cover;">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #1a1a1a; margin-left: -12px; object-fit: cover;">
            </div>
            <span class="text-sm font-semibold text-light">Mais de 10.000 criadores ativos</span>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-card">
            <div class="text-center" style="margin-bottom: 3rem;">
                <a href="{{ route('home') }}" style="display: inline-block;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 512 512" style="margin-bottom: 1.5rem;">
                        <defs><linearGradient id="authLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                        <rect width="512" height="512" rx="100" fill="url(#authLogoGrad)" />
                        <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                    </svg>
                </a>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Bem-vindo ao Mogram</h2>
                <p class="text-muted text-sm">Acesse sua conta para gerenciar seu conteúdo.</p>
            </div>

            <div class="auth-tabs">
                <a href="/login" class="auth-tab active">Entrar</a>
                <a href="/register" class="auth-tab">Cadastrar</a>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 12px; margin-bottom: 2rem; color: #ef4444; font-size: 13px;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mogram-input-group">
                    <label class="mogram-label">E-mail ou nome de usuário</label>
                    <div class="mogram-input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <input type="text" name="login" class="mogram-input" placeholder="seu@email.com" required>
                </div>

                <div class="mogram-input-group">
                    <div class="flex justify-between items-center" style="margin-bottom: 0.5rem;">
                        <label class="mogram-label" style="margin-bottom: 0;">Senha</label>
                        <a href="{{ route('password.request') }}" class="text-blue text-xs font-bold">Esqueceu sua senha?</a>
                    </div>
                    <div class="mogram-input-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input type="password" name="password" class="mogram-input" placeholder="••••••••" required>
                    <div class="mogram-input-password-toggle">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                </div>

                <button type="submit" class="mogram-btn-primary mogram-btn-full" style="margin-top: 1rem;">
                    Entrar na Plataforma
                </button>
            </form>

            <div style="margin: 2rem 0; position: relative; text-align: center;">
                <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: var(--border-gray); z-index: 0;"></div>
                <span style="position: relative; background: var(--dark-bg); padding: 0 1rem; color: var(--text-muted); font-size: 10px; font-weight: 800; text-transform: none;">Ou continue com</span>
            </div>

            <div class="flex flex-direction-column gap-4" style="flex-direction: column;">
                <button class="mogram-btn-social">
                    <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#EA4335" d="M12.48 10.92v3.28h7.84c-.24 1.84-.9 3.47-1.92 4.64-1.12 1.34-2.88 2.62-5.92 2.62-4.73 0-8.59-3.41-8.59-8.46s3.86-8.46 8.59-8.46c2.51 0 4.27 1.01 5.56 2.22l2.3-2.3C18.66 2.76 16.03 1.5 12.48 1.5 6.3 1.5 1.5 6.44 1.5 12.63s4.8 11.13 10.98 11.13c3.34 0 5.86-1.1 7.82-3.14 2 2 4.7 3.14 7.7 3.14 5.34 0 9.7-4.36 9.7-9.7s-4.36-9.7-9.7-9.7c-2.34 0-4.48.84-6.14 2.24L12.48 10.92z"/></svg>
                    Google
                </button>
            </div>

            <p class="text-center text-muted" style="font-size: 10px; margin-top: 3rem; line-height: 1.6;">
                Ao continuar, você concorda com nossos <br> <a href="{{ route('terms') }}" class="text-light">Termos de Uso</a> e <a href="{{ route('privacy') }}" class="text-light">Política de Privacidade</a>.
            </p>
        </div>
    </div>
</div>
@endsection
