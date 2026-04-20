@extends('layouts.app')

@section('title', 'Central de Ajuda - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div style="padding: 4rem 2rem; max-width: 900px; margin: 0 auto;">
            <header style="text-align: center; margin-bottom: 5rem;">
                <h1 style="font-size: 42px; font-weight: 950; color: white; margin-bottom: 1rem; letter-spacing: -1.5px;">Central de Ajuda</h1>
                <p style="color: var(--text-muted); font-size: 18px; font-weight: 600;">Como podemos ajudar você hoje?</p>
            </header>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 5rem;">
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary-blue)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'">
                    <div style="width: 48px; height: 48px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 1.5rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: white; margin-bottom: 0.75rem;">Conta e Perfil</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Tudo sobre como configurar seu perfil, editar dados e gerenciar sua conta.</p>
                </div>

                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary-blue)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'">
                    <div style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #22c55e; margin-bottom: 1.5rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h10M7 9h10"/></svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: white; margin-bottom: 0.75rem;">Financeiro</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Dúvidas sobre depósitos, saques, taxas e como funcionam os pagamentos.</p>
                </div>

                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary-blue)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'">
                    <div style="width: 48px; height: 48px; background: rgba(239, 68, 68, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ef4444; margin-bottom: 1.5rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: white; margin-bottom: 0.75rem;">Segurança</h3>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">Como protegemos seus dados e o que você pode fazer para manter sua conta segura.</p>
                </div>
            </div>

            <section style="margin-bottom: 5rem;">
                <h2 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 2rem;">Perguntas Frequentes</h2>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <details style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; transition: 0.2s;">
                        <summary style="font-weight: 800; color: white; cursor: pointer; display: flex; align-items: center; gap: 10px; list-style: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                            Como posso me tornar um criador no Mogram?
                        </summary>
                        <p style="margin-top: 1rem; color: var(--text-muted); font-size: 14px; line-height: 1.6; padding-left: 30px;">
                            Para se tornar um criador, acesse o Mogram Studio no seu menu lateral. Lá você poderá configurar seu perfil de criador, definir categorias e começar a publicar conteúdo exclusivo.
                        </p>
                    </details>

                    <details style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; transition: 0.2s;">
                        <summary style="font-weight: 800; color: white; cursor: pointer; display: flex; align-items: center; gap: 10px; list-style: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                            Quanto tempo leva para processar um saque?
                        </summary>
                        <p style="margin-top: 1rem; color: var(--text-muted); font-size: 14px; line-height: 1.6; padding-left: 30px;">
                            Os saques são processados em até 48 horas úteis após a solicitação. Lembramos que é necessário atingir o saldo mínimo estipulado no seu painel financeiro.
                        </p>
                    </details>

                    <details style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; transition: 0.2s;">
                        <summary style="font-weight: 800; color: white; cursor: pointer; display: flex; align-items: center; gap: 10px; list-style: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                            O Mogram é seguro?
                        </summary>
                        <p style="margin-top: 1rem; color: var(--text-muted); font-size: 14px; line-height: 1.6; padding-left: 30px;">
                            Sim, utilizamos criptografia de ponta a ponta para seus dados e parceiros de pagamento certificados internacionalmente para garantir a segurança de suas transações financeiras.
                        </p>
                    </details>
                </div>
            </section>

            <div style="background: linear-gradient(135deg, rgba(51, 144, 236, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%); border: 1.5px solid rgba(51, 144, 236, 0.2); border-radius: 32px; padding: 4rem; text-align: center;">
                <h2 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 1rem;">Ainda precisa de ajuda?</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem; font-weight: 600;">Nossa equipe de suporte está disponível para atender você.</p>
                <a href="mailto:info@mogramnetwork.com" class="mogram-btn-primary" style="padding: 1rem 3rem; border-radius: 16px; text-decoration: none; font-weight: 800; display: inline-block;">Falar com o Suporte</a>
            </div>
        </div>
    </main>
</div>

<style>
    summary::-webkit-details-marker { display: none; }
    details[open] summary svg { transform: rotate(180deg); }
    details[open] { background: rgba(255,255,255,0.04) !important; border-color: rgba(51, 144, 236, 0.3) !important; }
</style>
@endsection
