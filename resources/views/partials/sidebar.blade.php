<aside class="sidebar" id="mogram_sidebar">
    <div class="sidebar-logo" style="display: flex; align-items: center; gap: 12px; padding: 0 1rem 3rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
            <defs><linearGradient id="sidebarLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
            <rect width="512" height="512" rx="100" fill="url(#sidebarLogoGrad)" />
            <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
        </svg>
        <span style="font-weight: 900; letter-spacing: -1px; color: white; font-size: 1.5rem;">Mogram</span>
    </div>
    
    <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
        <a href="{{ route('dashboard') }}" class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Home
        </a>
        <a href="{{ route('stories') }}" class="menu-item {{ Route::is('stories') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Stories
        </a>
        <a href="{{ route('studio.create') }}" class="menu-item {{ Route::is('studio.create') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Criar
        </a>
        <a href="{{ route('lives') }}" class="menu-item {{ Route::is('lives') || Route::is('live.*') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
            Lives
        </a>
        <a href="#" class="menu-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Chat
        </a>
        <a href="{{ route('creator.profile') }}" class="menu-item {{ Route::is('creator.profile') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Perfil
        </a>
        <a href="{{ route('studio.dashboard') }}" class="menu-item" style="color: var(--primary-blue);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Mogram Studio
        </a>
        <a href="{{ route('studio.settings') }}" class="menu-item {{ Route::is('studio.settings') ? 'active' : '' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Configurações
        </a>
    </nav>

    <div class="sidebar-user">
        @if(Auth::user()->avatar)
            <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #3390ec;">
        @else
            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 50%;">
        @endif
        <div style="flex: 1; min-width: 0;">
            <p style="font-size: 13px; font-weight: 700; color: white; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">@ {{ Auth::user()->username }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>
</aside>

@push('mobile-menu')
<!-- Mobile Menu Toggle & Overlay -->
<button class="mobile-menu-toggle" id="mogram_mobile_btn" onclick="toggleMobileMenu()">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<div class="sidebar-overlay" id="mogram_sidebar_overlay" onclick="toggleMobileMenu()"></div>

<script>
    function toggleMobileMenu() {
        document.getElementById('mogram_sidebar').classList.toggle('active');
        document.getElementById('mogram_mobile_btn').classList.toggle('active');
        document.getElementById('mogram_sidebar_overlay').classList.toggle('active');
    }
</script>
@endpush
