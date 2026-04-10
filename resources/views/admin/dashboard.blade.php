@extends('layouts.admin')

@section('title', 'Dashboard')

@section('admin_content')
<div style="margin-bottom: 3rem;">
    <h1 style="font-size: 2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Visão Geral</h1>
    <p style="color: var(--text-muted); font-weight: 600;">Bem-vindo ao centro de comando da Mogram.</p>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    <!-- Users Card -->
    <div class="admin-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 1.5rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Usuários Totais</p>
            <h2 style="font-size: 1.75rem; font-weight: 900;">{{ number_format($stats['total_users'], 0, ',', '.') }}</h2>
            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600;">Base de usuários ativa</p>
        </div>
    </div>

    <!-- Deposits Card -->
    <div class="admin-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 1.5rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Depósitos Totais</p>
            <h2 style="font-size: 1.75rem; font-weight: 900;">R$ {{ number_format($stats['total_deposits'], 2, ',', '.') }}</h2>
            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600;">Entrada de capital confirmada</p>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="admin-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--success); margin-bottom: 1.5rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Receita Total</p>
            <h2 style="font-size: 1.75rem; font-weight: 900;">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</h2>
            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600;">Fluxo bruto histórico</p>
        </div>
    </div>

    <!-- Profit Card -->
    <div class="admin-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(239, 68, 68, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--danger); margin-bottom: 1.5rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Lucro Líquido</p>
            <h2 style="font-size: 1.75rem; font-weight: 900;">R$ {{ number_format($stats['net_profit'], 2, ',', '.') }}</h2>
            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600;">Comissão de 15%</p>
        </div>
    </div>
</div>

<!-- Chart & Side Tables -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <!-- Revenue Trend -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.25rem;">Tendência de Receita</h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600;">Desempenho financeiro nos últimos 30 dias</p>
            </div>
            <div style="display: flex; background: rgba(255,255,255,0.05); padding: 4px; border-radius: 12px;">
                <button style="padding: 8px 16px; border: none; background: transparent; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; cursor: pointer;">7 Dias</button>
                <button style="padding: 8px 16px; border: none; background: var(--primary-blue); color: white; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 10px rgba(51, 144, 236, 0.2);">30 Dias</button>
                <button style="padding: 8px 16px; border: none; background: transparent; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; cursor: pointer;">Ano</button>
            </div>
        </div>
        <div style="height: 350px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions & Recent -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="admin-card" style="padding: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 800; margin-bottom: 1.5rem;">Ações Rápidas</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button style="width: 100%; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.03); border: 1px solid var(--border-gray); padding: 1rem; border-radius: 14px; color: white; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span style="font-size: 0.85rem; font-weight: 700;">Exportar Relatório</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
                <button style="width: 100%; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.03); border: 1px solid var(--border-gray); padding: 1rem; border-radius: 14px; color: white; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="16" y1="11" x2="22" y2="11"/></svg>
                        <span style="font-size: 0.85rem; font-weight: 700;">Convidar Criador</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>

        <div class="admin-card" style="padding: 1.5rem; flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 800;">Atividade Recente</h3>
                <a href="#" style="color: var(--primary-blue); font-size: 0.75rem; font-weight: 800; text-decoration: none;">Ver tudo</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($recentActivity as $act)
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ $act->avatar ? Storage::url($act->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$act->name }}" style="width: 32px; height: 32px; border-radius: 8px;">
                    <div style="flex: 1;">
                        <h4 style="font-size: 0.8rem; font-weight: 800;">{{ $act->name }}</h4>
                        <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600;">{{ $act->created_at->diffForHumans() }}</p>
                    </div>
                    <div style="color: var(--success); font-size: 0.7rem; font-weight: 840; background: rgba(34, 197, 94, 0.1); padding: 4px 8px; border-radius: 6px;">
                        Novo
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(51, 144, 236, 0.3)');
    gradient.addColorStop(1, 'rgba(51, 144, 236, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->pluck('date')->map(function($d) { return date('d/m', strtotime($d)); })) !!},
            datasets: [{
                label: 'Receita (R$)',
                data: {!! json_encode($revenueData->pluck('daily_total')) !!},
                fill: true,
                backgroundColor: gradient,
                borderColor: '#3390ec',
                borderWidth: 4,
                pointBackgroundColor: '#3390ec',
                pointBorderColor: '#0b0d17',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.03)' },
                    ticks: { color: '#64748b', font: { weight: '600' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { weight: '600' } }
                }
            }
        }
    });
</script>
@endsection
