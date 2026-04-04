<footer style="padding: 6rem 0; background: #0b0a15; border-top: 1px solid rgba(255,255,255,0.02);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1.5fr repeat(3, 1fr); gap: 4rem; margin-bottom: 6rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
                        <defs><linearGradient id="footerLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                        <rect width="512" height="512" rx="100" fill="url(#footerLogoGrad)" />
                        <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                    </svg>
                    <span style="font-size: 1.75rem; font-weight: 900; color: white; letter-spacing: -1px;">Mogram</span>
                </div>
                <p class="text-muted" style="line-height: 1.8; max-width: 300px; font-size: 0.9rem;">Potencializando criadores de conteúdo a construir impérios digitais com liberdade e lucro real.</p>
                
                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="#" style="background: rgba(255,255,255,0.03); color: white; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33zM9.75 15.02V8.48L15.45 11.75l-5.7 3.27z"/></svg>
                    </a>
                    <a href="#" style="background: rgba(255,255,255,0.03); color: white; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 style="font-weight: 900; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: white; margin-bottom: 2rem;">Explorar</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="#" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Top Criadores</a>
                    <a href="#" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Próximas Lives</a>
                    <a href="#" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Categorias</a>
                </div>
            </div>
            
            <div>
                <h4 style="font-weight: 900; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: white; margin-bottom: 2rem;">Plataforma</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="{{ route('login') }}" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Entrar</a>
                    <a href="{{ route('register') }}" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Criar Conta</a>
                    <a href="#" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Central de Ajuda</a>
                </div>
            </div>
            
            <div>
                <h4 style="font-weight: 900; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: white; margin-bottom: 2rem;">Privacidade</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="{{ route('terms') }}" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Termos de Uso</a>
                    <a href="{{ route('privacy') }}" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Privacidade</a>
                    <a href="#" class="text-muted" style="text-decoration: none; font-size: 0.9rem;">Suporte</a>
                </div>
            </div>
        </div>
        
        <div style="padding-top: 3rem; border-top: 1px solid rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: center;">
            <p class="text-muted" style="font-size: 0.8rem;">&copy; 2026 Mogram Network. Made with passion for creators.</p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #22C55E; font-weight: 900; font-size: 0.75rem;">
                <span style="width: 8px; height: 8px; background: #22C55E; border-radius: 50%;"></span>
                SISTEMAS OPERACIONAIS
            </div>
        </div>
    </div>
</footer>
