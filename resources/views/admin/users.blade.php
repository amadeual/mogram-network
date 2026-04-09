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
<div class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
    <div style="flex: 1; position: relative;">
        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Buscar por nome ou e-mail..." style="width: 100%; background: transparent; border: none; padding: 10px 45px; color: white; outline: none; font-weight: 600;">
    </div>
    
    <div style="display: flex; gap: 0.75rem;">
        <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
            <option>Todos os Status</option>
            <option>Ativos</option>
            <option>Suspensos</option>
            <option>Pendentes</option>
        </select>
        <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
            <option>Todas as Funções</option>
            <option>Administrador</option>
            <option>Criador</option>
            <option>Usuário</option>
        </select>
        <button style="background: rgba(255,255,255,0.05); border: none; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="admin-card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Usuário</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Função</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Receita Gerada</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Data de Cadastro</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$user->name }}" style="width: 40px; height: 40px; border-radius: 12px;">
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 800;">{{ $user->name }}</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">{{ $user->username }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 8px; background: {{ $user->is_verified ? 'var(--success)' : 'var(--danger)' }}; border-radius: 50%;"></div>
                        <span style="font-size: 0.8rem; font-weight: 800;">{{ $user->is_verified ? 'Ativo' : 'Pendente' }}</span>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <div style="background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840; display: inline-block;">
                        {{ ucfirst($user->role ?? 'usuário') }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; font-weight: 800; font-size: 0.9rem;">
                    R$ {{ number_format($user->balance * 2.5, 2, ',', '.') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <button style="background: transparent; border: none; color: white; cursor: pointer; padding: 8px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">Mostrando <strong>1</strong> a <strong>{{ $users->count() }}</strong> de <strong>{{ $users->total() }}</strong> usuários</p>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
