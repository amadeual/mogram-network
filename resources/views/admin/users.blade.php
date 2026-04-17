@extends('layouts.admin')

@section('title', 'Gerenciar Usuários')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Usuários / Gerenciar</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Gerenciar Usuários</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Visualize e gerencie todos os membros da plataforma.</p>
    </div>
    <button class="btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Adicionar Novo Usuário
    </button>
</div>

<!-- Filters Bar -->
<form action="{{ route('admin.users') }}" method="GET" class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
    <div style="flex: 1; position: relative;">
        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou e-mail..." style="width: 100%; background: transparent; border: none; padding: 10px 45px; color: white; outline: none; font-weight: 600;">
    </div>
    
    <div style="display: flex; gap: 0.75rem;">
        <select name="status" onchange="this.form.submit()" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
            <option value="">Todos os Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativos</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspensos</option>
        </select>
        <select name="role" onchange="this.form.submit()" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
            <option value="">Todas as Funções</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="creator" {{ request('role') == 'creator' ? 'selected' : '' }}>Criador</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Usuário</option>
        </select>
        <button type="submit" style="background: var(--primary-blue); border: none; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; box-shadow: 0 4px 12px rgba(51, 144, 236, 0.2);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2z"/></svg>
        </button>
    </div>
</form>

<!-- Users Table -->
<div class="admin-card" style="padding: 0; overflow: visible;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Usuário</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Função</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Carteira</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Cadastro</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;">
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$user->name }}" style="width: 40px; height: 40px; border-radius: 12px;">
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 800;">{{ $user->name }}</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">@<span>{{ $user->username }}</span></p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    @php
                        $statusColor = $user->status == 'suspended' ? 'var(--danger)' : 'var(--success)';
                        $statusLabel = $user->status == 'suspended' ? 'Suspenso' : 'Ativo';
                    @endphp
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 8px; background: {{ $statusColor }}; border-radius: 50%;"></div>
                        <span style="font-size: 0.8rem; font-weight: 800; color: {{ $statusColor }}">{{ $statusLabel }}</span>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <div style="background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840; display: inline-block;">
                        {{ ucfirst($user->role ?? 'usuário') }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; font-weight: 900; font-size: 0.9rem;">
                    R$ {{ number_format($user->balance, 2, ',', '.') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <div style="position: relative; display: inline-block;">
                        <button onclick="toggleDropdown(this)" class="actions-btn" style="background: transparent; border: none; color: white; cursor: pointer; padding: 8px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                        <div class="actions-dropdown">
                            <div class="dropdown-label">Gerenciar</div>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="dropdown-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Ver Detalhes
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-label">Ações</div>
                            
                            <form action="{{ route('admin.users.reset_password', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3L15.5 7.5z"/></svg>
                                    Resetar Senha
                                </button>
                            </form>

                            @if($user->two_factor_secret)
                                <form action="{{ route('admin.users.toggle', [$user->id, 'reset_2fa']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        Limpar 2FA
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.users.toggle', [$user->id, $user->withdrawals_frozen ? 'unfreeze_withdrawals' : 'freeze_withdrawals']) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                                    {{ $user->withdrawals_frozen ? 'Liberar Saques' : 'Bloquear Saques' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.toggle', [$user->id, $user->deposits_frozen ? 'unfreeze_deposits' : 'freeze_deposits']) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    {{ $user->deposits_frozen ? 'Liberar Depósitos' : 'Bloquear Depósitos' }}
                                </button>
                            </form>

                            <div class="dropdown-divider"></div>

                            <form action="{{ route('admin.users.toggle', [$user->id, $user->status == 'suspended' ? 'activate' : 'suspend']) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                    {{ $user->status == 'suspended' ? 'Ativar Conta' : 'Suspender Conta' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">Mostrando <strong>{{ $users->firstItem() }}</strong> a <strong>{{ $users->lastItem() }}</strong> de <strong>{{ $users->total() }}</strong> usuários</p>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    .actions-btn:hover {
        background: rgba(51, 144, 236, 0.1) !important;
        color: var(--primary-blue) !important;
        transform: scale(1.1);
    }
    .actions-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        background: rgba(17, 20, 30, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        width: 260px;
        z-index: 1000;
        box-shadow: 0 25px 60px rgba(0,0,0,0.6);
        padding: 0.85rem;
        text-align: left;
    }
    .actions-dropdown.show {
        display: block;
        animation: dropdownReveal 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes dropdownReveal {
        from { opacity: 0; transform: translateY(15px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .dropdown-label {
        padding: 0.65rem 0.85rem;
        font-size: 0.65rem;
        font-weight: 850;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        opacity: 0.6;
    }
    .dropdown-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        color: #e2e8f0;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.25s;
    }
    .dropdown-item svg {
        opacity: 0.7;
        transition: 0.2s;
    }
    .dropdown-item:hover {
        background: rgba(51, 144, 236, 0.1);
        color: white;
        padding-left: 1.25rem;
    }
    .dropdown-item:hover svg {
        opacity: 1;
        color: var(--primary-blue);
        transform: scale(1.1);
    }
    .dropdown-item.danger:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    .dropdown-item.danger:hover svg {
        color: #ef4444;
    }
    .dropdown-divider {
        height: 1px;
        background: rgba(255,255,255,0.05);
        margin: 0.6rem 0.85rem;
    }
</style>

@section('scripts')
<script>
    function toggleDropdown(btn) {
        const dropdown = btn.nextElementSibling;
        const allDropdowns = document.querySelectorAll('.actions-dropdown');
        
        allDropdowns.forEach(d => {
            if (d !== dropdown) d.classList.remove('show');
        });
        
        dropdown.classList.toggle('show');
        
        // Close on click outside
        const closeDropdown = (e) => {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
                document.removeEventListener('click', closeDropdown);
            }
        };
        
        if (dropdown.classList.contains('show')) {
            setTimeout(() => {
                document.addEventListener('click', closeDropdown);
            }, 0);
        }
    }
</script>
@endsection
@endsection
