@extends('layouts.app')

@section('title', $live->title . ' - Mogram Transmissão')

@section('content')
<div class="dash-layout" style="background: #0b0a15; display: flex; flex-direction: column; overflow: hidden;">
    <!-- Main Stream Layout -->
    <!-- Amazon IVS SDKs -->
    <script src="https://web-broadcast.live-video.net/1.8.0/amazon-ivs-web-broadcast.js"></script>
    <script src="https://player.live-video.net/1.24.0/amazon-ivs-player.min.js"></script>
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
                    <button id="end_live_btn" onclick="deleteLive(this)" style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); padding: 0.75rem 1rem; border-radius: 12px; color: #ef4444; font-weight: 800; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        Encerrar
                    </button>
                    @endif
                    @if(Auth::id() != $live->user_id)
                    <button style="background: #3390ec; border: none; padding: 0.75rem 1.75rem; border-radius: 12px; color: white; font-weight: 800; cursor: pointer;">Seguir</button>
                    @endif
                </div>
            </div>

            <!-- Video Player Container -->
            <div id="video_player_container" style="background: black; border-radius: 24px; position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                
                <!-- Video Layers -->
                <div id="video_layers" style="position: absolute; inset: 0;">
                    
                    <!-- 1. Video System (Active Stream) -->
                    <div id="video_wrapper" style="width: 100%; height: 100%; display: none; gap: 4px;">
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
                            <video id="cohost_video" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover; display: none;"></video>
                        </div>
                        
                        <div id="unmute_prompt" style="display: none; position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 80; align-items: center; justify-content: center; cursor: pointer;" onclick="unmuteVideo()">
                            <div style="background: var(--primary-blue); color: white; padding: 1rem 2rem; border-radius: 50px; font-weight: 800; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.4);">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
                                CLIQUE PARA ATIVAR O SOM
                            </div>
                        </div>

                        <!-- 6. Media Status Overlays -->
                        <div id="muted_overlay" style="display: none; position: absolute; top: 1rem; right: 1rem; background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 6px 12px; border-radius: 20px; z-index: 90; align-items: center; gap: 6px;">
                            <span>🔇</span> MICROFONE MUTADO
                        </div>
                        <div id="camera_off_overlay" style="display: none; position: absolute; inset: 0; background: rgba(0,0,0,0.8); z-index: 70; align-items: center; justify-content: center;">
                            <div style="text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📷</div>
                                <h3 style="color: white; font-weight: 800;">CÂMERA DESLIGADA</h3>
                            </div>
                        </div>
                        <div id="ended_overlay" style="display: none; position: absolute; inset: 0; background: #0b0a15; z-index: 200; align-items: center; justify-content: center; flex-direction: column;">
                            <div style="width: 80px; height: 80px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; box-shadow: 0 0 30px rgba(239, 68, 68, 0.4);">
                                <svg width="40" height="40" fill="white" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4-9h-8v2h8v-2z"/></svg>
                            </div>
                            <h2 style="color: white; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Transmissão Encerrada</h2>
                            <p style="color: #888; font-weight: 600; margin-bottom: 2rem;">Obrigado por assistir!</p>
                            <a href="{{ route('lives') }}" style="background: #3390ec; color: white; text-decoration: none; padding: 12px 30px; border-radius: 12px; font-weight: 800;">Explorar outras lives</a>
                        </div>

                        <!-- 7. Paid Entry Overlay -->
                        @if(isset($hasAccess) && !$hasAccess)
                        <div id="payment_overlay" style="position: absolute; inset: 0; background: #0b0a15; z-index: 300; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 2rem; text-align: center;">
                            <div style="width: 100px; height: 100px; background: rgba(255, 214, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 2rem; border: 2px solid #ffd600; box-shadow: 0 0 50px rgba(255, 214, 0, 0.2);">
                                <span style="font-size: 3rem;">💎</span>
                            </div>
                            <h2 style="color: white; font-weight: 900; font-size: 1.75rem; margin-bottom: 0.5rem; letter-spacing: -1px;">Transmissão VIP</h2>
                            <p style="color: #888; font-weight: 600; max-width: 300px; margin-bottom: 2rem;">Esta é uma live exclusiva para apoiadores. Adquira seu ticket para entrar agora.</p>
                            
                            <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); padding: 1.5rem 2rem; border-radius: 20px; margin-bottom: 2rem; min-width: 200px;">
                                <p style="color: #ffd600; font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Valor Total</p>
                                <p style="color: white; font-size: 2rem; font-weight: 900;">R$ {{ number_format($live->price, 2, ',', '.') }}</p>
                            </div>

                            <form action="{{ route('live.buy', $live->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: linear-gradient(135deg, #ffd600, #ff9100); border: none; padding: 1rem 3rem; border-radius: 12px; color: black; font-weight: 900; cursor: pointer; font-size: 1rem; box-shadow: 0 10px 30px rgba(255,214,0,0.3); transition: 0.3s;" onmouseover="this.style.scale='1.05'" onmouseout="this.style.scale='1'">
                                    COMPRAR TICKET AGORA
                                </button>
                            </form>
                            <a href="{{ route('lives') }}" style="margin-top: 1.5rem; color: #64748b; text-decoration: none; font-weight: 700; font-size: 0.9rem;">Voltar para Explorar</a>
                        </div>
                        @endif
                    </div>

                    <!-- 2. Offline / Start Prompt Layer -->
                    <div id="offline_view" style="width: 100%; height: 100%; position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 150; background: #0b0a15;">
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

                    <!-- 3. Overlays -->
                    <div style="position: absolute; top: 1.5rem; left: 1.5rem; display: flex; gap: 10px; z-index: 60;">
                        <div style="background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px;">AO VIVO</div>
                        <div style="background: rgba(0,0,0,0.5); color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; display: flex; align-items: center; gap: 5px;">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> 
                            <span id="viewer_count_overlay">{{ count($messages->unique('user_id')) }}</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.1); color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; display: flex; align-items: center; gap: 5px;">
                            ❤️ <span id="likes_count_overlay">{{ $live->likes()->count() }}</span>
                        </div>
                        <div id="connection_status_tag" style="background: rgba(51,144,236,0.3); color: #3390ec; font-size: 8px; font-weight: 900; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(51,144,236,0.3);">
                            STATUS: INICIANDO...
                        </div>
                    </div>

                    <!-- 4. Broadcaster Tools -->
                    @if(Auth::id() == $live->user_id)
                        <div id="broadcaster_tools" style="display: none; position: absolute; top: 1.5rem; right: 1.5rem; display: flex; flex-direction: column; gap: 10px; z-index: 100;">
                            <button onclick="toggleAudio()" id="btn_audio" title="Mudar Áudio" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">🎤</button>
                            <button onclick="toggleVideo()" id="btn_video" title="Mudar Vídeo" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">📹</button>
                            <button onclick="togglePause()" id="btn_pause" title="Pausar" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">⏸</button>
                            <button onclick="toggleScreenShare()" id="btn_screen" title="Compartilhar Tela" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">🖥️</button>
                            <button onclick="switchCamera()" id="btn_flip" title="Trocar Câmera" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">🔄</button>
                        </div>
                    @endif

                    <button id="btn_fullscreen" onclick="toggleFullscreen()" style="position: absolute; bottom: 1.5rem; right: 1.5rem; background: rgba(0,0,0,0.5); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer; z-index: 100; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Interaction Bar -->
            <div style="margin-top: 1.5rem; background: rgba(255,255,255,0.03); border-radius: 20px; padding: 0.5rem; display: flex; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.05);">
                @php
                    $hasLiked = Auth::check() ? $live->likes()->where('user_id', Auth::id())->exists() : false;
                @endphp
                <button onclick="toggleLikeLive()" id="btn_like_live" style="flex: 1; height: 60px; background: transparent; border: none; color: {{ $hasLiked ? '#ef4444' : '#8fb1bf' }}; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <svg width="20" height="20" fill="{{ $hasLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span>CURTIR <span id="likes_count_text" style="font-size: 0.75rem; opacity: 0.7;">{{ $live->likes()->count() > 0 ? $live->likes()->count() : '' }}</span></span>
                </button>

                @if(Auth::id() != $live->user_id)
                    <button onclick="toggleGiftModal()" style="flex: 1; color: #ffd600; font-weight: 800; background: transparent; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>🎁</span> PRESENTEAR
                    </button>
                @endif

                <button onclick="shareLive()" style="flex: 1; color: #8fb1bf; font-weight: 800; background: transparent; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <span>🔗</span> COMPARTILHAR
                </button>
            </div>
        </main>

        <!-- Right Side: Chat Area -->
        <aside style="width: 400px; background: #0b0a15; border-left: 1.5px solid rgba(255,255,255,0.05); display: flex; flex-direction: column;">
            <div style="padding: 1.25rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); font-weight: 900; color: white;">Chat ao Vivo</div>
            
            <div id="chat_messages" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                @foreach($messages as $msg)
                    @include('partials.chat-message', ['message' => $msg])
                @endforeach
            </div>

            <div style="padding: 1.25rem; background: rgba(0,0,0,0.2); border-top: 1.5px solid rgba(255,255,255,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    @foreach(['❤️','🔥','👏','🤣','😮','😭','💰','🙌'] as $emoji)
                        <span onclick="insertEmoji('{{ $emoji }}')" style="cursor: pointer; font-size: 1.1rem;">{{ $emoji }}</span>
                    @endforeach
                </div>

                <div style="display: flex; gap: 10px;">
                    <input type="text" id="chat_input" placeholder="Diga algo..." style="flex: 1; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 12px 15px; color: white; outline: none;">
                    <button onclick="sendChatMessage()" id="btn_send_chat" style="background: #3390ec; border: none; width: 48px; border-radius: 16px; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Scripts -->
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

<div id="toast_container" style="position: fixed; top: 2rem; right: 2rem; z-index: 10005;"></div>

<!-- Custom Confirmation Modal -->
<div id="mogram_confirm_modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); z-index: 10006; align-items: center; justify-content: center; padding: 2rem;">
    <div style="background: #1a1c2e; width: 100%; max-width: 400px; border-radius: 24px; padding: 2rem; border: 1.5px solid rgba(255,255,255,0.05); text-align: center; box-shadow: 0 40px 100px rgba(0,0,0,0.9);">
        <div id="confirm_icon" style="width: 60px; height: 60px; background: rgba(239,68,68,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #ef4444;">
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 id="confirm_title" style="color: white; font-weight: 800; font-size: 1.25rem; margin-bottom: 0.5rem;">Confirmar Ação</h3>
        <p id="confirm_msg" style="color: #888; font-size: 0.9rem; line-height: 1.5; margin-bottom: 2rem; font-weight: 600;"></p>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <button id="confirm_btn_yes" style="background: #ef4444; color: white; border: none; padding: 1rem; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Sim, encerrar</button>
            <button id="confirm_btn_no" style="background: transparent; color: #555; border: none; padding: 0.8rem; border-radius: 12px; font-weight: 700; cursor: pointer;" onmouseover="this.style.color='#888'" onmouseout="this.style.color='#555'">Cancelar</button>
        </div>
    </div>
</div>

<script>
    const IS_CREATOR = {{ Auth::id() == $live->user_id ? 'true' : 'false' }};
    const IVS_INGEST_ENDPOINT = '{{ env('AWS_IVS_INGEST_ENDPOINT') }}';
    const IVS_STREAM_KEY = '{{ env('AWS_IVS_STREAM_KEY') }}';
    const IVS_PLAYBACK_URL = '{{ env('AWS_IVS_PLAYBACK_URL') }}';
    
    let ivsBroadcaster = null;
    let ivsPlayer = null;
    let selectedGiftId = null;

    function updateStatus(text, color = '#3390ec') {
        const tag = document.getElementById('connection_status_tag');
        if (tag) {
            tag.innerText = 'STATUS: ' + text.toUpperCase();
            tag.style.color = color;
            tag.style.borderColor = color;
        }
    }

    // --- AMAZON IVS LOGIC ---

    function initIVS() {
        console.log('Initializing Amazon IVS...');
        
        if (IS_CREATOR) {
            initBroadcaster();
        } else {
            initPlayer();
        }
    }

    async function initBroadcaster() {
        if (!IVS_INGEST_ENDPOINT || !IVS_STREAM_KEY) {
            updateStatus('Erro: IVS Config faltando', '#ef4444');
            console.error('Amazon IVS credentials missing in .env');
            // Try fallback to local if needed, or just stop
            return;
        }

        // Fix: Use the global namespace correctly
        const IVS = window.IVSBroadcastClient;
        if (!IVS) {
            console.error('Amazon IVS Broadcast SDK not loaded');
            updateStatus('Erro: SDK não carregado', '#ef4444');
            return;
        }
        
        try {
            ivsBroadcaster = IVS.create({
                streamConfig: IVS.BASIC_LANDSCAPE,
                ingestEndpoint: IVS_INGEST_ENDPOINT,
            });

            const preview = document.getElementById('creator_video');
            ivsBroadcaster.attachPreview(preview);
            
            updateStatus('IVS Pronto', '#22c55e');

            ivsBroadcaster.on(IVS.Events.ERROR, (err) => {
                console.error('Broadcaster Error:', err);
                updateStatus('Erro na Transmissão', '#ef4444');
            });

            ivsBroadcaster.on(IVS.Events.CONNECTION_STATE_CHANGE, (state) => {
                console.log('IVS State:', state);
                if (state === 'CONNECTED') updateStatus('Ao Vivo (Amazon)', '#22c55e');
                if (state === 'DISCONNECTED') updateStatus('Offline', '#ff9800');
            });

            // Automatically start camera and broadcast for the creator
            console.log('Starting IVS Camera and Broadcast...');
            await startBroadcasting();

        } catch (err) {
            console.error('Broadcaster Init Failed:', err);
            updateStatus('Erro no Broadcaster', '#ef4444');
            showRetryUI('Não foi possível iniciar o broadcaster: ' + err.message);
        }
    }

    function initPlayer() {
        if (!IVSPlayer.isPlayerSupported) {
            updateStatus('Navegador sem suporte', '#ef4444');
            return;
        }

        ivsPlayer = IVSPlayer.create();
        const videoElement = document.getElementById('creator_video');
        ivsPlayer.attachHTMLVideoElement(videoElement);
        
        updateStatus('Conectando...', '#3390ec');

        ivsPlayer.addEventListener(IVSPlayer.PlayerEventType.STATE_CHANGED, (state) => {
            console.log('Player State:', state);
            if (state === 'BUFFERING') updateStatus('Carregando...', '#3390ec');
            if (state === 'PLAYING') {
                updateStatus('Ao Vivo', '#22c55e');
                document.getElementById('offline_view').style.display = 'none';
                document.getElementById('video_wrapper').style.display = 'flex';
            }
            if (state === 'IDLE') updateStatus('Aguardando Criador...', '#3390ec');
        });

        ivsPlayer.addEventListener(IVSPlayer.PlayerEventType.ERROR, (err) => {
            console.error('Player error:', err);
            updateStatus('Erro de conexão', '#ef4444');
            // Auto-retry after 5s
            setTimeout(() => {
                if(IVS_PLAYBACK_URL) ivsPlayer.load(IVS_PLAYBACK_URL);
            }, 5000);
        });

        if (IVS_PLAYBACK_URL) {
            ivsPlayer.load(IVS_PLAYBACK_URL);
            ivsPlayer.play();
        } else {
            updateStatus('Aguardando Transmissão...', '#3390ec');
        }
    }

    // Replace startCamera logic for IVS
    async function startBroadcasting() {
        if (!ivsBroadcaster) {
            console.error('Broadcaster not initialized');
            showRetryUI('Broadcaster não inicializado.');
            return;
        }

        try {
            console.log('Requesting User Media...');
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { width: 1280, height: 720 },
                audio: true
            });

            window.localStream = stream;
            
            // Add devices to IVS
            console.log('Adding devices to IVS Broadcaster...');
            await ivsBroadcaster.addVideoInputDevice(stream, 'camera', { index: 0 });
            await ivsBroadcaster.addAudioInputDevice(stream, 'mic');

            console.log('Broadcasting to Amazon IVS...');
            await ivsBroadcaster.startBroadcast(IVS_STREAM_KEY);
            
            // Sync with DB
            fetch('{{ route('live.start', $live->id) }}', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });

            // UI Updates
            console.log('IVS Broadcast Started Successfully');
            document.getElementById('offline_view').style.display = 'none';
            document.getElementById('video_wrapper').style.display = 'flex';
            const tools = document.getElementById('broadcaster_tools');
            if (tools) tools.style.display = 'flex';

            if (!window.chatPollingStarted) {
                startChatPolling();
                window.chatPollingStarted = true;
            }

        } catch (err) {
            console.error('Start Broadcast Error:', err);
            updateStatus('Erro de Câmera', '#ef4444');
            showRetryUI('Erro ao acessar câmera/microfone: ' + err.message);
        }
    }

    // Call initIVS instead of initPeer
    window.addEventListener('load', () => {
        initIVS();
    });

    function initPeer() { /* Disabled for Amazon IVS */ }
                    c.on('close', () => { window.activeCalls = window.activeCalls.filter(cl => cl !== c); });
                }
            };
        }

        peer.on('error', (err) => {
            console.error('Peer error type:', err.type);
            if (err.type === 'peer-unavailable') {
                // Handled by retry logic
            } else if (err.type === 'id-taken') {
                if (IS_CREATOR) {
                    console.warn('Creator ID taken (ghost session?), retrying in 5 seconds...');
                    setTimeout(() => window.location.reload(), 5000);
                }
            } else if (err.type === 'network' || err.type === 'server-error') {
                setTimeout(() => {
                    if (peer && !peer.destroyed) peer.reconnect();
                }, 5000);
            }
        });
    }

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast_container');
        const toast = document.createElement('div');
        toast.style.cssText = `background: ${type === 'success' ? '#3390ec' : '#ef4444'}; color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1rem; font-weight: 800;`;
        toast.innerText = message;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    function showRetryUI(errorMessage) {
        document.getElementById('camera_loading').style.display = 'none';
        document.getElementById('camera_retry').style.display = 'block';
        document.getElementById('camera_error_msg').textContent = errorMessage || '';
    }

    function activateStream(stream) {
        if (window.localStream) {
            const videoTrack = stream.getVideoTracks()[0];
            replaceVideoTrack(videoTrack);
            
            // Audio replacement
            const audioTrack = stream.getAudioTracks()[0];
            const oldAudio = window.localStream.getAudioTracks()[0];
            if (oldAudio) {
                oldAudio.stop();
                window.localStream.removeTrack(oldAudio);
            }
            window.localStream.addTrack(audioTrack);
        } else {
            window.localStream = stream;
            const video = document.getElementById('creator_video');
            video.srcObject = window.localStream;
            video.play().catch(() => {});
        }

        document.getElementById('offline_view').style.display = 'none';
        document.getElementById('video_wrapper').style.display = 'flex';
        
        const tools = document.getElementById('broadcaster_tools');
        if (tools) tools.style.display = 'flex';

        if (IS_CREATOR) {
            console.log('CREATOR: Streaming to server...');
            showToast('Sua live está ativa!', 'success');
        } else {
            console.log('VIEWER: Connection established, waiting for stream data...');
        }
        
        if (window.answerPendingCalls) window.answerPendingCalls();
        
        fetch('{{ route('live.start', $live->id) }}', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });

        if (!window.chatPollingStarted) {
            startChatPolling();
        }
    }

    function startBroadcasterPreview() {
        startBroadcasting();
    }

    function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showRetryUI('Câmera não suportada neste navegador.');
            return;
        }

        const constraints = {
            video: { 
                facingMode: currentFacingMode || 'user',
                width: { ideal: 1280 }, 
                height: { ideal: 720 } 
            },
            audio: { echoCancellation: true, noiseSuppression: true }
        };

        navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => activateStream(stream))
        .catch(err => {
            console.error('Camera error:', err);
            // Fallback for environment
            if (currentFacingMode === 'environment') {
                currentFacingMode = 'user';
                return startCamera();
            }
            showRetryUI('Houve um erro ao acessar a câmera: ' + err.message);
        });
    }

    function unmuteVideo() {
        const video = document.getElementById('creator_video');
        video.muted = false;
        document.getElementById('unmute_prompt').style.display = 'none';
        
        // Ensure AudioContext is resumed for WebRTC
        if (window.AudioContext || window.webkitAudioContext) {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            if (ctx.state === 'suspended') ctx.resume();
        }
        
        showToast('Áudio ativado!', 'success');
    }

    function togglePause() {
        const overlay = document.getElementById('paused_overlay');
        const isCurrentlyPaused = overlay.style.display === 'flex';
        const willBePaused = !isCurrentlyPaused;

        overlay.style.display = willBePaused ? 'flex' : 'none';
        document.getElementById('btn_pause').style.background = willBePaused ? '#ef4444' : 'rgba(0,0,0,0.6)';
        
        if (window.localStream) {
            window.localStream.getVideoTracks().forEach(t => t.enabled = !willBePaused);
            window.localStream.getAudioTracks().forEach(t => t.enabled = !willBePaused);
        }

        // Broadcast to server (we use the existing start route or a generic toggle)
        fetch('/lives/' + {{ $live->id }} + '/pause', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ paused: willBePaused })
        });
    }

    let isScreenSharing = false;
    let currentFacingMode = 'user';
    let activeCalls = []; // Track active PeerJS calls to replace tracks

    function toggleAudio() {
        if (!window.localStream) return;
        const t = window.localStream.getAudioTracks()[0];
        if (t) {
            t.enabled = !t.enabled;
            const isMuted = !t.enabled;
            document.getElementById('btn_audio').style.background = t.enabled ? 'rgba(0,0,0,0.6)' : '#ef4444';
            document.getElementById('muted_overlay').style.display = isMuted ? 'flex' : 'none';
            
            fetch('/lives/' + {{ $live->id }} + '/media', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: JSON.stringify({ type: 'audio', value: isMuted })
            });
        }
    }

    function toggleVideo() {
        if (!window.localStream) return;
        const t = window.localStream.getVideoTracks()[0];
        if (t) {
            t.enabled = !t.enabled;
            const isOff = !t.enabled;
            document.getElementById('btn_video').style.background = t.enabled ? 'rgba(0,0,0,0.6)' : '#ef4444';
            document.getElementById('camera_off_overlay').style.display = isOff ? 'flex' : 'none';

            fetch('/lives/' + {{ $live->id }} + '/media', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: JSON.stringify({ type: 'video', value: isOff })
            });
        }
    }

    async function toggleScreenShare() {
        if (!isScreenSharing) {
            try {
                const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                const videoTrack = screenStream.getVideoTracks()[0];
                
                replaceVideoTrack(videoTrack);
                
                videoTrack.onended = () => {
                    stopScreenShare();
                };
                
                isScreenSharing = true;
                document.getElementById('btn_screen').style.background = '#3390ec';
                document.getElementById('btn_flip').style.display = 'none'; // Can't flip screen share
            } catch (err) {
                console.error("Error starting screen share:", err);
            }
        } else {
            stopScreenShare();
        }
    }

    async function stopScreenShare() {
        isScreenSharing = false;
        document.getElementById('btn_screen').style.background = 'rgba(0,0,0,0.6)';
        document.getElementById('btn_flip').style.display = 'block';
        await startCamera(); // Return to camera
    }

    async function switchCamera() {
        if (isScreenSharing) return;
        currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
        await startCamera();
    }

    function replaceVideoTrack(newTrack) {
        if (!window.localStream) return;
        
        const oldTrack = window.localStream.getVideoTracks()[0];
        if (oldTrack) {
            oldTrack.stop();
            window.localStream.removeTrack(oldTrack);
        }
        
        window.localStream.addTrack(newTrack);
        document.getElementById('creator_video').srcObject = window.localStream;

        // Replace track in all active PeerJS calls
        if (!window.activeCalls) window.activeCalls = [];
        window.activeCalls.forEach(call => {
            const peerConnection = call.peerConnection;
            if (peerConnection) {
                const sender = peerConnection.getSenders().find(s => s.track && s.track.kind === 'video');
                if (sender) {
                    sender.replaceTrack(newTrack);
                }
            }
        });
    }

    function startChatPolling() {
        setInterval(() => {
            fetch('{{ route('live.messages', $live->id) }}')
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const box = document.getElementById('chat_messages');
                    const wasAtBottom = box.scrollHeight - box.clientHeight <= box.scrollTop + 100;
                    box.innerHTML = data.html;
                    if (wasAtBottom) box.scrollTop = box.scrollHeight;
                }
            });

            fetch('{{ route('live.status', $live->id) }}')
            .then(res => {
                if (res.status === 404) throw new Error('Ended');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.status === 'ended') throw new Error('Ended');

                    document.getElementById('viewer_count_overlay').innerText = data.viewer_count;
                    document.getElementById('likes_count_overlay').innerText = data.likes_count;
                    
                    // Sync States for Audience
                    if (!IS_CREATOR) {
                        document.getElementById('paused_overlay').style.display = data.is_paused ? 'flex' : 'none';
                        document.getElementById('muted_overlay').style.display = data.is_muted ? 'flex' : 'none';
                        document.getElementById('camera_off_overlay').style.display = data.is_camera_off ? 'flex' : 'none';
                    }
                }
            })
            .catch(err => {
                if (err.message === 'Ended') {
                    document.getElementById('ended_overlay').style.display = 'flex';
                }
            });
        }, 3000);
    }

    function insertEmoji(emoji) {
        document.getElementById('chat_input').value += emoji;
    }

    function sendChatMessage() {
        const input = document.getElementById('chat_input');
        const message = input.value.trim();
        if(!message) return;
        input.value = '';

        fetch('{{ route('live.chat', $live->id) }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({message: message})
        });
    }

    document.getElementById('chat_input').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendChatMessage();
    });

    function toggleLikeLive() {
        fetch('{{ route('live.like', $live->id) }}', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });
    }

    function shareLive() {
        navigator.clipboard.writeText(window.location.href);
        showToast('Link copiado!');
    }

    function toggleFullscreen() {
        const c = document.getElementById('video_player_container');
        if (!document.fullscreenElement) c.requestFullscreen();
        else document.exitFullscreen();
    }

    function toggleGiftModal() {
        const m = document.getElementById('gift_modal');
        m.style.display = m.style.display === 'none' ? 'flex' : 'none';
    }

    function selectGift(id) {
        selectedGiftId = id;
        document.getElementById('send_gift_btn').disabled = false;
        document.getElementById('send_gift_btn').style.opacity = '1';
    }

    function confirmSendGift() {
        fetch('{{ route('live.gift', $live->id) }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({gift_id: selectedGiftId})
        }).then(() => { toggleGiftModal(); showToast('Enviado!'); });
    }

    function deleteLive(btn) {
        if (typeof showMogramConfirm === 'function') {
            showMogramConfirm('Encerrar Live', 'Deseja realmente encerrar esta transmissão agora? Todos os espectadores serão desconectados.', () => {
                executeDeleteLive(btn);
            });
        } else {
            if (confirm('Deseja realmente encerrar esta transmissão?')) {
                executeDeleteLive(btn);
            }
        }
    }

    function executeDeleteLive(btn) {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = 'Encerrando...';
        btn.disabled = true;
        btn.style.background = '#ef4444';
        btn.style.color = 'white';
        btn.style.borderColor = '#ef4444';

        if (window.localStream) {
            window.localStream.getTracks().forEach(t => t.stop());
        }

        if (peer) peer.destroy();
        if (ivsBroadcaster) {
            try {
                ivsBroadcaster.stopBroadcast();
            } catch (e) {
                console.error('Error stopping IVS:', e);
            }
        }

        fetch('{{ route('live.destroy', $live->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route('lives') }}';
            } else {
                alert('Erro ao encerrar: ' + (data.message || 'Desconhecido'));
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error('Error ending live:', err);
            window.location.href = '{{ route('lives') }}';
        });
    }

    window.onbeforeunload = function() {
        if (peer) peer.destroy();
        if (ivsBroadcaster) ivsBroadcaster.stopBroadcast();
    };

    // Helper to start the stream
    function initLive() {
        console.log('Initializing Mogram Live Studio...');
        try {
            // Disabled legacy Peer initialization
            // if (typeof initPeer === 'function') initPeer();
            
            if (IS_CREATOR) {
                console.log('Creator mode detected, IVS will handle camera start.');
                // For IVS, we wait for initIVS to call startBroadcasting
            } else {
                console.log('Viewer mode detected, starting chat...');
                if (typeof startChatPolling === 'function') startChatPolling();
            }
        } catch (e) {
            console.error('Failed to initialize live studio:', e);
        }
    }

    document.addEventListener('DOMContentLoaded', initLive);

    function showMogramConfirm(title, message, onConfirm) {
        const modal = document.getElementById('mogram_confirm_modal');
        if (!modal) {
            if (confirm(message)) onConfirm();
            return;
        }
        
        document.getElementById('confirm_title').innerText = title;
        document.getElementById('confirm_msg').innerText = message;
        
        const okBtn = document.getElementById('confirm_btn_yes');
        const noBtn = document.getElementById('confirm_btn_no');
        
        noBtn.onclick = closeConfirm;
        okBtn.onclick = () => {
            closeConfirm();
            onConfirm();
        };
        
        modal.style.display = 'flex';
    }

    function closeConfirm() {
        const modal = document.getElementById('mogram_confirm_modal');
        if (modal) modal.style.display = 'none';
    }

    // Close on click outside
    window.addEventListener('click', function(event) {
        const confirmModal = document.getElementById('mogram_confirm_modal');
        if (confirmModal && event.target == confirmModal) closeConfirm();
    });
</script>

<style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection
