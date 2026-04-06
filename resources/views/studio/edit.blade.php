@extends('layouts.app')

@section('title', 'Editar Conteúdo - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include("partials.studio-sidebar")

    <!-- Content Area -->
    <main class="main-content" style="background: #0b0a15;">
        <header class="studio-header" style="padding: 2.5rem 3rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('studio.dashboard') }}" style="color: var(--text-muted); cursor: pointer; transition: 0.2s; background: rgba(255,255,255,0.05); padding: 0.5rem; border-radius: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 style="font-size: 2.25rem; font-weight: 900; color: white;">Editar Conteúdo</h1>
                <p style="color: var(--text-muted); font-size: 14px;">Atualize os detalhes da sua publicação.</p>
            </div>
        </header>

        <div class="studio-body" style="padding: 0 3rem 3rem;">
            <form action="{{ route('studio.update', $post->id) }}" method="POST" enctype="multipart/form-data" 
                  class="studio-grid-custom studio-card-pad" style="background: rgba(255, 255, 255, 0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem; display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem;">
                @csrf
                @method('PUT')
                
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Basic Info -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: var(--primary-blue); border-radius: 2px;"></div>
                            Título do Conteúdo
                        </label>
                        <input type="text" name="title" value="{{ $post->title }}" required
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 1rem; color: white; font-size: 14px; outline: none; transition: 0.2s;">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: #a855f7; border-radius: 2px;"></div>
                            Descrição
                        </label>
                        <textarea name="description" rows="5"
                                  style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 1rem; color: white; font-size: 14px; outline: none; transition: 0.2s; resize: none;">{{ $post->description }}</textarea>
                    </div>

                    <!-- File Upload -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: #f59e0b; border-radius: 2px;"></div>
                            Atualizar Arquivo (Opcional)
                        </label>
                        <div style="border: 2px dashed rgba(255,255,255,0.1); border-radius: 24px; padding: 3rem 2rem; text-align: center; background: rgba(255,255,255,0.01); cursor: pointer; transition: 0.3s;"
                             onclick="document.getElementById('file-input').click()">
                            <input type="file" name="file" id="file-input" hidden>
                            <div style="width: 56px; height: 56px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin: 0 auto 1.25rem;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: white; margin-bottom: 0.5rem;">Clique para trocar o arquivo</h4>
                            <p style="font-size: 12px; color: var(--text-muted);">Arquivo atual: {{ basename($post->file_path) }}</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Settings -->
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="font-size: 13px; font-weight: 800; color: white;">Tipo de Conteúdo</label>
                            <select name="type" required
                                    style="background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0.875rem; color: white; outline: none;">
                                <option value="video" {{ $post->type == 'video' ? 'selected' : '' }}>Vídeo</option>
                                <option value="image" {{ $post->type == 'image' ? 'selected' : '' }}>Imagem</option>
                                <option value="pdf" {{ $post->type == 'pdf' ? 'selected' : '' }}>Documento (PDF)</option>
                                <option value="stories" {{ $post->type == 'stories' ? 'selected' : '' }}>Stories</option>
                            </select>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="font-size: 13px; font-weight: 800; color: white;">Preço de Venda (R$)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 900;">R$</span>
                                <input type="number" name="price" step="0.01" value="{{ $post->price }}"
                                       style="background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0.875rem 1rem 0.875rem 3rem; color: white; outline: none; width: 100%;">
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem; background: rgba(51, 144, 236, 0.05); padding: 1.25rem; border-radius: 16px;">
                            <div style="flex: 1;">
                                <h5 style="font-size: 13px; font-weight: 800; color: white; margin-bottom: 2px;">Exclusivo PRO</h5>
                                <p style="font-size: 11px; color: var(--text-muted);">Apenas para assinantes.</p>
                            </div>
                            <input type="checkbox" name="is_exclusive" {{ $post->is_exclusive ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--primary-blue);">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <button type="submit" class="mogram-btn-primary" style="padding: 1.25rem; border-radius: 18px; font-weight: 900; font-size: 15px; width: 100%; box-shadow: 0 10px 25px rgba(51, 144, 236, 0.4);">
                            Salvar Alterações
                        </button>
                        <a href="{{ route('studio.dashboard') }}" style="text-align: center; font-size: 13px; font-weight: 800; color: var(--text-muted); text-decoration: none; margin-top: 0.5rem;">Descartar Mudanças</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
