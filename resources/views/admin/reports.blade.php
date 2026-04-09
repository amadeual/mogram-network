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
<div class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 3rem; display: flex; align-items: center; gap: 1rem;">
    <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option>Período: Este Mês</option>
        <option>Período: Último Mês</option>
        <option>Período: Últimos 90 Dias</option>
        <option>Período: Personalizado</option>
    </select>
    <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option>Criador: Todos</option>
        <option>Criador: Verificados</option>
    </select>
    <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option>Tipo: Conteúdo</option>
        <option>Tipo: Lives</option>
        <option>Tipo: Assinaturas</option>
    </select>
    <div style="flex: 1; position: relative;">
        <svg style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Buscar relatório..." style="width: 100%; background: transparent; border: none; padding: 10px 15px; color: white; outline: none; font-weight: 600;">
    </div>
</div>

<!-- Main Metrics Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <div style="color: var(--success); display: flex; align-items: center; gap: 4px; font-size: 0.65rem; font-weight: 900; background: rgba(34, 197, 94, 0.1); padding: 2px 6px; border-radius: 4px; margin-bottom: 1rem; width: fit-content;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                +12%
            </div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Receita Bruta</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">R$ 1.2M</h2>
        </div>
        <div style="color: var(--success); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <div style="color: var(--success); display: flex; align-items: center; gap: 4px; font-size: 0.65rem; font-weight: 900; background: rgba(34, 197, 94, 0.1); padding: 2px 6px; border-radius: 4px; margin-bottom: 1rem; width: fit-content;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                +5%
            </div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Novos Assinantes</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">4,502</h2>
        </div>
        <div style="color: var(--primary-blue); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <div style="color: var(--text-muted); display: flex; align-items: center; gap: 4px; font-size: 0.65rem; font-weight: 900; background: rgba(255, 255, 255, 0.05); padding: 2px 6px; border-radius: 4px; margin-bottom: 1rem; width: fit-content;">
                ~ 0%
            </div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Lives Realizadas</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">120</h2>
        </div>
        <div style="color: var(--danger); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
    </div>
    <div class="admin-card" style="padding: 1.5rem; display: flex; justify-content: space-between;">
        <div>
            <div style="color: var(--danger); display: flex; align-items: center; gap: 4px; font-size: 0.65rem; font-weight: 900; background: rgba(239, 68, 68, 0.1); padding: 2px 6px; border-radius: 4px; margin-bottom: 1rem; width: fit-content;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                -2%
            </div>
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Taxa de Retenção</p>
            <h2 style="font-size: 1.5rem; font-weight: 900;">84.5%</h2>
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
    // Monetization Trend (Bar Chart)
    const trendCtx = document.getElementById('monetizationTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: ['01 Jun', '07 Jun', '14 Jun', '21 Jun', '28 Jun'],
            datasets: [
                {
                    label: 'Assinaturas',
                    data: [180, 250, 220, 310, 290],
                    backgroundColor: '#3390ec',
                    borderRadius: 6,
                    barThickness: 15
                },
                {
                    label: 'Gorjetas',
                    data: [120, 190, 160, 240, 210],
                    backgroundColor: '#ef4444',
                    borderRadius: 6,
                    barThickness: 15
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

    // Traffic Source (Doughnut Chart)
    const trafficCtx = document.getElementById('trafficSourceChart').getContext('2d');
    new Chart(trafficCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#3390ec', '#ef4444', '#22c55e', 'orange'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { tooltip: { enabled: false } }
        }
    });
</script>
@endsection
