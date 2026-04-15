<footer class="site-footer">
    <div class="container">
        <div class="footer-top-cta">
            <div style="flex: 1;">
                <h2 style="font-size: 2rem; font-weight: 950; margin-bottom: 0.5rem; letter-spacing: -1px;">Pronto para mudar o jogo?</h2>
                <p style="color: #666; font-size: 1rem; font-weight: 500;">Junte-se a milhares de criadores que já estão faturando com liberdade total.</p>
            </div>
            <a href="{{ route('register') }}" class="footer-cta-btn">Começar Agora</a>
        </div>

        <div class="footer-grid">
            <div class="footer-brand">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 512 512">
                        <defs><linearGradient id="footerLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                        <rect width="512" height="512" rx="110" fill="url(#footerLogoGrad)" />
                        <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                    </svg>
                    <span style="font-size: 1.85rem; font-weight: 950; color: white; letter-spacing: -1.5px;">Mogram</span>
                </div>
                <p style="line-height: 1.8; color: #777; font-size: 0.95rem; margin-bottom: 2rem;">A plataforma definitva para criadores que buscam autonomia, monetização justa e conexão real com sua audiência.</p>
                
                <div style="display: flex; gap: 0.85rem;">
                    <a href="#" class="footer-social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33zM9.75 15.02V8.48L15.45 11.75l-5.7 3.27z"/></svg>
                    </a>
                    <a href="#" class="footer-social-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="footer-heading">Recursos</h4>
                <div class="footer-links">
                    <a href="#">Top Criadores</a>
                    <a href="{{ route('lives') }}">Lives Ativas</a>
                    <a href="#">Stories</a>
                    <a href="#">Marketplace</a>
                </div>
            </div>
            
            <div>
                <h4 class="footer-heading">Plataforma</h4>
                <div class="footer-links">
                    <a href="{{ route('login') }}">Entrar na Conta</a>
                    <a href="{{ route('register') }}">Parceiro Creator</a>
                    <a href="{{ route('creators') }}">Para Criadores</a>
                    <a href="#">Mogram Studio</a>
                    <a href="#">Central de Ajuda</a>
                </div>
            </div>
            
            <div>
                <h4 class="footer-heading">Jurídico</h4>
                <div class="footer-links">
                    <a href="{{ route('terms') }}">Termos de Uso</a>
                    <a href="{{ route('privacy') }}">Política de Privacidade</a>
                    <a href="#">Cookies</a>
                    <a href="#">Suporte Direto</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <p style="font-size: 0.85rem; color: #555; margin: 0;">&copy; 2026 Mogram Network. Todos os direitos reservados.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 8px; background: rgba(34, 197, 94, 0.05); padding: 4px 12px; border-radius: 99px; border: 1px solid rgba(34, 197, 94, 0.1);">
                    <span style="width: 6px; height: 6px; background: #22C55E; border-radius: 50%; box-shadow: 0 0 8px #22C55E;"></span>
                    <span style="color: #22C55E; font-weight: 800; font-size: 0.7rem; letter-spacing: 0.5px;">SISTEMA ONLINE</span>
                </div>
                <p style="font-size: 0.85rem; color: #555; margin: 0;">Feito para <strong>Criadores</strong>.</p>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        padding: 5rem 0 3rem;
        background: #08070e;
        border-top: 1px solid rgba(255,255,255,0.05);
        position: relative;
        overflow: hidden;
    }

    .site-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 1200px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 75, 31, 0.3), transparent);
    }

    .footer-top-cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 4rem;
        margin-bottom: 4rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        gap: 2rem;
        flex-wrap: wrap;
    }

    .footer-cta-btn {
        background: white;
        color: black;
        padding: 1.15rem 2.5rem;
        border-radius: 99px;
        font-weight: 900;
        text-decoration: none;
        font-size: 1rem;
        transition: 0.3s;
        box-shadow: 0 10px 30px rgba(255,255,255,0.1);
    }

    .footer-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255,255,255,0.2);
        background: #ff4b1f;
        color: white;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
    }

    .footer-social-link {
        background: rgba(255,255,255,0.04);
        color: #999;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.03);
    }

    .footer-social-link:hover {
        background: #ff4b1f;
        color: white;
        transform: translateY(-5px);
        border-color: #ff4b1f;
    }

    @media (min-width: 640px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .footer-grid {
            grid-template-columns: 2fr repeat(3, 1fr);
            gap: 5rem;
        }
    }

    .footer-heading {
        font-weight: 900;
        font-size: 1rem;
        color: white;
        margin-bottom: 1.75rem;
        letter-spacing: -0.5px;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .footer-links a {
        color: #777;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: 0.2s;
    }

    .footer-links a:hover {
        color: #ff4b1f;
        padding-left: 5px;
    }

    .footer-bottom {
        padding-top: 2.5rem;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
        text-align: center;
    }

    @media (min-width: 768px) {
        .footer-bottom {
            flex-direction: row;
            justify-content: space-between;
            text-align: left;
        }
    }
</style>
