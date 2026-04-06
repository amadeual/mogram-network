@extends('layouts.app')

@section('title', 'Mogram - Iniciar Live')

@section('content')
<div class="dash-layout">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Create Area -->
    <main class="main-content" style="padding: 1.5rem 3rem;">
        <div style="display: flex; gap: 3rem; align-items: flex-start;">
            <div style="flex: 1.5;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem;">
                    <div>
                        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 5px;">Configurar Transmissão</h2>
                        <p style="color: var(--text-gray); font-size: 0.9rem;">Preencha os detalhes para iniciar sua live agora.</p>
                    </div>
                </div>

                <form action="{{ route('live.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="editor-card" style="padding: 2.5rem;">
                        <!-- Thumbnail Selection -->
                        <div style="margin-bottom: 2.5rem; text-align: center;">
                            <label for="thumbnail" style="cursor: pointer; display: block;">
                                <div id="thumb_preview" style="width: 100%; aspect-ratio: 16/9; background: rgba(255,255,255,0.02); border: 2px dashed rgba(255,255,255,0.1); border-radius: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; transition: 0.3s; overflow: hidden; position: relative;">
                                    <svg width="48" height="48" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <span style="color: var(--text-gray); font-weight: 700; font-size: 0.9rem;">Upload Capa da Live (16:9)</span>
                                </div>
                            </label>
                            <input type="file" name="thumbnail" id="thumbnail" hidden accept="image/*" onchange="previewThumb(this)">
                        </div>

                        <!-- Title Input -->
                        <div style="margin-bottom: 2rem;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Título da Live</label>
                            <input type="text" name="title" required placeholder="Ex: Respondendo perguntas e jogando conversa fora! ✨" 
                                   style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 600; font-size: 1.1rem; outline: none; transition: 0.3s;"
                                   onfocus="this.style.borderColor='var(--primary-blue)'">
                        </div>

                        <!-- Description Input -->
                        <div style="margin-bottom: 2rem;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Descrição da Live</label>
                            <textarea name="description" required placeholder="Diga aos seus fãs o que esperar desta transmissão..." 
                                   style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 500; font-size: 1rem; outline: none; transition: 0.3s; min-height: 120px; resize: vertical;"
                                   onfocus="this.style.borderColor='var(--primary-blue)'"></textarea>
                        </div>

                        <!-- Category Input -->
                        <div style="margin-bottom: 2rem;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Categoria</label>
                            <select name="category" required style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 600; outline: none; appearance: none; cursor: pointer; transition: 0.3s;" onfocus="this.style.borderColor='var(--primary-blue)'" onchange="this.style.borderColor='rgba(255,255,255,0.08)'">
                                <option value="" disabled selected>Selecione uma categoria...</option>
                                <option value="Gaming">Gaming 🎮</option>
                                <option value="Música">Música 🎵</option>
                                <option value="Bate-papo">Bate-papo 💬</option>
                                <option value="Educação">Educação 📚</option>
                                <option value="Lifestyle">Lifestyle ✨</option>
                                <option value="Geral">Geral 🌍</option>
                            </select>
                        </div>

                        <!-- Monetization -->
                        <div style="margin-bottom: 3rem;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Tipo de Acesso</label>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                                <label class="access-type-card">
                                    <input type="radio" name="is_free" value="1" checked onchange="togglePrice(this.value)" style="display: none;">
                                    <div class="card-content">
                                        <div class="icon-wrap">🌍</div>
                                        <div style="flex: 1;">
                                            <h4 style="color: white; font-size: 1rem; font-weight: 800; margin: 0;">Público Geral</h4>
                                            <p style="color: var(--text-gray); font-size: 0.8rem; margin: 0; line-height: 1.2;">Live grátis para todos os seguidores</p>
                                        </div>
                                        <div class="check-circle"></div>
                                    </div>
                                </label>
                                
                                <label class="access-type-card">
                                    <input type="radio" name="is_free" value="0" onchange="togglePrice(this.value)" style="display: none;">
                                    <div class="card-content">
                                        <div class="icon-wrap" style="background: rgba(255,214,0,0.1); color: #ffd600;">💎</div>
                                        <div style="flex: 1;">
                                            <h4 style="color: white; font-size: 1rem; font-weight: 800; margin: 0;">Ticket VIP</h4>
                                            <p style="color: var(--text-gray); font-size: 0.8rem; margin: 0; line-height: 1.2;">Live fechada e monetizada</p>
                                        </div>
                                        <div class="check-circle"></div>
                                    </div>
                                </label>
                            </div>

                            <div id="price_container" style="display: none; animation: slideDown 0.3s ease;">
                                <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Preço do Bilhete VIP (R$)</label>
                                <input type="number" name="price" step="0.01" placeholder="Ex: 19,90" 
                                       style="width: 100%; background: rgba(255,255,255,0.03); border: 2px solid rgba(255,214,0,0.3); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 800; font-size: 1.1rem; outline: none; transition: 0.3s;"
                                       onfocus="this.style.borderColor='#ffd600'">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.5rem; border-radius: 20px; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; justify-content: center; gap: 1rem; box-shadow: 0 15px 40px rgba(0,133,255,0.4);">
                            <div style="width: 12px; height: 12px; background: white; border-radius: 50%; box-shadow: 0 0 10px white; animation: pulse 1.5s infinite;"></div>
                            Iniciar Transmissão Ao Vivo
                        </button>
                    </div>
                </form>
            </div>

            <!-- Dashboard Info -->
            <div style="flex: 1;">
                <div class="editor-card" style="padding: 2rem; background: rgba(255,255,255,0.02); border: none;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 1.5rem;">Sua audiência agora</h3>
                    <div style="display: flex; gap: 1.5rem; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-gray); font-size: 0.9rem;">Assinantes Online</span>
                            <span style="font-weight: 700;">{{ number_format(Auth::user()->followers()->count(), 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-gray); font-size: 0.9rem;">Ganhos estimados</span>
                            <span style="font-weight: 700; color: #4ADE80;">R$ 0,00</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(255,214,0,0.05); border-radius: 20px; border: 1px solid rgba(255,214,0,0.1);">
                    <p style="color: #ffd600; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 10px;">Lembrete</p>
                    <p style="color: #ccc; font-size: 0.85rem; line-height: 1.5;">Lives pagas costumam gerar 3x mais engajamento profundo com fãs VIP.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function previewThumb(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('thumb_preview');
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                preview.style.borderStyle = 'solid';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePrice(val) {
        document.getElementById('price_container').style.display = (val == '0') ? 'block' : 'none';
    }
</script>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .access-type-card {
        display: block;
        cursor: pointer;
    }
    .card-content {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: rgba(255,255,255,0.02);
        border: 2px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .icon-wrap {
        width: 44px; height: 44px;
        background: rgba(51, 144, 236, 0.1);
        color: #3390ec;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
    }
    .check-circle {
        width: 24px; height: 24px;
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 50%;
        transition: 0.3s;
        position: relative;
    }
    .access-type-card input:checked + .card-content {
        background: rgba(51, 144, 236, 0.05);
        border-color: #3390ec;
    }
    
    .access-type-card input[value="0"]:checked + .card-content {
        background: rgba(255, 214, 0, 0.05);
        border-color: #ffd600;
    }
    .access-type-card input[value="0"]:checked + .card-content .check-circle {
        border-color: #ffd600;
        background: #ffd600;
    }
    
    .access-type-card input:checked + .card-content .check-circle {
        border-color: #3390ec;
        background: #3390ec;
    }
    .access-type-card input:checked + .card-content .check-circle::after {
        content: '';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 10px; height: 10px; background: white; border-radius: 50%;
    }

    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
