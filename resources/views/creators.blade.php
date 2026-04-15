@extends('layouts.app')

@section('title', 'Mogram | Para Criadores')
@section('meta_description', 'Descubra todas as vantagens de ser um criador no Mogram. Monetize sem algoritmos, saques via PIX em 24h e suporte local.')

@section('content')
@include('partials.navbar')

<header class="hero-social" style="padding-top: 8rem; padding-bottom: 4rem;">
    <div class="container" style="text-align: center;">
        <h1 class="hero-title" style="margin-bottom: 1.5rem; font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 950; letter-spacing: -2px;">
            Monetização Real, <br><span class="grad-text" style="background: linear-gradient(90deg, #ff8c2d, #ff4b1f); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Sem Julgamento de Algoritmos.</span>
        </h1>
        <p class="text-muted" style="font-size: 1.25rem; max-width: 700px; margin: 0 auto 3.5rem; line-height: 1.6; color: #aaa;">
            Assuma o controle total do seu conteúdo e da sua audiência. No Mogram, você não depende da sorte ou de robôs para gerar receita. Transforme sua influência em um negócio altamente lucrativo.
        </p>
        <a href="{{ route('register') }}" class="mogram-btn-primary hero-cta-btn" style="display: inline-flex; background: white; color: black; padding: 1.15rem 2.5rem; border-radius: 99px; font-weight: 900; text-decoration: none; font-size: 1rem; transition: 0.3s; box-shadow: 0 10px 30px rgba(255,255,255,0.1);">
            Começar a Lucrar
        </a>
    </div>
</header>

<section style="padding: 5rem 0; background: #0b0a15;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
            
            <!-- Advantage 1 -->
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 30px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.transform='none'">
                <div style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Saques Rápidos no PIX</h3>
                <p style="color: #aaa; line-height: 1.6; font-size: 1rem;">
                    Dinheiro na mão é melhor que na promessa. Faça saques rápidos em até 24hrs no PIX logo que atingir apenas R$50 de receita. Sem burocracia, sem esperas intermináveis e com máxima transparência.
                </p>
            </div>

            <!-- Advantage 2 -->
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 30px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.transform='none'">
                <div style="width: 60px; height: 60px; background: rgba(255, 75, 31, 0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff4b1f" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Várias Formas de Monetização</h3>
                <p style="color: #aaa; line-height: 1.6; font-size: 1rem;">
                    Diversifique seus ganhos! Faça dinheiro com venda de conteúdo exclusivo, transmissões de lives interativas, recebendo presentes virtuais e muito mais. Use sua criatividade sem limites.
                </p>
            </div>

            <!-- Advantage 3 -->
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 30px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.transform='none'">
                <div style="width: 60px; height: 60px; background: rgba(51, 144, 236, 0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#3390ec" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Suporte Local Exclusivo</h3>
                <p style="color: #aaa; line-height: 1.6; font-size: 1rem;">
                    Nós estamos perto de você. No Mogram, os criadores contam com suporte local dedicado. Repostas rápidas e eficientes de uma equipe que entende o seu sucesso como o da nossa plataforma.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Call to Action Social -->
<section style="padding: 6rem 0; background: #08070e;">
    <div class="container">
        <div class="cta-card" style="background: linear-gradient(135deg, #ff8c2d 0%, #ff4b1f 100%); padding: 5rem; border-radius: 50px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 40px 100px -20px rgba(255, 75, 31, 0.4);">
            <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 950; margin-bottom: 1.5rem; color: white;">Pronto para transformar fãs em receita real?</h2>
            <p style="font-size: 1.25rem; font-weight: 600; opacity: 0.9; max-width: 600px; margin: 0 auto 3.5rem; color: white;">Pare de trabalhar de graça para algoritmos invisíveis.</p>
            
            <a href="{{ route('register') }}" style="background: white; color: #ff4b1f; padding: 1.5rem 4rem; border-radius: 99px; font-weight: 900; font-size: 1.125rem; text-decoration: none; display: inline-block; transition: 0.3s; box-shadow: 0 10px 30px rgba(255,255,255,0.2);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 40px rgba(255,255,255,0.3)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 30px rgba(255,255,255,0.2)'">
                Quero Ser Criador
            </a>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
