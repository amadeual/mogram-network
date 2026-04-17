@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">📧</div>
    <h1>Verifique seu E-mail</h1>
    <p>Obrigado por se juntar ao <span class="highlight">Mogram Network</span>. Para começar sua jornada exclusiva, por favor confirme seu endereço de e-mail.</p>
    
    <div style="margin: 32px 0;">
        <p style="font-size: 14px; color: rgba(255, 255, 255, 0.6);">Clique no botão abaixo para validar sua conta:</p>
        <a href="{{ $verificationUrl }}" class="btn">VERIFICAR MEU E-MAIL</a>
    </div>

    <p style="font-size: 13px; color: rgba(255, 255, 255, 0.4);">Se você não criou esta conta, nenhuma ação adicional é necessária.</p>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4); font-weight: 700;">Este link expirará em 60 minutos.</p>
    </div>
@endsection
