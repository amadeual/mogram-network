@extends('layouts.admin')

@section('title', 'Gerenciamento de Suporte')

@section('content')
<div style="padding: 2.5rem;">
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -1.5px; margin-bottom: 0.5rem;">Gestão de Chamados</h1>
            <p style="color: var(--text-muted); font-size: 15px; font-weight: 600;">{{ $tickets->where('status', 'Aberto')->count() }} tickets aguardando atendimento agora.</p>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <div class="stat-mini-card">
                <span class="label">TOTAL</span>
                <span class="value">{{ $tickets->count() }}</span>
            </div>
            <div class="stat-mini-card open">
                <span class="label">ABERTOS</span>
                <span class="value">{{ $tickets->where('status', 'Aberto')->count() }}</span>
            </div>
        </div>
    </header>

    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1.5px solid rgba(255,255,255,0.03);">
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">ID</th>
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">Usuário</th>
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">Assunto / Mensagem</th>
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">Categoria</th>
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">Status</th>
                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase;">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.02); transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.5rem; color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;">#{{ $ticket->id }}</td>
                    <td style="padding: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($ticket->user->avatar)
                                <img src="{{ Storage::url($ticket->user->avatar) }}" style="width: 32px; height: 32px; border-radius: 8px;">
                            @else
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $ticket->user->name }}" style="width: 32px; height: 32px; border-radius: 8px;">
                            @endif
                            <div>
                                <p style="color: white; font-size: 13px; font-weight: 800; margin: 0;">{{ $ticket->user->name }}</p>
                                <p style="color: var(--text-muted); font-size: 10px; font-weight: 600; margin: 0;">@<span>{{ $ticket->user->username }}</span></p>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1.5rem;">
                        <p style="color: white; font-size: 13px; font-weight: 800; margin-bottom: 2px;">{{ $ticket->subject }}</p>
                        <p style="color: rgba(255,255,255,0.3); font-size: 11px; font-weight: 600;">{{ Str::limit($ticket->lastMessage?->message, 50) }}</p>
                    </td>
                    <td style="padding: 1.5rem;">
                        <span class="category-tag {{ Str::slug($ticket->category) }}">{{ $ticket->category }}</span>
                    </td>
                    <td style="padding: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 900; color: {{ $ticket->status == 'Aberto' ? '#22c55e' : ($ticket->status == 'Resolvido' ? 'rgba(255,255,255,0.3)' : '#ffd600') }}">
                             <div style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></div>
                             {{ $ticket->status }}
                        </div>
                    </td>
                    <td style="padding: 1.5rem;">
                        <a href="{{ route('admin.support.show', $ticket->id) }}" style="background: rgba(51, 144, 236, 0.1); border: 1.2px solid rgba(51, 144, 236, 0.2); color: #3390ec; text-decoration: none; padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 900; transition: 0.2s;" onmouseover="this.style.background='#3390ec'; this.style.color='white'">
                            Responder
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .stat-mini-card { background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.06); padding: 10px 20px; border-radius: 12px; display: flex; flex-direction: column; min-width: 120px; }
    .stat-mini-card.open { border-color: rgba(34, 197, 94, 0.2); }
    .stat-mini-card .label { font-size: 9px; font-weight: 900; color: rgba(255,255,255,0.4); letter-spacing: 1px; margin-bottom: 4px; }
    .stat-mini-card .value { font-size: 18px; font-weight: 950; color: white; }
    .stat-mini-card.open .value { color: #22c55e; }

    .category-tag { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: none; }
    .category-tag.pagamentos { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
    .category-tag.tecnico { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .category-tag.financeiro { background: rgba(52, 211, 153, 0.1); color: #34d399; }
    .category-tag.moderacao { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
</style>
@endsection
