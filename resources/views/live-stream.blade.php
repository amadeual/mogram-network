@extends('layouts.app')

@section('title', $live->title . ' - Mogram Transmissão')

@section('content')
<div class="dash-layout" style="background: #0b0a15; display: flex; flex-direction: column; overflow: hidden;">
    <!-- Main Stream Layout -->
    <div style="display: flex; flex: 1; height: calc(100vh - 60px);">
        <!-- Sidebar Navigation -->
        <aside style="width: 280px; background: #0b0a15; border-right: 1.5px solid rgba(255,255,255,0.05); padding: 1.5rem; display: flex; flex-direction: column; gap: 2rem;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
                    <defs><linearGradient id="streamLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#streamLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
                <span style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -1px;">Mogram</span>
            </div>

            <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
                <p style="font-size: 0.65rem; font-weight: 800; color: #555; text-transform: uppercase;">Menu Principal</p>
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; color: #888; text-decoration: none; padding: 0.8rem; border-radius: 12px; font-weight: 700; transition: 0.3s;" onmouseover="this.style.background='rgba(51,144,236,0.1)'; this.style.color='white'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg> Home
                </a>
                <a href="{{ route('lives') }}" style="display: flex; align-items: center; gap: 12px; color: white; text-decoration: none; padding: 0.8rem; border-radius: 12px; font-weight: 700; background: #1a1c2e;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg> Lives
                </a>
            </nav>

            <div style="margin-top: auto; padding-top: 2rem;">
                <p style="font-size: 0.65rem; font-weight: 800; color: #555; text-transform: uppercase; margin-bottom: 1rem;">Canais Sugeridos</p>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($suggestedChannels as $suggested)
                    <div class="live-card-modern" onclick="showMogramLoader(); window.location.href='{{ route('live.watch', $suggested->id) }}'" style="display: flex; align-items: center; gap: 10px; text-decoration: none; cursor: pointer;">
                        <img src="{{ $suggested->user->avatar ? Storage::url($suggested->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $suggested->user->name }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #22c55e;">
                        <div style="flex: 1;">
                            <p style="font-size: 0.75rem; font-weight: 700; color: white;">{{ $suggested->user->name }}</p>
                            <p style="font-size: 0.65rem; color: #555;">{{ Str::limit($suggested->title, 15) }}</p>
                        </div>
                        <span style="font-size: 0.65rem; color: #ef4444; font-weight: 800;">● {{ number_format(count($suggested->chats) * 1.5, 0) }}</span>
                    </div>
                    @empty
                    <p style="font-size: 0.7rem; color: #555; text-align: center;">Nenhum canal online agora.</p>
                    @endforelse
                </div>
            </div>
        </aside>

        <!-- Stream Area -->
        <main style="flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 0 1.5rem;">
            <!-- Creator Header -->
            <div style="padding: 1.5rem 0; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; gap: 1.25rem; align-items: center;">
                    <div style="position: relative; width: 64px; height: 64px; padding: 3px; border-radius: 50%; background: linear-gradient(45deg, #ef4444, #3390ec); display: flex; align-items: center; justify-content: center;">
                        <img src="{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $live->user->name }}" 
                             style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #0b0a15;">
                        <div style="position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; font-size: 8px; font-weight: 900; padding: 2px 6px; border-radius: 4px; border: 2px solid #0b0a15;">LIVE</div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: white;">{{ $live->user->name }}</h2>
                            @if($live->user->is_verified)
                                <svg width="16" height="16" fill="#3390ec" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            @endif
                        </div>
                        <p style="color: #8fb1bf; font-size: 0.95rem; font-weight: 600;">{{ $live->title }}</p>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px; align-items: center;">
                    @if(Auth::id() == $live->user_id)
                    <button onclick="deleteLive()" style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); padding: 0.75rem 1rem; border-radius: 12px; color: #ef4444; font-weight: 800; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        Encerrar
                    </button>
                    @endif
                    @if(Auth::id() != $live->user_id)
                    <button style="background: #3390ec; border: none; padding: 0.75rem 1.75rem; border-radius: 12px; color: white; font-weight: 800; cursor: pointer;">Seguir</button>
                    @endif
                </div>
            </div>

            <!-- Video Player Container (REFIXED) -->
            <div style="background: black; border-radius: 24px; position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                
                <!-- Video Layers -->
                <div id="video_layers" style="position: absolute; inset: 0;">
                    
                    <!-- 1. Video System (Active Stream) -->
                    <div id="video_wrapper" style="width: 100%; height: 100%; display: {{ $live->status == 'online' ? 'flex' : 'none' }}; gap: 4px;">
                        <div id="main_video_slot" style="flex: 1; height: 100%; position: relative; background: #000;">
                            <video id="creator_video" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                            <div id="paused_overlay" style="display: none; position: absolute; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(20px); align-items: center; justify-content: center; z-index: 50;">
                                <div style="text-align: center;">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">⏸️</div>
                                    <h3 style="color: white; font-weight: 800; text-transform: uppercase;">Transmissão Pausada</h3>
                                </div>
                            </div>
                        </div>
                        <div id="cohost_slot" style="display: none; width: 40%; height: 100%; position: relative; background: #111; border-left: 2px solid #000;">
                            <div id="cohost_waiting" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                <div class="loader" style="width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.1); border-top-color: #3390ec; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                            </div>
                            <video id="cohost_video" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover; display: none;"></video>
                        </div>
                    </div>

                    <!-- 2. Offline / Start Prompt Layer -->
                    <div id="offline_view" style="width: 100%; height: 100%; position: absolute; inset: 0; display: {{ $live->status == 'online' && Auth::id() != $live->user_id ? 'none' : 'flex' }}; flex-direction: column; align-items: center; justify-content: center;">
                        <img src="{{ Storage::url($live->thumbnail) }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;">
                        <div style="position: relative; z-index: 5; text-align: center;">
                            @if(Auth::id() == $live->user_id)
                                <div id="camera_loading" style="text-align: center;">
                                    <div style="width: 60px; height: 60px; border: 3px solid rgba(51,144,236,0.2); border-top-color: #3390ec; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1.5rem;"></div>
                                    <h3 style="color: white; font-weight: 800;">Iniciando câmera...</h3>
                                    <p style="color: #888; font-size: 0.9rem;">Aguarde, estamos preparando seu estúdio.</p>
                                </div>
                                <div id="camera_retry" style="display: none; text-align: center;">
                                    <div style="width: 80px; height: 80px; background: rgba(51, 144, 236, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 2px solid #3390ec; cursor: pointer;" onclick="startCamera()">
                                        <svg width="32" height="32" fill="#3390ec" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                                    </div>
                                    <h3 style="color: white; font-weight: 800;">Toque para iniciar a câmera</h3>
                                    <p id="camera_error_msg" style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;"></p>
                                </div>
                            @else
                                <div style="width: 50px; height: 50px; border: 3px solid rgba(255,255,255,0.1); border-top-color: white; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1.5rem;"></div>
                                <h3 style="color: white; font-weight: 800;">Aguardando o criador...</h3>
                                <p style="color: #888; font-size: 0.85rem; margin-top: 0.5rem;">A transmissão começará em breve.</p>
                            @endif
                        </div>
                    </div>

                    <!-- 3. Overlays (Live Tag, Stats) -->
                    <div style="position: absolute; top: 1.5rem; left: 1.5rem; display: flex; gap: 10px; z-index: 60;">
                        <div style="background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px;">AO VIVO</div>
                        <div style="background: rgba(0,0,0,0.5); color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; display: flex; align-items: center; gap: 5px;">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> 
                            <span id="viewer_count">{{ count($messages->unique('user_id')) }}</span>
                        </div>
                        @if(Auth::id() == $live->user_id)
                            <div style="background: rgba(51, 144, 236, 0.2); color: #3390ec; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; border: 1px solid #3390ec;">
                                GANHOS: R$ <span id="live_earnings">0,00</span>
                            </div>
                        @endif
                    </div>

                    <!-- 4. Broadcaster Tools (IN THE RIGHT PLACE) -->
                    @if(Auth::id() == $live->user_id)
                        <div id="broadcaster_tools" style="display: none; position: absolute; top: 1.5rem; right: 1.5rem; gap: 10px; z-index: 100;">
                            <button onclick="toggleAudio()" id="btn_audio" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">🎤</button>
                            <button onclick="toggleVideo()" id="btn_video" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">📹</button>
                            <button onclick="togglePause()" id="btn_pause" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">⏸</button>
                            <button onclick="inviteCoHost()" style="background: #3390ec; height: 44px; border-radius: 12px; border: none; padding: 0 1rem; color: white; font-weight: 800; cursor: pointer;">+ CO-HOST</button>
                        </div>
                    @endif

                </div> <!-- End Layers -->
            </div> <!-- End Video Container -->

            <!-- Bottom Interaction Bar -->
            <div style="margin-top: 1.5rem; background: rgba(255,255,255,0.02); border-radius: 20px; padding: 0.5rem; display: flex; gap: 0.5rem;">
                <button style="flex: 1; height: 60px; background: transparent; border: none; color: #8fb1bf; font-weight: 800; cursor: pointer;">CURTIR</button>
                <div style="width: 1px; background: rgba(255,255,255,0.05);"></div>
                <button onclick="toggleGiftModal()" style="flex: 1; color: #ffd600; font-weight: 800; background: transparent; border: none; cursor: pointer;">PRESENTEAR</button>
                <div style="width: 1px; background: rgba(255,255,255,0.05);"></div>
                <button style="flex: 1; color: #8fb1bf; font-weight: 800; background: transparent; border: none; cursor: pointer;">COMPARTILHAR</button>
            </div>
        </main>

        <!-- Right Side: Chat Area -->
        <aside style="width: 400px; background: #0b0a15; border-left: 1.5px solid rgba(255,255,255,0.05); display: flex; flex-direction: column;">
            <div style="padding: 1.25rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); font-weight: 900; color: white; display: flex; justify-content: space-between;">
                <span>Chat ao Vivo</span>
                <span style="color: #3390ec;">• {{ count($messages) }}</span>
            </div>
            
            <div id="chat_messages" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                @foreach($messages as $msg)
                    @include('partials.chat-message', ['message' => $msg])
                @endforeach
            </div>

            <div style="padding: 1.5rem; background: rgba(0,0,0,0.2);">
                @if(Auth::id() != $live->user_id)
                <div style="background: #3390ec; padding: 12px; border-radius: 12px; margin-bottom: 1rem; color: white; font-weight: 800; text-align: center; cursor: pointer;">
                    Torne-se VIP • R$ 19,90
                </div>
                @endif
                <div style="display: flex; gap: 10px;">
                    <input type="text" id="chat_input" placeholder="Diga algo..." style="flex: 1; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px; color: white; outline: none;">
                    <button onclick="sendChatMessage()" style="background: #3390ec; border: none; width: 44px; height: 44px; border-radius: 12px; color: white; cursor: pointer;">➤</button>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Scripts & Modals -->
