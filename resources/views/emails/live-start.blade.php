@extends('emails.layout')

@section('content')
    <div style="font-size: 40px; margin-bottom: 24px;">🔴</div>
    <h1>{{ $creator->name }} está ao vivo!</h1>
    <p><span class="highlight">{{ $creator->name }}</span> acabou de iniciar uma transmissão ao vivo: <strong>{{ $live->title }}</strong></p>
    <p>Não perca! Junte-se agora para interagir, enviar presentes e apoiar a comunidade.</p>
    <a href="{{ url('/lives/' . $live->id) }}" class="btn">Assistir à Live Agora</a>
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
        <p style="font-size: 14px;">Você está recebendo este alerta porque segue {{ $creator->name }}.</p>
    </div>
@endsection
