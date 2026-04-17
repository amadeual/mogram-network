@extends('layouts.admin')

@section('title', 'Funções e Permissões')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Configurações / Administrativo</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Funções e Permissões</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Defina o que cada administrador pode acessar no painel.</p>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Criar Nova Função
    </a>
</div>

<div class="admin-card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 850;">Função</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 850;">Permissões Ativas</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 850;">Administradores</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 850;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr style="border-bottom: 1px solid var(--border-gray);">
                <td style="padding: 1.5rem 2rem;">
                    <div style="font-weight: 900; font-size: 1rem; color: var(--primary-blue);">{{ $role->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">slug: {{ $role->slug }}</div>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        @foreach($role->permissions as $perm)
                            <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.03);">
                                {{ $perm }}
                            </span>
                        @endforeach
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center;">
                    <span style="font-weight: 900; font-size: 1.1rem;">{{ $role->users_count }}</span>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn-primary" style="padding: 8px 12px; font-size: 0.75rem; background: rgba(255,255,255,0.05); box-shadow: none;">Editar</a>
                        <form action="{{ route('admin.roles.delete', $role->id) }}" method="POST" onsubmit="return confirm('Excluir esta função permanentemente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-primary" style="padding: 8px 12px; font-size: 0.75rem; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); color: #ef4444; box-shadow: none;">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 4rem; text-align: center; color: var(--text-muted); font-weight: 700;">Nenhuma função personalizada criada ainda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 2rem; border: 1px dashed rgba(255,255,255,0.1); background: transparent;">
    <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; font-style: italic;">
        💡 <strong>Nota:</strong> Desenvolvedores e Proprietários listados no arquivo de configuração do sistema possuem acesso total e não precisam estar vinculados a uma função.
    </p>
</div>
@endsection
