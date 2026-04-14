    {{-- ===== SIDEBAR OVERLAY (mobile backdrop) ===== --}}
    <div class="sidebar-overlay" id="studio_mogram_overlay" onclick="closeStudioSidebar()"></div>

    {{-- ===== MOBILE TOP BAR ===== --}}
    <div class="mobile-top-bar mobile-only">
        {{-- Burger Button --}}
        <button class="burger-btn" id="studio_mobile_btn" onclick="toggleStudioSidebar()" aria-label="Toggle menu">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>

        {{-- Logo centered --}}
        <a href="{{ route('dashboard') }}" class="mobile-logo" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                <defs><linearGradient id="mobileLogoGradStudioRestored" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                <rect width="512" height="512" rx="100" fill="url(#mobileLogoGradStudioRestored)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
            <span class="grad-text" style="font-weight: 900; letter-spacing: -1px; font-size: 1.15rem;">Studio</span>
        </a>
        <div style="width: 44px;"></div>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="studio_mogram_sidebar">

        {{-- Mobile sidebar header --}}
        <div class="sidebar-mobile-header mobile-only">
            <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap: 10px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                    <defs><linearGradient id="sidebarMobGradStudioRestored" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#sidebarMobGradStudioRestored)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="grad-text" style="font-weight:900;font-size:1.25rem;letter-spacing:-0.5px;">Studio</span>
            </a>
            <button class="sidebar-close-btn" onclick="closeStudioSidebar()" aria-label="Close menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="sidebar-header desktop-only" style="display: flex; align-items: center; justify-content: center; padding: 1.25rem 0.75rem;">
            <a href="{{ route('dashboard') }}" class="sidebar-logo" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <defs><linearGradient id="studioLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#studioLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="grad-text" style="font-weight: 900; letter-spacing: -1px; font-size: 1.5rem;">Studio</span>
            </a>
        </div>
            
        {{-- User Info --}}
        <div style="padding: 0 0.625rem; margin-bottom: 0.5rem;">
            <a href="{{ route('studio.settings') }}" style="display: flex; align-items: center; gap: 12px; padding: 0.75rem; border-radius: 12px; background: rgba(255,255,255,0.03); text-decoration: none; border: 1px solid rgba(255,255,255,0.05);">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #3390ec; flex-shrink:0;">
                @else
                    <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 32px; height: 32px; border-radius: 50%; flex-shrink:0;">
                @endif
                <div class="studio-user-details" style="flex: 1; min-width: 0;">
                    <p style="font-size: 13px; font-weight: 700; color: white; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
                    <p style="font-size: 10px; color: var(--text-muted); margin: 0;">@<span>{{ Auth::user()->username }}</span></p>
                </div>
            </a>
        </div>

        <nav style="display: flex; flex-direction: column; gap: 0.35rem; flex: 1; padding: 0 0.625rem;">
            @php
                $superAdmins = ['bomboadmar@gmail.com', 'criptovida@gmail.com'];
            @endphp
            @if(auth()->user()->role === 'admin' || in_array(auth()->user()->email, $superAdmins))
                <a href="{{ route('admin.dashboard') }}" class="menu-item sidebar-nav-item" style="color: #3390ec; background: rgba(51, 144, 236, 0.08); margin-bottom: 0.5rem; border: 1.5px solid rgba(51, 144, 236, 0.15);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Painel Admin</span>
                </a>
            @endif

            <a href="{{ route('dashboard') }}" class="menu-item sidebar-nav-item" style="color: #a855f7; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 0.5rem;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Voltar ao Feed</span>
            </a>

            <a href="{{ route('studio.dashboard') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.dashboard') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h7v7H3z"/><path d="M14 3h7v7h-7z"/><path d="M14 14h7v7h-7z"/><path d="M3 14h7v7H3z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('studio.content') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.content') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span>Conteúdo</span>
            </a>
            <a href="{{ route('studio.analytics') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.analytics') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span>Analytics</span>
            </a>
            <a href="{{ route('studio.finance') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.finance') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span>Financeiro</span>
            </a>
            <a href="{{ route('support.index') }}" class="menu-item sidebar-nav-item {{ Route::is('support.*') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><circle cx="12" cy="12" r="1"/></svg>
                <span>Suporte</span>
            </a>
            <a href="{{ route('studio.settings') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.settings') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span>Configurações</span>
            </a>

            <div class="sidebar-divider desktop-only"></div>
        </nav>

        <div class="sidebar-user" style="padding: 1rem 0.625rem; flex-shrink: 0; border-top: 1px solid rgba(255,255,255,0.03);">
            <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                <div style="width: 8px; height: 8px; background: #3390ec; border-radius: 50%; box-shadow: 0 0 10px #3390ec;"></div>
                <div>
                    <p style="font-size: 10px; color: var(--text-muted); text-transform: none; font-weight: 800; margin: 0;">Status</p>
                    <p style="font-size: 11px; color: white; font-weight: 700; margin: 0;">Verificado</p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="menu-item" style="width: 100%; background: transparent; border: none; color: #ef4444; padding: 0.875rem 1rem; cursor: pointer; justify-content: flex-start; gap: 1rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span class="logout-text">Sair</span>
                </button>
            </form>
        </div>
    </aside>

<script>
function toggleStudioSidebar() {
    const sidebar  = document.getElementById('studio_mogram_sidebar');
    const overlay  = document.getElementById('studio_mogram_overlay');
    const burgerBtn = document.getElementById('studio_mobile_btn');
    if (!sidebar || !overlay) return;
    const isOpen = sidebar.classList.contains('active');
    if (isOpen) {
        closeStudioSidebar();
    } else {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        if (burgerBtn) burgerBtn.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeStudioSidebar() {
    const sidebar   = document.getElementById('studio_mogram_sidebar');
    const overlay   = document.getElementById('studio_mogram_overlay');
    const burgerBtn = document.getElementById('studio_mobile_btn');
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    if (burgerBtn) burgerBtn.classList.remove('open');
    document.body.style.overflow = '';
}

function toggleSidebarCollapse() {
    const sidebar = document.getElementById('studio_mogram_sidebar') || document.getElementById('mogram_sidebar');
    if (!sidebar) return;
    const isCollapsed = sidebar.classList.toggle('collapsed');
    localStorage.setItem('sidebar_collapsed', isCollapsed);
    if (isCollapsed) {
        document.body.classList.add('sidebar-is-collapsed');
    } else {
        document.body.classList.remove('sidebar-is-collapsed');
    }
}

// Init
(function() {
    const sidebar = document.getElementById('studio_mogram_sidebar') || document.getElementById('mogram_sidebar');
    if (!sidebar) return;
    
    // Force expanded state on Studio to ensure texts are visible
    sidebar.classList.remove('collapsed');
    document.body.classList.remove('sidebar-is-collapsed');
    
    // Clear stored collapsed state to prevent it from coming back
    if (sidebar.id === 'studio_mogram_sidebar') {
        localStorage.setItem('sidebar_collapsed', 'false');
    }
})();
</script>
