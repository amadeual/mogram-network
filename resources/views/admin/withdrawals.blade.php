@extends('layouts.admin')

@section('title', 'Gestão de Saques')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Financeiro / Saques</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Solicitações de Saque</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Gerencie e processe pagamentos para os criadores da plataforma.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <div class="admin-card" style="padding: 10px 20px; display: flex; align-items: center; gap: 10px; background: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.2);">
            <div style="width: 8px; height: 8px; background: var(--success); border-radius: 50%;"></div>
            <span style="font-size: 0.8rem; font-weight: 800; color: var(--success);">Pendentes: R$ {{ number_format($pendingAmount, 2, ',', '.') }}</span>
        </div>
    </div>
</div>

<!-- Table -->
<div class="admin-card" style="padding: 0; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.25rem 1rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Criador</th>
                <th style="padding: 1.25rem 1rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Valor</th>
                <th style="padding: 1.25rem 1rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Dados Pagamento</th>
                <th style="padding: 1.25rem 1rem; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Status</th>
                <th style="padding: 1.25rem 1rem; text-align: center; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Data</th>
                <th style="padding: 1.25rem 1rem; text-align: right; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; font-weight: 800;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $withdrawal)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ $withdrawal->user->avatar ? Storage::url($withdrawal->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$withdrawal->user->name }}" style="width: 32px; height: 32px; border-radius: 8px;">
                        <div>
                            <h4 style="font-size: 0.8rem; font-weight: 800;">{{ $withdrawal->user->name }}</h4>
                            <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600;">@<span>{{ $withdrawal->user->username }}</span></p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1rem; font-weight: 900; color: white; font-size: 0.85rem; white-space: nowrap;">
                    R$ {{ number_format($withdrawal->amount, 2, ',', '.') }}
                </td>
                <td style="padding: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            @if($withdrawal->method == 'pix')
                                <div style="width: 20px; height: 20px; background: #32bcad; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.55rem; font-weight: 900;">PIX</div>
                            @elseif($withdrawal->method == 'redotpay')
                                <div style="width: 20px; height: 20px; background: #e11d48; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.5rem; font-weight: 900;">RDOT</div>
                            @else
                                <div style="width: 20px; height: 20px; background: #26a17b; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.55rem; font-weight: 900;">USDT</div>
                            @endif
                            <span style="font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.7);">{{ strtoupper($withdrawal->method) }}</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.03); padding: 4px 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 6px; max-width: 180px;">
                            <span style="font-size: 0.7rem; font-weight: 600; color: #3390ec; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $withdrawal->account_info }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $withdrawal->account_info }}'); alert('Copiado!')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; display: flex; align-items: center; padding: 2px;">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                    </div>
                </td>
                <td style="padding: 1rem;">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'rgba(234, 179, 8, 0.1)', 'text' => '#eab308', 'label' => 'Pendente'],
                            'approved' => ['bg' => 'rgba(34, 197, 94, 0.1)', 'text' => 'var(--success)', 'label' => 'Pago'],
                            'rejected' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => 'var(--danger)', 'label' => 'Recusado'],
                        ];
                        $status = $statusColors[$withdrawal->status] ?? $statusColors['pending'];
                    @endphp
                    <div style="background: {{ $status['bg'] }}; color: {{ $status['text'] }}; padding: 3px 10px; border-radius: 6px; font-size: 0.65rem; font-weight: 900; display: inline-block; text-transform: uppercase;">
                        {{ $status['label'] }}
                    </div>
                </td>
                <td style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; font-weight: 700; white-space: nowrap;">
                    {{ $withdrawal->created_at->format('d/m/y H:i') }}
                </td>
                <td style="padding: 1rem; text-align: right;">
                    @if($withdrawal->status == 'pending')
                        <div style="display: flex; justify-content: flex-end; gap: 6px;">
                            <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: var(--success); border: none; color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; cursor: pointer; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Aprovar</button>
                            </form>
                            <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja recusar este saque?')">
                                @csrf
                                <button type="submit" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: var(--danger); padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 800; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">Recusar</button>
                            </form>
                        </div>
                    @else
                        <button style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="padding: 1rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700;">Mostrando {{ $withdrawals->firstItem() }}-{{ $withdrawals->lastItem() }} de {{ $withdrawals->total() }} pedidos</p>
        <div>
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
@endsection
