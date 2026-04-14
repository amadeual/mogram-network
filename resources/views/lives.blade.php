@extends('layouts.app')

@section('title', 'Lives | Mogram')

@section('content')
<div class="dash-layout" style="background: #0b0a15;">
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content" style="padding: 1.5rem 2rem; overflow-y: auto;">
        <!-- Trending Header -->
        <header style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
            <div>
        <h1 style="font-size: 2.5rem; font-weight: 900; color: white; letter-spacing: -1px; margin-bottom: 0.5rem;">Explorar <span style="color: var(--primary-blue);">Lives</span></h1>
        <p style="color: #888; font-size: 1rem; font-weight: 600;">Descubra talentos e interaja em tempo real.</p>
    </div>
    
    <!-- Inline Preview Helper (for later reference) -->
    <div id="live_preview_modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index: 10001; align-items: center; justify-content: center; padding: 2rem;">
        <div style="background: #1a1c2e; width: 550px; border-radius: 30px; padding: 2.5rem; border: 1.5px solid rgba(255,255,255,0.05); position: relative; box-shadow: 0 30px 60px rgba(0,0,0,0.8);">
            <div id="preview_thumb" style="width: 100%; aspect-ratio: 16/9; border-radius: 20px; overflow: hidden; margin-bottom: 2rem; position: relative; border: 2px solid rgba(255,255,255,0.03);">
                <img id="preview_img" src="" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 1rem; left: 1rem; background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px;">AO VIVO</div>
            </div>
            
            <div style="display: flex; gap: 15px; align-items: start; margin-bottom: 1.5rem;">
                <img id="preview_avatar" src="" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #3390ec;">
                <div style="flex: 1;">
                   <h2 id="preview_title" style="color: white; font-size: 1.5rem; font-weight: 800; margin: 0 0 5px;"></h2>
                   <div style="display: flex; align-items: center; gap: 10px;">
                       <p id="preview_creator" style="color: #3390ec; font-size: 0.85rem; font-weight: 700; margin: 0;"></p>
                       <span id="preview_price" style="background: #ffd600; color: black; font-size: 9px; font-weight: 900; padding: 2px 8px; border-radius: 6px; text-transform: none;">Ticket VIP</span>
                   </div>
                </div>
            </div>
            
            <p id="preview_desc" style="color: #888; font-size: 0.95rem; line-height: 1.6; margin-bottom: 2.5rem; max-height: 150px; overflow-y: auto; padding-right: 10px;"></p>
            
            <div style="display: flex; gap: 1rem;">
                <a id="preview_join_btn" href="" onclick="showMogramLoader()" style="flex: 1; background: var(--primary-blue); color: white; text-align: center; text-decoration: none; padding: 1.25rem; border-radius: 20px; font-weight: 800; transition: 0.3s; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3);">ENTRAR AGORA</a>
                <button onclick="closePreview()" style="background: rgba(255,255,255,0.05); color: #888; border: none; padding: 1rem 1.5rem; border-radius: 20px; font-weight: 700; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">Cancelar</button>
            </div>
        </div>
    </div>
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                 <button class="notif-bell" onclick="toggleNotifs()" style="background: rgba(255,255,255,0.05); border: none; width: 44px; height: 44px; border-radius: 12px; color: #888; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; position: relative;" onmouseover="this.style.background='rgba(51,144,236,0.1)'; this.style.color='var(--primary-blue)'">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div style="position: absolute; top: 10px; right: 10px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid #0b0a15; display: {{ auth()->user()->unreadNotifications->count() > 0 ? 'block' : 'none' }};"></div>
                </button>
                <button class="btn-studio" onclick="window.location.href='/lives/create'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Iniciar Live
                </button>
            </div>
        </header>

        <!-- Custom Confirmation Modal -->
        <div id="mogram_confirm_modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); z-index: 10002; align-items: center; justify-content: center; padding: 2rem;">
            <div style="background: #1a1c2e; width: 100%; max-width: 400px; border-radius: 24px; padding: 2rem; border: 1.5px solid rgba(255,255,255,0.05); text-align: center; box-shadow: 0 40px 100px rgba(0,0,0,0.9);">
                <div id="confirm_icon" style="width: 60px; height: 60px; background: rgba(51,144,236,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #3390ec;">
                    <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 id="confirm_title" style="color: white; font-weight: 800; font-size: 1.25rem; margin-bottom: 0.5rem;">Confirmar Ação</h3>
                <p id="confirm_msg" style="color: #888; font-size: 0.9rem; line-height: 1.5; margin-bottom: 2rem; font-weight: 600;"></p>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button id="confirm_btn_yes" style="background: #3390ec; color: white; border: none; padding: 1rem; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#2b7bcc'" onmouseout="this.style.background='#3390ec'">Sim, continuar</button>
                    <button id="confirm_btn_no" style="background: transparent; color: #555; border: none; padding: 0.8rem; border-radius: 12px; font-weight: 700; cursor: pointer;" onmouseover="this.style.color='#888'" onmouseout="this.style.color='#555'">Cancelar</button>
                </div>
            </div>
        </div>

        <!-- Categories / Filters (TikTok Style) -->
        <div style="display: flex; gap: 1rem; margin-bottom: 3rem; overflow-x: auto; padding-bottom: 10px;">
            <a href="?category=Explorar" class="filter-pill {{ request('category', 'Explorar') == 'Explorar' ? 'active' : '' }}" style="text-decoration: none;">Explorar</a>
            <a href="?category=Música" class="filter-pill {{ request('category') == 'Música' ? 'active' : '' }}" style="text-decoration: none;">Música</a>
            <a href="?category=Fé & Religião" class="filter-pill {{ request('category') == 'Fé & Religião' ? 'active' : '' }}" style="text-decoration: none;">Fé & Religião</a>
            <a href="?category=Tecnologia" class="filter-pill {{ request('category') == 'Tecnologia' ? 'active' : '' }}" style="text-decoration: none;">Tecnologia</a>
            <a href="?category=Educação" class="filter-pill {{ request('category') == 'Educação' ? 'active' : '' }}" style="text-decoration: none;">Educação</a>
            <a href="?category=Outros" class="filter-pill {{ request('category') == 'Outros' ? 'active' : '' }}" style="text-decoration: none;">Outros</a>
        </div>

        <!-- Section: My Scheduled Lives (Only for Creator) -->
        @php
            $myScheduled = $scheduledLives->where('user_id', Auth::id());
        @endphp

        @if($myScheduled->count() > 0)
        <div style="margin-bottom: 4rem;">
            <h3 style="font-size: 1.1rem; font-weight: 900; color: white; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <span style="width: 12px; height: 12px; background: #ffd600; border-radius: 3px;"></span> Suas Lives Agendadas
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
                @foreach($myScheduled as $live)
                <div class="live-card-modern creator-mode">
                    <div class="thumb-wrapper">
                        <img src="{{ Storage::url($live->thumbnail) }}" class="thumb">
                        <div class="time-tag">{{ $live->scheduled_at ? $live->scheduled_at->format('d M, H:i') : $live->started_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="info">
                        <h4 class="title">{{ $live->title }}</h4>
                        <div style="display: flex; gap: 10px; margin-top: 1rem;">
                            <button class="btn-start" onclick="window.location.href='{{ route('live.watch', $live->id) }}'">ENTRAR NO ESTÚDIO</button>
                            <button class="btn-config" onclick="window.location.href='{{ route('live.edit', $live->id) }}'"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></button>
                        </div>
                        <div style="margin-top: 10px; display: flex; align-items: center; gap: 5px; color: #3390ec; font-size: 11px; font-weight: 800;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            {{ $live->subscribers_count }} Inscritos
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Section: Live Now -->
        <div style="margin-bottom: 4rem;">
            <h3 style="font-size: 1.1rem; font-weight: 900; color: white; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <span style="width: 12px; height: 12px; background: #ef4444; border-radius: 50%; animation: pulse 1.5s infinite;"></span> Ao Vivo Agora
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @forelse($onlineLives as $live)
                <div class="live-card-modern" onclick="openPreview('{{ route('live.watch', $live->id) }}', '{{ addslashes($live->title) }}', '{{ addslashes(Str::limit($live->description, 500)) }}', '{{ Storage::url($live->thumbnail) }}', '{{ $live->user->name }}', '{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$live->user->name }}', '{{ number_format($live->price, 2, '.', '') }}', {{ (in_array($live->id, $userAccessIds) || Auth::id() == $live->user_id) ? 'true' : 'false' }}, '{{ $live->id }}', {{ Auth::id() == $live->user_id ? 'true' : 'false' }})">
                    <div class="thumb-wrapper">
                        <img src="{{ Storage::url($live->thumbnail) }}" class="thumb">
                        <div class="live-tag">LIVE</div>
                        <div class="stats-tag">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> {{ number_format(count($live->chats) * 1.5 + 50, 0) }}
                        </div>
                    </div>
                    <div class="info">
                        <div style="display: flex; gap: 12px; align-items: start;">
                            <img src="{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$live->user->name }}" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--primary-blue);">
                            <div style="flex: 1;">
                                <h4 class="title">{{ $live->title }}</h4>
                                <p style="color: #666; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">@<span>{{ $live->user->username }}</span></p>
                                <p class="desc-snippet">{{ Str::limit($live->description, 60) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; padding: 5rem; text-align: center; background: rgba(255,255,255,0.02); border-radius: 30px; border: 2px dashed rgba(255,255,255,0.05);">
                    <p style="color: #555; font-size: 1rem; font-weight: 700;">Nenhuma transmissão ativa no momento.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Section: Upcoming Scheduled -->
        <div style="margin-bottom: 4rem;">
            <h3 style="font-size: 1.1rem; font-weight: 900; color: white; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <span style="width: 12px; height: 12px; background: #3390ec; border-radius: 3px;"></span> Próximas Transmissões
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($scheduledLives->where('user_id', '!=', Auth::id()) as $live)
                <div class="live-card-modern scheduled">
                    <div class="thumb-wrapper">
                        <img src="{{ Storage::url($live->thumbnail) }}" class="thumb">
                        <div class="schedule-tag">{{ $live->scheduled_at ? $live->scheduled_at->format('d M, H:i') : $live->started_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="info">
                        <h4 class="title">{{ $live->title }}</h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                             <div style="display: flex; flex-direction: column; gap: 4px;">
                                 <p style="color: #666; font-size: 0.8rem; margin: 0;">Por {{ $live->user->name }}</p>
                                 <p style="color: #3390ec; font-size: 10px; font-weight: 800; display: flex; align-items: center; gap: 4px; margin: 0;">
                                     <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                     {{ $live->subscribers_count }} Inscritos
                                 </p>
                             </div>
                                   @if(in_array($live->id, $userAccessIds) || Auth::id() == $live->user_id)
                                       <button class="btn-notify" style="border-color: #22c55e; color: #22c55e;">{{ Auth::id() == $live->user_id ? 'Sua Live' : 'Inscrito' }}</button>
                                   @else
                                       <form id="buy_form_{{ $live->id }}" action="{{ route('live.buy', $live->id) }}" method="POST" style="display: none;">@csrf</form>
                                       <button type="button" class="btn-notify" onclick="showMogramConfirm('Confirmar Inscrição', 'Confirmar inscrição por R$ {{ number_format($live->price, 2, ',', '.') }}?', () => { showMogramLoader(); document.getElementById('buy_form_{{ $live->id }}').submit(); })" style="background: #3390ec; color: white; border: none; padding: 6px 12px; font-size: 10px;">INSCREVER (R$ {{ number_format($live->price, 2, ',', '.') }})</button>
                                   @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

<style>
    /* Premium TikTok-style UI tokens */
    .filter-pill {
        background: rgba(255,255,255,0.05);
        color: #888;
        padding: 0.8rem 1.5rem;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
        white-space: nowrap;
    }
    .filter-pill.active { background: #3390ec; color: white; }
    .filter-pill:hover:not(.active) { background: rgba(255,255,255,0.1); color: white; }

    .btn-studio {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 16px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3);
    }

    .live-card-modern {
        background: rgba(255,255,255,0.02);
        border-radius: 24px;
        overflow: hidden;
        cursor: pointer;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1.5px solid rgba(255,255,255,0.03);
    }
    .live-card-modern:hover { transform: translateY(-10px); border-color: var(--primary-blue); background: rgba(51,144,236,0.05); }

    .thumb-wrapper { position: relative; aspect-ratio: 16/9; overflow: hidden; }
    .thumb { width:100%; height:100%; object-fit: cover; transition: 0.5s; }
    .live-card-modern:hover .thumb { scale: 1.05; }

    .live-tag { position: absolute; top: 1rem; left: 1rem; background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; }
    .stats-tag { position: absolute; bottom: 1rem; left: 1rem; background: rgba(0,0,0,0.6); color: white; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; display: flex; align-items: center; gap: 5px; }
    .time-tag { position: absolute; top: 1rem; right: 1rem; background: #ffd600; color: black; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; }
    .schedule-tag { position: absolute; top: 1rem; right: 1rem; background: #3390ec; color: white; font-size: 10px; font-weight: 900; padding: 4px 10px; border-radius: 6px; }

    .info { padding: 1.25rem; }
    .title { color: white; font-size: 1rem; font-weight: 800; line-height: 1.4; margin: 0; }

    /* Creator Tools */
    .btn-start { flex: 1; background: #22c55e; border: none; padding: 0.8rem; border-radius: 12px; color: white; font-weight: 900; font-size: 0.75rem; cursor: pointer; }
    .btn-config { width: 44px; background: rgba(255,255,255,0.05); border: none; border-radius: 12px; color: #888; cursor: pointer; display: flex; align-items: center; justify-content: center; }

    .btn-notify { background: transparent; border: 1.5px solid #3390ec; color: #3390ec; font-size: 0.7rem; font-weight: 800; padding: 5px 12px; border-radius: 8px; cursor: pointer; }

    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }

    .desc-snippet { color: #888; font-size: 0.75rem; font-weight: 600; line-height: 1.4; margin: 0; }
</style>

<script>
    function openPreview(url, title, desc, thumb, creator, avatar, price, hasAccess, liveId, isOwner) {
        document.getElementById('preview_img').src = thumb;
        document.getElementById('preview_avatar').src = avatar;
        document.getElementById('preview_title').innerText = title;
        document.getElementById('preview_creator').innerText = 'Por ' + creator;
        document.getElementById('preview_desc').innerText = desc || 'Nenhuma descrição disponível.';
        
        const joinBtn = document.getElementById('preview_join_btn');
        const priceTag = document.getElementById('preview_price');
        
        // Reset button
        joinBtn.onclick = function() { showMogramLoader(); closePreview(); };
        joinBtn.innerText = 'ENTRAR AGORA';
        joinBtn.style.background = 'var(--primary-blue)';
        joinBtn.removeAttribute('data-buy-form');

        // Set price
        priceTag.innerText = 'R$ ' + parseFloat(price).toFixed(2);
        priceTag.style.background = '#ffd600';
        priceTag.style.color = 'black';
        
        if (!hasAccess && !isOwner) {
            joinBtn.innerText = 'PAGAR E ENTRAR (R$ ' + parseFloat(price).toFixed(2) + ')';
            joinBtn.style.background = 'linear-gradient(135deg, #ffd600, #ff9100)';
            joinBtn.style.color = 'black';
            joinBtn.href = 'javascript:void(0)';
            joinBtn.onclick = function() {
                showMogramConfirm('Confirmar Compra', 'Será descontado R$ ' + parseFloat(price).toLocaleString('pt-BR', {minimumFractionDigits: 2}) + ' do seu saldo para acessar esta live. Deseja continuar?', () => {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/lives/' + liveId + '/buy';
                    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
                    document.body.appendChild(form);
                    showMogramLoader();
                    form.submit();
                });
            };
        } else {
            joinBtn.href = url;
        }
        
        document.getElementById('live_preview_modal').style.display = 'flex';
    }

    function closePreview() {
        document.getElementById('live_preview_modal').style.display = 'none';
    }

    function showMogramLoader() {
        if (window.parent && typeof window.parent.showMogramLoader === 'function') {
            window.parent.showMogramLoader();
        } else if (typeof window.showMogramLoader === 'function') {
            window.showMogramLoader();
        } else {
            console.log('Loader called but not defined.');
        }
    }

    // Close on click outside
    window.onclick = function(event) {
        const modal = document.getElementById('live_preview_modal');
        const confirmModal = document.getElementById('mogram_confirm_modal');
        if (event.target == modal) closePreview();
        if (confirmModal && event.target == confirmModal) closeConfirm();
    }

    function showMogramConfirm(title, message, onConfirm) {
        const modal = document.getElementById('mogram_confirm_modal');
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
        document.getElementById('mogram_confirm_modal').style.display = 'none';
    }
</script>
@endsection
