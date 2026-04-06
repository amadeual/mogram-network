@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">💰</div>
    <h1>Depósito Confirmado!</h1>
    <p>Seu saldo no <span class="highlight">Mogram Network</span> foi atualizado. Os fundos já estão disponíveis para uso imediato em nossa plataforma.</p>
    
    <div class="stats-grid">
        <div class="stat-item">VALOR <span class="stat-value" style="color: #22c55e;">+ R$ {{ number_format($amount, 2, ',', '.') }}</span></div>
        <div class="stat-item">MÉTODO <span class="stat-value">PIX / CARTÃO (ABACATE PAY)</span></div>
        <div class="stat-item">DATA <span class="stat-value">{{ date('d M, Y - H:i') }}</span></div>
    </div>

    <p>Use seu saldo para apoiar seus criadores favoritos, desbloquear conteúdos exclusivos ou assinar novos canais.</p>
    
    <a href="{{ url('/wallet') }}" class="btn">VER MINHA CARTEIRA</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">Identificador da transação: #{{ $id }}</p>
    </div>
@endsection
