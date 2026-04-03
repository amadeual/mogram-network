@extends('emails.layout')

@section('content')
    <div style="font-size: 40px; margin-bottom: 24px;">🔑</div>
    <h1>Redefinição de Senha</h1>
    <p>Você solicitou a redefinição de sua senha de acesso ao <span class="highlight">Mogram</span>. Clique no botão abaixo para escolher uma nova senha.</p>
    <a href="{{ url('/password/reset', $token ?? '') }}" class="btn">Redefinir Minha Senha</a>
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <p style="font-size: 14px;">Este link expira em 60 minutos. Se você não solicitou isso, nenhuma ação adicional é necessária.</p>
    </div>
@endsection
