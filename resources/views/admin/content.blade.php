@extends('layouts.admin')

@section('title', 'Gestão de Conteúdo')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Conteúdo / Posts</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Gestão de Conteúdo</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Monitore e modere as publicações e transmissões ao vivo da plataforma.</p>
    </div>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    <div class="admin-card" style="padding: 1.5rem;">
        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Total de Posts</p>
        <h2 style="font-size: 1.5rem; font-weight: 900;">{{ $posts->total() }}</h2>
    </div>
    <div class="admin-card" style="padding: 1.5rem;">
        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Transmissões Ativas/Recentes</p>
        <h2 style="font-size: 1.5rem; font-weight: 900;">{{ count($lives) }}</h2>
    </div>
</div>

<!-- Posts Table -->
<div class="admin-card" style="padding: 0; margin-bottom: 3rem; overflow-x: auto;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1.5px solid var(--border-gray);">
        <h3 style="font-size: 1rem; font-weight: 800;">Galeria de Posts</h3>
    </div>
    <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Criador</th>
                <th style="padding: 1rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Título/Legenda</th>
                <th style="padding: 1rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Preço</th>
                <th style="padding: 1rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Mídia</th>
                <th style="padding: 1rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1rem 2rem;">
                    @if($post->user)
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$post->user->name }}" style="width: 32px; height: 32px; border-radius: 8px;">
                        <div>
                            <h4 style="font-size: 0.8rem; font-weight: 800;">{{ $post->user->name }}</h4>
                            <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600;">@<span>{{ $post->user->username }}</span></p>
                        </div>
                    </div>
                    @else
                    <span style="color: var(--text-muted); font-size: 0.8rem;">Usuário Deletado</span>
                    @endif
                </td>
                <td style="padding: 1rem 2rem;">
                    <p style="font-size: 0.85rem; font-weight: 600; color: white;">{{ Str::limit($post->title ?? $post->content, 50) }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-muted);">{{ $post->created_at->diffForHumans() }}</p>
                </td>
                <td style="padding: 1rem 2rem; text-align: center;">
                    @if($post->price > 0)
                        <span style="color: var(--success); font-weight: 800; font-size: 0.85rem;">R$ {{ number_format($post->price, 2, ',', '.') }}</span>
                    @else
                        <span style="color: var(--text-muted); font-weight: 800; font-size: 0.85rem;">Gratuito</span>
                    @endif
                </td>
                <td style="padding: 1rem 2rem; text-align: center;">
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.05); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; color: var(--text-muted);">
                        @if($post->type == 'video')
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                            Vídeo
                        @else
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Imagem
                        @endif
                    </div>
                </td>
                <td style="padding: 1rem 2rem; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <a href="{{ route('creator.profile', $post->user->username) }}" target="_blank" class="header-btn" style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); color: var(--primary-blue);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <form action="{{ route('admin.content.delete_post', $post->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este post permanentemente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="header-btn" style="width: 32px; height: 32px; background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 1.5rem 2rem; border-top: 1.5px solid var(--border-gray);">
        {{ $posts->links() }}
    </div>
</div>

<!-- Lives Section -->
<div class="admin-card" style="padding: 0; overflow-x: auto;">
    <div style="padding: 1.5rem 2rem; border-bottom: 1.5px solid var(--border-gray);">
        <h3 style="font-size: 1rem; font-weight: 800;">Auditando Lives</h3>
    </div>
    <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Criador</th>
                <th style="padding: 1rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Título</th>
                <th style="padding: 1rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Status</th>
                <th style="padding: 1rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lives as $live)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1rem 2rem;">
                    @if($live->user)
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$live->user->name }}" style="width: 32px; height: 32px; border-radius: 8px;">
                        <h4 style="font-size: 0.8rem; font-weight: 800;">{{ $live->user->name }}</h4>
                    </div>
                    @endif
                </td>
                <td style="padding: 1rem 2rem;">
                    <p style="font-size: 0.85rem; font-weight: 600; color: white;">{{ Str::limit($live->title, 50) }}</p>
                </td>
                <td style="padding: 1rem 2rem; text-align: center;">
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: {{ $live->status == 'online' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(255,255,255,0.05)' }}; color: {{ $live->status == 'online' ? 'var(--danger)' : 'var(--text-muted)' }}; padding: 6px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase;">
                        <div style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></div>
                        {{ $live->status == 'online' ? 'Ao Vivo' : 'Encerrada' }}
                    </div>
                </td>
                <td style="padding: 1rem 2rem; text-align: right;">
                    <form action="{{ route('admin.content.delete_live', $live->id) }}" method="POST" onsubmit="return confirm('Encerrar/Remover esta live agora?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="header-btn" style="width: 32px; height: 32px; background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
