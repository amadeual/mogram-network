@extends('layouts.app')

@section('title', 'Dashboard - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <!-- Studio Content -->
    <main class="main-content" style="background: #0b0a15;">
        <header class="studio-header" style="padding: 2.5rem 3rem 1.5rem; display: flex; align-items: start; justify-content: space-between;">
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 900; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Dashboard do Studio</h1>
                <p style="color: var(--text-muted); font-size: 15px;">Acompanhe o desempenho e gerencie seu conteúdo.</p>
            </div>
            <a href="{{ route('studio.create') }}" class="mogram-btn-primary" style="padding: 0.875rem 2rem; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(51, 144, 236, 0.4); border-radius: 12px; font-weight: 700; text-decoration: none; color: white;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Novo Conteúdo
            </a>
        </header>

        <div class="studio-body" style="padding: 0 3rem 3rem;">
            <!-- Metrics Grid -->
            <div class="studio-grid-3" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Publicações Totais</p>
                        <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        </div>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin-bottom: 0.75rem;">{{ Auth::user()->posts()->count() }}</h3>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #22c55e;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        +0% <span style="font-weight: 400; color: var(--text-muted); margin-left: 2px;">vs. mês passado</span>
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Aprovados (30d)</p>
                        <div style="width: 32px; height: 32px; background: rgba(168, 85, 247, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin-bottom: 0.75rem;">{{ Auth::user()->posts()->count() }}</h3>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #22c55e;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        +0% <span style="font-weight: 400; color: var(--text-muted); margin-left: 2px;">vs. mês passado</span>
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Receita Total</p>
                        <div style="width: 32px; height: 32px; background: rgba(34, 197, 94, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <h3 style="font-size: 2rem; font-weight: 950; color: white; margin-bottom: 0.75rem;">R$ {{ number_format($totalRevenue ?? 0, 2, ',', '.') }}</h3>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #22c55e;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        0% <span style="font-weight: 400; color: var(--text-muted); margin-left: 2px;">este mês</span>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="studio-card-pad" style="background: rgba(255, 255, 255, 0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2rem;">
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 18px; font-weight: 900; color: white;">Publicações Recentes</h3>
                </div>

                <table class="studio-table">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <th style="padding-bottom: 1.5rem;">CONTEÚDO</th>
                            <th style="padding-bottom: 1.5rem;">TIPO</th>
                            <th style="padding-bottom: 1.5rem;">STATUS</th>
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
                                        <p style="font-size: 11px; color: var(--text-muted);">{{ $post->created_at->diffForHumans() }}</p>
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
                                    <div style="width: 7px; height: 7px; background: #22c55e; border-radius: 50%;"></div>
                                    Publicado
                                </span>
                            </td>
                            <td style="font-size: 14px; font-weight: 800; color: white;">R$ {{ number_format($post->price, 2, ',', '.') }}</td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 1.25rem; justify-content: flex-end; color: var(--text-muted);">
                                    <a href="{{ route('studio.edit', $post->id) }}" style="color: inherit; text-decoration: none;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="cursor:pointer;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form action="{{ route('studio.delete', $post->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: transparent; border: none; color: inherit; padding: 0; cursor: pointer;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">Nenhum conteúdo encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($posts->count() > 0)
                <div style="display: flex; justify-content: center; margin-top: 2rem;">
                    <a href="{{ route('studio.content') }}" style="color: var(--primary-blue); font-size: 13px; font-weight: 800; text-decoration: none;">Ver todas as publicações</a>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
