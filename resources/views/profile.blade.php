@extends('layouts.app')

@section('title', 'Ana Silva - Mogram Creator Hub')

@section('content')
<div class="app-layout">
    <!-- Sidebar (Same as Feed) -->
    <aside class="sidebar">
        <div class="sidebar-logo">Mogram</div>
        <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
            <a href="{{ route('dashboard') }}" class="menu-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </a>
            <a href="#" class="menu-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Stories
            </a>
            <a href="#" class="menu-item active">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Perfil
            </a>
            <a href="#" class="menu-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Configurações
            </a>
        </nav>
        <div class="sidebar-user">
            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 50%;">
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 13px; font-weight: 700; color: white; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Creator Hub</p>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="creator-header">
            <div style="position: relative; display: inline-block;">
                <img src="{{ asset('images/creators/ana.png') }}" class="creator-avatar-large">
                <div style="position: absolute; bottom: 20px; right: 5px; width: 24px; height: 24px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid #0b0a15;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                </div>
            </div>
            
            <h1 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 0.25rem;">Ana Silva</h1>
            <p style="font-size: 11px; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Lifestyle & Moda</p>
            
            <div class="creator-stats">
                <div class="stat-item">
                    <span class="stat-value">125K</span>
                    <span class="stat-label">Seguidores</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">300</span>
                    <span class="stat-label">Posts</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">4.9</span>
                    <span class="stat-label">Avaliação</span>
                </div>
            </div>

            <p style="max-width: 420px; margin: 0 auto; line-height: 1.6; color: var(--text-light); text-align: center;">
                Conteúdo exclusivo sobre moda, bastidores e dicas de estilo. Assine para desbloquear tudo! ✨👗📸
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 2rem;">
                <button class="mogram-btn-social" style="padding: 1rem 3rem;">Seguir</button>
                <button class="mogram-btn-primary" style="padding: 1rem 3rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Assinar
                </button>
                <button class="mogram-btn-social" style="padding: 1rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </button>
            </div>
        </div>

        <div class="tab-bar">
            <a href="#" class="tab-link active">Posts</a>
            <a href="#" class="tab-link">Stories</a>
            <a href="#" class="tab-link">Lives</a>
        </div>

        <div class="feed-container">
            <!-- Pinned Post -->
            <div class="post-card">
                <div style="padding: 0.75rem 1.5rem; background: rgba(51, 144, 236, 0.05); border-bottom: 1px solid var(--border-gray); display: flex; align-items: center; gap: 8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#3390ec"><path d="M21 10h-8V2l-1-1H4v21l1 1h8v-3l1-1h7l1-1V11l-1-1z"/></svg>
                    <span style="font-size: 10px; font-weight: 800; color: var(--primary-blue); text-transform: uppercase;">Fixado</span>
                </div>
                <div class="post-media" style="aspect-ratio: 1/1;">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop" style="filter: blur(20px) brightness(0.5);">
                    <div class="exclusive-overlay">
                        <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.5rem;">Conteúdo Exclusivo</h3>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2rem;">Bastidores da sessão de fotos de Verão.</p>
                        <button class="mogram-btn-primary" style="padding: 1rem 3.5rem; border-radius: 12px;">Desbloquear <span style="font-weight: 400; opacity: 0.8; margin-left: 8px;">R$ 9,90</span></button>
                    </div>
                </div>
            </div>

            <!-- Normal Post -->
            <div class="post-card">
                <div class="post-header">
                    <img src="{{ asset('images/creators/ana.png') }}" class="post-author-img">
                    <div style="flex: 1;">
                        <h4 style="font-size: 14px; font-weight: 800;">Ana Silva</h4>
                        <p style="font-size: 11px; color: var(--text-muted);">Ontem às 13:30</p>
                    </div>
                </div>
                <div class="post-media" style="aspect-ratio: 1/1;">
                    <img src="https://images.unsplash.com/photo-1539109132381-31a1C974a0c1?q=80&w=1974&auto=format&fit=crop">
                </div>
                <div class="post-footer">
                    <div style="display: flex; gap: 1.5rem;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </div>
                </div>
                <div style="padding: 0 1.5rem 1.5rem;">
                    <p style="font-size: 13px; font-weight: 800; margin-bottom: 0.25rem;">2.845 curtidas</p>
                    <p style="font-size: 13px; line-height: 1.5;"><span style="font-weight: 800;">Ana Silva</span> Look do dia para o evento de ontem! Apaixonada por essa combinação de cores. O que acharam? 👇</p>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 0.5rem; cursor: pointer;">Ver todos os 124 comentários</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
