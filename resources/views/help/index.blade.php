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

            <!-- Dynamic Navigation -->
            <nav style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-bottom: 6rem;">
                @foreach($articles as $article)
                    <a href="#{{ $article->slug }}" class="guide-nav-item">{{ $article->title }}</a>
                @endforeach
            </nav>

            <div style="display: flex; flex-direction: column; gap: 8rem;">
                @forelse($articles as $article)
                    <section id="{{ $article->slug }}" class="help-section">
                        <div class="section-content {{ $loop->iteration % 2 == 0 ? 'reverse' : '' }}">
                            <div class="section-text">
                                <span class="step-badge">Guia Mogram</span>
                                <h2 class="section-title">{{ $article->title }}</h2>
                                <p class="section-desc">{{ $article->description }}</p>
                                <div class="article-body">
                                    {!! $article->content !!}
                                </div>
                            </div>
                            <div class="section-image-container">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="guide-img">
                                @else
                                    <div style="width: 100%; aspect-ratio: 16/9; background: rgba(51,144,236,0.1); border-radius: 24px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                @empty
                    <div style="text-align: center; padding: 5rem 0;">
                        <p style="color: #64748b; font-size: 1.25rem; font-weight: 600;">Nenhum guia disponível no momento.</p>
                    </div>
                @endforelse
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

    .article-body ul, .article-body ol {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .article-body li {
        color: #cbd5e1;
        font-weight: 600;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        line-height: 1.5;
    }

    .article-body li::before {
        content: '';
        width: 6px;
        height: 6px;
        background: var(--primary-blue);
        border-radius: 50%;
        box-shadow: 0 0 10px var(--primary-blue);
        margin-top: 8px;
        flex-shrink: 0;
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
