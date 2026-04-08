<div id="toast-container"></div>

<div class="notification-dropdown" id="notif-dropdown">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
        <h3 style="font-size: 1rem; font-weight: 800; margin: 0; color: white;">Notificações</h3>
        <span onclick="markAllNotificationsAsRead()" style="font-size: 0.7rem; color: var(--primary-blue); cursor: pointer; font-weight: 700; background: rgba(51,144,236,0.1); padding: 4px 10px; border-radius: 6px;">Marcar todas</span>
    </div>

    <!-- Notification List -->
    <div id="real-notif-list" style="max-height: 420px; overflow-y: auto; overflow-x: hidden;">
        <!-- Notifications will be loaded here -->
        <div style="padding: 2.5rem 1.5rem; text-align: center; color: #555; font-size: 0.85rem; font-weight: 600;">
            Carregando notificações...
        </div>
    </div>

    <div style="padding: 1rem; text-align: center; border-top: 1.5px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.2);">
        <a href="#" style="color: #555; font-size: 0.75rem; font-weight: 800; text-decoration: none; text-transform: none; letter-spacing: 0.5px;">Ver histórico completo</a>
    </div>
</div>

<style>
    .notif-item-premium {
        padding: 1.25rem 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
    }
    .notif-item-premium:hover { background: rgba(255,255,255,0.02); }
    .notif-item-premium.unread { background: rgba(51, 144, 236, 0.03); }
    .notif-item-premium.unread:hover { background: rgba(51, 144, 236, 0.05); }
    
    .notif-time-badge { font-size: 10px; font-weight: 700; color: #555; margin-top: 6px; }
    
    .notification-dropdown {
        position: fixed;
        top: 80px; 
        right: 20px;
        width: 380px;
        background: #11121d;
        border: 1.5px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.6);
        z-index: 99999;
        display: none;
        overflow: hidden;
    }
    .notification-dropdown.active { display: block; animation: dropdownSlide 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    
    @keyframes dropdownSlide {
        from { transform: translateY(-20px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
</style>

<script>
    // Professional Toast Implementation
    window.showToast = function(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if(!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast';
        
        // CSS for Toast if not already in global styles
        toast.style.cssText = `
            background: #1a1c2e;
            border-left: 4px solid #3390ec;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            animation: toastIn 0.3s ease-out;
            pointer-events: auto;
        `;
        
        let icon = '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>';
        if (type === 'success') {
            toast.style.borderLeftColor = '#34C759';
            icon = '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>';
        } else if (type === 'live') {
            toast.style.borderLeftColor = '#FF3B30';
            icon = '<span style="width: 10px; height: 10px; background: #FF3B30; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span>';
        }

        toast.innerHTML = `
            ${icon}
            <div style="font-size: 0.9rem; font-weight: 600;">${message}</div>
            <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #555; cursor: pointer; font-size: 1.2rem;">&times;</button>
        `;

        container.appendChild(toast);

        // Auto remove after 5s
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                toast.style.transition = '0.5s';
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    };

    // Fetch Notifications from API
    window.fetchRealNotifications = function() {
        const list = document.getElementById('real-notif-list');
        if(!list) return;

        fetch("{{ route('notifications.index') }}")
        .then(res => res.json())
        .then(data => {
            updateNotifBadge(data.unread_count);
            
            if (data.notifications.length === 0) {
                list.innerHTML = `
                    <div style="padding: 4rem 2rem; text-align: center;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="2" style="margin-bottom: 1rem;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <p style="color: #555; font-size: 0.9rem; font-weight: 700;">Nenhuma notificação por enquanto</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = '';
            data.notifications.forEach(notif => {
                const item = document.createElement('div');
                item.className = `notif-item-premium ${notif.read_at ? '' : 'unread'}`;
                
                let iconHtml = '';
                const type = notif.data.type || 'info';
                
                if (type === 'live') {
                    iconHtml = `
                        <div style="position: relative; flex-shrink: 0;">
                            <img src="${notif.data.avatar || 'https://api.dicebear.com/7.x/avataaars/svg?seed=Mogram'}" style="width: 42px; height: 42px; border-radius: 12px; background: #1a1a1a;">
                            <div style="position: absolute; top: -4px; right: -4px; color: #ef4444; font-size: 12px; filter: drop-shadow(0 0 2px black);">🔴</div>
                        </div>
                    `;
                } else if (type === 'deposit') {
                    iconHtml = `
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(34, 197, 94, 0.1); display: flex; align-items: center; justify-content: center; color: #22c55e; flex-shrink: 0;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v20M5 12l7 7 7-7"/></svg>
                        </div>
                    `;
                } else if (type === 'follow') {
                    iconHtml = `
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(51, 144, 236, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-blue); flex-shrink: 0;">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>
                        </div>
                    `;
                } else {
                    iconHtml = `
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: #888; flex-shrink: 0;">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                    `;
                }

                item.innerHTML = `
                    ${iconHtml}
                    <div style="flex: 1; min-width: 0;">
                        <p style="font-size: 0.85rem; line-height: 1.4; color: #ccc; margin: 0;">
                            <span style="font-weight: 800; color: white;">${notif.data.title || 'Mogram'}</span> ${notif.data.message}
                        </p>
                        <div class="notif-time-badge">${formatNotifTime(notif.created_at)}</div>
                    </div>
                `;
                
                if(!notif.read_at) {
                    item.innerHTML += `<div style="width: 8px; height: 8px; background: var(--primary-blue); border-radius: 50%; box-shadow: 0 0 10px var(--primary-blue); flex-shrink:0; margin-top: 6px;"></div>`;
                }

                list.appendChild(item);
            });
        })
        .catch(err => console.error("Erro ao buscar notificações:", err));
    };

    function formatNotifTime(dateStr) {
        const date = new Date(dateStr);
        const now = new Date();
        const diff = (now - date) / 1000; // seconds

        if (diff < 60) return 'Agora';
        if (diff < 3600) return `Há ${Math.floor(diff / 60)} min`;
        if (diff < 86400) return `Há ${Math.floor(diff / 3600)} h`;
        return date.toLocaleDateString('pt-BR');
    }

    function updateNotifBadge(count) {
        const badges = document.querySelectorAll('.notif-badge, #notif-badge');
        const bells = document.querySelectorAll('.notif-bell');
        
        badges.forEach(badge => {
            badge.style.display = count > 0 ? 'block' : 'none';
        });

        // Some pages might have a dot inside the bell instead of an ID'd badge
        bells.forEach(bell => {
            const dot = bell.querySelector('div[style*="background: #ef4444"], div[style*="background: #FF3B30"], div[style*="background: #3390ec"]');
            if(dot) dot.style.display = count > 0 ? 'block' : 'none';
        });
    }

    window.markAllNotificationsAsRead = function() {
        fetch("{{ route('notifications.read') }}", {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(() => {
            updateNotifBadge(0);
            fetchRealNotifications();
        });
    }

    // Toggle Dropdown with Dynamic Positioning
    window.toggleNotifs = function() {
        const dropdown = document.getElementById('notif-dropdown');
        if(!dropdown) return;

        const isActive = dropdown.classList.contains('active');
        const bell = event.currentTarget;
        const rect = bell.getBoundingClientRect();

        if (!isActive) {
            // Position relative to current bell
            dropdown.style.top = (rect.bottom + 10) + 'px';
            dropdown.style.right = (window.innerWidth - rect.right) + 'px';
            
            fetchRealNotifications();
            dropdown.classList.add('active');
        } else {
            dropdown.classList.remove('active');
        }
    };

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('notif-dropdown');
        const bells = document.querySelectorAll('.notif-bell');
        let clickedBell = false;
        
        bells.forEach(bell => {
            if(bell && bell.contains(e.target)) clickedBell = true;
        });

        if (dropdown && !dropdown.contains(e.target) && !clickedBell) {
            dropdown.classList.remove('active');
        }
    });

    // Initial check for unread count
    document.addEventListener('DOMContentLoaded', () => {
        fetchRealNotifications();
    });
</script>
