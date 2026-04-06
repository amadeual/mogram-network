@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">📸</div>
    <h1>Novo Conteúdo Desbloqueado!</h1>
    <p>Sua compra de conteúdo no <span class="highlight">Mogram Network</span> foi realizada com sucesso. O conteúdo exclusivo já está em sua biblioteca.</p>
    
    <div class="stats-grid">
        <div class="stat-item">CONTEÚDO <span class="stat-value">CONTEÚDO EXCLUSIVO</span></div>
        <div class="stat-item">CRIADOR <span class="stat-value">PERFIL OFICIAL</span></div>
        <div class="stat-item">INVESTIDO <span class="stat-value" style="color: #ef4444;">- R$ {{ number_format($amount, 2, ',', '.') }}</span></div>
    </div>

    <p>Obrigado por apoiar a economia criativa. Aproveite sua visualização agora!</p>
    
    <a href="{{ url('/dashboard') }}" class="btn">ACESSAR CONTEÚDO</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center;">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4);">Aproveite cada pixel. Seu apoio é essencial.</p>
    </div>
@endsection
