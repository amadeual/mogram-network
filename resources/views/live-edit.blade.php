@extends('layouts.app')

@section('title', 'Mogram - Editar Live')

@section('content')
<div class="dash-layout" style="background: #0b0a15; min-height: 100vh;">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Create Area -->
    <main class="main-content" style="padding: 1rem 1.5rem;">
        
        <!-- Header Section -->
        <header style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 1rem;">
            <div>
                <p style="color: var(--primary-blue); font-weight: 800; font-size: 0.65rem; text-transform: none; letter-spacing: 2px; margin-bottom: 5px;">Editar Transmissão</p>
                <h1 style="font-size: clamp(1.5rem, 3.5vw, 2rem); font-weight: 900; color: white; letter-spacing: -1.5px; line-height: 1;">Ajustar <span style="background: linear-gradient(90deg, #3390ec, #00d2ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Live</span></h1>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 6px; font-weight: 500;">Atualize os detalhes da sua live agendada.</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="button" onclick="window.history.back()" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 0.6rem 1.2rem; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 0.85rem;" onmouseover="this.style.background='rgba(255,255,255,0.08)'">Cancelar</button>
            </div>
        </header>

        <form action="{{ route('live.update', $live->id) }}" method="POST" enctype="multipart/form-data" id="live-form">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 1rem; margin-bottom: 2rem; animation: premiumZoomIn 0.3s forwards;">
                <p style="color: #ef4444; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; margin-bottom: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Ops! Verifique os campos abaixo:
                </p>
                <ul style="color: #ef4444; font-size: 0.75rem; font-weight: 600; padding-left: 1.5rem; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="responsive-grid">
                
                <!-- Left: Form Details -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Scheduling Card -->
                    <div class="glass-editor-card">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: white;">Agendamento</h3>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <label class="scheduling-option">
                                <input type="radio" name="schedule_type" value="now" {{ $live->status != 'scheduled' ? 'checked' : '' }} onchange="toggleScheduleInput(false)">
                                <div class="option-content">
                                    <span class="dot"></span>
                                    <div class="txt">
                                        <p class="main">Agora</p>
                                        <p class="sub">Tornar imediata</p>
                                    </div>
                                </div>
                            </label>
                            <label class="scheduling-option">
                                <input type="radio" name="schedule_type" value="later" {{ $live->status == 'scheduled' ? 'checked' : '' }} onchange="toggleScheduleInput(true)">
                                <div class="option-content">
                                    <span class="dot"></span>
                                    <div class="txt">
                                        <p class="main">Agendar</p>
                                        <p class="sub">Para nova data</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="schedule_datetime_container" style="display: {{ $live->status == 'scheduled' ? 'block' : 'none' }}; animation: premiumZoomIn 0.3s forwards;">
                            <label class="premium-label">Data e Hora da Transmissão</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="mogram-input-v2 calendar-picker" min="{{ date('Y-m-d\TH:i') }}" value="{{ $live->scheduled_at ? $live->scheduled_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                    </div>

                    <!-- General Info Card -->
                    <div class="glass-editor-card">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.5rem;">
                            <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </div>
                            <h3 style="font-size: 1rem; font-weight: 800; color: white;">Informações Gerais</h3>
                        </div>

                        <!-- Title Input -->
                        <div style="margin-bottom: 1rem;">
                            <label class="premium-label">Título da Transmissão</label>
                            <input type="text" name="title" required maxlength="100" class="mogram-input-v2 @error('title') error @enderror" value="{{ old('title', $live->title) }}">
                            @error('title') <p class="field-error">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description Input -->
                        <div style="margin-bottom: 1rem;">
                            <label class="premium-label">Descrição</label>
                            <textarea name="description" required maxlength="1000" class="mogram-input-v2 @error('description') error @enderror" style="min-height: 80px; resize: none;">{{ old('description', $live->description) }}</textarea>
                            @error('description') <p class="field-error">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category Select -->
                        <div>
                            <label class="premium-label">Categoria</label>
                            <div style="position: relative;">
                                <select name="category" required class="mogram-select-v2 @error('category') error @enderror">
                                    @foreach(['Explorar', 'Música', 'Fé & Religião', 'Tecnologia', 'Educação', 'Outros'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $live->category) == $cat ? 'selected' : '' }} style="background: #1a1c2e; color: white;">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Access Config -->
                    <div class="glass-editor-card">
                         <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; background: rgba(255, 214, 0, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ffd600;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: white;">Configuração de Acesso</h3>
                        </div>

                        <div id="price_container">
                            <label class="premium-label" style="color: #ffd600;">Valor do Ingresso (R$)</label>
                            <div style="position: relative;">
                                <input type="number" name="price" step="0.01" min="5.00" required class="mogram-input-v2 @error('price') error @enderror" value="{{ old('price', $live->price) }}" style="padding-left: 3rem; border-color: rgba(255, 214, 0, 0.2); color: #ffd600; font-size: 1.3rem;">
                                <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #ffd600; font-weight: 800;">R$</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Side -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Cover Photo -->
                    <div class="glass-editor-card" style="padding: 1.25rem;">
                         <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                            <h3 style="font-size: 0.9rem; font-weight: 800; color: white;">Capa atual</h3>
                        </div>

                        <label for="thumbnail" class="thumbnail-upload-box" id="thumb_box" style="background-image: url({{ Storage::url($live->thumbnail) }}); background-size: cover; background-position: center;">
                            <div id="thumb_placeholder" style="opacity: 0;">
                                <div class="upload-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                </div>
                                <p style="font-weight: 800; color: white; font-size: 0.8rem;">Alterar capa</p>
                            </div>
                        </label>
                        <input type="file" name="thumbnail" id="thumbnail" hidden accept="image/*" onchange="previewThumb(this)">
                    </div>

                    <!-- Action Button -->
                    <div style="margin-top: 0.5rem;">
                        <button type="submit" form="live-form" class="mogram-btn-stream" id="submit-btn">
                            <span id="btn-text">Salvar Alterações</span>
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </main>
</div>

<script>
    function toggleScheduleInput(show) {
        const container = document.getElementById('schedule_datetime_container');
        const picker = document.getElementById('scheduled_at');
        if (show) {
            container.style.display = 'block';
            picker.setAttribute('required', 'required');
        } else {
            container.style.display = 'none';
            picker.removeAttribute('required');
        }
    }

    document.getElementById('live-form').addEventListener('submit', function(e) {
        if (!this.checkValidity()) return;
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '<div class="mogram-spinner" style="width:16px; height:16px;"></div> SALVANDO...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    });

    function previewThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.getElementById('thumb_box');
                box.style.backgroundImage = `url(${e.target.result})`;
                document.getElementById('thumb_placeholder').style.opacity = '0';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    /* Reuse styles from create-live */
    .responsive-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; align-items: flex-start; }
    @media (max-width: 992px) { .responsive-grid { grid-template-columns: 1fr; } }
    .glass-editor-card { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(20px); border: 1.5px solid rgba(255, 255, 255, 0.05); border-radius: 16px; padding: 1.5rem; transition: 0.3s ease; }
    .premium-label { display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; margin-bottom: 8px; }
    .mogram-input-v2 { width: 100%; background: rgba(0, 0, 0, 0.2); border: 1.5px solid rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 0.85rem 1rem; color: white; font-weight: 600; outline: none; transition: 0.3s; }
    .mogram-input-v2:focus { border-color: var(--primary-blue); }
    .mogram-select-v2 { width: 100%; background: #1a1c2e; border: 1.5px solid rgba(255, 255, 255, 0.08); border-radius: 10px; padding: 0.85rem 1rem; color: white; font-weight: 600; outline: none; appearance: none; }
    .thumbnail-upload-box { width: 100%; aspect-ratio: 16/9; background: rgba(0,0,0,0.3); border: 2px dashed rgba(255,255,255,0.1); border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; }
    .upload-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; margin-bottom: 0.5rem; }
    .mogram-btn-stream { width: 100%; padding: 1.25rem; border: none; border-radius: 16px; background: var(--primary-blue); color: white; font-weight: 900; display: flex; align-items: center; justify-content: center; gap: 12px; cursor: pointer; transition: 0.4s; }
    .mogram-spinner { border: 3px solid rgba(255,255,255,0.2); border-top: 3px solid white; border-radius: 50%; animation: spin 1s linear infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    
    .scheduling-option { cursor: pointer; }
    .scheduling-option input { display: none; }
    .scheduling-option .option-content { padding: 1rem; background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
    .scheduling-option .dot { width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.2); border-radius: 50%; position: relative; }
    .scheduling-option input:checked + .option-content { background: rgba(51,144,236,0.08); border-color: #3390ec; }
    .scheduling-option input:checked + .option-content .dot { border-color: #3390ec; background: #3390ec; }
    .scheduling-option input:checked + .option-content .dot::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 6px; height: 6px; background: white; border-radius: 50%; }
    .scheduling-option .txt .main { color: white; font-weight: 800; font-size: 0.85rem; margin: 0; }
    .scheduling-option .txt .sub { color: #64748b; font-size: 0.65rem; margin: 0; }
    
    .calendar-picker { color-scheme: dark; }
    .field-error { color: #ef4444; font-size: 0.7rem; font-weight: 700; margin-top: 5px; }
</style>
@endsection
