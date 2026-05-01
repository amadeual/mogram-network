<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Mogram | Monetize sua Influência e Conteúdo Exclusivo')</title>
    <meta name="title" content="@yield('title', 'Mogram | Monetize sua Influência e Conteúdo Exclusivo')">
    <meta name="description" content="@yield('meta_description', 'Mogram é a plataforma definitiva para criadores de conteúdo monetizarem sua influência. Venda conteúdo exclusivo, faça lives e interaja com seus fãs sem limites.')">
    <meta name="keywords" content="mogram, criadores de conteúdo, monetização, conteúdo exclusivo, lives, influência, redes sociais, assinatura, fãs, brasil, ganhar dinheiro online">
    <meta name="author" content="Mogram">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Portuguese">
    <meta name="revisit-after" content="7 days">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Mogram | Monetize sua Influência e Conteúdo Exclusivo')">
    <meta property="og:description" content="@yield('meta_description', 'Mogram é a plataforma definitiva para criadores de conteúdo monetizarem sua influência. Venda conteúdo exclusivo, faça lives e interaja com seus fãs sem limites.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Mogram | Monetize sua Influência e Conteúdo Exclusivo')">
    <meta property="twitter:description" content="@yield('meta_description', 'Mogram é a plataforma definitiva para criadores de conteúdo monetizarem sua influência. Venda conteúdo exclusivo, faça lives e interaja com seus fãs sem limites.')">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJnIiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj48c3RvcCBvZmZzZXQ9IjAlIiBzdHlsZT0ic3RvcC1jb2xvcjojZmY4YzJkO3N0b3Atb3BhY2l0eToxIiAvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3R5bGU9InN0b3AtY29sb3I6I2ZmNGIxZitzdG9wLW9wYWNpdHk6MSIgLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48cmVjdCB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgcng9IjEwMCIgZmlsbD0idXJsKCNnKSIgLz48cGF0aCBkPSJNMTIwIDM5MlYxMjBoODBsNTYgMTIwIDU2LTEyMGg4MHYyNzJoLTYwVjIwMGwtNzYgMTYwLTc2LTE2MHYxOTJ6IiBmaWxsPSJ3aGl0ZSIgLz48L3N2Zz4=">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Small ad-hoc styles that might not merit full CSS file inclusion yet */
        .icon { width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; }

        /* Global Select Fix */
        select, option {
            background-color: #11141e !important;
            color: #ffffff !important;
        }

        /* SweetAlert2 Customized Styles for Mogram */
        div.swal2-popup.mogram-swal-popup {
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Override standard alert to provide a professional, Mogram-styled notification globally
        window.alert = function(message) {
            Swal.fire({
                title: 'Aviso',
                text: message,
                icon: 'warning',
                confirmButtonText: 'Entendi',
                confirmButtonColor: '#3390ec',
                background: '#161a26',
                color: '#ffffff',
                customClass: {
                    popup: 'mogram-swal-popup'
                }
            });
        };

        // Global Professional Deletion Confirmation using SweetAlert2
        window.confirmDelete = function(event, form, text = "Esta ação não pode ser desfeita!") {
            event.preventDefault();
            Swal.fire({
                title: 'Tem certeza?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar',
                background: '#161a26',
                color: '#ffffff',
                customClass: {
                    popup: 'mogram-swal-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        };
    </script>
</head>
<body>
    @auth
    @endauth

    @yield('content')
    @auth
        @include('partials.notifications')
    @endauth
    @include('partials.premium-loader')
    
    <!-- Stunning Mogram Professional Modal -->
    <div id="mogram-modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(8, 7, 14, 0.85); backdrop-filter: blur(12px); z-index: 20000; align-items: center; justify-content: center; animation: fadeInModal 0.3s ease-out;">
        <div style="background: #161a26; border: 1px solid rgba(255,255,255,0.08); border-radius: 32px; padding: 2.5rem; width: 420px; max-width: 90%; text-align: center; box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8); transform: translateY(0); transition: 0.3s; position: relative; overflow: hidden;">
            <!-- Glow Effect -->
            <div id="modal-glow" style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(51, 144, 236, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div id="mogram-modal-icon" style="width: 64px; height: 64px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.75rem; color: #3390ec; position: relative;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            
            <h3 id="mogram-modal-title" style="font-size: 1.5rem; font-weight: 900; color: white; margin-bottom: 0.75rem; letter-spacing: -0.5px;">Confirmar Ação</h3>
            <p id="mogram-modal-text" style="color: #94a3b8; font-size: 0.95rem; font-weight: 600; line-height: 1.6; margin-bottom: 2.5rem;">Deseja realmente prosseguir com esta operação?</p>
            
            <div style="display: flex; gap: 1rem;">
                <button onclick="closeMogramModal()" style="flex: 1; padding: 1rem; border-radius: 16px; background: rgba(255,255,255,0.04); color: white; font-weight: 800; border: 1px solid rgba(255,255,255,0.05); cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.background='rgba(255,255,255,0.04)'">Cancelar</button>
                <button id="mogram-modal-confirm" style="flex: 1; padding: 1rem; border-radius: 16px; background: #3390ec; color: white; font-weight: 900; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(51, 144, 236, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(51, 144, 236, 0.2)'">Confirmar</button>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInModal { from { opacity: 0; } to { opacity: 1; } }
        @keyframes toastUpApp { from { transform: translate(-50%, 50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }
    </style>

    <script>
        function openMogramModal(title, text, confirmCallback, confirmLabel = 'Confirmar', iconType = 'info') {
            const overlay = document.getElementById('mogram-modal-overlay');
            const titleEl = document.getElementById('mogram-modal-title');
            const textEl = document.getElementById('mogram-modal-text');
            const confirmBtn = document.getElementById('mogram-modal-confirm');
            const iconEl = document.getElementById('mogram-modal-icon');
            const glowEl = document.getElementById('modal-glow');

            titleEl.innerText = title;
            textEl.innerText = text;
            confirmBtn.innerText = confirmLabel;
            
            confirmBtn.onclick = () => {
                confirmCallback();
                closeMogramModal();
            };

            if (iconType === 'danger') {
                iconEl.innerHTML = '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                iconEl.style.color = '#ef4444';
                iconEl.style.background = 'rgba(239,68,68,0.1)';
                confirmBtn.style.background = '#ef4444';
                confirmBtn.style.boxShadow = '0 10px 20px rgba(239, 68, 68, 0.2)';
                glowEl.style.background = 'radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%)';
            } else {
                iconEl.innerHTML = '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>';
                iconEl.style.color = '#3390ec';
                iconEl.style.background = 'rgba(51,144,236,0.1)';
                confirmBtn.style.background = '#3390ec';
                confirmBtn.style.boxShadow = '0 10px 20px rgba(51, 144, 236, 0.2)';
                glowEl.style.background = 'radial-gradient(circle, rgba(51, 144, 236, 0.05) 0%, transparent 70%)';
            }

            overlay.style.display = 'flex';
        }

        function closeMogramModal() {
            document.getElementById('mogram-modal-overlay').style.display = 'none';
        }

        // Standardize confirmDelete to use the new Custom Modal
        window.confirmDelete = function(event, form, text = "Esta ação não pode ser desfeita!") {
            event.preventDefault();
            openMogramModal('Tem certeza?', text, () => {
                form.submit();
            }, 'Sim, Deletar', 'danger');
        };
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
        // Mention System Autocomplete
        let mentionDropdown = null;
        let activeMentionInput = null;

        document.addEventListener('input', async function(e) {
            if (e.target.tagName === 'TEXTAREA' || (e.target.tagName === 'INPUT' && (e.target.type === 'text' || !e.target.type))) {
                const input = e.target;
                const value = input.value;
                const cursorPosition = input.selectionStart;
                const textBeforeCursor = value.substring(0, cursorPosition);
                const words = textBeforeCursor.split(/[\s\n]/);
                const lastWord = words[words.length - 1];

                if (lastWord.startsWith('@') && lastWord.length > 1) {
                    const query = lastWord.substring(1).split(/[^a-zA-Z0-9]/)[0]; // Clean query
                    if (!query) return hideMentionDropdown();
                    
                    activeMentionInput = input;
                    const users = await fetchMentions(query);
                    if (users && users.length > 0) {
                        showMentionDropdown(users, input);
                    } else {
                        hideMentionDropdown();
                    }
                } else {
                    hideMentionDropdown();
                }
            }
        });

        async function fetchMentions(q) {
            try {
                const resp = await fetch(`/search/users?q=${encodeURIComponent(q)}`);
                const data = await resp.json();
                return data.users || [];
            } catch (e) {
                return [];
            }
        }

        function showMentionDropdown(users, input) {
            if (!mentionDropdown) {
                mentionDropdown = document.createElement('div');
                mentionDropdown.style.cssText = `
                    position: absolute;
                    background: #1a1c2e;
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 12px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                    z-index: 100000;
                    max-height: 200px;
                    overflow-y: auto;
                    width: 250px;
                    display: flex;
                    flex-direction: column;
                `;
                document.body.appendChild(mentionDropdown);
            }

            const rect = input.getBoundingClientRect();
            mentionDropdown.style.left = `${rect.left}px`;
            mentionDropdown.style.top = `${rect.bottom + window.scrollY + 5}px`;
            mentionDropdown.innerHTML = '';
            mentionDropdown.style.display = 'flex';

            users.forEach(user => {
                const item = document.createElement('div');
                item.style.cssText = `
                    padding: 10px 14px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    cursor: pointer;
                    transition: 0.2s;
                    border-bottom: 1px solid rgba(255,255,255,0.03);
                `;
                item.innerHTML = `
                    <img src="${user.avatar}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                    <div style="flex: 1; overflow: hidden;">
                        <p style="font-size: 13px; font-weight: 800; color: white; margin: 0; overflow: hidden; text-overflow: ellipsis;">${user.name}</p>
                        <p style="font-size: 11px; color: #3390ec; margin: 0; font-weight: 600;">@${user.username}</p>
                    </div>
                `;
                item.onmouseover = () => item.style.background = 'rgba(51, 144, 236, 0.15)';
                item.onmouseout = () => item.style.background = 'transparent';
                item.onclick = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    insertMention(user.username);
                };
                mentionDropdown.appendChild(item);
            });
        }

        function hideMentionDropdown() {
            if (mentionDropdown) mentionDropdown.style.display = 'none';
        }

        function insertMention(username) {
            if (!activeMentionInput) return;
            const input = activeMentionInput;
            const value = input.value;
            const cursorPosition = input.selectionStart;
            const textBeforeCursor = value.substring(0, cursorPosition);
            const textAfterCursor = value.substring(cursorPosition);
            
            const words = textBeforeCursor.split(/[\s\n]/);
            words[words.length - 1] = '@' + username + ' ';
            
            input.value = words.join(' ') + textAfterCursor;
            
            // Dispatch input event to trigger any listeners (like auto-expand)
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.focus();
            hideMentionDropdown();
        }

        document.addEventListener('mousedown', (e) => {
            if (mentionDropdown && !mentionDropdown.contains(e.target) && e.target !== activeMentionInput) {
                hideMentionDropdown();
            }
        });
    </script>
</body>
</html>
