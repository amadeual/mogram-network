@extends('layouts.app')

@section('title', 'Minha Carteira - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content" style="flex: 1; background: #0b0a15; padding: 2.5rem 3rem; overflow-y: auto;">
        
        <header class="studio-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px;">Minha Carteira</h1>
        </header>

        <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 28px; padding: 2rem; margin-bottom: 2.5rem; position: relative; box-shadow: 0 15px 35px rgba(18, 97, 209, 0.2); overflow: hidden; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 12px; font-weight: 850; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Seu Saldo</p>
                <h2 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -1.5px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
            </div>
            <button onclick="showToast('Integração de PIX em breve!', 'info')" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white; padding: 0.75rem 1.5rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; font-weight: 900; font-size: 13px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 5v14M5 12h14"/></svg>
                Depositar
            </button>
        </div>

        <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 1.5rem;">Histórico de Gastos</h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($history as $item)
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.35rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: rgba(239, 68, 68, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #ef4444;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 3px;">{{ $item['type'] }}</h4>
                        <p style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Para {{ $item['user'] }} • {{ (new \DateTime($item['date']))->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 16px; font-weight: 950; color: white;">
                        - R$ {{ number_format($item['amount'], 2, ',', '.') }}
                    </p>
                    <p style="font-size: 10px; color: #22c55e; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">{{ $item['status'] }}</p>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem; background: rgba(255,255,255,0.01); border-radius: 24px; border: 1px dashed rgba(255,255,255,0.05);">
                <p style="color: var(--text-muted); font-size: 13px;">Você ainda não realizou nenhum desbloqueio de conteúdo.</p>
            </div>
            @endforelse
        </div>

    </main>
</div>
@endsection
