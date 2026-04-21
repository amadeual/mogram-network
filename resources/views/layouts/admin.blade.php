<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://kit.fontawesome.com/your-kit.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Override standard alert to provide a professional, Mogram-styled notification globally in Admin Panel
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

    <style>
        /* SweetAlert2 Customized Styles for Mogram */
        div.swal2-popup.mogram-swal-popup {
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }

        :root {
            --bg-deep: #0b0d17;
            --bg-card: #161a26;
            --bg-sidebar: #11141e;
            --primary-blue: #3390ec;
            --text-white: #ffffff;
            --text-muted: #64748b;
            --border-gray: rgba(255, 255, 255, 0.05);
            --success: #22c55e;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-white);
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-gray);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 3rem;
        }

        .logo-box {
            width: 38px;
            height: 38px;
            background: var(--primary-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(51, 144, 236, 0.3);
        }

        .logo-text h2 {
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--primary-blue);
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .nav-item svg {
            width: 22px;
            height: 22px;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(51, 144, 236, 0.1);
            color: var(--text-white);
        }

        .nav-item.active {
            background: var(--primary-blue);
            box-shadow: 0 10px 30px rgba(51, 144, 236, 0.2);
        }

        /* Sidebar Footer (User Profile) */
        .sidebar-profile {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-gray);
            border-radius: 20px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 2rem;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
        }

        .profile-info h4 {
            font-size: 0.9rem;
            font-weight: 800;
        }

        .profile-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem 3rem;
        }

        /* Top Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .search-bar {
            position: relative;
            flex: 1;
            max-width: 450px;
        }

        .search-bar input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 12px 15px 12px 45px;
            color: white;
            font-size: 0.9rem;
            outline: none;
            transition: 0.3s;
        }

        .search-bar input:focus {
            border-color: var(--primary-blue);
            background: rgba(255, 255, 255, 0.08);
        }

        .search-bar svg {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: var(--text-white);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Generic Admin Components */
        .admin-card {
            background: var(--bg-card);
            border: 1px solid var(--border-gray);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 800;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(51, 144, 236, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(51, 144, 236, 0.4);
        }

        /* Fade Animation */
        .fade-in { animation: fadeInAnim 0.5s ease-out; }
        @keyframes fadeInAnim { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Global Select Fix */
        select, option {
            background-color: #11141e !important;
            color: #ffffff !important;
        }

        /* Notification Dropdown */
        .notification-wrapper {
            position: relative;
        }
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            width: 320px;
            background: var(--bg-card);
            border: 1px solid var(--border-gray);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            padding: 1.25rem;
            display: none;
            z-index: 1000;
        }
        .notification-dropdown.active {
            display: block;
            animation: fadeInAnim 0.3s ease-out;
        }
        .notification-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: 0.2s;
            margin-bottom: 8px;
        }
        .notification-item:hover {
            background: rgba(255,255,255,0.05);
        }

        /* Print Styles */
        @media print {
            body { background: white; color: black; }
            .sidebar, .top-header, .no-print { display: none !important; }
            .main-content { margin-left: 0; padding: 0; }
            .admin-card { box-shadow: none; border: 1px solid #ddd; background: white; color: black; break-inside: avoid; }
            h1, h2, h3, h4, p, span, div, td, th { color: black !important; }
            svg { color: black !important; }
        }
    </style>
</head>
<body>
    @php
        $openTickets = \App\Models\Ticket::where('status', 'Aberto')->count();
        $pendingWithdrawals = \App\Models\Withdrawal::where('status', 'pending')->count();
        $totalAlerts = $openTickets + $pendingWithdrawals;
    @endphp
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-box">
                    <svg width="24" height="24" viewBox="0 0 512 512" fill="white"><path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z"/></svg>
                </div>
                <div class="logo-text">
                    <h2>Mogram</h2>
                    <span>PAINELADMIN</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('studio.dashboard') }}" class="nav-item" style="color: #a855f7; background: rgba(168, 85, 247, 0.08); margin-bottom: 1.5rem; border: 1.5px solid rgba(168, 85, 247, 0.15); box-shadow: 0 4px 12px rgba(168, 85, 247, 0.05);">
                    <svg  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/><circle cx="11" cy="11" r="2"/></svg>
                    Mogram Studio
                </a>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
                @if(Auth::user()->canAccess('manage_users'))
                <a href="{{ route('admin.users') }}" class="nav-item {{ Route::is('admin.users') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Usuários
                </a>
                @endif

                @if(Auth::user()->canAccess('manage_content'))
                <a href="{{ route('admin.content') }}" class="nav-item {{ Route::is('admin.content') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Conteúdo
                </a>
                <a href="{{ route('admin.lives') }}" class="nav-item {{ Route::is('admin.lives') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    Lives
                </a>
                @endif

                @if(Auth::user()->canAccess('manage_finance'))
                <div style="color: var(--text-muted); font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin: 1rem 0 0.5rem 1.25rem;">Financeiro</div>
                <a href="{{ route('admin.withdrawals') }}" class="nav-item {{ Route::is('admin.withdrawals') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Saques
                </a>
                <a href="{{ route('admin.deposits') }}" class="nav-item {{ Route::is('admin.deposits') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    Depósitos
                </a>
                @endif

                <div style="color: var(--text-muted); font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin: 1rem 0 0.5rem 1.25rem;">Relacionamento</div>
                @if(Auth::user()->canAccess('manage_support'))
                <a href="{{ route('admin.support.index') }}" class="nav-item {{ Route::is('admin.support.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Suporte e Tickets
                </a>
                @endif

                @if(Auth::user()->canAccess('manage_reports'))
                <a href="{{ route('admin.reports') }}" class="nav-item {{ Route::is('admin.reports') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Relatórios
                </a>
                <a href="{{ route('admin.logs') }}" class="nav-item {{ Route::is('admin.logs') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Logs do Sistema
                </a>
                @endif

                @if(Auth::user()->canAccess('manage_roles'))
                <a href="{{ route('admin.roles') }}" class="nav-item {{ Route::is('admin.roles*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                    Permissões
                </a>
                @endif

                @if(Auth::user()->canAccess('manage_settings'))
                <a href="{{ route('admin.settings') }}" class="nav-item {{ Route::is('admin.settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Configurações
                </a>
                @endif
            </nav>

            <div class="sidebar-profile">
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.Auth::user()->name }}" class="profile-img">
                <div class="profile-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Administrador</p>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="search-bar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Buscar usuários, conteúdo ou transações...">
                </div>
                <div class="header-actions">
                    <div class="notification-wrapper">
                        <button class="header-btn" onclick="document.getElementById('admin-notif-dropdown').classList.toggle('active')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            @if($totalAlerts > 0)
                                <span style="position: absolute; top: 8px; right: 8px; width: 10px; height: 10px; background: var(--danger); border-radius: 50%; border: 2px solid var(--bg-deep);"></span>
                            @endif
                        </button>
                        
                        <div id="admin-notif-dropdown" class="notification-dropdown">
                            <h3 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 1rem;">Notificações</h3>
                            
                            @if($openTickets > 0)
                            <a href="{{ route('admin.support.index') }}" class="notification-item">
                                <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </div>
                                <div>
                                    <h4 style="font-size: 0.8rem; font-weight: 700;">{{ $openTickets }} Tickets em aberto</h4>
                                    <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Clique para responder</p>
                                </div>
                            </a>
                            @endif

                            @if($pendingWithdrawals > 0)
                            <a href="{{ route('admin.withdrawals') }}" class="notification-item">
                                <div style="width: 32px; height: 32px; background: rgba(168, 85, 247, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div>
                                    <h4 style="font-size: 0.8rem; font-weight: 700;">{{ $pendingWithdrawals }} Saques pendentes</h4>
                                    <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Clique para processar</p>
                                </div>
                            </a>
                            @endif

                            @if($totalAlerts == 0)
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 600;">
                                <p>Tudo em dia! ✨</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="header-btn" style="color: var(--danger)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </header>

            @if(session('success'))
            <div style="background: var(--success); color: white; padding: 1rem 1.5rem; border-radius: 14px; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; font-weight: 700; box-shadow: 0 10px 30px rgba(34, 197, 94, 0.2); animation: fadeInAnim 0.3s ease-out;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div style="background: var(--danger); color: white; padding: 1rem 1.5rem; border-radius: 14px; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; font-weight: 700; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2); animation: fadeInAnim 0.3s ease-out;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif

            <div class="fade-in">
                @yield('admin_content')
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#161a26',
                        color: '#fff',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    @if(session('success'))
                        Toast.fire({
                            icon: 'success',
                            title: '{{ session("success") }}'
                        });
                    @endif

                    @if(session('error'))
                        Toast.fire({
                            icon: 'error',
                            title: '{{ session("error") }}'
                        });
                    @endif
                });
            </script>

        </main>
    </div>

    @yield('scripts')
</body>
</html>
