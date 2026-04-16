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

        <div style="margin-top: 3.5rem; display: flex; justify-content: center; gap: 2.5rem; flex-wrap: wrap; opacity: 0.8;">
            <div style="display: flex; align-items: center; gap: 10px; color: #eee; font-size: 0.9rem; font-weight: 700;">
                <div style="width: 32px; height: 32px; background: rgba(34, 197, 94, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                Saques PIX < 24h
            </div>
            <div style="display: flex; align-items: center; gap: 10px; color: #eee; font-size: 0.9rem; font-weight: 700;">
                <div style="width: 32px; height: 32px; background: rgba(34, 197, 94, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                Segunda à Sexta
            </div>
            <div style="display: flex; align-items: center; gap: 10px; color: #eee; font-size: 0.9rem; font-weight: 700;">
                <div style="width: 32px; height: 32px; background: rgba(34, 197, 94, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                Mínimo R$ 50
            </div>
        </div>
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
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.25rem;">Saques Agilizados no PIX</h3>
                
                <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem 0; color: #eee; font-size: 0.9rem; font-weight: 600; display: flex; flex-direction: column; gap: 8px;">
                    <li style="display: flex; align-items: center; gap: 10px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Aprovação em até 24h (Seg à Sex)
                    </li>
                    <li style="display: flex; align-items: center; gap: 10px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Mínimo R$ 50 | Taxa R$ 5
                    </li>
                </ul>

                <div style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 18px; padding: 1.25rem; margin-bottom: 2rem;">
                    <p style="font-size: 0.8rem; color: #888; margin-bottom: 0.5rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Liberação de Saldo:</p>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 4px;">
                        <span style="color: #ccc;">via PIX</span>
                        <span style="color: #22c55e; font-weight: 800;">IMEDIATO</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #ccc;">via CARTÃO</span>
                        <span style="color: #ff8c2d; font-weight: 800;">ATÉ 3 DIAS ÚTEIS</span>
                    </div>
                </div>

                <p style="color: #aaa; line-height: 1.6; font-size: 0.95rem;">
                    No Mogram, seus ganhos são processados com agilidade e total transparência.
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

 <!-- Revenue Comparison Section -->
