@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">💰</div>
    <h1>Depósito Confirmado!</h1>
    <p>Seu saldo no <span class="highlight">Mogram Network</span> foi atualizado com sucesso. Os fundos já estão disponíveis em sua carteira.</p>
    
    <table class="stats-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="stat-label">VALOR:</td>
            <td class="stat-value" style="color: #22c55e;">+ R$ {{ number_format($amount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="stat-label">MÉTODO:</td>
            <td class="stat-value">PIX / CARTÃO</td>
        </tr>
        <tr>
            <td class="stat-label">DATA:</td>
            <td class="stat-value">{{ date('d/m/Y - H:i') }}</td>
        </tr>
    </table>

    <p>Apoie seus criadores favoritos ou assine novos canais hoje mesmo.</p>
    
    <a href="{{ url('/wallet') }}" class="btn">VER MINHA CARTEIRA</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">ID da Transação: #{{ $id }}</p>
    </div>
@endsection
