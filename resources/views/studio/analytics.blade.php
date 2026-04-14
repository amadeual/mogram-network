@extends('layouts.app')

@section('title', 'Analytics Global - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <main class="main-content">
        <header class="studio-header" style="margin-bottom: 3rem;">
            <div>
                <h1 style="font-size: 2.5rem; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Analytics Geral</h1>
                <p style="color: var(--text-muted); font-size: 15px;">Acompanhe o desempenho das suas tribos.</p>
            </div>
        </header>

        <div class="studio-body">
            <!-- Key Metrics -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
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

        <div class="responsive-grid-feed" style="margin-top: 3rem;">
            <!-- Main Chart -->
            <div class="studio-card-pad" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem; position: relative;">
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 2.5rem;">Evolução de Ganhos Semanal <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin-left: 8px;">(R$)</span></h3>
                
                <div style="height: 280px; display: flex; flex-direction: row; align-items: flex-end; gap: 16px; position: relative; padding-left: 45px; padding-bottom: 30px;">
                    <!-- Grid Lines -->
                    <div style="position: absolute; left: 45px; right: 0; top: 0; height: 1px; background: rgba(255,255,255,0.05); z-index: 1;"></div>
                    <div style="position: absolute; left: 45px; right: 0; top: 50%; height: 1px; background: rgba(255,255,255,0.05); z-index: 1;"></div>
                    <div style="position: absolute; left: 45px; right: 0; bottom: 30px; height: 1px; background: rgba(255,255,255,0.1); z-index: 1;"></div>

                    @php 
                        $rawValues = $weeklyEarnings instanceof \Illuminate\Support\Collection ? $weeklyEarnings->values()->toArray() : array_values((array)$weeklyEarnings);
                        $max_observed = count($rawValues) > 0 ? max($rawValues) : 0;
                        $fixed_max = 1000;
                        if($max_observed > 0) {
                            $fixed_max = ceil($max_observed / 500) * 500;
                            if($fixed_max < 100) $fixed_max = 100;
                        }
                    @endphp

                    <!-- Scale Labels -->
                    <div style="position: absolute; left: 0; top: -6px; font-size: 10px; color: var(--text-muted); font-weight: 800; font-family: monospace;">{{ $fixed_max >= 1000 ? number_format($fixed_max/1000, 1) . 'k' : $fixed_max }}</div>
                    <div style="position: absolute; left: 0; top: calc(50% - 6px); font-size: 10px; color: var(--text-muted); font-weight: 800; font-family: monospace;">{{ $fixed_max >= 1000 ? number_format(($fixed_max/2)/1000, 1) . 'k' : $fixed_max/2 }}</div>
                    <div style="position: absolute; left: 0; bottom: 24px; font-size: 10px; color: var(--text-muted); font-weight: 800; font-family: monospace;">0</div>

                    <!-- Bars -->
                    @foreach($weeklyEarnings as $day => $val)
                        @php 
                            $percentage = min(100, max(2, ($val / $fixed_max) * 100));
                        @endphp
                        <div style="flex: 1; height: 100%; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; position: relative; z-index: 2; group;">
                            <!-- Tooltip -->
                            <div style="opacity: {{ $val > 0 ? 1 : 0 }}; position: absolute; top: calc(100% - {{ $percentage }}% - 25px); font-size: 10px; color: {{ $val > 0 ? 'white' : 'transparent' }}; font-weight: 900; background: rgba(0,0,0,0.6); padding: 2px 6px; border-radius: 6px; white-space: nowrap; transition: 0.3s; pointer-events: none;">
                                @if($val > 0) R$ {{ number_format($val, 2, ',', '.') }} @endif
                            </div>
                            
                            <!-- Bar -->
                            <div style="width: 100%; max-width: 45px; height: {{ $percentage }}%; background: linear-gradient(to top, #3390ec, #8b5cf6); border-radius: 8px 8px 0 0; transition: height 1s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2); cursor: pointer;" onmouseover="this.style.filter='brightness(1.2)'" onmouseout="this.style.filter='brightness(1)'"></div>
                            
                            <!-- Day Label -->
                            <div style="position: absolute; bottom: 0; font-size: 11px; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">
                                {{ substr($day, 0, 3) }}
                            </div>
                        </div>
                    @endforeach
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
