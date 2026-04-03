@extends('emails.layout')

@section('content')
    <div style="font-size: 40px; margin-bottom: 24px;">💰</div>
    <h1>Depósito Confirmado!</h1>
    <p>Excelentes notícias! Seu depósito de <span class="highlight">R$ {{ number_format($amount ?? 0, 2, ',', '.') }}</span> foi processado e já está disponível em sua conta.</p>
    <p>Agora você pode assinar canais, apoiar seus criadores favoritos com presentes exclusivos ou desbloquear posts premium.</p>
    <a href="{{ url('/dashboard') }}" class="btn">Acessar Minha Carteira</a>
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <p style="font-size: 14px;">ID da Transação: #{{ $transaction_id ?? '2024TX999' }}</p>
    </div>
@endsection
