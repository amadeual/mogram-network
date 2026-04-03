@extends('layouts.app')

@section('title', 'Mogram - Monetize sua influência sem limites')

@section('content')
@include('partials.navbar')

<header class="hero" style="padding: 4rem 0 8rem;">
    <div class="container" style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 4rem; align-items: center;">
        <div class="hero-content">
            <div style="display: inline-flex; align-items: center; gap: 8px; padding: 0.4rem 1rem; background: rgba(51, 144, 236, 0.1); border: 1px solid rgba(51, 144, 236, 0.2); border-radius: 99px; margin-bottom: 2.5rem;">
                <span style="width: 8px; height: 8px; background: #3390ec; border-radius: 50%; display: block;"></span>
                <span style="font-size: 10px; font-weight: 800; color: #3390ec; text-transform: uppercase; letter-spacing: 1px;">Nova Plataforma</span>
            </div>
            <h1 style="font-size: clamp(3rem, 6vw, 5.5rem); line-height: 1; font-weight: 900; letter-spacing: -3px; margin-bottom: 2rem;">
                Monetize sua <span class="grad-text">influência</span> sem limites.
            </h1>
            <p class="text-muted" style="font-size: 1.125rem; max-width: 550px; line-height: 1.6; margin-bottom: 3.5rem;">
                A plataforma definitiva que une o social do Instagram com a rentabilidade do Patreon. Comunidade, conteúdo e vendas em um só lugar.
            </p>
            
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 3rem;">
                <a href="{{ route('register') }}" class="mogram-btn-primary" style="padding: 1.25rem 2.5rem; font-size: 1rem; border-radius: 99px;">
                    Criar conta grátis
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#" class="mogram-btn-social" style="padding: 1.25rem 2.5rem; background: transparent; border-radius: 99px; border-color: rgba(255,255,255,0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                    Ver demo
                </a>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="flex" style="margin-left: 0.5rem;">
                    <img src="{{ asset('images/creators/ana.png') }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #000; object-fit: cover;">
                    <img src="{{ asset('images/creators/marcos.png') }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #000; margin-left: -12px; object-fit: cover;">
                    <img src="{{ asset('images/creators/julia.png') }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #000; margin-left: -12px; object-fit: cover;">
                </div>
                <p class="text-xs font-bold text-muted" style="text-transform: uppercase; letter-spacing: 1px;">Junte-se a +10.000 Criadores</p>
            </div>
        </div>
        
        <div class="hero-visual" style="position: relative;">
            <div style="position: relative; z-index: 2;">
                <img src="{{ asset('images/mogram_mockup.png') }}" alt="Mogram Mobile App" style="width: 100%; max-width: 500px; border-radius: 40px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8);">
                
                <div style="position: absolute; bottom: 10%; right: -5%; background: rgba(14, 14, 14, 0.85); backdrop-filter: blur(20px); padding: 1.5rem; border-radius: 20px; border: 1px solid var(--border-gray); z-index: 5;">
                    <p class="text-xs text-muted font-bold" style="text-transform: uppercase;">Receita Mensal</p>
                    <p style="font-size: 1.5rem; font-weight: 900; color: white; margin: 0.25rem 0;">R$ 14.250,00</p>
                    <div class="flex items-center gap-2">
                        <span style="display: block; width: 45px; height: 4px; background: #22C55E; border-radius: 2px;"></span>
                        <span style="color: #22C55E; font-size: 12px; font-weight: 800;">+12%</span>
                    </div>
                </div>
            </div>
            <!-- Decorative blur bg -->
            <div style="position: absolute; top: 10%; left: 10%; width: 80%; height: 80%; background: var(--primary-blue); opacity: 0.15; filter: blur(100px); z-index: 0;"></div>
        </div>
    </div>
</header>

<section class="brands" style="padding: 2rem 0; background: rgba(255,255,255,0.02); border-y: 1px solid var(--border-gray);">
    <div class="container" style="display: flex; align-items: center; justify-content: center; gap: 3rem; flex-wrap: wrap;">
        <span class="text-xs font-bold text-muted" style="text-transform: uppercase; letter-spacing: 2px;">Powered by:</span>
        <div style="display: flex; align-items: center; gap: 3rem; opacity: 0.5; filter: grayscale(1);">
            <span style="font-weight: 900; font-size: 1.25rem; letter-spacing: -0.5px;">Cloudflare</span>
            <span style="font-weight: 900; font-size: 1.25rem; letter-spacing: -0.5px;">Abacatepay</span>
            <span style="font-weight: 900; font-size: 1.25rem; letter-spacing: -0.5px;">Stripe</span>
            <span style="font-weight: 900; font-size: 1.25rem; letter-spacing: -0.5px;">AWS</span>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div style="text-align: center;">
            <h2 class="section-title">Poder para os Criadores</h2>
            <p class="section-subtitle">Ferramentas exclusivas desenhadas para maximizar seus ganhos e engajamento sem depender do algoritmo.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Feed Exclusivo</h3>
                <p class="text-muted">Publique fotos, vídeos e áudios que apenas seus assinantes podem acessar. Tenha domínio total do seu nicho.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Assinaturas Recorrentes</h3>
                <p class="text-muted">Crie planos mensais de suporte e ofereça benefícios únicos. Transforme seguidores em uma base fiel de apoio.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l9.78-9.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Lives & Presentes</h3>
                <p class="text-muted">Faça transmissões ao vivo interativas e receba incentivos em tempo real dos seus maiores fãs em todo o mundo.</p>
            </div>
        </div>
    </div>
