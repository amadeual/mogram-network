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
        <div class="notif-bell" style="width: 44px; display:flex; justify-content:center; cursor:pointer;" onclick="toggleNotifs()">
            <div class="notif-badge" style="width:8px;height:8px;background:#3390ec;border-radius:50%;box-shadow:0 0 8px #3390ec; display: {{ auth()->user()->unreadNotifications->count() > 0 ? 'block' : 'none' }};"></div>
        </div>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" id="mogram_sidebar">

        {{-- Mobile sidebar header (shown only inside sidebar on mobile) --}}
        <div class="sidebar-mobile-header mobile-only">
            <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap: 10px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                    <defs><linearGradient id="sidebarMobGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#sidebarMobGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="grad-text" style="font-weight:900;font-size:1.25rem;letter-spacing:-0.5px;">Mogram</span>
            </a>
            <button class="sidebar-close-btn" onclick="closeMogramSidebar()" aria-label="Close menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="sidebar-header desktop-only" style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.75rem 1.5rem;">
            <a href="{{ route('dashboard') }}" class="sidebar-logo" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <defs><linearGradient id="sidebarLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#sidebarLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span class="grad-text" style="font-weight: 900; letter-spacing: -1px; font-size: 1.5rem;">Mogram</span>
            </a>
            <button onclick="toggleSidebarCollapse()" class="burger-btn desktop-only" style="width: 38px; height: 38px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>

        <nav style="display: flex; flex-direction: column; gap: 0.35rem;">
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
                $unreadChatsCount = \App\Models\Message::where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->distinct('sender_id')
                    ->count('sender_id');
            @endphp
            <a href="{{ route('chat.index') }}" class="menu-item sidebar-nav-item {{ Route::is('chat.*') ? 'active' : '' }}">
                <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    @if($unreadChatsCount > 0)
                        <span style="position: absolute; top: -6px; right: -8px; background: #ef4444; color: white; font-size: 8px; font-weight: 900; min-width: 15px; height: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1.5px solid #0b0a15; box-shadow: 0 0 10px rgba(239, 68, 68, 0.3); z-index: 10;">
                            {{ $unreadChatsCount }}
                        </span>
                    @endif
                </div>
                <span style="margin-left: 12px;">Chat</span>
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
            
            <div class="sidebar-divider mobile-only"></div>
            <a href="{{ route('studio.dashboard') }}" class="menu-item sidebar-nav-item" style="color: var(--primary-blue);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span>Mogram Studio</span>
            </a>
            <a href="{{ route('studio.settings') }}" class="menu-item sidebar-nav-item {{ Route::is('studio.settings') ? 'active' : '' }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span>Configurações</span>
            </a>

            {{-- Collapse Toggle (Desktop) --}}
            <div class="sidebar-divider desktop-only"></div>
            <button onclick="toggleSidebarCollapse()" class="menu-item desktop-only" style="background: transparent; border: none; width: 100%; border-top: 1px solid rgba(255,255,255,0.03); padding-top: 1rem; margin-top: 0.5rem; justify-content: flex-start;">
                <svg id="collapse-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition: transform 0.3s;"><polyline points="15 18 9 12 15 6"/></svg>
                <span>Recolher</span>
            </button>
        </nav>

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
    </aside>

<style>
/* ===== BURGER BUTTON ===== */
.burger-btn {
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    flex-shrink: 0;
    padding: 0;
}

.burger-btn:active {
    transform: scale(0.92);
    background: rgba(255,255,255,0.1);
}

.burger-line {
    display: block;
    width: 20px;
    height: 2px;
    background: white;
    border-radius: 2px;
    transform-origin: center;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.2s,
                width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Burger → X animation */
.burger-btn.open .burger-line:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}
.burger-btn.open .burger-line:nth-child(2) {
    opacity: 0;
    width: 0;
}
.burger-btn.open .burger-line:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

