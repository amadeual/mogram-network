@extends('layouts.app')

@section('title', 'Mogram - Explorar Lives')

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
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                 <button class="notif-bell" onclick="toggleNotifs()" style="background: rgba(255,255,255,0.05); border: none; width: 44px; height: 44px; border-radius: 12px; color: #888; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; position: relative;" onmouseover="this.style.background='rgba(51,144,236,0.1)'; this.style.color='var(--primary-blue)'">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div style="position: absolute; top: 10px; right: 10px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid #0b0a15;"></div>
                </button>
                <button class="btn-studio" onclick="window.location.href='/lives/create'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Iniciar Transmissão
                </button>
            </div>
        </header>

        <!-- Categories / Filters (TikTok Style) -->
        <div style="display: flex; gap: 1rem; margin-bottom: 3rem; overflow-x: auto; padding-bottom: 10px;">
            <a href="?category=Para Você" class="filter-pill {{ request('category', 'Para Você') == 'Para Você' ? 'active' : '' }}" style="text-decoration: none;">Para Você</a>
            <a href="?category=Seguindo" class="filter-pill {{ request('category') == 'Seguindo' ? 'active' : '' }}" style="text-decoration: none;">Seguindo</a>
            <a href="?category=Explorar" class="filter-pill {{ request('category') == 'Explorar' ? 'active' : '' }}" style="text-decoration: none;">Explorar</a>
            <a href="?category=Música" class="filter-pill {{ request('category') == 'Música' ? 'active' : '' }}" style="text-decoration: none;">Música</a>
            <a href="?category=Fé & Religião" class="filter-pill {{ request('category') == 'Fé & Religião' ? 'active' : '' }}" style="text-decoration: none;">Fé & Religião</a>
            <a href="?category=Tecnologia" class="filter-pill {{ request('category') == 'Tecnologia' ? 'active' : '' }}" style="text-decoration: none;">Tecnologia</a>
            <a href="?category=Educação" class="filter-pill {{ request('category') == 'Educação' ? 'active' : '' }}" style="text-decoration: none;">Educação</a>
            <a href="?category=Geral" class="filter-pill {{ request('category') == 'Geral' ? 'active' : '' }}" style="text-decoration: none;">Geral</a>
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
                        <div class="time-tag">{{ $live->started_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="info">
                        <h4 class="title">{{ $live->title }}</h4>
                        <div style="display: flex; gap: 10px; margin-top: 1rem;">
                            <button class="btn-start" onclick="window.location.href='{{ route('live.watch', $live->id) }}'">ENTRAR NO ESTÚDIO</button>
                            <button class="btn-config"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></button>
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
                <div class="live-card-modern" onclick="showMogramLoader(); window.location.href='{{ route('live.watch', $live->id) }}'">
                    <div class="thumb-wrapper">
                        <img src="{{ Storage::url($live->thumbnail) }}" class="thumb">
                        <div class="live-tag">LIVE</div>
                        <div class="stats-tag">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> {{ number_format(count($live->chats) * 1.5 + 50, 0) }}
                        </div>
                    </div>
                    <div class="info">
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <img src="{{ $live->user->avatar ? Storage::url($live->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$live->user->name }}" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--primary-blue);">
                            <div style="flex: 1;">
                                <h4 class="title">{{ $live->title }}</h4>
                                <p style="color: #666; font-size: 0.8rem; font-weight: 700;">@ {{ $live->user->username }}</p>
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
                        <div class="schedule-tag">{{ $live->started_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="info">
                        <h4 class="title">{{ $live->title }}</h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                             <p style="color: #666; font-size: 0.8rem;">Por {{ $live->user->name }}</p>
                             <button class="btn-notify">Me Avisar</button>
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
</style>
@endsection
