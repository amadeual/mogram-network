@extends('layouts.admin')

@section('title', 'Relatórios Analíticos')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Admin / Relatórios</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Relatórios Analíticos</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Visão detalhada do desempenho da plataforma, engajamento e monetização.</p>
    </div>
    <button class="btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Exportar Relatório
    </button>
</div>

<!-- Date & Filters -->
<form action="{{ route('admin.reports') }}" method="GET" class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 3rem; display: flex; align-items: center; gap: 1rem;">
    <select name="period" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option value="30">Período: Últimos 30 Dias</option>
        <option value="90">Período: Últimos 90 Dias</option>
    </select>
    <select name="creator_id" onchange="this.form.submit()" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option value="">Todos os Criadores</option>
        @foreach($creators as $creator)
            <option value="{{ $creator->id }}" {{ $creatorId == $creator->id ? 'selected' : '' }}>
                {{ $creator->name }} (@ {{ $creator->username }})
            </option>
        @endforeach
    </select>
    <div style="flex: 1; position: relative;">
        <svg style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Pesquisar..." style="width: 100%; background: transparent; border: none; padding: 10px 15px; color: white; outline: none; font-weight: 600;">
    </div>
    <button type="submit" class="btn-primary" style="padding: 10px 20px; border-radius: 12px;">Filtrar</button>
</form>

<!-- Main Metrics Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Receita Bruta</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">R$ {{ number_format($grossRevenue, 2, ',', '.') }}</h2>
        </div>
        <div style="color: var(--success); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Assinantes Ativos</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">{{ number_format($newSubscribers, 0, ',', '.') }}</h2>
        </div>
        <div style="color: var(--primary-blue); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Lives Concluídas</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">{{ number_format($completedLives, 0, ',', '.') }}</h2>
        </div>
        <div style="color: var(--danger); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Conteúdos Criados</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">{{ number_format($totalContents, 0, ',', '.') }}</h2>
        </div>
        <div style="color: orange; opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Monetization Trends -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 850;">Tendência de Monetização</h3>
            <div style="display: flex; gap: 1rem; font-size: 0.75rem; font-weight: 800;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <div style="width: 10px; height: 10px; background: var(--primary-blue); border-radius: 50%;"></div> Assinaturas
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <div style="width: 10px; height: 10px; background: var(--danger); border-radius: 50%;"></div> Gorjetas
                </div>
            </div>
        </div>
        <div style="height: 350px;">
            <canvas id="monetizationTrendChart"></canvas>
        </div>
    </div>

    <!-- Traffic Sources -->
    <div class="admin-card">
        <h3 style="font-size: 1.1rem; font-weight: 850; margin-bottom: 2rem;">Fonte de Tráfego</h3>
        <div style="height: 250px; position: relative; margin-bottom: 2rem;">
            <canvas id="trafficSourceChart"></canvas>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                <h2 style="font-size: 1.75rem; font-weight: 900; margin: 0;">45%</h2>
                <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 800;">Direto</p>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach([['label' => 'Direto / App', 'value' => '45%', 'color' => '#3390ec'], ['label' => 'Redes Sociais', 'value' => '25%', 'color' => '#ef4444'], ['label' => 'Orgânico', 'value' => '20%', 'color' => '#22c55e'], ['label' => 'Indicação', 'value' => '10%', 'color' => 'orange']] as $source)
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; font-weight: 700;">
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                    <div style="width: 8px; height: 8px; background: {{ $source['color'] }}; border-radius: 50%;"></div> {{ $source['label'] }}
                </div>
                <span>{{ $source['value'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Monetization Trend (Line Chart)
    const trendCtx = document.getElementById('monetizationTrendChart').getContext('2d');
    
    const chartLabels = {!! json_encode($chartData->pluck('date')->map(fn($d) => date('d/m', strtotime($d)))) !!};
    const chartValues = {!! json_encode($chartData->pluck('total')) !!};

    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: chartLabels.length > 0 ? chartLabels : ['Sem dados'],
            datasets: [
                {
                    label: 'Vendas (R$)',
                    data: chartValues.length > 0 ? chartValues : [0],
                    borderColor: '#3390ec',
                    backgroundColor: 'rgba(51, 144, 236, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#64748b' } },
                x: { grid: { display: false }, ticks: { color: '#64748b' } }
            }
        }
    });

    // Simple placeholder for other charts since data is now real
    const trafficCtx = document.getElementById('trafficSourceChart').getContext('2d');
    new Chart(trafficCtx, {
        type: 'doughnut',
        data: {
            labels: ['Vendas', 'Outros'],
            datasets: [{
                data: [{{ $grossRevenue > 0 ? 100 : 0 }}, {{ $grossRevenue > 0 ? 0 : 100 }}],
                backgroundColor: ['#3390ec', 'rgba(255,255,255,0.1)'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { tooltip: { enabled: true } }
        }
    });
</script>
@endsection
