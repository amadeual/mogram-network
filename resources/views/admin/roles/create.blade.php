@extends('layouts.admin')

@section('title', 'Criar Nova Função')

@section('admin_content')
<div style="margin-bottom: 3rem;">
    <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
        <a href="{{ route('admin.roles') }}" style="color: inherit; text-decoration: none;">Funções</a> / Criar
    </p>
    <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px;">Nova Função Admin</h1>
</div>

<form action="{{ route('admin.roles.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem;">
        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 950; margin-bottom: 2rem;">Dados Básicos</h3>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="font-size: 0.75rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.75rem;">Nome da Função (Ex: Suporte Nível 1)</label>
                <input type="text" name="name" class="mogram-input-field" placeholder="Digite o nome..." required style="height: 54px; background: rgba(0,0,0,0.2); border-radius: 12px; font-weight: 700;">
            </div>

            <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.6;">O slug será gerado automaticamente a partir do nome.</p>
        </div>

        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 950; margin-bottom: 2rem;">Atribuir Permissões</h3>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                @foreach($permissions as $slug => $label)
                <label style="display: flex; align-items: center; gap: 15px; padding: 1.25rem; background: rgba(255,255,255,0.02); border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.05); cursor: pointer; transition: 0.2s;" onmouseover="this.style.borderColor='rgba(51, 144, 236, 0.3)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'">
                    <input type="checkbox" name="permissions[]" value="{{ $slug }}" style="width: 20px; height: 20px; accent-color: var(--primary-blue);">
                    <div>
                        <span style="display: block; font-weight: 850; font-size: 0.95rem;">{{ $label }}</span>
                        <span style="font-size: 0.7rem; color: var(--text-muted); font-family: monospace;">{{ $slug }}</span>
                    </div>
                </label>
                @endforeach
            </div>

            <div style="margin-top: 3rem; display: flex; gap: 1rem;">
                <button type="submit" class="mogram-btn-primary" style="flex: 1; height: 56px; border-radius: 14px; font-weight: 950; font-size: 0.9rem;">CRIAR FUNÇÃO</button>
                <a href="{{ route('admin.roles') }}" class="mogram-btn-primary" style="flex: 0.5; height: 56px; border-radius: 14px; background: transparent; border: 1.5px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 950; text-decoration: none; display: flex; align-items: center; justify-content: center;">CANCELAR</a>
            </div>
        </div>
    </div>
</form>
@endsection
