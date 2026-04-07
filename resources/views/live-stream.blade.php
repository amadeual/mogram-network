@extends('layouts.app')

@section('title', $live->title . ' - Mogram Transmissão')

@section('content')
<div class="dash-layout" style="background: #0b0a15; display: flex; flex-direction: column; overflow: hidden;">
    <!-- Main Stream Layout -->
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
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

            <!-- Video Player Container -->
            <div id="video_player_container" style="background: black; border-radius: 24px; position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                
                <!-- Video Layers -->
                <div id="video_layers" style="position: absolute; inset: 0;">
                    
                    <!-- 1. Video System (Active Stream) -->
                    <div id="video_wrapper" style="width: 100%; height: 100%; display: {{ $live->status == 'online' ? 'flex' : 'none' }}; gap: 4px;">
                        <div id="main_video_slot" style="flex: 1; height: 100%; position: relative; background: #000;">
                            <video id="creator_video" autoplay playsinline {{ Auth::id() == $live->user_id ? 'muted' : '' }} style="width: 100%; height: 100%; object-fit: cover;"></video>
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
                    </div>

                    <!-- 4. Broadcaster Tools -->
                    @if(Auth::id() == $live->user_id)
                        <div id="broadcaster_tools" style="display: none; position: absolute; top: 1.5rem; right: 1.5rem; gap: 10px; z-index: 100;">
                            <button onclick="toggleAudio()" id="btn_audio" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">🎤</button>
                            <button onclick="toggleVideo()" id="btn_video" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">📹</button>
                            <button onclick="togglePause()" id="btn_pause" style="background: rgba(0,0,0,0.6); width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); color: white; cursor: pointer;">⏸</button>
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

<div id="toast_container" style="position: fixed; top: 2rem; right: 2rem; z-index: 9999;"></div>

<script>
    let selectedGiftId = null;
    const IS_CREATOR = {{ Auth::id() == $live->user_id ? 'true' : 'false' }};
    const LIVE_ID = 'mogram_live_{{ $live->id }}';
    let peer = null;
    window.localStream = null;

    function initPeer() {
        const peerId = IS_CREATOR ? LIVE_ID : 'mogr_v_' + Math.random().toString(36).substr(2, 6);
        const peerConfig = {
            debug: 1,
            config: {
                'iceServers': [
                    { url: 'stun:stun.l.google.com:19302' },
                    { url: 'stun:stun1.l.google.com:19302' },
                    { url: 'stun:stun2.l.google.com:19302' },
                ]
            }
        };

        try {
            peer = new Peer(peerId, peerConfig);
        } catch (e) {
            console.error('Peer creation failed:', e);
            return;
        }

        let pendingCalls = [];

        peer.on('open', (id) => {
            console.log('Peer connected with ID:', id);
            if (!IS_CREATOR) {
                setTimeout(tryCallCreator, 1500);
            }
        });

        function tryCallCreator() {
            if (!peer || peer.destroyed || peer.disconnected) {
                if (peer && peer.disconnected) peer.reconnect();
                setTimeout(tryCallCreator, 2000);
                return;
            }

            console.log('Viewer: Calling creator ID:', LIVE_ID);
            
            // Note: PeerJS needs a stream to initiate a call. 
            // Most browsers require a stream with tracks to fire 'stream' event on the other side.
            let dummyStream;
            try {
                const canvas = document.createElement('canvas');
                canvas.width = canvas.height = 1;
                dummyStream = canvas.captureStream();
                // Add a silent audio track if possible
                if (window.AudioContext || window.webkitAudioContext) {
                    const ctx = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = ctx.createOscillator();
                    const dst = oscillator.connect(ctx.createMediaStreamDestination());
                    oscillator.start();
                    dummyStream.addTrack(dst.stream.getAudioTracks()[0]);
                }
            } catch(e) {
                dummyStream = new MediaStream();
            }

            const call = peer.call(LIVE_ID, dummyStream);
            
            if (!call) {
                setTimeout(tryCallCreator, 3000);
                return;
            }

            call.on('stream', (remoteStream) => {
                console.log('Received stream from creator!');
                const video = document.getElementById('creator_video');
                if (video.srcObject !== remoteStream) {
                    video.srcObject = remoteStream;
                    video.play().then(() => {
                        console.log('Playback success');
                        document.getElementById('offline_view').style.display = 'none';
                        document.getElementById('video_wrapper').style.display = 'flex';
                    }).catch(e => {
                        console.warn('Autoplay blocked, unmuting might be needed');
                        video.muted = true;
                        video.play();
                        document.getElementById('offline_view').style.display = 'none';
                        document.getElementById('video_wrapper').style.display = 'flex';
                        document.getElementById('unmute_prompt').style.display = 'flex';
                    });
                }
            });
            
            call.on('error', (err) => {
                console.error('Call error:', err);
                setTimeout(tryCallCreator, 4000);
            });
        }

        if (IS_CREATOR) {
            peer.on('call', (call) => {
                console.log('Incoming call from viewer...');
                if (window.localStream) {
                    call.answer(window.localStream);
                } else {
                    pendingCalls.push(call);
                }
            });

            window.answerPendingCalls = () => {
                while (pendingCalls.length > 0) {
                    const c = pendingCalls.shift();
                    c.answer(window.localStream);
                }
            };
        }

        peer.on('error', (err) => {
            console.error('Peer error type:', err.type);
            if (err.type === 'peer-unavailable') { /* Ignore, handled by retry */ }
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
        window.localStream = stream;
        const video = document.getElementById('creator_video');
        video.srcObject = stream;
        video.play().catch(() => {});

        document.getElementById('offline_view').style.display = 'none';
        document.getElementById('video_wrapper').style.display = 'flex';
        
        const tools = document.getElementById('broadcaster_tools');
        if (tools) tools.style.display = 'flex';

        if (window.answerPendingCalls) window.answerPendingCalls();
        
        fetch('{{ route('live.start', $live->id) }}', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });

        startChatPolling();
    }

    function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showRetryUI('Câmera não suportada neste navegador.');
            return;
        }

        const constraints = {
            video: { width: { ideal: 1280 }, height: { ideal: 720 } },
            audio: { echoCancellation: true, noiseSuppression: true }
        };

        navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => activateStream(stream))
        .catch(err => {
            console.error('Camera error:', err);
            // Fallback to simple
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(s => activateStream(s))
            .catch(() => showRetryUI('Acesso à câmera negado ou não encontrado.'));
        });
    }

    function unmuteVideo() {
        const video = document.getElementById('creator_video');
        video.muted = false;
        document.getElementById('unmute_prompt').style.display = 'none';
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

    function deleteLive() {
        if (confirm('Encerrar live?')) {
            fetch('{{ route('live.destroy', $live->id) }}', {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            }).then(() => window.location.href = '/lives');
        }
    }

    // Helper to start the stream
    function initLive() {
        initPeer();
        if (IS_CREATOR) {
            setTimeout(startCamera, 1000);
        } else {
            startChatPolling();
        }
    }

    document.addEventListener('DOMContentLoaded', initLive);
</script>

<style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection
