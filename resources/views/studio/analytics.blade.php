@extends('layouts.app')

@section('title', 'Analytics Global - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <main class="main-content studio-main-pad" style="background: #0b0a15; padding: 2.5rem 3rem;">
        <header class="studio-header" style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: end;">
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Analytics Geral</h1>
                <p style="color: var(--text-muted); font-size: 15px;">Monitoramento completo do seu desempenho no Mogram.</p>
            </div>
        </header>

        <!-- Key Metrics -->
        <div class="studio-grid-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
            <div class="premium-metric-card" style="--accent-color: #3390ec;">
                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: none;">Visualizações Totais</p>
                <h3 style="font-size: 2.25rem; font-weight: 950; color: white; margin: 0.75rem 0;">{{ number_format($totalViews, 0, ',', '.') }}</h3>
                <div style="color: #22c55e; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Frequência Alta
                </div>
            </div>
            <div class="premium-metric-card" style="--accent-color: #22c55e;">
                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: none;">Ganhos (R$)</p>
                <h3 style="font-size: 2.25rem; font-weight: 950; color: #22c55e; margin: 0.75rem 0;">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</h3>
                <div style="color: #22c55e; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    0%
                </div>
            </div>
        </div>

        <div class="studio-grid-2" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
            <!-- Main Chart -->
            <div class="studio-card-pad" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 3rem;">Evolução de Ganhos Semanal (Seg-Dom)</h3>
                <div style="height: 300px; display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; padding-bottom: 2rem; position: relative; border-left: 1px solid rgba(255,255,255,0.05); padding-left: 15px;">
                    @php $fixed_max = 2500; @endphp
                    @foreach($weeklyEarnings as $day => $val)
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                            <div style="font-size: 9px; color: #22c55e; font-weight: 800; min-height: 12px;">@if($val > 0) R$ {{ number_format($val, 0) }} @endif</div>
                            <div style="width: 100%; height: {{ min(100, max(2, ($val / $fixed_max) * 100)) }}%; background: linear-gradient(to top, var(--primary-blue), #8b5cf6); border-radius: 12px 12px 6px 6px; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 20px rgba(51, 144, 236, 0.3); cursor: pointer;" title="R$ {{ number_format($val, 2) }}"></div>
                            <div style="font-size: 10px; color: var(--text-muted); font-weight: 700; margin-top: 4px; text-transform: capitalize;">{{ $day }}</div>
                        </div>
                    @endforeach

                    <!-- Scale markers -->
                    <div style="position: absolute; left: -10px; top: 0; bottom: 32px; display: flex; flex-direction: column; justify-content: space-between; font-size: 9px; color: var(--text-muted); font-weight: 700;">
                        <span>2500</span>
                        <span>1250</span>
                        <span>0</span>
                    </div>
                </div>
            </div>

            <!-- Content Ranking -->
            <div class="studio-card-pad" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
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
