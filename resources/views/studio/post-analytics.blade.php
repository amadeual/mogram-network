@extends('layouts.app')

@section('title', 'Análise de Performance - ' . $post->title)

@section('content')
<div class="app-layout">
    @include("partials.studio-sidebar")

    <main class="main-content" style="background: #0b0a15; padding: 2rem 3rem;">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 0.5rem;">Posts / <span style="color: white; font-weight: 700;">Análise de Performance</span></p>
                <h1 style="font-size: 2rem; font-weight: 950; color: white;">Detalhes da Análise</h1>
            </div>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <button style="background: rgba(255,255,255,0.05); border: none; padding: 0.75rem 1.5rem; color: white; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Exportar Relatório
                </button>
                <div style="width: 44px; height: 44px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; position: relative;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div style="position: absolute; top: 12px; right: 12px; width: 6px; height: 6px; background: #3390ec; border-radius: 50%;"></div>
                </div>
            </div>
        </header>

        <!-- Post Summary Card -->
        <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2rem; display: flex; gap: 2rem; align-items: center; margin-bottom: 2rem;">
            <div style="width: 120px; height: 120px; border-radius: 20px; overflow: hidden; background: rgba(255,255,255,0.1);">
                @if($post->type == 'image')
                    <img src="{{ Storage::url($post->file_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                @endif
            </div>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                    <span style="background: rgba(51, 144, 236, 0.1); color: #3390ec; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">EXCLUSIVO</span>
                    <span style="color: var(--text-muted); font-size: 12px;">Publicado em {{ $post->created_at->format('d M Y') }}</span>
                </div>
                <h2 style="font-size: 1.75rem; font-weight: 900; color: white; margin-bottom: 0.75rem;">{{ $post->title }}</h2>
                <p style="color: var(--text-muted); font-size: 14px; max-width: 600px;">{{ $post->description ?? 'Nenhuma descrição fornecida para este conteúdo.' }}</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('studio.edit', $post->id) }}" style="width: 48px; height: 48px; background: #3390ec; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form action="{{ route('studio.delete', $post->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; border: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Metric Cards -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
            <div class="premium-metric-card" style="--accent-color: #3390ec;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div style="width: 36px; height: 36px; background: rgba(51, 144, 236, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <span style="color: #22c55e; font-size: 11px; font-weight: 800;">+12%</span>
                </div>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 0.5rem;">Visualizações</p>
                <h3 style="font-size: 2rem; font-weight: 950; color: white;">12.430</h3>
            </div>
            
            <div class="premium-metric-card" style="--accent-color: #22c55e;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div style="width: 36px; height: 36px; background: rgba(34, 197, 94, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span style="color: #22c55e; font-size: 11px; font-weight: 800;">+5.2%</span>
                </div>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 0.5rem;">Total Ganho</p>
                <h3 style="font-size: 2rem; font-weight: 950; color: #22c55e;"><span style="font-size: 1.25rem;">R$</span> 2.850,00</h3>
            </div>

            <div class="premium-metric-card" style="--accent-color: #a855f7;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div style="width: 36px; height: 36px; background: rgba(168, 85, 247, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <span style="color: #22c55e; font-size: 11px; font-weight: 800;">+18%</span>
                </div>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 0.5rem;">Desbloqueios</p>
                <h3 style="font-size: 2rem; font-weight: 950; color: white;">412</h3>
            </div>

            <div class="premium-metric-card" style="--accent-color: #f59e0b;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div style="width: 36px; height: 36px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <span style="color: #22c55e; font-size: 11px; font-weight: 800;">+1.5%</span>
                </div>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 0.5rem;">Taxa Engajamento</p>
                <h3 style="font-size: 2rem; font-weight: 950; color: white;">8.4%</h3>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
            <!-- Chart Section -->
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <h3 style="font-size: 18px; font-weight: 900; color: white;">Desempenho ao Longo do Tempo</h3>
                    <div style="background: rgba(0,0,0,0.3); padding: 4px; border-radius: 12px; display: flex; gap: 4px;">
                        <button style="background: rgba(255,255,255,0.05); border: none; color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 800;">Ganhos</button>
                        <button style="background: transparent; border: none; color: var(--text-muted); padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 800;">Alcance</button>
                    </div>
                </div>
                <div style="height: 250px; display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; padding: 0 1rem;">
                    @php $heights = [30, 45, 60, 70, 65, 90, 80, 75]; @php
                    @foreach(['SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SÁB', 'DOM', 'HOJE'] as $i => $day)
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                        <div style="width: 100%; height: {{ $heights[$i] }}%; background: {{ $day == 'SÁB' ? 'var(--primary-blue)' : 'rgba(51, 144, 236, 0.15)' }}; border-radius: 8px; position: relative; transition: 0.3s;" onmouseover="this.style.background='var(--primary-blue)'" onmouseout="this.style.background='{{ $day == 'SÁB' ? 'var(--primary-blue)' : 'rgba(51, 144, 236, 0.15)' }}'"></div>
                        <span style="font-size: 10px; font-weight: 800; color: var(--text-muted);">{{ $day }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Audience Section -->
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem;">
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 2rem;">Público Alvo</h3>
                
                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">LOCALIZAÇÃO</p>
                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 3rem;">
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 12px;">
                            <span style="color: white; font-weight: 800;">São Paulo, SP</span>
                            <span style="color: white;">45%</span>
                        </div>
                        <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px;">
                            <div style="width: 45%; height: 100%; background: var(--primary-blue); border-radius: 2px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 12px;">
                            <span style="color: white; font-weight: 800;">Rio de Janeiro, RJ</span>
                            <span style="color: white;">22%</span>
                        </div>
                        <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px;">
                            <div style="width: 22%; height: 100%; background: var(--primary-blue); border-radius: 2px; opacity: 0.6;"></div>
                        </div>
                    </div>
                </div>

                <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">FAIXA ETÁRIA</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 16px; text-align: center;">
                        <p style="font-size: 10px; color: var(--text-muted); margin-bottom: 4px;">18-24</p>
                        <p style="font-size: 16px; font-weight: 900; color: white;">38%</p>
                    </div>
                    <div style="background: rgba(51, 144, 236, 0.05); padding: 1rem; border: 1px solid rgba(51, 144, 236, 0.2); border-radius: 16px; text-align: center;">
                        <p style="font-size: 10px; color: var(--primary-blue); margin-bottom: 4px;">25-34</p>
                        <p style="font-size: 16px; font-weight: 900; color: var(--primary-blue);">52%</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2rem; margin-top: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 18px; font-weight: 900; color: white;">Principais Comentários</h3>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        128
                    </span>
                    <a href="#" style="font-size: 12px; color: var(--primary-blue); font-weight: 800; text-decoration: none;">Ver todos</a>
                </div>
            </div>
            <p style="color: var(--text-muted); font-size: 13px; text-align: center; padding: 2rem;">Nenhum comentário em destaque para este post.</p>
        </div>
    </main>
</div>
@endsection
