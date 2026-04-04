<div class="nav-container" style="position: sticky; top: 0; z-index: 1000; background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-gray);">
    <nav class="container flex justify-between items-center" style="height: 64px;">
        <div class="logo">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <defs><linearGradient id="navLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#navLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="text-xl font-black grad-text" style="letter-spacing: -1px;">MOGRAM</span>
            </a>
        </div>
        
        <!-- Desktop Links - only visible on desktop -->
        <div class="nav-links-desktop">
            <a href="#" class="text-light text-sm font-semibold">Explorar Feed</a>
            <a href="#" class="text-light text-sm font-semibold">Explorar Criadores</a>
            <a href="#" class="text-light text-sm font-semibold">Ganhos</a>
        </div>
        
        <div class="nav-actions flex items-center gap-3">
            @auth
                <div class="nav-dropdown-wrapper">
                    <div class="flex items-center gap-2 cursor-pointer">
                        @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--primary-blue); object-fit: cover;">
                        @else
                            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}&backgroundColor=3390ec" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--border-gray);">
                        @endif
                        <span class="text-white text-sm font-bold nav-user-name">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="opacity: 0.5;"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                    
                    <div class="nav-dropdown">
                        <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                        <a href="{{ route('studio.dashboard') }}" class="dropdown-item" style="color: var(--primary-blue);">Mogram Studio</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #ef4444; width: 100%; text-align: left;">Sair</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-white text-sm font-bold nav-login-desktop">Entrar</a>
                <a href="{{ route('register') }}" class="mogram-btn-primary" style="padding: 0.6rem 1.2rem; font-size: 13px;">Começar</a>
            @endauth

            <!-- Mobile Hamburger Btn - ONLY visible on mobile -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                <svg id="menu-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg id="menu-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Side Menu Overlay -->
    <div id="mobile-menu-overlay" class="mobile-menu-overlay">
        <div class="mobile-menu-content">
            <a href="#" class="mobile-menu-link">Explorar Feed</a>
            <a href="#" class="mobile-menu-link">Explorar Criadores</a>
            <a href="#" class="mobile-menu-link">Ganhos</a>
            <div class="dropdown-divider" style="margin: 1.5rem 0;"></div>
            @guest
                <a href="{{ route('login') }}" class="mobile-menu-link" style="color: var(--primary-blue);">Entrar</a>
            @endguest
        </div>
    </div>
</div>

<!-- Mobile Bottom Navigation Bar -->
<nav class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="bottom-nav-item active">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Início</span>
    </a>
    <a href="#" class="bottom-nav-item">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <span>Explorar</span>
    </a>
    <a href="{{ route('lives') }}" class="bottom-nav-item bottom-nav-live">
        <div class="bottom-nav-live-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <span>Live</span>
    </a>
    @auth
    <a href="{{ route('dashboard') }}" class="bottom-nav-item">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Perfil</span>
    </a>
    @else
    <a href="{{ route('login') }}" class="bottom-nav-item">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        <span>Entrar</span>
    </a>
    @endauth
</nav>

<script>
    function toggleMobileMenu() {
        const overlay = document.getElementById('mobile-menu-overlay');
        const openIcon = document.getElementById('menu-icon-open');
        const closeIcon = document.getElementById('menu-icon-close');
        
        if (overlay.classList.contains('active')) {
            overlay.classList.remove('active');
            openIcon.style.display = 'block';
            closeIcon.style.display = 'none';
            document.body.style.overflow = 'auto';
        } else {
            overlay.classList.add('active');
            openIcon.style.display = 'none';
            closeIcon.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }
</script>
