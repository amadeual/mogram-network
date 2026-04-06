@extends('emails.layout')

@section('content')
    <div style="font-size: 48px; margin-bottom: 24px;">🚀</div>
    <h1>Bem-vindo à Elite, {{ $userName }}!</h1>
    <p>Sua jornada no <span class="highlight">Mogram Network</span> acaba de começar. Prepare-se para conteúdos que você não verá em nenhum outro lugar.</p>
    
    <table class="stats-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td class="stat-label">USUÁRIO:</td>
            <td class="stat-value">{{ $userName }}</td>
        </tr>
        <tr>
            <td class="stat-label">STATUS:</td>
            <td class="stat-value" style="color: #22c55e;">ATIVO</td>
        </tr>
        <tr>
            <td class="stat-label">MEMBRO DESDE:</td>
            <td class="stat-value">{{ date('d/m/Y') }}</td>
        </tr>
    </table>

    <p>Explore as produções originais e apoie seus criadores favoritos agora mesmo.</p>
    
    <a href="{{ url('/dashboard') }}" class="btn">ACESSAR MINHA CONTA</a>
    
    <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
        <p style="font-size: 13px; color: rgba(255,255,255,0.4); font-weight: 700;">Dúvidas? Entre em contato com o suporte vip.</p>
    </div>
@endsection
