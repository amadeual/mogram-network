@extends('layouts.app')

@section('title', 'Minha Carteira - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content" style="flex: 1; background: #0b0a15; padding: 2.5rem 3rem; overflow-y: auto;">
        
        <header class="studio-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px;">Minha Carteira</h1>
        </header>

        <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 32px; padding: 2.5rem; margin-bottom: 3rem; position: relative; box-shadow: 0 20px 40px rgba(18, 97, 209, 0.3); overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2rem;">
                <p style="font-size: 13px; font-weight: 850; color: rgba(255,255,255,0.8); text-transform: uppercase; letter-spacing: 1px;">Seu Saldo</p>
            </div>
            <h2 style="font-size: 3.5rem; font-weight: 950; color: white; margin-bottom: 2rem; letter-spacing: -2px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
            <div style="display: flex; gap: 1rem;">
                <button onclick="showToast('Integração de PIX em breve!', 'info')" style="background: white; color: #1261d1; padding: 0.875rem 1.75rem; border: none; border-radius: 14px; font-weight: 950; font-size: 14px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Depositar Agora
                </button>
            </div>
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
