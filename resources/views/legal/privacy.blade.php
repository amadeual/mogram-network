@extends('layouts.app')

@section('title', 'Política de Privacidade - Mogram')

@section('content')
<div class="container" style="padding: 8rem 0 12rem;">
    <div style="max-width: 800px; margin: 0 auto;">
        <a href="{{ url('/') }}" class="text-blue font-bold text-sm" style="display: flex; align-items: center; gap: 8px; margin-bottom: 2rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Voltar ao Início
        </a>
        
        <h1 class="section-title" style="margin-bottom: 3rem;">Política de Privacidade</h1>
        
        <div class="simulator-card" style="display: block; padding: 4rem; line-height: 1.8; color: var(--text-light);">
            <p style="margin-bottom: 1.5rem;">Sua privacidade é importante para nós. Esta política descreve como coletamos, usamos e protegemos suas informações pessoais no Mogram.</p>
            
            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">1. Informações Coletadas</h3>
            <p>Coletamos informações básicas como nome, e-mail e dados de perfil que você fornece ao se cadastrar. Também processamos dados de pagamento através de nossos parceiros seguros.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">2. Como Usamos Seus Dados</h3>
            <p>Utilizamos suas informações para fornecer nossos serviços, processar pagamentos, enviar comunicações importantes e melhorar a experiência geral da plataforma.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">3. Segurança dos Dados</h3>
            <p>Implementamos medidas de segurança padrão do setor para proteger seus dados contra acesso não autorizado, alteração ou divulgação indevida.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">4. Compartilhamento de Informações</h3>
            <p>Não vendemos suas informações pessoais para terceiros. Compartilhamos dados apenas com parceiros essenciais para operar o serviço, como processadores de pagamento (Stripe, Abacatepay).</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">5. Seus Direitos</h3>
            <p>Você tem o direito de acessar, corrigir ou excluir suas informações pessoais a qualquer momento através das configurações da sua conta.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">6. Cookies</h3>
            <p>Usamos cookies para melhorar a navegação e personalizar sua experiência na plataforma. Ao continuar navegando, você concorda com o uso de cookies.</p>

            <p style="margin-top: 4rem; font-size: 0.875rem; color: var(--text-muted);">Última atualização: 22 de Março de 2026.</p>
        </div>
    </div>
</div>
@endsection
