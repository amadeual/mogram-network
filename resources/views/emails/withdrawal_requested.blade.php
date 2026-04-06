@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">🏧</div>
    <h1>Solicitação de Saque Enviada!</h1>
    <p>Sua solicitação de retirada de saldo no <span class="highlight">Mogram Network</span> foi recebida e agora está em fase de processamento pela nossa equipe financeira.</p>
    
    <div class="stats-grid">
        <div class="stat-item">VALOR <span class="stat-value" style="color: #ef4444;">R$ {{ number_format($amount, 2, ',', '.') }}</span></div>
        <div class="stat-item">MÉTODO <span class="stat-value">{{ strtoupper($method) }}</span></div>
        <div class="stat-item">STATUS <span class="stat-value" style="color: #f59e0b;">PENDENTE</span></div>
    </div>

    <p>O processamento de saques pode levar de 1 a 24 horas úteis. Fique atento ao seu histórico para atualizações.</p>
    
    <a href="{{ url('/studio/finance') }}" class="btn">VER HISTÓRICO</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">Identificador da solicitação: #{{ $id }}</p>
    </div>
@endsection