<div id="gift_modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;">
    <div style="background: #1a1c2e; width: 400px; border-radius: 24px; padding: 2rem;">
        <h3 style="color: white; margin-bottom: 1.5rem;">Enviar Presente</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
            @foreach($gifts as $gift)
                <div onclick="selectGift({{ $gift->id }}, {{ $gift->price }}, '{{ $gift->name }}')" style="background: rgba(255,255,255,0.05); padding: 10px; border-radius: 12px; text-align: center; cursor: pointer; border: 2px solid transparent;" class="gift-card" id="gift_{{ $gift->id }}">
                    <div style="font-size: 24px;">{{ $gift->icon }}</div>
                    <div style="font-size: 10px; color: white; margin-top: 5px;">R$ {{ number_format($gift->price, 0) }}</div>
                </div>
            @endforeach
        </div>
        <button id="send_gift_btn" disabled onclick="confirmSendGift()" style="width: 100%; margin-top: 2rem; background: #3390ec; border: none; padding: 12px; border-radius: 12px; color: white; font-weight: 800; opacity: 0.5;">ENVIAR</button>
        <button onclick="toggleGiftModal()" style="width: 100%; margin-top: 0.5rem; background: transparent; border: none; color: #888; font-weight: 700; cursor: pointer;">Cancelar</button>
    </div>
