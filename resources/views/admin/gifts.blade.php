@extends('layouts.admin')

@section('title', 'Gerenciar Presentes Virtuais')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Monetização / Presentes Virtuais</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Presentes Virtuais</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Gerencie os itens que os usuários podem enviar como mimos.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
    @foreach($gifts as $gift)
    <div class="admin-card" style="padding: 2rem; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 2rem;">
            <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.03); border: 1.5px solid var(--border-gray); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                {{ $gift->icon }}
            </div>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 900; margin-bottom: 4px;">{{ $gift->name }}</h3>
                <p style="color: var(--success); font-weight: 800; font-size: 1rem;">R$ {{ number_format($gift->price, 2, ',', '.') }}</p>
            </div>
        </div>

        <form action="{{ route('admin.gifts.update', $gift->id) }}" method="POST" style="display: flex; flex-direction: column; gap:1.25rem;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Nome</label>
                    <input type="text" name="name" value="{{ $gift->name }}" style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-gray); border-radius: 10px; padding: 10px 14px; color: white; font-weight: 700; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Ícone (Emoji)</label>
                    <input type="text" name="icon" value="{{ $gift->icon }}" style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-gray); border-radius: 10px; padding: 10px 14px; color: white; font-weight: 700; outline: none; text-align: center;">
                </div>
            </div>
            <div>
                <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Preço (R$)</label>
                <input type="number" step="0.01" name="price" value="{{ $gift->price }}" style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-gray); border-radius: 10px; padding: 10px 14px; color: #22c55e; font-weight: 900; outline: none;">
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 0.5rem; padding: 10px;">
                Atualizar Presente
            </button>
        </form>

        <div style="position: absolute; top: 0; right: 0; padding: 1rem; opacity: 0.1; font-size: 4rem; pointer-events: none; transform: rotate(15deg);">
            {{ $gift->icon }}
        </div>
    </div>
    @endforeach

    <!-- Add New Placeholder -->
    <div class="admin-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; border-style: dashed; background: transparent; opacity: 0.6; cursor: pointer;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
        <div style="width: 50px; height: 50px; background: rgba(51, 144, 236, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 1rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <p style="font-weight: 800; color: var(--primary-blue);">Adicionar Novo Presente</p>
    </div>
</div>
@endsection
