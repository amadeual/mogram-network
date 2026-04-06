@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">💰</div>
    <h1>Nova Venda Realizada!</h1>
    <p>Excelente notícia! Você acabou de realizar uma venda de conteúdo no <span class="highlight">Mogram Network</span>. Seu saldo foi atualizado.</p>
    
    <table class="stats-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="stat-label">CONTEÚDO:</td>
            <td class="stat-value">{{ $postTitle }}</td>
        </tr>
        <tr>
            <td class="stat-label">COMPRADOR:</td>
            <td class="stat-value">{{ $buyerName }}</td>
        </tr>
        <tr>
            <td class="stat-label">GANHO:</td>
            <td class="stat-value" style="color: #22c55e;">+ R$ {{ number_format($amount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="stat-label">DATA:</td>
            <td class="stat-value">{{ date('d/m/Y - H:i') }}</td>
        </tr>
    </table>

    <p style="margin-top: 24px;">Continue criando conteúdos incríveis para aumentar sua audiência e seus ganhos!</p>
    
    <a href="{{ url('/studio') }}" class="btn">VER MEU STUDIO</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">Mogram Network - Onde Criadores De Verdade Prosperam.</p>
    </div>
@endsection
