@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">🚀</div>
    <h1>Bem-vindo à Elite, {{ $userName }}!</h1>
    <p>Sua jornada no <span class="highlight">Mogram Network</span> acaba de começar. Estamos preparando um feed exclusivo com os melhores criadores do mundo para você.</p>
    
    <div class="stats-grid">
        <div class="stat-item">USUÁRIO <span class="stat-value">{{ $userName }}</span></div>
        <div class="stat-item">STATUS <span class="stat-value" style="color: #22c55e;">ATIVO</span></div>
        <div class="stat-item">MEMBRO DESDE <span class="stat-value">{{ date('d/m/Y') }}</span></div>
    </div>

    <p>Explore agora os conteúdos exclusivos, assine seus perfis favoritos e monetize sua própria arte.</p>
    
    <a href="{{ url('/dashboard') }}" class="btn">ACESSAR MEU DASHBOARD</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4); font-weight: 700;">Dúvidas? Responda a este e-mail ou fale com o suporte.</p>
    </div>
@endsection
