@extends('layouts.admin')

@section('title', 'Editar Artigo de Ajuda')

@section('admin_content')
<div style="margin-bottom: 3rem;">
    <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Central de Ajuda / Editar</p>
    <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px;">Editar: {{ $article->title }}</h1>
</div>

<form action="{{ route('admin.help.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="admin-card" style="max-width: 800px;">
    @csrf
    @method('PUT')
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Título</label>
            <input type="text" name="title" required value="{{ old('title', $article->title) }}" placeholder="Ex: Como postar conteúdo" style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: white; font-weight: 600; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary-blue)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
        </div>
        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</label>
            <select name="category" required style="width: 100%; background: #11141e; border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: white; font-weight: 600; outline: none;">
                <option value="Primeiros Passos" {{ $article->category == 'Primeiros Passos' ? 'selected' : '' }}>Primeiros Passos</option>
                <option value="Conteúdo e Studio" {{ $article->category == 'Conteúdo e Studio' ? 'selected' : '' }}>Conteúdo e Studio</option>
                <option value="Comunidades" {{ $article->category == 'Comunidades' ? 'selected' : '' }}>Comunidades</option>
                <option value="Financeiro e Ganhos" {{ $article->category == 'Financeiro e Ganhos' ? 'selected' : '' }}>Financeiro e Ganhos</option>
                <option value="Dicas Pro" {{ $article->category == 'Dicas Pro' ? 'selected' : '' }}>Dicas Pro</option>
            </select>
        </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Pequena Descrição</label>
        <textarea name="description" rows="2" style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: white; font-weight: 600; outline: none; resize: none;">{{ old('description', $article->description) }}</textarea>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Conteúdo Completo (Suporta HTML)</label>
        <textarea name="content" rows="10" required style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: white; font-weight: 600; outline: none; font-family: monospace;">{{ old('content', $article->content) }}</textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Imagem Ilustrativa</label>
            @if($article->image)
                <img src="{{ Storage::url($article->image) }}" style="width: 100px; border-radius: 8px; margin-bottom: 10px; display: block; border: 1px solid rgba(255,255,255,0.1);">
            @endif
            <input type="file" name="image" accept="image/*" style="width: 100%; color: #94a3b8; font-size: 0.9rem;">
        </div>
        <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Ordem de Exibição / Status</label>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <input type="number" name="order" value="{{ old('order', $article->order) }}" style="width: 80px; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 15px; color: white; font-weight: 600; outline: none;">
                <label style="display: flex; align-items: center; gap: 8px; color: white; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_active" {{ $article->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-blue);"> Ativo
                </label>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--border-gray);">
        <button type="submit" class="btn-primary" style="padding: 12px 40px;">Atualizar Artigo</button>
        <a href="{{ route('admin.help.index') }}" style="background: rgba(255,255,255,0.03); color: white; padding: 12px 30px; border-radius: 14px; text-decoration: none; font-weight: 800; border: 1px solid var(--border-gray);">Cancelar</a>
    </div>
</form>
@endsection
