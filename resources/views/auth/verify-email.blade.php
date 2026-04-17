@extends('layouts.app')

@section('title', 'Verifique seu E-mail - Mogram')

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
            Verificação de Segurança
        </div>
        
        <h1 style="font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 800; line-height: 1.2; margin-bottom: 1.5rem;">
            Confirme seu <span class="grad-text">e-mail</span> para continuar.
        </h1>
        
        <p class="text-light" style="font-size: clamp(0.95rem, 1.5vw, 1.05rem); max-width: 450px; margin-bottom: 2.5rem; line-height: 1.6;">
            Enviamos um link de verificação para o seu endereço de e-mail. Por favor, clique no link para validar sua conta e acessar todos os recursos do Mogram.
        </p>
    </div>

    <div class="auth-right">
        <div class="auth-form-card">
            <div class="text-center" style="margin-bottom: 3rem;">
                <div style="width: 80px; height: 80px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Verifique seu E-mail</h2>
                <p class="text-muted text-sm">Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você?</p>
            </div>

            @if (session('success'))
                <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); padding: 1rem; border-radius: 12px; margin-bottom: 2rem; color: #22c55e; font-size: 13px; text-align: center; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-direction-column gap-4" style="flex-direction: column;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="mogram-btn-primary mogram-btn-full">
                        Reenviar E-mail de Verificação
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mogram-btn-social" style="width: 100%; border: none; background: transparent; color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                        Sair da Conta
                    </button>
                </form>
            </div>

            <p class="text-center text-muted" style="font-size: 10px; margin-top: 3rem; line-height: 1.6;">
                Se você não recebeu o e-mail, verifique sua caixa de spam ou <br> clique no botão acima para reenviar.
            </p>
        </div>
    </div>
</div>
@endsection
