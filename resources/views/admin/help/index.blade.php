@extends('layouts.admin')

@section('title', 'Gerenciar Central de Ajuda')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Suporte / Central de Ajuda</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Gerenciar Central de Ajuda</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Crie e edite guias e artigos para os usuários.</p>
    </div>
    <a href="{{ route('admin.help.create') }}" class="btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Artigo
    </a>
</div>

<div class="admin-card" style="padding: 0; overflow: visible;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Artigo</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Categoria</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Ordem</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;">
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" style="width: 48px; height: 32px; border-radius: 6px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                        @else
                            <div style="width: 48px; height: 32px; border-radius: 6px; background: rgba(51,144,236,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                        @endif
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 800;">{{ $article->title }}</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted);">{{ Str::limit($article->description, 50) }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <span style="background: rgba(255,255,255,0.05); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; color: #94a3b8; border: 1px solid rgba(255,255,255,0.05)">
                        {{ $article->category }}
                    </span>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; font-weight: 800; color: white;">
                    {{ $article->order }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center;">
                    @if($article->is_active)
                        <span style="color: var(--success); font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <div style="width: 6px; height: 6px; background: var(--success); border-radius: 50%;"></div>
                            Ativo
                        </span>
                    @else
                        <span style="color: var(--text-muted); font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <div style="width: 6px; height: 6px; background: var(--text-muted); border-radius: 50%;"></div>
                            Inativo
                        </span>
                    @endif
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <a href="{{ route('admin.help.edit', $article->id) }}" style="background: rgba(51,144,236,0.1); color: var(--primary-blue); padding: 8px; border-radius: 10px; transition: 0.2s;" onmouseover="this.style.background='var(--primary-blue)'; this.style.color='white'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <form action="{{ route('admin.help.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: rgba(239,68,68,0.1); color: var(--danger); border: none; padding: 8px; border-radius: 10px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='var(--danger)'; this.style.color='white'">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem 2rem; text-align: center;">
                    <p style="color: var(--text-muted); font-weight: 600;">Nenhum artigo de ajuda encontrado.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
