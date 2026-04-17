@extends('layouts.admin')

@section('title', 'Logs de Atividade')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Monitoramento / Auditoria</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Logs de Atividade</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Acompanhe em tempo real todas as ações e transações na rede.</p>
    </div>
    
    <div style="display: flex; gap: 1rem;">
        <form action="{{ route('admin.logs') }}" method="GET" style="display: flex; gap: 0.5rem;">
            <select name="type" class="mogram-input-field" style="width: 180px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 12px; font-weight: 700; border: 1.5px solid var(--border-gray);">
                <option value="">Todos os Tipos</option>
                <option value="financial" {{ request('type') == 'financial' ? 'selected' : '' }}>💰 Financeiro</option>
                <option value="admin_action" {{ request('type') == 'admin_action' ? 'selected' : '' }}>🛡️ Admin Action</option>
                <option value="security" {{ request('type') == 'security' ? 'selected' : '' }}>🔒 Segurança</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar usuário ou ação..." class="mogram-input-field" style="width: 250px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 12px; padding: 0 1rem; border: 1.5px solid var(--border-gray);">
            <button type="submit" class="btn-primary" style="height: 48px; padding: 0 1.5rem;">Filtrar</button>
        </form>
    </div>
</div>

<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: rgba(255,255,255,0.02); border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 850; letter-spacing: 1px;">Data / Hora</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 850; letter-spacing: 1px;">Usuário</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 850; letter-spacing: 1px;">Descrição da Atividade</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 850; letter-spacing: 1px;">Tipo</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 850; letter-spacing: 1px;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.25rem 2rem;">
                    <span style="display: block; font-weight: 800; font-size: 0.85rem; color: var(--text-white);">{{ $log->created_at->format('d/m/Y') }}</span>
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">{{ $log->created_at->format('H:i:s') }}</span>
                </td>
                <td style="padding: 1.25rem 2rem;">
                    @if($log->user)
                    <a href="{{ route('admin.users.show', $log->user->id) }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                        <img src="{{ $log->user->avatar ? Storage::url($log->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$log->user->name }}" style="width: 32px; height: 32px; border-radius: 10px; object-fit: cover;">
                        <div>
                            <span style="display: block; color: var(--text-white); font-weight: 900; font-size: 0.9rem;">{{ $log->user->name }}</span>
                            <span style="font-size: 0.75rem; color: var(--primary-blue); font-weight: 800;">@</span><span style="font-size: 0.75rem; color: var(--primary-blue); font-weight: 800;">{{ $log->user->username }}</span>
                        </div>
                    </a>
                    @else
                    <span style="color: var(--text-muted); font-weight: 600; font-style: italic;">Usuário Removido</span>
                    @endif
                </td>
                <td style="padding: 1.25rem 2rem;">
                    <p style="font-weight: 600; font-size: 0.95rem; line-height: 1.4; color: rgba(255,255,255,0.9);">
                        {{ $log->description }}
                    </p>
                    @if($log->admin)
                        <span style="font-size: 0.7rem; color: var(--text-muted); display: block; margin-top: 4px;">Executado por Admin: <strong>{{ $log->admin->name }}</strong></span>
                    @endif
                </td>
                <td style="padding: 1.25rem 2rem; text-align: center;">
                    @php
                        $color = match($log->type) {
                            'financial' => '#22c55e',
                            'admin_action' => '#3390ec',
                            'security' => '#ef4444',
                            default => '#64748b'
                        };
                        $bg = match($log->type) {
                            'financial' => 'rgba(34, 197, 94, 0.1)',
                            'admin_action' => 'rgba(51, 144, 236, 0.1)',
                            'security' => 'rgba(239, 68, 68, 0.1)',
                            default => 'rgba(255,255,255,0.05)'
                        };
                    @endphp
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 8px; background: {{ $bg }}; color: {{ $color }}; font-weight: 900; font-size: 0.65rem; text-transform: uppercase; border: 1px solid {{ str_replace('0.1', '0.2', $bg) }};">
                        {{ $log->type }}
                    </span>
                </td>
                <td style="padding: 1.25rem 2rem; text-align: right;">
                    @if($log->amount)
                        <span style="font-weight: 950; font-size: 1.05rem; color: {{ $log->amount > 0 ? '#22c55e' : '#ef4444' }}">
                            {{ $log->amount > 0 ? '+' : '' }}R$ {{ number_format($log->amount, 2, ',', '.') }}
                        </span>
                        @if($log->wallet_type)
                            <span style="display: block; font-size: 0.65rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">{{ $log->wallet_type == 'balance' ? 'Carteira' : 'Studio' }}</span>
                        @endif
                    @else
                        <span style="color: var(--text-muted); font-weight: 850;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 5rem; text-align: center;">
                    <div style="opacity: 0.5;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                        <p style="font-weight: 700; font-size: 1.1rem;">Nenhum log encontrado para os critérios de busca.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $logs->appends(request()->query())->links() }}
</div>
@endsection