</section>

<section class="steps" style="background: rgba(255,255,255,0.01);">
    <div class="container">
        <div style="text-align: center;">
            <div style="font-size: 10px; font-weight: 800; color: #3390ec; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1.5rem;">Passo a passo</div>
            <h2 class="section-title">Do cadastro ao saque em 3 passos</h2>
            <p class="section-subtitle">Simplificamos tudo para você focar no que importa: criar conteúdo incrível e interagir com sua rede.</p>
        </div>

        <div class="steps-grid">
            <div class="step-item">
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    <div class="step-number">1</div>
                </div>
                <h4 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.75rem;">Crie sua conta</h4>
                <p class="text-muted text-sm">Cadastre-se gratuitamente, valide seu perfil e defina sua identidade visual na rede.</p>
            </div>
            <div class="step-item">
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <div class="step-number">2</div>
                </div>
                <h4 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.75rem;">Poste conteúdo</h4>
                <p class="text-muted text-sm">Suba seus conteúdos exclusivos, defina os valores de acesso e comece a convidar seus fãs.</p>
            </div>
            <div class="step-item">
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    <div class="step-number">3</div>
                </div>
                <h4 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.75rem;">Receba seus ganhos</h4>
                <p class="text-muted text-sm">Monitore seu saldo em tempo real e realize saques via PIX com rapidez e total segurança.</p>
            </div>
        </div>
    </div>
</section>

<section class="simulator">
    <div class="container">
        <div class="simulator-card">
            <div class="simulator-controls">
                <h2 style="font-size: 2.5rem; font-weight: 850; margin-bottom: 1rem;">Simule seu potencial</h2>
                <p class="text-muted" style="margin-bottom: 3.5rem;">Arraste os seletores para estimar quanto você pode lucrar mensalmente no Mogram.</p>
                
                <div class="control-group">
                    <div class="flex justify-between items-center">
                        <label class="font-bold text-sm">Seguidores no Instagram</label>
                        <span id="followers-val" style="color: var(--primary-blue); font-weight: 900; font-size: 1.5rem;">50.000</span>
                    </div>
                    <input type="range" id="followers" min="1000" max="1000000" value="50000" class="range-slider">
                </div>

                <div class="control-group">
                    <div class="flex justify-between items-center">
                        <label class="font-bold text-sm">Taxa de Conversão</label>
                        <span id="conversion-val" style="color: var(--primary-blue); font-weight: 900; font-size: 1.5rem;">2%</span>
                    </div>
                    <input type="range" id="conversion" min="1" max="20" value="2" class="range-slider">
                </div>
            </div>
            
            <div class="simulator-result" style="text-align: center; background: rgba(255,255,255,0.03); padding: 3rem; border-radius: 24px; border: 1px solid var(--border-gray);">
                <p class="text-xs font-bold text-muted" style="text-transform: uppercase; letter-spacing: 2px;">Renda Mensal Estimada</p>
                <h2 id="total-earnings" style="font-size: 3.5rem; font-weight: 900; margin: 1rem 0; letter-spacing: -2px;">R$ 14.900</h2>
                <p id="wage-comparison" style="color: #22C55E; font-weight: 800; font-size: 14px; margin-bottom: 2rem;">Isso é 10x o salário mínimo!</p>
                <a href="{{ route('register') }}" class="mogram-btn-primary mogram-btn-full" style="padding: 1.25rem;">Começar agora</a>
            </div>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <div style="text-align: center;">
            <h2 class="section-title">Quem já está lucrando</h2>
            <p class="section-subtitle">Histórias reais de criadores que construíram seus próprios negócios na nossa plataforma.</p>
        </div>

        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="user-header">
                    <img src="{{ asset('images/creators/ana.png') }}" class="user-avatar" style="object-fit: cover;">
                    <div>
                        <h4 class="font-bold">Ana Silva</h4>
                        <p class="text-xs text-blue">@anasilvafit</p>
                    </div>
                </div>
                <p class="text-sm text-light" style="font-style: italic; line-height: 1.7;">"Criei meu feed exclusivo aqui e finalmente tenho liberdade financeira para focar no meu conteúdo fitness sem depender de patrocinadores externos."</p>
                <div class="earning-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    + R$ 12.500 /mês
                </div>
            </div>
            <div class="testimonial-card">
                <div class="user-header">
                    <img src="{{ asset('images/creators/marcos.png') }}" class="user-avatar" style="object-fit: cover;">
                    <div>
                        <h4 class="font-bold">Marcos Gamer</h4>
                        <p class="text-xs text-blue">@marcosplay</p>
                    </div>
                </div>
                <p class="text-sm text-light" style="font-style: italic; line-height: 1.7;">"A facilidade do suporte via recorrência me permitiu investir em novos equipamentos. Minha comunidade é muito mais engajada no Mogram."</p>
                <div class="earning-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    + R$ 8.900 /mês
                </div>
            </div>
            <div class="testimonial-card">
                <div class="user-header">
                    <img src="{{ asset('images/creators/julia.png') }}" class="user-avatar" style="object-fit: cover;">
                    <div>
                        <h4 class="font-bold">Julia Tech</h4>
                        <p class="text-xs text-blue">@juliatech</p>
                    </div>
                </div>
                <p class="text-sm text-light" style="font-style: italic; line-height: 1.7;">"O sistema de presentes nas lives é transformador. Sinto que meu tempo é verdadeiramente valorizado pelos meus seguidores."</p>
                <div class="earning-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    + R$ 15.200 /mês
                </div>
            </div>
        </div>
    </div>
