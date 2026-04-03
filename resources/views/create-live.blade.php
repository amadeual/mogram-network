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

                        <!-- Monetization -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                            <div>
                                <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Tipo de Acesso</label>
                                <select name="is_free" id="access_type" onchange="togglePrice(this.value)"
                                        style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 600; outline: none; appearance: none; cursor: pointer;">
                                    <option value="1">Grátis para todos</option>
                                    <option value="0">Pago (Ticket de Acesso)</option>
                                </select>
                            </div>
                            <div id="price_container" style="display: none;">
                                <label style="display: block; font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 1px;">Preço do Bilhete (R$)</label>
                                <input type="number" name="price" step="0.01" placeholder="0,00" 
                                       style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; color: white; font-weight: 800; font-size: 1.1rem; outline: none;">
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
                            <span style="font-weight: 700;">1.240</span>
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
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 1.1em;
    }
</style>
@endsection
