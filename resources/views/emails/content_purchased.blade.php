@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">📸</div>
    <h1>Conteúdo Desbloqueado!</h1>
    <p>A sua compra de conteúdo exclusivo no <span class="highlight">Mogram Network</span> foi realizada. O conteúdo já está em sua biblioteca.</p>
    
    <table class="stats-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="stat-label">CONTEÚDO:</td>
            <td class="stat-value">EXCLUSIVO</td>
        </tr>
        <tr>
            <td class="stat-label">INVESTIDO:</td>
            <td class="stat-value" style="color: #ef4444;">- R$ {{ number_format($amount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="stat-label">DATA:</td>
            <td class="stat-value">{{ date('d/m/Y - H:i') }}</td>
        </tr>
    </table>

    <p>Obrigado por apoiar a economia criativa. Aproveite cada minuto!</p>
    
    <a href="{{ url('/dashboard') }}" class="btn">ACESSAR CONTEÚDO</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">Seu suporte é essencial para nossos criadores.</p>
    </div>
@endsection
