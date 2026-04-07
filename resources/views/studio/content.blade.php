@extends('layouts.app')

@section('title', 'Gerenciar Conteúdo - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar (Integrated Gabriel Style) -->
    <aside class="sidebar" style="background: #0f111a; border-right: 1px solid rgba(255,255,255,0.05);">
        <div style="padding: 2rem 1.5rem; display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
            <div>
                <h4 style="font-size: 15px; font-weight: 700; color: white; margin: 0;">{{ Auth::user()->name }}</h4>
                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">@<span>{{ Auth::user()->username }}</span></p>
            </div>
        </div>
        
        <nav style="display: flex; flex-direction: column; gap: 0.25rem; padding: 0 0.75rem;">
            <a href="{{ route('dashboard') }}" class="menu-item" style="padding: 0.875rem 1rem; color: #a855f7; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 0.5rem; border-radius: 0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Voltar ao Feed
            </a>
            <a href="{{ route('studio.dashboard') }}" class="menu-item" style="padding: 0.875rem 1rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h7v7H3z"/><path d="M14 3h7v7h-7z"/><path d="M14 14h7v7h-7z"/><path d="M3 14h7v7H3z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('studio.content') }}" class="menu-item active" style="padding: 0.875rem 1rem; border-radius: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Conteúdo
            </a>
            <a href="{{ route('studio.analytics') }}" class="menu-item" style="padding: 0.875rem 1rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Analytics
            </a>
            <a href="#" class="menu-item" style="display: flex; justify-content: space-between; padding: 0.875rem 1rem;">
                </span>
                <span style="background: var(--primary-blue); color: white; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700;">0</span>
            </a>
            <a href="{{ route('studio.finance') }}" class="menu-item" style="padding: 0.875rem 1rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Financeiro
            </a>
            <a href="{{ route('studio.settings') }}" class="menu-item" style="padding: 0.875rem 1rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Configurações
            </a>
        </nav>

        <div style="margin-top: auto; padding: 2rem 0.75rem;">
            <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                <div style="width: 8px; height: 8px; background: #3390ec; border-radius: 50%; box-shadow: 0 0 10px #3390ec;"></div>
                <div>
                    <p style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 800; margin: 0;">Status da conta</p>
                    <p style="font-size: 11px; color: white; font-weight: 700; margin: 0;">Verificado</p>
                </div>
            </div>
    </aside>

    <main class="main-content" style="background: #0b0a15;">
        <header class="studio-header" style="padding: 2.5rem 3rem 1.5rem; display: flex; align-items: start; justify-content: space-between;">
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 900; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Gerenciar Conteúdo</h1>
                <p style="color: var(--text-muted); font-size: 15px;">Visualize, edite e monitore o desempenho de suas publicações.</p>
            </div>
            <a href="{{ route('studio.create') }}" class="mogram-btn-primary" style="padding: 0.875rem 2rem; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(51, 144, 236, 0.4); border-radius: 12px; font-weight: 700; text-decoration: none; color: white;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Novo Conteúdo
            </a>
        </header>

        <div class="studio-body" style="padding: 0 3rem 3rem;">
            <div class="metrics-grid studio-grid-3" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
                <div class="premium-metric-card" style="padding: 1.5rem; --accent-color: #3390ec;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Publicações Totais</p>
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin: 0.75rem 0;">{{ $totalPosts }}</h3>
                    <p style="font-size: 11px; color: var(--text-muted);">Acervo completo do criador</p>
                </div>
                <div class="premium-metric-card" style="padding: 1.5rem; --accent-color: #22c55e;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Receita Acumulada</p>
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin: 0.75rem 0;">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</h3>
                    <p style="font-size: 11px; color: #22c55e; font-weight: 700;">+ R$ 0,00 <span style="font-weight: 400; color: var(--text-muted);">esta semana</span></p>
                </div>
                <div class="premium-metric-card" style="padding: 1.5rem; --accent-color: #a855f7;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Engagement Global</p>
                    @php
                        $totalEngagement = $posts->sum(function($p) { return $p->getEngagement(); });
                        $avgEngagement = $totalPosts > 0 ? $totalEngagement / $totalPosts : 0;
                    @endphp
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin: 0.75rem 0;">{{ number_format($avgEngagement, 1, ',', '.') }}</h3>
                    <p style="font-size: 11px; color: var(--text-muted);">Média por publicação</p>
                </div>
            </div>

            <div class="studio-card-pad" style="background: rgba(255, 255, 255, 0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2rem;">
                <table class="studio-table">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <th style="padding-bottom: 1.5rem;">CONTEÚDO</th>
                            <th style="padding-bottom: 1.5rem;">TIPO</th>
                            <th style="padding-bottom: 1.5rem;">STATUS</th>
                            <th style="padding-bottom: 1.5rem;">MÉTRICAS</th>
                            <th style="padding-bottom: 1.5rem;">PREÇO</th>
                            <th style="padding-bottom: 1.5rem; text-align: right;">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>
                                <div style="display: flex; gap: 1.25rem; align-items: center;">
                                    <div style="position: relative; width: 88px; height: 50px; border-radius: 10px; overflow: hidden; background: rgba(255,255,255,0.05);">
                                        @if($post->type == 'image')
                                            <img src="{{ Storage::url($post->file_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white;">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 style="font-size: 14px; font-weight: 800; color: white; margin-bottom: 4px;">{{ $post->title }}</h4>
                                        <p style="font-size: 11px; color: var(--text-muted);">{{ $post->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="background: rgba(255,255,255,0.05); padding: 6px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; color: white; display: inline-flex; align-items: center; gap: 8px; text-transform: capitalize;">
                                    {{ $post->type }}
                                </span>
                            </td>
                            <td>
                                <span style="background: rgba(34,197,94,0.1); color: #22c55e; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px;">
                                    <div style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%; box-shadow: 0 0 10px #22c55e;"></div>
                                    Publicado
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 1.5rem; align-items: center;">
                                    <div style="text-align: center;">
                                        <p style="font-size: 12px; font-weight: 900; color: white; margin: 0;">{{ number_format($post->views, 0, ',', '.') }}</p>
                                        <p style="font-size: 9px; color: var(--text-muted); text-transform: uppercase;">Views</p>
                                    </div>
                                    <div style="text-align: center;">
                                        <p style="font-size: 12px; font-weight: 900; color: var(--primary-blue); margin: 0;">{{ number_format($post->getEngagement(), 0, ',', '.') }}</p>
                                        <p style="font-size: 9px; color: var(--text-muted); text-transform: uppercase;">Engage</p>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size: 14px; font-weight: 800; color: white;">R$ {{ number_format($post->price, 2, ',', '.') }}</td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 1rem; justify-content: flex-end; color: var(--text-muted); align-items: center;">
                                    <a href="{{ route('studio.post_analytics', $post->id) }}" style="color: var(--primary-blue); text-decoration: none; padding: 0.5rem; background: rgba(51, 144, 236, 0.1); border-radius: 8px;" title="Ver Análise">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                    </a>
                                    <a href="{{ route('studio.edit', $post->id) }}" style="color: inherit; text-decoration: none; padding: 0.5rem;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form action="{{ route('studio.delete', $post->id) }}" method="POST" onsubmit="return confirm('Excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: transparent; border: none; color: inherit; cursor: pointer; padding: 0.5rem;">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align: center; padding: 4rem; color: var(--text-muted);">Nenhum conteúdo.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 2rem;">{{ $posts->links() }}</div>
            </div>
        </div>
    </main>
</div>
@endsection
