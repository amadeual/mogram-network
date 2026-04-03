<div id="toast-container"></div>

<div class="notification-dropdown" id="notif-dropdown">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
        <h3 style="font-size: 1rem; font-weight: 800; margin: 0; color: white;">Notificações</h3>
        <span style="font-size: 0.7rem; color: var(--primary-blue); cursor: pointer; font-weight: 700; background: rgba(51,144,236,0.1); padding: 4px 10px; border-radius: 6px;">Marcar todas</span>
    </div>

    <!-- Notification List -->
    <div style="max-height: 420px; overflow-y: auto; overflow-x: hidden;">
        <!-- Live Alert -->
        <div class="notif-item-premium">
            <div style="position: relative; flex-shrink: 0;">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Ana" style="width: 42px; height: 42px; border-radius: 12px; background: #1a1a1a;">
                <div style="position: absolute; top: -4px; right: -4px; color: #ef4444; font-size: 12px; filter: drop-shadow(0 0 2px black);">🔴</div>
            </div>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 0.8rem; line-height: 1.4; color: #ccc; margin: 0;">
                    <span style="font-weight: 800; color: white;">Ana Clara</span> iniciou uma transmissão: <b style="color: var(--primary-blue);">"Talk Show Noturno"</b>
                </p>
                <div class="notif-time-badge">AGORA</div>
            </div>
            <div style="width: 8px; height: 8px; background: var(--primary-blue); border-radius: 50%; box-shadow: 0 0 10px var(--primary-blue);"></div>
        </div>

        <!-- Purchase Alert -->
        <div class="notif-item-premium">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(34, 197, 94, 0.1); display: flex; align-items: center; justify-content: center; color: #22c55e; flex-shrink: 0;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v20M5 12l7 7 7-7"/></svg>
            </div>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 0.8rem; line-height: 1.4; color: #ccc; margin: 0;">Seu depósito de <span style="font-weight: 800; color: #4ade80;">R$ 150,00</span> foi confirmado!</p>
                <div style="font-size: 0.65rem; color: #555; margin-top: 4px;">Há 15 minutos</div>
            </div>
        </div>

        <!-- System Alert -->
        <div class="notif-item-premium">
             <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(51, 144, 236, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary-blue); flex-shrink: 0;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
             </div>
             <div style="flex: 1; min-width: 0;">
                 <p style="font-size: 0.8rem; line-height: 1.4; color: #ccc; margin: 0;">Segurança: Detectamos um novo login em sua conta.</p>
                 <div style="font-size: 0.65rem; color: #555; margin-top: 4px;">Há 2 horas</div>
             </div>
        </div>
    </div>

    <div style="padding: 1rem; text-align: center; border-top: 1.5px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.2);">
        <a href="#" style="color: #555; font-size: 0.75rem; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">Limpar tudo</a>
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
    }
    .notif-item-premium:hover { background: rgba(255,255,255,0.02); }
    .notif-time-badge { font-size: 9px; font-weight: 900; background: #ef4444; color: white; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 6px; }
    
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
        const toast = document.createElement('div');
        toast.className = 'toast';
        
        let icon = '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>';
        if (type === 'success') {
            toast.style.borderLeftColor = '#34C759';
            icon = '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>';
        } else if (type === 'live') {
            toast.style.borderLeftColor = '#FF3B30';
            icon = '<span style="width: 10px; height: 10px; background: #FF3B30; border-radius: 50%; display: inline-block;"></span>';
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

    // Toggle Dropdown
    window.toggleNotifs = function() {
        const dropdown = document.getElementById('notif-dropdown');
        dropdown.classList.toggle('active');
    };

    // Close dropdown on click outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('notif-dropdown');
        const bell = document.querySelector('.notif-bell');
        if (dropdown && bell && !dropdown.contains(e.target) && !bell.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
</script>
