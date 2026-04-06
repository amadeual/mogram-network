@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">🏧</div>
    <h1>Solicitação de Saque Enviada!</h1>
    <p>Sua solicitação no <span class="highlight">Mogram Network</span> foi recebida e agora está em fase de processamento financeiro.</p>
    
    <table class="stats-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="stat-label">VALOR:</td>
            <td class="stat-value" style="color: #ef4444;">- R$ {{ number_format($amount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="stat-label">MÉTODO:</td>
            <td class="stat-value">{{ strtoupper($method) }}</td>
        </tr>
        <tr>
            <td class="stat-label">DATA:</td>
            <td class="stat-value">{{ date('d/m/Y - H:i') }}</td>
        </tr>
    </table>

    <p>O processamento de saques pode levar de 1 a 24 horas úteis. Fique atento ao suporte para qualquer novidade.</p>
    
    <a href="{{ url('/studio/finance') }}" class="btn">VER HISTÓRICO</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">ID da Solicitação: #{{ $id }}</p>
    </div>
@endsection