</div>

<div id="toast_container" style="position: fixed; top: 2rem; right: 2rem; z-index: 9999;"></div>

<script>
    let selectedGiftId = null;
    const IS_CREATOR = {{ Auth::id() == $live->user_id ? 'true' : 'false' }};

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast_container');
        const toast = document.createElement('div');
        toast.style.cssText = `background: ${type === 'success' ? '#3390ec' : '#ef4444'}; color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1rem; font-weight: 800; animation: slideIn 0.3s forwards;`;
        toast.innerText = message;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    function showRetryUI(errorMessage) {
        const loading = document.getElementById('camera_loading');
        const retry = document.getElementById('camera_retry');
        const errorMsg = document.getElementById('camera_error_msg');
        if (loading) loading.style.display = 'none';
        if (retry) retry.style.display = 'block';
        if (errorMsg) errorMsg.textContent = errorMessage || '';
    }

    function activateStream(stream) {
        window.localStream = stream;
        const video = document.getElementById('creator_video');
        video.srcObject = stream;
        video.play().catch(() => {});

        document.getElementById('offline_view').style.display = 'none';
        document.getElementById('video_wrapper').style.display = 'flex';
        
        const tools = document.getElementById('broadcaster_tools');
        if (tools) tools.style.display = 'flex';

        // Update audio/video button states based on available tracks
        const audioBtn = document.getElementById('btn_audio');
        const videoBtn = document.getElementById('btn_video');
        const hasAudio = stream.getAudioTracks().length > 0;
        const hasVideo = stream.getVideoTracks().length > 0;
        if (audioBtn) audioBtn.style.background = hasAudio ? 'rgba(0,0,0,0.6)' : '#ef4444';
        if (videoBtn) videoBtn.style.background = hasVideo ? 'rgba(0,0,0,0.6)' : '#ef4444';

        if (typeof hideMogramLoader === 'function') hideMogramLoader();
        showToast('Câmera iniciada! Você está ao vivo.', 'success');
        
        // Signal server that we are online
        fetch('{{ route('live.start', $live->id) }}', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });

        startChatPolling();
    }

    function startCamera() {
        // Check for secure context (HTTPS or localhost)
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showRetryUI('Seu navegador não suporta acesso à câmera. Use HTTPS ou um navegador moderno.');
            showToast('Câmera não disponível neste navegador/conexão.', 'error');
            return;
        }

        if (typeof showMogramLoader === 'function') showMogramLoader();

        // Try video + audio first
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } }, audio: true })
        .then(stream => {
            activateStream(stream);
        })
        .catch(err => {
            console.warn('Full media failed, trying video only:', err.name);
            // Fallback: try video only
            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(stream => {
                activateStream(stream);
                showToast('Câmera iniciada sem áudio (microfone não disponível).', 'success');
            })
            .catch(err2 => {
                console.warn('Video only failed, trying audio only:', err2.name);
                // Fallback: try audio only
                navigator.mediaDevices.getUserMedia({ video: false, audio: true })
                .then(stream => {
                    activateStream(stream);
                    showToast('Apenas áudio disponível (câmera não encontrada).', 'success');
                })
                .catch(err3 => {
                    console.error('All media failed:', err3.name, err3.message);
                    if (typeof hideMogramLoader === 'function') hideMogramLoader();
                    
                    let errorMsg = 'Erro ao acessar câmera/microfone.';
                    if (err3.name === 'NotAllowedError' || err3.name === 'PermissionDeniedError') {
                        errorMsg = 'Permissão negada. Permita o acesso à câmera nas configurações do navegador.';
                    } else if (err3.name === 'NotFoundError' || err3.name === 'DevicesNotFoundError') {
                        errorMsg = 'Nenhuma câmera ou microfone encontrado no dispositivo.';
                    } else if (err3.name === 'NotReadableError' || err3.name === 'TrackStartError') {
                        errorMsg = 'Câmera em uso por outro aplicativo. Feche outros apps e tente novamente.';
                    } else if (err3.name === 'OverconstrainedError') {
                        errorMsg = 'Câmera não suporta a resolução solicitada.';
                    } else if (window.location.protocol !== 'https:' && window.location.hostname !== 'localhost') {
                        errorMsg = 'Câmera requer conexão segura (HTTPS). Contate o administrador.';
                    }

                    showRetryUI(errorMsg);
                    showToast(errorMsg, 'error');
                });
            });
        });
    }

    function togglePause() {
        const overlay = document.getElementById('paused_overlay');
        const btn = document.getElementById('btn_pause');
        if (!overlay || !btn) return;
        
        const isPaused = overlay.style.display === 'flex';
        overlay.style.display = isPaused ? 'none' : 'flex';
        btn.style.background = isPaused ? 'rgba(0,0,0,0.6)' : '#ef4444';
        
        // Actually pause/resume the stream tracks
        if (window.localStream) {
            window.localStream.getVideoTracks().forEach(t => t.enabled = isPaused);
            window.localStream.getAudioTracks().forEach(t => t.enabled = isPaused);
        }
        
        showToast(isPaused ? 'Live retomada!' : 'Live pausada');
    }

    function inviteCoHost() {
        document.getElementById('cohost_slot').style.display = 'block';
        showToast('Convidando co-host...');
        setTimeout(() => {
            document.getElementById('cohost_waiting').style.display = 'none';
            document.getElementById('cohost_video').style.display = 'block';
            showToast('Co-host entrou!');
        }, 3000);
    }

    function toggleAudio() {
        if (!window.localStream) return;
        const tracks = window.localStream.getAudioTracks();
        if (tracks.length === 0) { showToast('Nenhum microfone disponível.', 'error'); return; }
        const t = tracks[0];
        t.enabled = !t.enabled;
        document.getElementById('btn_audio').style.background = t.enabled ? 'rgba(0,0,0,0.6)' : '#ef4444';
        showToast(t.enabled ? 'Microfone ligado' : 'Microfone desligado');
    }

    function toggleVideo() {
        if (!window.localStream) return;
        const tracks = window.localStream.getVideoTracks();
        if (tracks.length === 0) { showToast('Nenhuma câmera disponível.', 'error'); return; }
        const t = tracks[0];
        t.enabled = !t.enabled;
        document.getElementById('btn_video').style.background = t.enabled ? 'rgba(0,0,0,0.6)' : '#ef4444';
        showToast(t.enabled ? 'Câmera ligada' : 'Câmera desligada');
    }

    function startChatPolling() {
        setInterval(() => {
            fetch('{{ route('live.messages', $live->id) }}')
            .then(res => res.json())
            .then(data => {
                if(data.success) document.getElementById('chat_messages').innerHTML = data.html;
            }).catch(() => {});
        }, 3000);

        if (!IS_CREATOR) {
            setInterval(checkLiveStatus, 5000);
        }
    }

    function checkLiveStatus() {
        fetch('{{ route('live.status', $live->id) }}')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'online') {
                window.location.reload();
            }
        }).catch(() => {});
    }

    function sendChatMessage() {
        const input = document.getElementById('chat_input');
        if(!input.value.trim()) return;
        fetch('{{ route('live.chat', $live->id) }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({message: input.value})
        }).then(() => { input.value = ''; });
    }

    function toggleGiftModal() {
        const m = document.getElementById('gift_modal');
        m.style.display = m.style.display === 'none' ? 'flex' : 'none';
    }

    function selectGift(id, price, name) {
        selectedGiftId = id;
        document.querySelectorAll('.gift-card').forEach(c => c.style.borderColor = 'transparent');
        document.getElementById('gift_'+id).style.borderColor = '#3390ec';
        const btn = document.getElementById('send_gift_btn');
        btn.disabled = false;
        btn.style.opacity = '1';
    }

    function confirmSendGift() {
        fetch('{{ route('live.gift', $live->id) }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({gift_id: selectedGiftId})
        }).then(() => { toggleGiftModal(); showToast('Presente enviado!'); });
    }

    function deleteLive() {
        openMogramModal('Encerrar Live', 'Tem certeza que deseja encerrar a transmissão? Esta ação não pode ser desfeita.', () => {
            // Stop all media tracks
            if (window.localStream) {
                window.localStream.getTracks().forEach(t => t.stop());
            }
            fetch('{{ route('live.destroy', $live->id) }}', {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            }).then(() => window.location.href = '/lives');
        });
    }

    // AUTO-START: If the current user is the creator, auto-start the camera on page load
    document.addEventListener('DOMContentLoaded', () => {
        if (IS_CREATOR) {
            // Small delay to ensure DOM is fully ready
            setTimeout(() => startCamera(), 500);
        } else {
            // For viewers, start chat polling immediately
            startChatPolling();
        }
    });
</script>

<style>
    @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection
