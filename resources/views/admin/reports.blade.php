@extends('layouts.admin')

@section('title', 'Relatórios Analíticos')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Admin / Relatórios</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Relatórios Analíticos</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Visão detalhada do desempenho da plataforma, engajamento e monetização.</p>
    </div>
    <div style="display: flex; gap: 10px;" class="no-print">
        <button onclick="exportTableToExcel('topCreatorsTable', 'relatorio-criadores.xlsx')" class="btn-primary" style="background: #22c55e;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Excel
        </button>
        <button onclick="window.print()" class="btn-primary" style="background: #ef4444;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            PDF
        </button>
    </div>
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
            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Lucro Líquido (Plataforma)</p>
            <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--success);">R$ {{ number_format($netProfit, 2, ',', '.') }}</h2>
        </div>
        <div style="color: var(--success); opacity: 0.5;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
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
{{-- Top Creators Table --}}
<div class="admin-card" style="margin-bottom: 3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.1rem; font-weight: 850;">Top Criadores — Receita no Período</h3>
        <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">Clique em "Extrato" para breakdown detalhado</span>
    </div>
    <table id="topCreatorsTable" style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <th style="text-align: left; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">#</th>
                <th style="text-align: left; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Criador</th>
                <th style="text-align: right; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Conteúdo</th>
                <th style="text-align: right; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Gorjetas</th>
                <th style="text-align: right; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Comunidade</th>
                <th style="text-align: right; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Comissão</th>
                <th style="text-align: right; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Bruto Total</th>
                <th style="text-align: center; padding: 0.75rem 1rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 0.7rem;">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topCreators as $i => $tc)
            @php
                $tcGross = $tc->content_revenue + $tc->gifts_revenue + $tc->community_revenue;
            @endphp
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 0.85rem 1rem; color: var(--text-muted); font-weight: 800;">{{ $i + 1 }}</td>
                <td style="padding: 0.85rem 1rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-blue), #6366f1); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.75rem; flex-shrink: 0;">
                            {{ strtoupper(substr($tc->name, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700;">{{ $tc->name }}</div>
                            <div style="color: var(--text-muted); font-size: 0.7rem;">@{{ $tc->username }}</div>
                        </div>
                    </div>
                </td>
                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700;">R$ {{ number_format($tc->content_revenue, 2, ',', '.') }}</td>
                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700;">R$ {{ number_format($tc->gifts_revenue, 2, ',', '.') }}</td>
                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700;">R$ {{ number_format($tc->community_revenue, 2, ',', '.') }}</td>
                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700; color: var(--danger);">R$ {{ number_format($tc->total_commission, 2, ',', '.') }}</td>
                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 900; color: var(--success);">R$ {{ number_format($tcGross, 2, ',', '.') }}</td>
                <td style="padding: 0.85rem 1rem; text-align: center;">
                    <a href="{{ route('admin.reports.creator', $tc->id) }}" class="btn-primary" style="padding: 6px 14px; font-size: 0.72rem; border-radius: 8px; text-decoration: none;">
                        Extrato
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="padding: 2rem; text-align: center; color: var(--text-muted);">Nenhum criador encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<!-- SheetJS para Excel -->
<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableID, filename = ''){
        var table = document.getElementById(tableID);
        var wb = XLSX.utils.table_to_book(table, {sheet: "Relatório"});
        
        // Remove columns or format if needed here
        XLSX.writeFile(wb, filename);
    }
</script>

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