</section>

<section class="final" style="padding: 10rem 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #3390ec 0%, #171717 100%); padding: 5rem; border-radius: 40px; display: flex; flex-direction: column; align-items: center; text-align: center; border: 1px solid rgba(51, 144, 236, 0.3);">
            <h2 style="font-size: clamp(2rem, 5vw, 4rem); font-weight: 900; line-height: 1; margin-bottom: 1.5rem;">Pronto para viver da <br> sua paixão?</h2>
            <p class="text-white" style="font-size: 1.25rem; opacity: 0.8; max-width: 600px; margin-bottom: 3.5rem;">Junte-se à revolução dos criadores. Configure seu perfil em menos de 5 minutos e mude de vida hoje.</p>
            <a href="{{ route('register') }}" style="background: white; color: black; padding: 1.5rem 4rem; border-radius: 99px; font-weight: 800; font-size: 1.125rem;">Começar Agora</a>
            <p class="text-xs font-bold" style="text-transform: uppercase; letter-spacing: 2px; margin-top: 1.5rem; opacity: 0.6;">Vem ser Mogram!</p>
        </div>
    </div>
</section>

<footer style="padding: 6rem 0; border-top: 1px solid var(--border-gray);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 4rem; margin-bottom: 6rem;">
            <div>
                <div style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1.5rem;">Mogram</div>
                <p class="text-muted text-sm" style="line-height: 1.6; max-width: 250px;">Potencializando criadores de conteúdo ao redor do mundo a construir negócios sustentáveis.</p>
                <div class="flex gap-4" style="margin-top: 2rem;">
                    <a href="#" class="text-muted" title="Facebook">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" class="text-muted" title="Instagram">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="text-muted" title="LinkedIn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.454C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-sm" style="margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Plataforma</h4>
                <div class="flex" style="flex-direction: column; gap: 0.75rem;">
                    <a href="#" class="text-muted text-sm">Funcionalidades</a>
                    <a href="#" class="text-muted text-sm">Preços</a>
                    <a href="#" class="text-muted text-sm">Feedbacks</a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-sm" style="margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Privacidade</h4>
                <div class="flex" style="flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('terms') }}" class="text-muted text-sm">Termos de Uso</a>
                    <a href="{{ route('privacy') }}" class="text-muted text-sm">Privacidade</a>
                    <a href="#" class="text-muted text-sm">Suporte</a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-sm" style="margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Status</h4>
                <div class="flex items-center gap-2">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #22C55E;"></span>
                    <span class="text-xs font-bold" style="color: #22C55E;">Sistemas Operacionais</span>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center" style="padding-top: 3rem; border-top: 1px solid var(--border-gray);">
            <p class="text-xs text-muted">&copy; 2026 Mogram Network. Todos os direitos reservados.</p>
            <div class="flex gap-4">
                <a href="#" class="text-xs text-muted">Aviso Legal</a>
                <a href="#" class="text-xs text-muted">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<script>
    const followersIn = document.getElementById('followers');
    const conversionIn = document.getElementById('conversion');
    const followersVal = document.getElementById('followers-val');
    const conversionVal = document.getElementById('conversion-val');
    const totalEarnings = document.getElementById('total-earnings');
    const wageComparison = document.getElementById('wage-comparison');

    function updateSimulator() {
        const followers = parseInt(followersIn.value);
        const conversion = parseInt(conversionIn.value);
        
        followersVal.innerText = followers >= 1000000 ? (followers/1000000).toFixed(1) + 'M' : followers.toLocaleString();
        conversionVal.innerText = conversion + '%';
        
        // Calculation: (Followers * Rate) * Average Ticket (R$ 15 approx)
        const earnings = Math.floor((followers * (conversion / 100)) * 14.9);
        totalEarnings.innerText = 'R$ ' + earnings.toLocaleString('pt-BR', { minimumFractionDigits: 0 });
        
        const ratio = Math.floor(earnings / 1412);
        if (ratio > 1) {
            wageComparison.innerText = `Isso é ${ratio}x o salário mínimo!`;
        } else {
            wageComparison.innerText = `Um excelente complemento de renda!`;
        }
    }

    followersIn.addEventListener('input', updateSimulator);
    conversionIn.addEventListener('input', updateSimulator);
    updateSimulator();
</script>
@endsection