/* ===== MOBILE TOP BAR ===== */
.mobile-top-bar {
    display: none !important;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: rgba(11, 10, 21, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    z-index: 200000 !important;
    align-items: center;
    justify-content: space-between;
    padding: 0 1rem;
}

.mobile-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.mobile-logo span {
    font-weight: 900;
    font-size: 1.1rem;
    color: white;
    letter-spacing: -0.5px;
}

/* ===== SIDEBAR MOBILE HEADER ===== */
.sidebar-mobile-header {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1rem 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    margin-bottom: 0.5rem;
    flex-shrink: 0;
}

.sidebar-close-btn {
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: rgba(255,255,255,0.7);
    transition: 0.2s;
}

.sidebar-close-btn:active {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    transform: scale(0.9);
}

/* ===== SIDEBAR DIVIDER ===== */
.sidebar-divider {
    height: 1px;
    background: rgba(255,255,255,0.05);
    margin: 0.5rem 0.875rem;
}

/* ===== NAV ITEM STAGGER ANIMATION on open ===== */
.sidebar-nav-item {
    opacity: 1;
    transform: translateX(0);
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

@keyframes navSlideIn {
    from { opacity: 0; transform: translateX(-16px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ===== RESPONSIVE MOBILE ===== */
@media (max-width: 991px) {
    .mobile-only  { display: flex !important; }
    .desktop-only { display: none !important; }
    .mobile-top-bar { display: flex !important; }

    /* Sidebar slides in from left */
    .sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        width: 82% !important;
        max-width: 300px !important;
        transform: translateX(-105%) !important;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
        z-index: 150000 !important;
        border-right: 1px solid rgba(255,255,255,0.06) !important;
        box-shadow: 20px 0 60px rgba(0,0,0,0.6) !important;
        padding: 0 0.75rem 1rem !important;
    }

    .sidebar-logo { display: none !important; }
    .sidebar-mobile-header { display: flex !important; }

    .sidebar.active {
        transform: translateX(0) !important;
    }

    /* Stagger nav items when sidebar opens */
    .sidebar.active .sidebar-nav-item:nth-child(1) { animation: navSlideIn 0.3s ease 0.05s both; }
    .sidebar.active .sidebar-nav-item:nth-child(2) { animation: navSlideIn 0.3s ease 0.10s both; }
    .sidebar.active .sidebar-nav-item:nth-child(3) { animation: navSlideIn 0.3s ease 0.15s both; }
    .sidebar.active .sidebar-nav-item:nth-child(4) { animation: navSlideIn 0.3s ease 0.20s both; }
    .sidebar.active .sidebar-nav-item:nth-child(5) { animation: navSlideIn 0.3s ease 0.25s both; }
    .sidebar.active .sidebar-nav-item:nth-child(6) { animation: navSlideIn 0.3s ease 0.30s both; }
    .sidebar.active .sidebar-nav-item:nth-child(7) { animation: navSlideIn 0.3s ease 0.35s both; }
    .sidebar.active .sidebar-nav-item:nth-child(8) { animation: navSlideIn 0.3s ease 0.40s both; }
    .sidebar.active .sidebar-nav-item:nth-child(9) { animation: navSlideIn 0.3s ease 0.45s both; }
    .sidebar.active .sidebar-nav-item:nth-child(10) { animation: navSlideIn 0.3s ease 0.50s both; }
    .sidebar.active .sidebar-nav-item:nth-child(11) { animation: navSlideIn 0.3s ease 0.55s both; }

    /* Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed !important;
        inset: 0 !important;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 9000 !important;
        opacity: 0;
        transition: opacity 0.35s ease !important;
        pointer-events: none;
    }

    .sidebar-overlay.active {
        display: block !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    /* Main content layout */
    .main-content {
        margin-left: 0 !important;
        padding-top: 60px !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .main-content > header { padding-left: 0 !important; border-top: 1px solid rgba(255,255,255,0.03); }
    .dash-layout .main-content, .app-layout .main-content { margin-left: 0 !important; }
    .right-sidebar { display: none !important; }
}
</style>

<script>
function toggleMogramSidebar() {
    const sidebar  = document.getElementById('mogram_sidebar');
    const overlay  = document.getElementById('mogram_sidebar_overlay');
    const burgerBtn = document.getElementById('mogram_mobile_btn');
    const isOpen   = sidebar.classList.contains('active');

    if (isOpen) {
        closeMogramSidebar();
    } else {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        burgerBtn.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeMogramSidebar() {
    const sidebar   = document.getElementById('mogram_sidebar');
    const overlay   = document.getElementById('mogram_sidebar_overlay');
    const burgerBtn = document.getElementById('mogram_mobile_btn');
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    burgerBtn.classList.remove('open');
    document.body.style.overflow = '';
}

// Swipe-to-close gesture
(function() {
    let startX = null;
    const sidebar = document.getElementById('mogram_sidebar');
    if (!sidebar) return;

    sidebar.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    }, { passive: true });

    sidebar.addEventListener('touchend', function(e) {
        if (startX === null) return;
        const deltaX = e.changedTouches[0].clientX - startX;
        if (deltaX < -60) { // swipe left to close
            closeMogramSidebar();
        }
        startX = null;
    }, { passive: true });
})();

function toggleSidebarCollapse() {
    const sidebar = document.getElementById('mogram_sidebar');
    const icon = document.getElementById('collapse-icon');
    const isCollapsed = sidebar.classList.toggle('collapsed');
    
    // Save state
    localStorage.setItem('sidebar_collapsed', isCollapsed);
    
    // Rotate icon
    if (icon) {
        icon.style.transform = isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    // Inform body for layout adjustments if needed
    if (isCollapsed) {
        document.body.classList.add('sidebar-is-collapsed');
    } else {
        document.body.classList.remove('sidebar-is-collapsed');
    }
}

// Initialize collapse state on load
(function() {
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    if (isCollapsed && window.innerWidth > 991) {
        const sidebar = document.getElementById('mogram_sidebar');
        const icon = document.getElementById('collapse-icon');
        if (sidebar) sidebar.classList.add('collapsed');
        if (icon) icon.style.transform = 'rotate(180deg)';
        document.body.classList.add('sidebar-is-collapsed');
    }
})();
</script>