<section style="padding: 8rem 0; background: #08070e; position: relative; overflow: hidden;">
    <!-- Background Decor -->
    <div style="position: absolute; top: 0; right: 0; width: 50%; height: 100%; background: radial-gradient(circle at 70% 50%, rgba(255, 75, 31, 0.05) 0%, transparent 60%); pointer-events: none;"></div>
    
    <div class="container">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 6rem;">
            <div style="background: rgba(255, 75, 31, 0.1); color: #ff4b1f; padding: 8px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 900; letter-spacing: 1px; margin-bottom: 1.5rem; text-transform: uppercase;">Transparência Total</div>
            <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 950; line-height: 1.1; margin-bottom: 2rem; letter-spacing: -2px;">
                Fique com a <span class="grad-text" style="background: linear-gradient(90deg, #ff8c2d, #ff4b1f); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Maior Parte</span> do que Produz.
            </h2>
            <p style="color: #888; font-size: 1.25rem; max-width: 750px; line-height: 1.6;">
                Enquanto as "redes vizinhas" lucram em cima do seu talento, o Mogram foi construído para potencializar sua independência financeira. Comparação real, lucro real.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2.5rem;">
            
            <!-- Conteúdo -->
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 45px; padding: 3.5rem 3rem; position: relative; transition: 0.5s; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px)'; this.style.borderColor='rgba(255,75,31,0.2)'; this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.05)'; this.style.background='rgba(255,255,255,0.02)'">
                <div style="font-size: 0.9rem; font-weight: 900; color: #ff4b1f; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    CONTEÚDO EXCLUSIVO
                </div>
                <h3 style="font-size: 2rem; font-weight: 950; margin-bottom: 3rem;">Fotos, Vídeos e PDFs</h3>
                
                <div style="margin-bottom: 3rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
                        <span style="font-size: 1.15rem; font-weight: 800; color: white;">Mogram</span>
                        <span style="font-size: 3rem; font-weight: 950; color: #22c55e; line-height: 1;">85%</span>
                    </div>
                    <div style="height: 16px; background: rgba(255,255,255,0.03); border-radius: 99px; position: relative; overflow: hidden;">
                        <div style="width: 85%; height: 100%; background: linear-gradient(90deg, #ff8c2d, #ff4b1f); border-radius: 99px;"></div>
                    </div>
                </div>

                <div style="opacity: 0.5;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 700;">
                        <span>Redes Vizinhas</span>
                        <span>70%</span>
                    </div>
                    <div style="height: 8px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden;">
                        <div style="width: 70%; height: 100%; background: #444; border-radius: 99px;"></div>
                    </div>
                </div>
            </div>

            <!-- Comunidades - Featured -->
            <div style="background: rgba(255, 75, 31, 0.03); border: 2px solid #ff4b1f; border-radius: 45px; padding: 3.5rem 3rem; position: relative; transition: 0.5s; overflow: hidden; box-shadow: 0 20px 50px -10px rgba(255, 75, 31, 0.2);" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 30px 60px -10px rgba(255, 75, 31, 0.3)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 20px 50px -10px rgba(255, 75, 31, 0.2)'">
                <div style="position: absolute; top: 25px; right: 25px; background: #ff4b1f; color: white; padding: 6px 14px; border-radius: 99px; font-size: 0.75rem; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">Recorde de Lucro</div>
                <div style="font-size: 0.9rem; font-weight: 900; color: #ff4b1f; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    COMUNIDADES
                </div>
                <h3 style="font-size: 2rem; font-weight: 950; margin-bottom: 3rem;">Subscrições VIP</h3>
                
                <div style="margin-bottom: 3rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
                        <span style="font-size: 1.15rem; font-weight: 800; color: white;">Mogram</span>
                        <span style="font-size: 3.5rem; font-weight: 950; color: #22c55e; line-height: 1;">90%</span>
                    </div>
                    <div style="height: 16px; background: rgba(255,255,255,0.03); border-radius: 99px; position: relative; overflow: hidden;">
                        <div style="width: 90%; height: 100%; background: linear-gradient(90deg, #ff8c2d, #ff4b1f); border-radius: 99px;"></div>
                    </div>
                </div>

                <div style="opacity: 0.5;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 700;">
                        <span>Redes Vizinhas</span>
                        <span>80%</span>
                    </div>
                    <div style="height: 8px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden;">
                        <div style="width: 80%; height: 100%; background: #444; border-radius: 99px;"></div>
                    </div>
                </div>
            </div>

            <!-- Gifts -->
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 45px; padding: 3.5rem 3rem; position: relative; transition: 0.5s; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px)'; this.style.borderColor='rgba(255,75,31,0.2)'; this.style.background='rgba(255,255,255,0.04)'" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.05)'; this.style.background='rgba(255,255,255,0.02)'">
                <div style="font-size: 0.9rem; font-weight: 900; color: #ff4b1f; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                    PRESENTES (GIFTS)
                </div>
                <h3 style="font-size: 2rem; font-weight: 950; margin-bottom: 3rem;">Gifts em Lives & Chat</h3>
                
                <div style="margin-bottom: 3rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
                        <span style="font-size: 1.15rem; font-weight: 800; color: white;">Mogram</span>
                        <span style="font-size: 3rem; font-weight: 950; color: #22c55e; line-height: 1;">80%</span>
                    </div>
                    <div style="height: 16px; background: rgba(255,255,255,0.03); border-radius: 99px; position: relative; overflow: hidden;">
                        <div style="width: 80%; height: 100%; background: linear-gradient(90deg, #ff8c2d, #ff4b1f); border-radius: 99px;"></div>
                    </div>
                </div>

                <div style="opacity: 0.5;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 700;">
                        <span>Redes Vizinhas</span>
                        <span>50%</span>
                    </div>
                    <div style="height: 8px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden;">
                        <div style="width: 50%; height: 100%; background: #444; border-radius: 99px;"></div>
                    </div>
                </div>
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
