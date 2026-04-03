@extends('layouts.app')

@section('title', 'Termos de Uso - Mogram')

@section('content')
<div class="container" style="padding: 8rem 0 12rem;">
    <div style="max-width: 800px; margin: 0 auto;">
        <a href="{{ url('/') }}" class="text-blue font-bold text-sm" style="display: flex; align-items: center; gap: 8px; margin-bottom: 2rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Voltar ao Início
        </a>
        
        <h1 class="section-title" style="margin-bottom: 3rem;">Termos de Uso</h1>
        
        <div class="simulator-card" style="display: block; padding: 4rem; line-height: 1.8; color: var(--text-light);">
            <p style="margin-bottom: 1.5rem;">Bem-vindo ao Mogram. Ao acessar ou usar nossa plataforma, você concorda em cumprir e estar vinculado aos seguintes Termos de Uso. Leia-os atentamente.</p>
            
            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">1. Aceitação dos Termos</h3>
            <p>Ao criar uma conta ou utilizar o Mogram, você declara que tem pelo menos 18 anos de idade e que concorda com estes termos. Se você não concorda com qualquer parte destes termos, não deve acessar a plataforma.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">2. Descrição do Serviço</h3>
            <p>O Mogram é uma rede social que permite aos criadores de conteúdo monetizarem seu trabalho através de assinaturas, vendas de conteúdo e interações com seguidores.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">3. Conduta do Usuário</h3>
            <p>Você é o único responsável pelo conteúdo que publica. É proibido publicar conteúdo ilegal, abusivo, difamatório ou que viole direitos autorais de terceiros. Reservamo-nos o direito de remover qualquer conteúdo que viole nossas diretrizes.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">4. Pagamentos e Taxas</h3>
            <p>Os criadores de conteúdo estão cientes de que o Mogram cobra uma taxa de serviço sobre as transações realizadas na plataforma. Os detalhes das taxas estão disponíveis no painel do criador.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">5. Encerramento de Conta</h3>
            <p>O Mogram reserva-se o direito de suspender ou encerrar sua conta a qualquer momento por violação destes termos ou por conduta prejudicial à comunidade.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">6. Alterações nos Termos</h3>
            <p>Podemos atualizar estes Termos de Uso periodicamente. O uso continuado da plataforma após as alterações constitui aceitação dos novos termos.</p>

            <p style="margin-top: 4rem; font-size: 0.875rem; color: var(--text-muted);">Última atualização: 22 de Março de 2026.</p>
        </div>
    </div>
</div>
@endsection
