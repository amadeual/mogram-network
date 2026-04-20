@extends('layouts.admin')

@section('title', 'Extrato — ' . $creator->name)

@section('admin_content')
{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
            <a href="{{ route('admin.reports') }}" style="color: inherit; text-decoration: none;">← Relatórios</a>
             / Extrato do Criador
        </p>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-blue), #6366f1); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1rem;">
                {{ strtoupper(substr($creator->name, 0, 2)) }}
            </div>
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 900; letter-spacing: -0.5px; margin: 0;">{{ $creator->name }}</h1>
                <p style="color: var(--text-muted); font-weight: 600; margin: 0;">@{{ $creator->username }} · {{ $creator->email }}</p>
            </div>
        </div>
    </div>
    <div style="font-size: 0.8rem; color: var(--text-muted); text-align: right; font-weight: 700;">
        Período: <span style="color: white;">{{ $dateFrom->format('d/m/Y') }}</span> até <span style="color: white;">{{ $dateTo->format('d/m/Y') }}</span>
    </div>
</div>

{{-- Filter Bar --}}
<form action="{{ route('admin.reports.creator', $creator->id) }}" method="GET" class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
    <div style="display: flex; flex-direction: column; gap: 4px;">
        <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted);">Período Rápido</label>
        <select name="period" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 8px 14px; color: white; font-weight: 700; outline: none;">
            <option value="7"  {{ $period == 7  ? 'selected' : '' }}>Últimos 7 dias</option>
            <option value="30" {{ $period == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
            <option value="90" {{ $period == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
            <option value="365" {{ $period == 365 ? 'selected' : '' }}>Último ano</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: column; gap: 4px;">
        <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted);">Data Início</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
            style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 8px 14px; color: white; font-weight: 700; outline: none;">
    </div>
    <div style="display: flex; flex-direction: column; gap: 4px;">
        <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted);">Data Fim</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
            style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 8px 14px; color: white; font-weight: 700; outline: none;">
    </div>
    <button type="submit" class="btn-primary" style="padding: 10px 22px; border-radius: 10px; align-self: flex-end;">Filtrar</button>
    <a href="{{ route('admin.users.show', $creator->id) }}" style="padding: 10px 18px; border-radius: 10px; background: rgba(255,255,255,0.06); color: white; font-weight: 700; font-size: 0.8rem; text-decoration: none; align-self: flex-end; border: 1.5px solid rgba(255,255,255,0.1);">
        Ver Perfil
    </a>
</form>

{{-- Financial Breakdown Cards --}}
<div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 2.5rem;">
    {{-- Receita Bruta --}}
    <div class="admin-card" style="padding: 1.25rem; grid-column: span 1;">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Receita Bruta</p>
        <h2 style="font-size: 1.4rem; font-weight: 900; color: white;">R$ {{ number_format($grossRevenue, 2, ',', '.') }}</h2>
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">Total recebido dos usuários</p>
    </div>
    {{-- Comissão Mogram --}}
    <div class="admin-card" style="padding: 1.25rem; border-left: 3px solid var(--danger);">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Comissão Mogram</p>
        <h2 style="font-size: 1.4rem; font-weight: 900; color: var(--danger);">R$ {{ number_format($totalCommission, 2, ',', '.') }}</h2>
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">
            {{ $grossRevenue > 0 ? number_format(($totalCommission / $grossRevenue) * 100, 1) : 0 }}% do bruto
        </p>
    </div>
    {{-- Custo Infra --}}
    <div class="admin-card" style="padding: 1.25rem; border-left: 3px solid orange;">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Custo Infra (est.)</p>
        <h2 style="font-size: 1.4rem; font-weight: 900; color: orange;">R$ {{ number_format($infraCost, 2, ',', '.') }}</h2>
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">{{ $infraRate }}% do bruto</p>
    </div>
    {{-- Líquido Plataforma --}}
    <div class="admin-card" style="padding: 1.25rem; border-left: 3px solid #a78bfa;">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Líquido Plataforma</p>
        <h2 style="font-size: 1.4rem; font-weight: 900; color: #a78bfa;">R$ {{ number_format($platformNet, 2, ',', '.') }}</h2>
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">Comissão − Infra</p>
    </div>
    {{-- Líquido ao Criador --}}
    <div class="admin-card" style="padding: 1.25rem; border-left: 3px solid var(--success);">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Líquido ao Criador</p>
        <h2 style="font-size: 1.4rem; font-weight: 900; color: var(--success);">R$ {{ number_format($netToCreator, 2, ',', '.') }}</h2>
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">Bruto − Comissão</p>
    </div>
    {{-- Saques --}}
    <div class="admin-card" style="padding: 1.25rem;">
        <p style="color: var(--text-muted); font-size: 0.68rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.4rem;">Saques Aprovados</p>
        <h2 style="font-size: 1.4rem; font-weight: 900;">R$ {{ number_format($totalWithdrawn, 2, ',', '.') }}</h2>
        @if($pendingWithdrawal > 0)
        <p style="font-size: 0.68rem; color: orange; margin-top: 4px;">+ R$ {{ number_format($pendingWithdrawal,2,',','.') }} pendente</p>
        @else
        <p style="font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">Sem pendências</p>
        @endif
    </div>
</div>

{{-- Revenue by Channel + Chart --}}
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2.5rem;">

    {{-- Channel Breakdown --}}
    <div class="admin-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 850; margin-bottom: 1.5rem;">Receita por Canal</h3>
        @php
            $channels = [
                ['label' => 'Conteúdo Exclusivo', 'icon' => '🔒', 'data' => $contentData, 'color' => '#3390ec'],
                ['label' => 'Gorjetas em Lives',  'icon' => '🎁', 'data' => $giftsData,   'color' => '#ef4444'],
                ['label' => 'Tickets de Live',    'icon' => '🎫', 'data' => $ticketsData,  'color' => '#f59e0b'],
                ['label' => 'Assinaturas Comunidade', 'icon' => '👥', 'data' => $communityData, 'color' => '#22c55e'],
            ];
        @endphp
        @foreach($channels as $ch)
        <div style="margin-bottom: 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 0.78rem; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                    <span>{{ $ch['icon'] }}</span> {{ $ch['label'] }}
                </span>
                <span style="font-size: 0.78rem; font-weight: 900; color: {{ $ch['color'] }};">
                    R$ {{ number_format($ch['data']->total, 2, ',', '.') }}
                </span>
            </div>
            <div style="background: rgba(255,255,255,0.06); border-radius: 999px; height: 5px; overflow: hidden;">
                @php $pct = $grossRevenue > 0 ? ($ch['data']->total / $grossRevenue) * 100 : 0; @endphp
                <div style="width: {{ $pct }}%; height: 100%; background: {{ $ch['color'] }}; border-radius: 999px; transition: width 1s;"></div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.68rem; color: var(--text-muted); margin-top: 4px;">
                <span>{{ $ch['data']->qty ?? 0 }} transações</span>
                <span>Comissão: R$ {{ number_format($ch['data']->commission, 2, ',', '.') }}</span>
            </div>
        </div>
        @endforeach

        {{-- Summary table --}}
        <div style="border-top: 1px solid rgba(255,255,255,0.07); padding-top: 1rem; margin-top: 0.5rem;">
            @foreach([
                ['label' => 'Receita Bruta', 'value' => $grossRevenue, 'color' => 'white', 'bold' => true],
                ['label' => '(-) Comissão Mogram', 'value' => -$totalCommission, 'color' => '#ef4444', 'bold' => false],
                ['label' => '(-) Custo Infra (est.)', 'value' => -$infraCost, 'color' => 'orange', 'bold' => false],
                ['label' => 'Líquido ao Criador', 'value' => $netToCreator, 'color' => '#22c55e', 'bold' => true],
            ] as $row)
            <div style="display: flex; justify-content: space-between; padding: 5px 0; font-size: 0.78rem; {{ $row['bold'] ? 'font-weight: 900;' : 'font-weight: 600;' }} color: {{ $row['color'] }};">
                <span>{{ $row['label'] }}</span>
                <span>R$ {{ number_format(abs($row['value']), 2, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Daily Revenue Chart --}}
    <div class="admin-card" style="padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 850; margin-bottom: 1.5rem;">Receita Diária no Período</h3>
        <div style="height: 280px;">
            <canvas id="creatorRevenueChart"></canvas>
        </div>
    </div>
</div>

{{-- Withdrawals Table --}}
@if($withdrawals->count())
<div class="admin-card" style="margin-bottom: 2.5rem;">
    <h3 style="font-size: 1rem; font-weight: 850; margin-bottom: 1.25rem; padding: 1.5rem 1.5rem 0;">Saques no Período</h3>
    <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <th style="text-align: left; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Data</th>
                <th style="text-align: right; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Valor</th>
                <th style="text-align: left; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Chave PIX</th>
                <th style="text-align: center; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $w)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                <td style="padding: 0.8rem 1.5rem; color: var(--text-muted);">{{ $w->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 0.8rem 1.5rem; text-align: right; font-weight: 800;">R$ {{ number_format($w->amount, 2, ',', '.') }}</td>
                <td style="padding: 0.8rem 1.5rem; font-family: monospace; font-size: 0.75rem;">{{ $w->pix_key ?? '—' }}</td>
                <td style="padding: 0.8rem 1.5rem; text-align: center;">
                    @if($w->status === 'approved')
                        <span style="background: rgba(34,197,94,0.15); color: #22c55e; padding: 3px 10px; border-radius: 999px; font-size: 0.68rem; font-weight: 800;">Aprovado</span>
                    @elseif($w->status === 'pending')
                        <span style="background: rgba(245,158,11,0.15); color: #f59e0b; padding: 3px 10px; border-radius: 999px; font-size: 0.68rem; font-weight: 800;">Pendente</span>
                    @else
                        <span style="background: rgba(239,68,68,0.15); color: #ef4444; padding: 3px 10px; border-radius: 999px; font-size: 0.68rem; font-weight: 800;">Recusado</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Transaction Log --}}
<div class="admin-card" style="margin-bottom: 3rem;">
    <h3 style="font-size: 1rem; font-weight: 850; padding: 1.5rem 1.5rem 0; margin-bottom: 1.25rem;">Log de Transações Financeiras</h3>
    @if($transactions->count())
    <table style="width: 100%; border-collapse: collapse; font-size: 0.78rem;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <th style="text-align: left; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Data</th>
                <th style="text-align: left; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Descrição</th>
                <th style="text-align: right; padding: 0.75rem 1.5rem; color: var(--text-muted); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $tx)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.035);">
                <td style="padding: 0.7rem 1.5rem; color: var(--text-muted); white-space: nowrap;">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 0.7rem 1.5rem;">{{ $tx->description }}</td>
                <td style="padding: 0.7rem 1.5rem; text-align: right; font-weight: 800; color: {{ $tx->amount >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                    {{ $tx->amount >= 0 ? '+' : '' }}R$ {{ number_format(abs($tx->amount), 2, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 1rem 1.5rem;">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
    @else
    <p style="padding: 2rem 1.5rem; color: var(--text-muted); font-weight: 600;">Nenhuma transação encontrada no período.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('creatorRevenueChart').getContext('2d');
    const labels = {!! json_encode($chartData->pluck('date')->map(fn($d) => date('d/m', strtotime($d)))) !!};
    const values = {!! json_encode($chartData->pluck('daily_total')) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.length > 0 ? labels : ['Sem dados'],
            datasets: [{
                label: 'Receita (R$)',
                data: values.length > 0 ? values : [0],
                backgroundColor: 'rgba(51,144,236,0.25)',
                borderColor: '#3390ec',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (c) => ' R$ ' + parseFloat(c.raw).toLocaleString('pt-BR', { minimumFractionDigits: 2 })
                    }
                }
            },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#64748b', callback: v => 'R$ ' + v } },
                x: { grid: { display: false }, ticks: { color: '#64748b' } }
            }
        }
    });
</script>
@endsection
