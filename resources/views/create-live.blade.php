@extends('layouts.app')

@section('title', 'Mogram - Iniciar Live')

@section('content')
<div class="dash-layout" style="background: #0b0a15; min-height: 100vh;">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Create Area -->
    <main class="main-content" style="padding: 1rem 1.5rem;">
        
        <!-- Header Section -->
        <header style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 1rem;">
            <div>
                <p style="color: var(--primary-blue); font-weight: 800; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Estúdio de Transmissão</p>
                <h1 style="font-size: clamp(1.5rem, 3.5vw, 2rem); font-weight: 900; color: white; letter-spacing: -1.5px; line-height: 1;">Configurar <span style="background: linear-gradient(90deg, #3390ec, #00d2ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Live</span></h1>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 6px; font-weight: 500;">Defina os detalhes da sua transmissão e comece a monetizar seu talento.</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="button" onclick="window.history.back()" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 0.6rem 1.2rem; border-radius: 10px; color: white; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 0.85rem;" onmouseover="this.style.background='rgba(255,255,255,0.08)'">Cancelar</button>
            </div>
        </header>

        <form action="{{ route('live.store') }}" method="POST" enctype="multipart/form-data" id="live-form">
            @csrf
            
            <div class="responsive-grid">
                
                <!-- Left: Form Details -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Core Info Card -->
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
                            <input type="text" name="title" required maxlength="100" placeholder="Ex: Show Acústico Exclusivo para Fãs! 🎸" class="mogram-input-v2">
                        </div>

                        <!-- Description Input -->
                        <div style="margin-bottom: 1rem;">
                            <label class="premium-label">Descrição (O que esperar?)</label>
                            <textarea name="description" required maxlength="1000" placeholder="Diga ao seu público sobre o que será a live..." class="mogram-input-v2" style="min-height: 80px; resize: none;"></textarea>
                        </div>

                        <!-- Dynamic Category Select -->
                        <div>
                            <label class="premium-label">Categoria do Conteúdo</label>
                            <div style="position: relative;">
                                <select name="category" required class="mogram-select-v2">
                                    <option value="" disabled selected style="background: #1a1c2e; color: white;">Selecione o nicho da sua live...</option>
                                    <optgroup label="Cultura & Entretenimento" style="background: #1a1c2e; color: #3390ec;">
                                        <option value="Música" style="background: #1a1c2e; color: white;">Música 🎵</option>
                                        <option value="Gaming" style="background: #1a1c2e; color: white;">Gaming 🎮</option>
                                        <option value="Bate-papo" style="background: #1a1c2e; color: white;">Bate-papo 💬</option>
                                        <option value="Lifestyle" style="background: #1a1c2e; color: white;">Lifestyle ✨</option>
                                    </optgroup>
                                    <optgroup label="Conhecimento & Espiritualidade" style="background: #1a1c2e; color: #3390ec;">
                                        <option value="Educação" style="background: #1a1c2e; color: white;">Educação 📚</option>
                                        <option value="Tecnologia" style="background: #1a1c2e; color: white;">Tecnologia 💻</option>
                                        <option value="Fé & Religião" style="background: #1a1c2e; color: white;">Fé & Religião 🙏</option>
                                    </optgroup>
                                    <optgroup label="Outros" style="background: #1a1c2e; color: #3390ec;">
                                        <option value="Geral" style="background: #1a1c2e; color: white;">Geral 🌍</option>
                                    </optgroup>
                                </select>
                                <div style="position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monetization Card -->
                    <div class="glass-editor-card">
                         <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; background: rgba(52, 211, 153, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #34d399;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: white;">Configuração de Acesso</h3>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <label class="access-type-card-v2">
                                <input type="radio" name="is_free" value="1" checked onchange="togglePrice(this.value)" style="display: none;">
                                <div class="card-inner">
                                    <span class="icon">🌍</span>
                                    <div class="text">
                                        <p class="t">Acesso Livre</p>
                                        <p class="d">Para todos os fãs</p>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>
                            
                            <label class="access-type-card-v2 vip">
                                <input type="radio" name="is_free" value="0" onchange="togglePrice(this.value)" style="display: none;">
                                <div class="card-inner">
                                    <span class="icon" style="background: rgba(255,214,0,0.1); color: #ffd600;">💎</span>
                                    <div class="text">
                                        <p class="t">Ticket VIP</p>
                                        <p class="d">Conteúdo pago</p>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </div>
                            </label>
                        </div>

                        <div id="price_container" style="display: none; transform-origin: top; animation: premiumZoomIn 0.3s forwards;">
                            <label class="premium-label" style="color: #ffd600;">Valor do Ingresso (R$)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #ffd600; font-weight: 800; font-size: 1.1rem;">R$</span>
                                <input type="number" name="price" step="0.01" min="1.00" placeholder="19,90" class="mogram-input-v2" style="padding-left: 3rem; border-color: rgba(255, 214, 0, 0.2); color: #ffd600; font-size: 1.3rem;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Visuals & Stats -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Thumbnail Preview Card -->
                    <div class="glass-editor-card" style="padding: 1.25rem;">
                         <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                            <h3 style="font-size: 0.9rem; font-weight: 800; color: white;">Capa da Live</h3>
                            <span style="font-size: 0.6rem; background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); padding: 3px 8px; border-radius: 6px; font-weight: 900;">16:9</span>
                        </div>

                        <label for="thumbnail" class="thumbnail-upload-box" id="thumb_box">
                            <div id="thumb_placeholder">
                                <div class="upload-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                </div>
                                <p style="font-weight: 800; color: white; font-size: 0.8rem;">Adicionar capa</p>
                            </div>
                        </label>
                        <input type="file" name="thumbnail" id="thumbnail" hidden accept="image/*" onchange="previewThumb(this)">
                    </div>

                    <!-- Audience Prediction Card -->
                    <div class="glass-editor-card" style="background: linear-gradient(135deg, rgba(51, 144, 236, 0.05) 0%, rgba(5, 4, 13, 1) 100%); padding: 1.5rem;">
                        <h3 style="font-size: 1rem; font-weight: 800; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;">
                            Audiência
                            <span style="font-size: 0.6rem; background: #22c55e; color: white; padding: 2px 8px; border-radius: 40px; animation: pulse 2s infinite;">ESTIMADA</span>
                        </h3>
                        
                        <div style="display: grid; gap: 0.75rem;">
                            <div class="stat-row">
                                <div class="label">Público Ativo</div>
                                <div class="value">{{ number_format(Auth::user()->followers()->count(), 0, ',', '.') }}</div>
                            </div>
                            <div class="stat-row">
                                <div class="label">Alcance Fãs</div>
                                <div class="value">{{ number_format(Auth::user()->followers()->count() * 1.5, 0, ',', '.') }}</div>
                            </div>
                            <div class="stat-row" style="border-top: 1.5px solid rgba(255,255,255,0.05); padding-top: 0.75rem; margin-top: 0.25rem;">
                                <div class="label" style="color: #4ade80;">Ganhos Estimados</div>
                                <div class="value" style="color: #4ade80;">R$ 0,00</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button Container -->
                    <div style="margin-top: 0.5rem;">
                        <button type="submit" form="live-form" class="mogram-btn-stream">
                            <span class="live-blink"></span>
                            INICIAR LIVE AGORA
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </main>
</div>

<script>
    function previewThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.getElementById('thumb_box');
                box.style.backgroundImage = `url(${e.target.result})`;
                box.style.backgroundSize = 'cover';
                box.style.backgroundPosition = 'center';
                document.getElementById('thumb_placeholder').style.opacity = '0';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePrice(val) {
        const container = document.getElementById('price_container');
        if (val == '0') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>

<style>
    .responsive-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 2rem;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .responsive-grid {
            grid-template-columns: 1fr;
        }
        .main-content {
            padding: 1rem !important;
        }
    }

    .glass-editor-card {
        background: rgba(255, 255, 255, 0.01);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1.5px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1rem;
        transition: 0.3s ease;
    }

    .premium-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .mogram-input-v2 {
        width: 100%;
        background: rgba(0, 0, 0, 0.2);
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        outline: none;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .mogram-input-v2:focus { border-color: var(--primary-blue); box-shadow: 0 0 15px rgba(51, 144, 236, 0.1); }
    .mogram-input-v2::placeholder { color: #334155; }

    .mogram-select-v2 {
        width: 100%;
        background: #1a1c2e;
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        outline: none;
        appearance: none;
        cursor: pointer;
    }

    .access-type-card-v2 .card-inner {
        padding: 1rem;
        background: rgba(255,255,255,0.02);
        border: 2px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: 0.3s;
    }
    .card-inner .icon { font-size: 1.25rem; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.03); border-radius: 10px; }
    .card-inner .text .t { font-weight: 800; color: white; margin: 0; font-size: 0.9rem; }
    .card-inner .text .d { font-size: 0.7rem; color: #64748b; margin: 0; }
    .radio-indicator { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.1); border-radius: 50%; margin-left: auto; transition: 0.3s; position: relative; }
    
    .access-type-card-v2 input:checked + .card-inner { background: rgba(51,144,236,0.05); border-color: #3390ec; }
    .access-type-card-v2 input:checked + .card-inner .radio-indicator { background: #3390ec; border-color: #3390ec; }
    .access-type-card-v2 input:checked + .card-inner .radio-indicator::after {
        content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 6px; height: 6px; background: white; border-radius: 50%;
    }

    .thumbnail-upload-box {
        width: 100%;
        aspect-ratio: 16/9;
        background: rgba(0,0,0,0.3);
        border: 2px dashed rgba(255,255,255,0.1);
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .upload-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #475569; margin-bottom: 0.75rem; }

    .stat-row { display: flex; justify-content: space-between; align-items: center; }
    .stat-row .label { color: #64748b; font-size: 0.85rem; font-weight: 600; }
    .stat-row .value { color: white; font-weight: 800; font-size: 0.95rem; }

    .mogram-btn-stream {
        width: 100%; padding: 1.25rem; border: none; border-radius: 16px;
        background: linear-gradient(135deg, #3390ec, #00d2ff);
        color: white; font-weight: 900; font-size: 1rem; letter-spacing: 0.5px;
        display: flex; align-items: center; justify-content: center; gap: 12px;
        cursor: pointer; transition: 0.4s;
        box-shadow: 0 15px 30px rgba(51, 144, 236, 0.2);
    }
    .mogram-btn-stream:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(51, 144, 236, 0.3); }
    .live-blink { width: 10px; height: 10px; background: white; border-radius: 50%; box-shadow: 0 0 10px white; animation: pulse 1.5s infinite; }

    @keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } 100% { opacity: 1; transform: scale(1); } }
    @keyframes premiumZoomIn { from { opacity: 0; transform: scaleY(0.8); } to { opacity: 1; transform: scaleY(1); } }
</style>
@endsection
