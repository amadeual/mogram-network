<div class="nav-container" style="position: sticky; top: 0; z-index: 1000; background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-gray);">
    <nav class="container flex justify-between items-center" style="height: 80px; padding: 0 1.5rem;">
        <div class="logo">
            <a href="{{ route('home') }}" class="text-2xl font-black grad-text">MOGRAM</a>
        </div>
        
        <div class="nav-links" style="display: none; align-items: center; gap: 2.5rem;">
            <a href="#" class="text-light text-sm font-semibold">Explorar Feed</a>
            <a href="#" class="text-light text-sm font-semibold">Explorar Criadores</a>
            <a href="#" class="text-light text-sm font-semibold">Ganhos</a>
        </div>
        
        <style> @media (min-width: 992px) { .nav-links { display: flex !important; } } </style>
        
        <div class="nav-actions" style="display: flex; gap: 1.5rem; align-items: center;">
            @auth
                <div class="nav-dropdown-wrapper">
                    <div style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid var(--primary-blue); object-fit: cover;">
                        @else
                            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}&backgroundColor=3390ec" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid var(--border-gray);">
                        @endif
                        <span class="text-white text-sm font-bold" style="display: none; @media (min-width: 768px) { display: inline; }">{{ Auth::user()->name }}</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="opacity: 0.5;"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                    
                    <div class="nav-dropdown">
                        <a href="{{ route('dashboard') }}" class="dropdown-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('studio.dashboard') }}" class="dropdown-item" style="color: var(--primary-blue);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            Mogram Studio
                        </a>
                        <a href="#" class="dropdown-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                            Definições
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #ef4444; width: 100%;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-white text-sm font-bold">Entrar</a>
                <a href="{{ route('register') }}" class="mogram-btn-primary" style="padding: 0.75rem 2rem; font-size: 14px;">Começar</a>
            @endauth
        </div>
    </nav>
</div>
