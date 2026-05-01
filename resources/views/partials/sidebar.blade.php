    {{-- ===== SIDEBAR OVERLAY (mobile backdrop) ===== --}}
    <div class="sidebar-overlay" id="mogram_sidebar_overlay" onclick="closeMogramSidebar()"></div>

    {{-- ===== MOBILE TOP BAR ===== --}}
    <div class="mobile-top-bar mobile-only" id="mogram_mobile_topbar">
        {{-- Burger Button --}}
        <button class="burger-btn" id="mogram_mobile_btn" onclick="toggleMogramSidebar()" aria-label="Toggle menu">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>

        {{-- Logo centered --}}
        <a href="{{ route('dashboard') }}" class="mobile-logo" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                <defs><linearGradient id="mobileLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                <rect width="512" height="512" rx="100" fill="url(#mobileLogoGrad)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
            <span class="grad-text" style="font-weight: 900; letter-spacing: -1px; font-size: 1.15rem;">Mogram</span>
        </a>

        {{-- Notification shortcut --}}
        @auth
        <div class="notif-bell" style="width: 44px; display:flex; justify-content:center; cursor:pointer;" onclick="toggleNotifs()">
            <div class="notif-badge" style="width:8px;height:8px;background:#3390ec;border-radius:50%;box-shadow:0 0 8px #3390ec; display: {{ auth()->user()->unreadNotifications->count() > 0 ? 'block' : 'none' }};"></div>
        </div>
        @endauth
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="mogram_sidebar">

        <div class="sidebar-header desktop-only" style="display: flex; align-items: center; padding: 0.5rem 0.75rem 1.0rem;">
            <a href="{{ route('dashboard') }}" class="sidebar-logo" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <defs><linearGradient id="sidebarLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#sidebarLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="grad-text" style="font-weight: 900; letter-spacing: -1px; font-size: 1.5rem;">Mogram</span>
            </a>
        </div>

        <nav style="display: flex; flex-direction: column; gap: 0.35rem; flex: 1;">
            <a href="{{ route('dashboard') }}" class="menu-item sidebar-nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Home</span>
            </a>
            <a href="{{ route('stories') }}" class="menu-item sidebar-nav-item {{ Route::is('stories') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Stories</span>
            </a>
            <a href="{{ route('studio.create') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.create') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <span>Criar</span>
            </a>
            <a href="{{ route('lives') }}" class="menu-item sidebar-nav-item {{ Route::is('lives') || Route::is('live.*') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                <span>Lives</span>
            </a>
            @php
                $unreadChatsCount = 0;
                if (Auth::check()) {
                    $unreadChatsCount = \App\Models\Message::where('receiver_id', Auth::id())
                        ->where('is_read', false)
                        ->distinct('sender_id')
                        ->count('sender_id');
                }
            @endphp
            <a href="{{ route('chat.index') }}" class="menu-item sidebar-nav-item {{ Route::is('chat.*') ? 'active' : '' }}">
                <div style="position: relative; display: flex; align-items: center;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    @if($unreadChatsCount > 0)
                        <span style="position: absolute; top: -6px; right: -8px; background: #ef4444; color: white; font-size: 8px; font-weight: 900; min-width: 15px; height: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1.5px solid #0b0a15; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3); z-index: 10;">
                            {{ $unreadChatsCount }}
                        </span>
                    @endif
                </div>
                <span>Chat</span>
            </a>
            <a href="{{ route('purchases.index') }}" class="menu-item sidebar-nav-item {{ Route::is('purchases.*') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span>Minhas Compras</span>
            </a>
            <a href="{{ route('wallet.index') }}" class="menu-item sidebar-nav-item {{ Route::is('wallet.*') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                <span>Carteira</span>
            </a>
            <a href="{{ route('communities.explore') }}" class="menu-item sidebar-nav-item {{ Route::is('communities.explore') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Comunidades</span>
            </a>
            <a href="{{ route('support.index') }}" class="menu-item sidebar-nav-item {{ Route::is('support.*') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><circle cx="12" cy="12" r="1"/></svg>
                <span>Suporte</span>
            </a>
            
            <div class="sidebar-divider mobile-only"></div>
            <a href="{{ route('studio.dashboard') }}" class="menu-item sidebar-nav-item" style="color: #3390ec;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span>Mogram Studio</span>
            </a>

            <div class="sidebar-divider desktop-only"></div>
        </nav>

        @auth
        <div class="sidebar-user">
            @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #3390ec; flex-shrink:0;">
            @else
                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 38px; height: 38px; border-radius: 50%; flex-shrink:0;">
            @endif
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 13px; font-weight: 700; color: white; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">@<span>{{ Auth::user()->username }}</span></p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
        @else
        <div class="sidebar-user" style="justify-content: center; gap: 0.75rem;">
            <a href="{{ route('login') }}" class="mogram-btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 800; flex: 1; text-align: center;">Entrar</a>
        </div>
        @endauth
    </aside>

<script>
function toggleMogramSidebar() {
    const sidebar  = document.getElementById('mogram_sidebar');
    const overlay  = document.getElementById('mogram_sidebar_overlay');
    const burgerBtn = document.getElementById('mogram_mobile_btn');
    if (!sidebar || !overlay) return;
    const isOpen = sidebar.classList.contains('active');
    if (isOpen) {
        closeMogramSidebar();
    } else {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        if (burgerBtn) burgerBtn.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeMogramSidebar() {
    const sidebar   = document.getElementById('mogram_sidebar');
    const overlay   = document.getElementById('mogram_sidebar_overlay');
    const burgerBtn = document.getElementById('mogram_mobile_btn');
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    if (burgerBtn) burgerBtn.classList.remove('open');
    document.body.style.overflow = '';
}

function toggleSidebarCollapse() {
    const sidebar = document.getElementById('mogram_sidebar');
    if (!sidebar) return;
    const isCollapsed = sidebar.classList.toggle('collapsed');
    localStorage.setItem('sidebar_collapsed', isCollapsed);
    if (isCollapsed) {
        document.body.classList.add('sidebar-is-collapsed');
    } else {
        document.body.classList.remove('sidebar-is-collapsed');
    }
}

// Init — sidebar always expanded on desktop
(function() {
    // On desktop, never auto-collapse
    if (window.innerWidth > 991) {
        const sidebar = document.getElementById('mogram_sidebar');
        if (sidebar) sidebar.classList.remove('collapsed');
        document.body.classList.remove('sidebar-is-collapsed');
    }
})();
</script>
