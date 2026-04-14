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

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">3. Propriedade e Responsabilidade do Conteúdo</h3>
            <p>A Mogram atua exclusivamente como uma plataforma intermediadora entre criadores de conteúdo e seus consumidores. A Mogram <strong>não é proprietária</strong> do conteúdo publicado na plataforma. Os criadores de conteúdo retêm todos os direitos de propriedade intelectual sobre suas publicações, sendo integralmente responsáveis pela natureza, legalidade e veracidade de tudo o que publicam.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">4. Conteúdo Proibido e Moderação</h3>
            <p>O Mogram mantém uma política de tolerância zero para atividades ilegais. Reservamo-nos o direito de derrubar transmissões ao vivo (Lives) e remover conteúdos permanentemente, sem aviso prévio, que envolvam:</p>
            <ul style="margin-left: 1.5rem; margin-top: 1rem;">
                <li>Exploração ou abuso infantil de qualquer natureza;</li>
                <li>Tráfico de seres humanos ou de órgãos;</li>
                <li>Comércio de substâncias ilícitas e entorpecentes;</li>
                <li>Venda de armas de fogo, munições e seus derivados;</li>
                <li>Conteúdo que promova terrorismo ou violência extrema.</li>
            </ul>
            <p style="margin-top: 1rem;">A violação destas diretrizes resultará no encerramento imediato da conta e, quando aplicável, na denúncia às autoridades competentes.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">5. Pagamentos e Taxas</h3>
            <p>Os criadores de conteúdo estão cientes de que o Mogram cobra uma taxa de serviço sobre as transações realizadas na plataforma. Os detalhes das taxas estão disponíveis no painel do criador.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">6. Encerramento de Conta</h3>
            <p>O Mogram reserva-se o direito de suspender ou encerrar sua conta a qualquer momento por violação destes termos ou por conduta prejudicial à comunidade.</p>

            <h3 class="font-bold" style="color: white; margin-top: 2.5rem; margin-bottom: 1rem;">7. Alterações nos Termos</h3>
            <p>Podemos atualizar estes Termos de Uso periodicamente. O uso continuado da plataforma após as alterações constitui aceitação dos novos termos.</p>

            <p style="margin-top: 4rem; font-size: 0.875rem; color: var(--text-muted);">Última atualização: 14 de Abril de 2026.</p>

        </div>
    </div>
</div>
@endsection
