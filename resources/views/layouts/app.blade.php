<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mogram - Monetize sua influência sem limites')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJnIiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj48c3RvcCBvZmZzZXQ9IjAlIiBzdHlsZT0ic3RvcC1jb2xvcjojZmY4YzJkO3N0b3Atb3BhY2l0eToxIiAvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3R5bGU9InN0b3AtY29sb3I6I2ZmNGIxZitzdG9wLW9wYWNpdHk6MSIgLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48cmVjdCB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgcng9IjEwMCIgZmlsbD0idXJsKCNnKSIgLz48cGF0aCBkPSJNMTIwIDM5MlYxMjBoODBsNTYgMTIwIDU2LTEyMGg4MHYyNzJoLTYwVjIwMGwtNzYgMTYwLTc2LTE2MHYxOTJ6IiBmaWxsPSJ3aGl0ZSIgLz48L3N2Zz4=">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-kit.js" crossorigin="anonymous"></script> <!-- Optional: Using generic font awesome for icons if needed -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Small ad-hoc styles that might not merit full CSS file inclusion yet */
        .icon { width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <!-- Global Mobile Elements -->
    <div class="sidebar-overlay" id="mogram_sidebar_overlay" onclick="toggleMobileMenu()"></div>
    
    <div class="mobile-top-bar mobile-only">
        <button class="mobile-menu-toggle" id="mogram_mobile_btn" onclick="toggleMobileMenu()">
            <svg class="icon-menu" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg class="icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="mobile-logo" style="display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                <defs><linearGradient id="mobileLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                <rect width="512" height="512" rx="100" fill="url(#mobileLogoGrad)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
            <span style="font-weight: 900; color: white; font-size: 1.1rem; letter-spacing: -0.5px;">Mogram</span>
        </div>
    </div>

    @yield('content')
    @include('partials.notifications')
    @include('partials.premium-loader')
    
    <!-- Custom Modal/Dialog -->
    <div id="mogram-modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 20000; align-items: center; justify-content: center;">
        <div style="background: #1a1c2e; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 2rem; width: 400px; max-width: 90%; text-align: center; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div id="mogram-modal-icon" style="width: 56px; height: 56px; background: rgba(239,68,68,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #ef4444;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <h3 id="mogram-modal-title" style="font-size: 1.25rem; font-weight: 800; color: white; margin-bottom: 0.75rem;">Confirmar Ação</h3>
            <p id="mogram-modal-text" style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; line-height: 1.5; margin-bottom: 2rem;">Deseja realmente prosseguir?</p>
            <div style="display: flex; gap: 1rem;">
                <button onclick="closeMogramModal()" style="flex: 1; padding: 0.875rem; border-radius: 12px; background: rgba(255,255,255,0.05); color: white; font-weight: 800; border: 1px solid rgba(255,255,255,0.05); cursor: pointer;">Cancelar</button>
                <button id="mogram-modal-confirm" style="flex: 1; padding: 0.875rem; border-radius: 12px; background: #ef4444; color: white; font-weight: 800; border: none; cursor: pointer;">Excluir</button>
            </div>
        </div>
    </div>

    <script>
        function openMogramModal(title, text, confirmCallback, iconType = 'error') {
            const overlay = document.getElementById('mogram-modal-overlay');
            document.getElementById('mogram-modal-title').innerText = title;
            document.getElementById('mogram-modal-text').innerText = text;
            const confirmBtn = document.getElementById('mogram-modal-confirm');
            
            confirmBtn.onclick = () => {
                confirmCallback();
                closeMogramModal();
            };

            if (iconType === 'success') {
                document.getElementById('mogram-modal-icon').style.color = '#3390ec';
                document.getElementById('mogram-modal-icon').style.background = 'rgba(51,144,236,0.1)';
                confirmBtn.style.background = '#3390ec';
            } else {
                document.getElementById('mogram-modal-icon').style.color = '#ef4444';
                document.getElementById('mogram-modal-icon').style.background = 'rgba(239,68,68,0.1)';
                confirmBtn.style.background = '#ef4444';
            }

            overlay.style.display = 'flex';
        }

        function closeMogramModal() {
            document.getElementById('mogram-modal-overlay').style.display = 'none';
        }
    </script>

    @if(session('success'))
        <div id="global-toast" style="position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: #3390ec; color: white; padding: 12px 24px; border-radius: 99px; font-size: 14px; font-weight: 800; z-index: 10000; box-shadow: 0 10px 30px rgba(0,0,0,0.5); animation: toastUpApp 0.3s ease-out;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const t = document.getElementById('global-toast');
                if(t) {
                    t.style.opacity = '0';
                    t.style.transition = '0.5s';
                    setTimeout(() => t.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <style>
        @keyframes toastUpApp { from { transform: translate(-50%, 50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }
    </style>

    @yield('scripts')
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mogram_sidebar');
            const btn = document.getElementById('mogram_mobile_btn');
            const overlay = document.getElementById('mogram_sidebar_overlay');
            if (sidebar) {
                sidebar.classList.toggle('active');
                if (btn) btn.classList.toggle('active');
                if (overlay) overlay.classList.toggle('active');
                // Lock body scroll only when sidebar is open
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }
        }
    </script>
</body>
</html>
