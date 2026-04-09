@extends('layouts.admin')

@section('title', 'Categorias de Conteúdo')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Conteúdo / Categorias</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Categorias de Conteúdo</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Gerencie a taxonomia de conteúdo da plataforma.</p>
    </div>
    <button class="btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nova Categoria
    </button>
</div>

<!-- Search Bar -->
<div class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
    <div style="flex: 1; position: relative;">
        <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Buscar por nome ou slug..." style="width: 100%; background: transparent; border: none; padding: 10px 45px; color: white; outline: none; font-weight: 600;">
    </div>
    <select style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
        <option>Todos os Status</option>
        <option>Ativas</option>
        <option>Inativas</option>
    </select>
</div>

<!-- Categories Table -->
<div class="admin-card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; width: 60px;"></th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Ícone</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Nome</th>
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Slug</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Posts</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 1.5rem 2rem; text-align: right; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.02)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.5rem 2rem; border-right: 1px solid var(--border-gray); color: var(--text-muted);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <div style="width: 42px; height: 42px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                        {{ $category['icon'] }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; font-weight: 800; font-size: 1rem;">
                    {{ $category['name'] }}
                </td>
                <td style="padding: 1.5rem 2rem;">
                    <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 8px; font-family: monospace; font-weight: 700;">/{{ $category['slug'] }}</span>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; font-weight: 800;">
                    {{ number_format($category['posts'], 0, ',', '.') }}
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center;">
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: {{ $category['status'] == 'active' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $category['status'] == 'active' ? 'var(--success)' : 'var(--danger)' }}; padding: 6px 12px; border-radius: 30px; font-size: 0.75rem; font-weight: 900; letter-spacing: 0.5px;">
                        <div style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></div>
                        {{ $category['status'] == 'active' ? 'Ativo' : 'Inativo' }}
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button style="background: transparent; border: none; color: var(--text-muted); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.1)'; this.style.color='var(--primary-blue)'" onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </button>
                        <button style="background: transparent; border: none; color: var(--text-muted); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='var(--danger)'" onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Footer info -->
    <div style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">Mostrando 1-{{ count($categories) }} de {{ count($categories) }} resultados</p>
    </div>
</div>
@endsection
