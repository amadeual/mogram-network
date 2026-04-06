{{-- ===== SIDEBAR OVERLAY (mobile backdrop) ===== --}}
<div class="sidebar-overlay" id="studio_sidebar_overlay" onclick="closeStudioSidebar()"></div>

{{-- ===== MOBILE TOP BAR ===== --}}
<div class="mobile-top-bar mobile-only" id="studio_mobile_topbar">
    {{-- Burger Button --}}
    <button class="burger-btn" id="studio_mobile_btn" onclick="toggleStudioSidebar()" aria-label="Toggle menu">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </button>

    {{-- Logo centered --}}
    <div class="mobile-logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
            <defs><linearGradient id="studioMobileLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
            <rect width="512" height="512" rx="100" fill="url(#studioMobileLogoGrad)" />
            <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
        </svg>
        <span>Mogram Studio</span>
    </div>

    <div style="width: 44px;"></div>
</div>

<aside class="sidebar" id="studio_sidebar" style="background: #0f111a; border-right: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column;">

    {{-- Mobile sidebar header (shown only inside sidebar on mobile) --}}
    <div class="sidebar-mobile-header mobile-only">
        <div style="display:flex; align-items:center; gap: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                <defs><linearGradient id="studioSidebarMobGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                <rect width="512" height="512" rx="100" fill="url(#studioSidebarMobGrad)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
            <span style="font-weight:900;font-size:1.25rem;color:white;letter-spacing:-0.5px;">Studio</span>
        </div>
        <button class="sidebar-close-btn" onclick="closeStudioSidebar()" aria-label="Close menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- User Profile Header (Desktop) --}}
    <a href="{{ route('studio.settings') }}" class="desktop-only" style="text-decoration: none; padding: 1.25rem 1.25rem; display: flex; align-items: center; gap: 0.875rem; border-bottom: 1px solid rgba(255,255,255,0.04); transition: 0.3s; flex-shrink: 0;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
        @if(Auth::user()->avatar)
            <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #3390ec;">
        @else
            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
        @endif
        <div>
            <h4 style="font-size: 15px; font-weight: 700; color: white; margin: 0;">{{ Auth::user()->name }}</h4>
            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">@ {{ Auth::user()->username }}</p>
        </div>
    </a>
    
    <nav style="display: flex; flex-direction: column; gap: 0.2rem; padding: 0.75rem 0.625rem; flex: 1;">
        <a href="{{ route('dashboard') }}" class="sidebar-nav-item menu-item" style="padding: 0.875rem 1rem; color: #a855f7; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 0.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Voltar ao Feed
        </a>
        <a href="{{ route('studio.dashboard') }}" class="sidebar-nav-item menu-item {{ Route::is('studio.dashboard') ? 'active' : '' }}" style="padding: 0.875rem 1rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h7v7H3z"/><path d="M14 3h7v7h-7z"/><path d="M14 14h7v7h-7z"/><path d="M3 14h7v7H3z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('studio.content') }}" class="sidebar-nav-item menu-item {{ Route::is('studio.content') ? 'active' : '' }}" style="padding: 0.875rem 1rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Conteúdo
        </a>
        <a href="{{ route('studio.analytics') }}" class="sidebar-nav-item menu-item {{ Route::is('studio.analytics') ? 'active' : '' }}" style="padding: 0.875rem 1rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Analytics
        </a>
        <a href="{{ route('studio.finance') }}" class="sidebar-nav-item menu-item {{ Route::is('studio.finance') ? 'active' : '' }}" style="padding: 0.875rem 1rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Financeiro
        </a>
        <a href="{{ route('studio.settings') }}" class="sidebar-nav-item menu-item {{ Route::is('studio.settings') ? 'active' : '' }}" style="padding: 0.65rem 0.875rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Configurações
        </a>
    </nav>

    <div style="margin-top: auto; padding: 1rem 0.625rem; flex-shrink: 0;">
        <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
            <div style="width: 8px; height: 8px; background: #3390ec; border-radius: 50%; box-shadow: 0 0 10px #3390ec;"></div>
            <div>
                <p style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 800; margin: 0;">Status da conta</p>
                <p style="font-size: 11px; color: white; font-weight: 700; margin: 0;">Verificado</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn" style="width: 100%; background: transparent; border: none; opacity: 0.6; color: #ef4444; padding: 0.875rem 1rem; display: flex; align-items: center; gap: 1rem; font-weight: 700; cursor: pointer;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sair
            </button>
        </form>
    </div>
</aside>

<style>
    .menu-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 1.25rem;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        transition: 0.2s;
    }
    .menu-item:hover {
        background: rgba(255,255,255,0.03);
        color: white;
    }
    .menu-item.active {
        background: rgba(51, 144, 236, 0.1);
        color: #3390ec;
    }
    .logout-btn:hover {
        opacity: 1 !important;
        background: rgba(239, 68, 68, 0.05);
        border-radius: 12px;
    }
</style>
<script>
function toggleStudioSidebar() {
    const sidebar  = document.getElementById('studio_sidebar');
    const overlay  = document.getElementById('studio_sidebar_overlay');
    const burgerBtn = document.getElementById('studio_mobile_btn');
    const isOpen   = sidebar.classList.contains('active');

    if (isOpen) {
        closeStudioSidebar();
    } else {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        burgerBtn.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeStudioSidebar() {
    const sidebar   = document.getElementById('studio_sidebar');
    const overlay   = document.getElementById('studio_sidebar_overlay');
    const burgerBtn = document.getElementById('studio_mobile_btn');
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    burgerBtn.classList.remove('open');
    document.body.style.overflow = '';
}

// Swipe-to-close gesture
(function() {
    let startX = null;
    const sidebar = document.getElementById('studio_sidebar');
    if (!sidebar) return;

    sidebar.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    }, { passive: true });

    sidebar.addEventListener('touchend', function(e) {
        if (startX === null) return;
        const deltaX = e.changedTouches[0].clientX - startX;
        if (deltaX < -60) { // swipe left to close
            closeStudioSidebar();
        }
        startX = null;
    }, { passive: true });
})();
</script>
