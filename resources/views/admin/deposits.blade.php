@extends('layouts.admin')

@section('title', 'Histórico de Depósitos')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Financeiro / Depósitos</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Histórico de Depósitos</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Monitore o fluxo de entrada de capital na plataforma.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <div class="admin-card" style="padding: 10px 20px; display: flex; align-items: center; gap: 10px; background: rgba(51, 144, 236, 0.1); border-color: rgba(51, 144, 236, 0.2);">
            <div style="width: 8px; height: 8px; background: var(--primary-blue); border-radius: 50%;"></div>
            <span style="font-size: 0.8rem; font-weight: 800; color: var(--primary-blue);">Total Hoje: R$ 12.840,00</span>
        </div>
    </div>
</div>

<!-- Table -->
<div class="admin-card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Usuário</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Valor Bruto</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Gateway ID</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Data do Depósito</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deposits as $deposit)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $deposit->user->avatar ? Storage::url($deposit->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$deposit->user->name }}" style="width: 36px; height: 36px; border-radius: 10px;">
                        <div>
                            <h4 style="font-size: 0.85rem; font-weight: 800;">{{ $deposit->user->name }}</h4>
                            <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">@<span>{{ $deposit->user->username }}</span></p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; font-weight: 900; color: var(--success);">
                    + R$ {{ number_format($deposit->amount, 2, ',', '.') }}
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <span style="font-family: monospace; font-size: 0.8rem; background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 6px; color: var(--text-muted);">{{ substr($deposit->external_id, 0, 12) }}...</span>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'rgba(255, 255, 255, 0.05)', 'text' => 'var(--text-muted)', 'label' => 'Aguardando'],
                            'approved' => ['bg' => 'rgba(34, 197, 94, 0.1)', 'text' => 'var(--success)', 'label' => 'Confirmado'],
                            'cancelled' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => 'var(--danger)', 'label' => 'Cancelado'],
                        ];
                        $status = $statusColors[$deposit->status] ?? $statusColors['approved'];
                    @endphp
                    <div style="background: {{ $status['bg'] }}; color: {{ $status['text'] }}; padding: 4px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 900; display: inline-block; text-transform: uppercase;">
                        {{ $status['label'] }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">
                    {{ $deposit->created_at->format('d/m/Y H:i') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <button style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; padding: 8px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.1)'; this.style.color='white'">
                        Ver Comprovante
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">Mostrando {{ $deposits->firstItem() }}-{{ $deposits->lastItem() }} de {{ $deposits->total() }} depósitos</p>
        <div>
            {{ $deposits->links() }}
        </div>
    </div>
</div>
@endsection
