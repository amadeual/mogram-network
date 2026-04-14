@extends('layouts.admin')

@section('title', 'Gestão de Transmissões Ao Vivo')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Lives / Gestão</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Gestão de Transmissões</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Controle total sobre as transmissões ao vivo, agendadas e encerradas.</p>
    </div>
</div>

<!-- Filters -->
<div class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
    <div style="display: flex; gap: 4px;">
        <a href="#" class="header-btn" style="padding: 8px 16px; border-radius: 10px; background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); font-weight: 800; font-size: 0.75rem;">Todas</a>
        <a href="#" class="header-btn" style="padding: 8px 16px; border-radius: 10px; background: transparent; color: var(--text-muted); font-weight: 800; font-size: 0.75rem;">Ao Vivo</a>
        <a href="#" class="header-btn" style="padding: 8px 16px; border-radius: 10px; background: transparent; color: var(--text-muted); font-weight: 800; font-size: 0.75rem;">Agendadas</a>
    </div>
    <div style="flex: 1; position: relative; margin-left: 1rem;">
        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Buscar live ou criador..." style="width: 100%; background: transparent; border: none; padding: 10px 45px; color: white; outline: none; font-weight: 600;">
    </div>
</div>

<div class="admin-card" style="padding: 0; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Criador</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Título</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Agendado/Iniciado</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lives as $live)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.5rem 2rem;">
                    @if($live->user)
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$live->user->name }}" style="width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid rgba(255,255,255,0.1);">
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 800;">{{ $live->user->name }}</h4>
                            <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700;">@<span>{{ $live->user->username }}</span></p>
                        </div>
                    </div>
                    @endif
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <p style="font-size: 0.9rem; font-weight: 700; color: white;">{{ $live->title }}</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted);">{{ Str::limit($live->description, 50) }}</p>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center;">
                    @if($live->status == 'online')
                        <p style="font-size: 0.85rem; font-weight: 800; color: var(--primary-blue);">Iniciada {{ $live->started_at ? $live->started_at->diffForHumans() : 'agora' }}</p>
                    @elseif($live->scheduled_at && $live->status != 'finished')
                        <p style="font-size: 0.85rem; font-weight: 800; color: #ff8c2d;">Para {{ $live->scheduled_at->format('d/m H:i') }}</p>
                    @else
                        <p style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted);">Finalizada</p>
                    @endif
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center;">
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: {{ $live->status == 'online' ? 'rgba(239, 68, 68, 0.1)' : ($live->status == 'finished' ? 'rgba(255,255,255,0.05)' : 'rgba(51, 144, 236, 0.1)') }}; color: {{ $live->status == 'online' ? 'var(--danger)' : ($live->status == 'finished' ? 'var(--text-muted)' : 'var(--primary-blue)') }}; padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">
                        <div style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></div>
                        {{ $live->status == 'online' ? 'Ao Vivo' : ($live->status == 'finished' ? 'Encerrada' : 'Agendada') }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        @if($live->status == 'online')
                        <form id="finish-live-{{ $live->id }}" action="{{ route('admin.lives.finish', $live->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="reason" id="reason-{{ $live->id }}">
                            <button title="Terminar Live" type="button" onclick="terminateLive({{ $live->id }})" class="header-btn" style="width: 36px; height: 36px; background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="6" y="6" width="12" height="12"/></svg>
                            </button>
                        </form>
                        @endif

                        
                        <a href="{{ route('live.watch', $live->id) }}" target="_blank" class="header-btn" style="width: 36px; height: 36px; background: rgba(51, 144, 236, 0.1); color: var(--primary-blue);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>

                        <form action="{{ route('admin.content.delete_live', $live->id) }}" method="POST" onsubmit="return confirm('Remover esta live permanentemente do sistema?')">
                            @csrf
                            @method('DELETE')
                            <button title="Deletar Live" type="submit" class="header-btn" style="width: 36px; height: 36px; background: rgba(239, 68, 68, 0.05); color: var(--text-muted);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 1.5rem 2rem; border-top: 1.5px solid var(--border-gray);">
        {{ $lives->links() }}
    </div>
</div>

<script>
    function terminateLive(id) {
        const reason = prompt("Por favor, informe a razão para encerrar esta live (ex: Conteúdo Impróprio, Direitos Autorais, etc.):");
        if (reason !== null && reason.trim() !== "") {
            document.getElementById('reason-' + id).value = reason;
            document.getElementById('finish-live-' + id).submit();
        } else if (reason !== null) {
            alert("A razão é obrigatória para encerrar a live.");
        }
    }
</script>
@endsection

