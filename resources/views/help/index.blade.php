@extends('layouts.app')

@section('title', 'Central de Ajuda - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div style="padding: 4rem 2rem; max-width: 1000px; margin: 0 auto;">
            <header style="text-align: center; margin-bottom: 5rem;">
                <p style="color: var(--primary-blue); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Suporte & Recursos</p>
                <h1 style="font-size: 48px; font-weight: 950; color: white; margin-bottom: 1rem; letter-spacing: -2px;">Central de Ajuda</h1>
                <p style="color: #64748b; font-size: 18px; font-weight: 600;">Aprenda a dominar o Mogram com nossos guias práticos.</p>
            </header>

            <!-- Quick Navigation -->
            <nav style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-bottom: 6rem;">
                <a href="#postar-conteudo" class="guide-nav-item">Postar Conteúdo</a>
                <a href="#criar-comunidades" class="guide-nav-item">Criar Comunidades</a>
                <a href="#iniciar-lives" class="guide-nav-item">Iniciar Lives</a>
                <a href="#enviar-gifts" class="guide-nav-item">Enviar Gifts</a>
            </nav>

            <div style="display: flex; flex-direction: column; gap: 8rem;">
                
                <!-- 1. Postar Conteúdo -->
                <section id="postar-conteudo" class="help-section">
                    <div class="section-content">
                        <div class="section-text">
                            <span class="step-badge">Etapa 1</span>
                            <h2 class="section-title">Como Postar Conteúdo</h2>
                            <p class="section-desc">Compartilhar seu conteúdo exclusivo é simples. Você pode postar fotos ou vídeos e até definir um preço para desbloqueio.</p>
                            <ul class="step-list">
                                <li>Acesse o <strong>Mogram Studio</strong> no menu lateral.</li>
                                <li>Clique em <strong>"Criar Novo"</strong> ou arraste seus arquivos.</li>
                                <li>Adicione uma legenda cativante para seus fãs.</li>
                                <li>Se desejar, ative o <strong>Conteúdo Desbloqueável</strong> e defina o valor em moedas.</li>
                                <li>Clique em <strong>Publicar</strong> e comece a faturar!</li>
                            </ul>
                        </div>
                        <div class="section-image-container">
                            <img src="{{ asset('images/guides/guide_post_content_1776776284037.png') }}" alt="Como Postar Conteúdo" class="guide-img">
                        </div>
                    </div>
                </section>

                <!-- 2. Criar Comunidades -->
                <section id="criar-comunidades" class="help-section">
                    <div class="section-content reverse">
                        <div class="section-text">
                            <span class="step-badge">Etapa 2</span>
                            <h2 class="section-title">Criando sua Comunidade</h2>
                            <p class="section-desc">Comunidades são perfeitas para fidelizar seu público em um ambiente exclusivo por assinatura.</p>
                            <ul class="step-list">
                                <li>Vá para a aba <strong>Comunidades</strong>.</li>
                                <li>Selecione <strong>"Criar Nova Comunidade"</strong>.</li>
                                <li>Escolha um nome marcante e uma imagem de capa premium.</li>
                                <li>Defina se a comunidade será <strong>Gratuita</strong> ou via <strong>Assinatura Mensal</strong>.</li>
                                <li>Configure o preço e as regras de convivência.</li>
                            </ul>
                        </div>
                        <div class="section-image-container">
                            <img src="{{ asset('images/guides/guide_create_community_1776776319490.png') }}" alt="Criar Comunidade" class="guide-img">
                        </div>
                    </div>
                </section>

                <!-- 3. Iniciar Lives -->
                <section id="iniciar-lives" class="help-section">
                    <div class="section-content">
                        <div class="section-text">
                            <span class="step-badge">Etapa 3</span>
                            <h2 class="section-title">Iniciando uma Live Stream</h2>
                            <p class="section-desc">Interaja em tempo real e receba presentes instantâneos durante suas transmissões.</p>
                            <ul class="step-list">
                                <li>No Studio, acesse a aba <strong>Lives</strong>.</li>
                                <li>Clique em <strong>"Iniciar Transmissão"</strong>.</li>
                                <li>Configure o título da Live e a categoria (ex: Chat, Gaming, ASMR).</li>
                                <li>Verifique sua conexão e iluminação no preview.</li>
                                <li>Clique em <strong>Entrar Ao Vivo</strong> e brilhe para sua audiência!</li>
                            </ul>
                        </div>
                        <div class="section-image-container">
                            <img src="{{ asset('images/guides/guide_start_live_1776776352552.png') }}" alt="Iniciar Lives" class="guide-img">
                        </div>
                    </div>
                </section>

                <!-- 4. Enviar Gifts -->
                <section id="enviar-gifts" class="help-section">
                    <div class="section-content reverse">
                        <div class="section-text">
                            <span class="step-badge">Etapa 4</span>
                            <h2 class="section-title">Como Enviar Gifts (Presentes)</h2>
                            <p class="section-desc">Apoie seus criadores favoritos enviando presentes virtuais durante as Lives ou no Chat.</p>
                            <ul class="step-list">
                                <li>Durante uma Live, clique no ícone de <strong>Presente (Mimo)</strong>.</li>
                                <li>Escolha entre uma variedade de Gifts, de rosas a diamantes.</li>
                                <li>Confirme o envio e veja seu nome aparecer em destaque na stream.</li>
                                <li>Você também pode enviar gifts diretamente nas mensagens privadas.</li>
                            </ul>
                        </div>
                        <div class="section-image-container">
                            <img src="{{ asset('images/guides/guide_send_gifts_v2_1776777015238.png') }}" alt="Enviar Gifts" class="guide-img">
                        </div>
                    </div>
                </section>

            </div>

            <!-- FAQ -->
            <section style="margin-top: 10rem; margin-bottom: 5rem;">
                <h2 style="font-size: 32px; font-weight: 950; color: white; margin-bottom: 3rem; text-align: center;">Perguntas Frequentes</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
                    <details class="help-details">
                        <summary>Como funcionam as moedas do Mogram?</summary>
                        <p>As moedas são a moeda virtual da plataforma. Você pode comprá-las via PIX ou Cartão e usá-las para desbloquear conteúdos, assinar comunidades e enviar gifts.</p>
                    </details>

                    <details class="help-details">
                        <summary>Quando recebo meus ganhos?</summary>
                        <p>Os pagamentos são processados em até 48h após a solicitação de saque, desde que você tenha atingido o valor mínimo para retirada configurado em seu painel.</p>
                    </details>
                </div>
            </section>

            <div style="background: linear-gradient(135deg, rgba(51, 144, 236, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%); border: 1.5px solid rgba(51, 144, 236, 0.2); border-radius: 40px; padding: 5rem; text-align: center; margin-top: 5rem; backdrop-filter: blur(10px);">
                <h2 style="font-size: 32px; font-weight: 950; color: white; margin-bottom: 1.5rem; letter-spacing: -1px;">Não encontrou o que procurava?</h2>
                <p style="color: #94a3b8; margin-bottom: 3rem; font-size: 1.15rem; font-weight: 600;">Nosso time de suporte está pronto para te ajudar a qualquer momento.</p>
                <div style="display: flex; justify-content: center; gap: 1.5rem;">
                    <a href="{{ route('support.index') }}" class="mogram-btn-primary" style="padding: 1.25rem 3rem; border-radius: 20px; text-decoration: none; font-weight: 900; font-size: 1.1rem; box-shadow: 0 15px 35px rgba(51, 144, 236, 0.3);">Abrir Ticket de Suporte</a>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    .help-section {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s forwards;
    }
    
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .section-content {
        display: flex;
        align-items: center;
        gap: 4rem;
    }

    .section-content.reverse {
        flex-direction: row-reverse;
    }

    .section-text {
        flex: 1;
    }

    .section-image-container {
        flex: 1.2;
        position: relative;
    }

    .guide-img {
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.08);
        transition: 0.5s;
    }

    .guide-img:hover {
        transform: scale(1.02) translateY(-10px);
        box-shadow: 0 50px 100px rgba(51, 144, 236, 0.2);
    }

    .step-badge {
        display: inline-block;
        background: rgba(51, 144, 236, 0.1);
        color: var(--primary-blue);
        padding: 6px 16px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 32px;
        font-weight: 950;
        color: white;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .section-desc {
        color: #94a3b8;
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .step-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .step-list li {
        color: #cbd5e1;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .step-list li::before {
        content: '';
        width: 6px;
        height: 6px;
        background: var(--primary-blue);
        border-radius: 50%;
        box-shadow: 0 0 10px var(--primary-blue);
    }

    .guide-nav-item {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 1rem 2rem;
        border-radius: 18px;
        color: white;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.95rem;
        transition: 0.3s;
    }

    .guide-nav-item:hover {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(51, 144, 236, 0.2);
    }

    .help-details {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 20px;
        padding: 1.5rem;
        transition: 0.3s;
    }

    .help-details summary {
        font-weight: 800;
        color: white;
        cursor: pointer;
        list-style: none;
        font-size: 1.1rem;
    }

    .help-details p {
        margin-top: 1.25rem;
        color: #94a3b8;
        line-height: 1.6;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .section-content, .section-content.reverse {
            flex-direction: column;
            gap: 3rem;
        }
        .section-title { font-size: 28px; }
    }
</style>
@endsection
