@extends('layouts.app')

@section('title', 'Analytics Global - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <main class="main-content" style="background: #0b0a15; padding: 2.5rem 3rem;">
        <header style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: end;">
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Analytics Geral</h1>
                <p style="color: var(--text-muted); font-size: 15px;">Monitoramento completo do seu desempenho no Mogram.</p>
            </div>
        </header>

        <!-- Key Metrics -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
            <div class="premium-metric-card" style="--accent-color: #3390ec;">
                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Visualizações Totais</p>
                <h3 style="font-size: 2.25rem; font-weight: 950; color: white; margin: 0.75rem 0;">128.4k</h3>
                <div style="color: #22c55e; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +12.5%
                </div>
            </div>
            <div class="premium-metric-card" style="--accent-color: #22c55e;">
                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Ganhos (R$)</p>
                <h3 style="font-size: 2.25rem; font-weight: 950; color: #22c55e; margin: 0.75rem 0;">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</h3>
                <div style="color: #22c55e; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +8.2%
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
            <!-- Main Chart -->
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 3rem;">Evolução de Ganhos</h3>
                <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-between; gap: 12px;">
                    @php $stats_data = [30, 45, 25, 60, 85, 40, 70, 95, 65, 55, 80, 100]; @endphp
                    @foreach($stats_data as $i => $val)
                        <div style="flex: 1; height: {{ $val }}%; background: var(--primary-blue); border-radius: 8px 8px 0 0; opacity: 0.6;"></div>
                    @endforeach
                </div>
            </div>

            <!-- Content Ranking -->
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 2rem;">Top Conteúdos</h3>
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @forelse($topPosts as $tpost)
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: white;">
                             <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 14px; font-weight: 800; color: white;">{{ $tpost->title }}</h4>
                            <p style="font-size: 11px; color: var(--text-muted);">{{ $tpost->type }}</p>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-size: 13px; font-weight: 900; color: #22c55e;">R$ {{ number_format($tpost->price, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    @empty
                    <p style="color: var(--text-muted); font-size: 13px;">Nenhum conteúdo disponível.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
