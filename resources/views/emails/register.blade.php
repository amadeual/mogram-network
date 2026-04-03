@extends('emails.layout')

@section('content')
    <div style="font-size: 40px; margin-bottom: 24px;">👋</div>
    <h1>Olá, {{ e($userName ?? 'Usuário') }}!</h1>
    <p>Bem-vindo ao <span class="highlight">Mogram</span>. Estamos empolgados em ter você conosco na plataforma mais inovadora de monetização de conteúdo.</p>
    <p>Comece a explorar agora, siga seus criadores favoritos ou inicie sua própria jornada como criador!</p>
    <a href="{{ url('/dashboard') }}" class="btn">Explorar o Mogram</a>
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <p style="font-size: 14px;">Você está inscrito nas notificações deste criador.</p>
    </div>
@endsection
