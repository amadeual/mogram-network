@extends('layouts.app')

@section('title', 'Stories - Mogram')

@section('content')
<div class="stories-platform-container" style="background: #0b0a15; height: 100vh; width: 100%; position: fixed; top: 0; left: 0; z-index: 9999; display: flex; flex-direction: column; overflow: hidden; font-family: 'Inter', sans-serif;">
    
    <!-- Premium Top Header -->
    <header style="height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 40px; background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); border-bottom: 1.5px solid rgba(255,255,255,0.03); z-index: 1000;">
        <div style="display: flex; align-items: center; gap: 12px; cursor: pointer;" onclick="window.location.href='{{ route('dashboard') }}'">
            <div style="width: 32px; height: 32px; background: #3390ec; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12 2L1 12h3v9h16v-9h3L12 2z"/></svg>
            </div>
            <span style="color: white; font-weight: 900; font-size: 20px; letter-spacing: -0.5px;">Mogram</span>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 50px; padding: 8px 16px; display: flex; align-items: center; gap: 10px;">
                <div style="width: 20px; height: 20px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; color: white; font-weight: 900;">$</div>
                <span style="color: white; font-weight: 800; font-size: 14px;">R$ {{ number_format(Auth::user()->balance, 2, ',', '.') }}</span>
            </div>
            <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1); cursor: pointer;">
        </div>
    </header>

    <!-- Main Stories Carousel -->
    <main style="flex: 1; display: flex; align-items: center; justify-content: center; position: relative; perspective: 1000px; padding-bottom: 80px;">
        
        <!-- Navigation Arrows -->
        <button onclick="prevStory()" class="nav-arrow prev" style="position: absolute; left: calc(50% - 320px); width: 45px; height: 45px; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 100; transition: 0.3s; backdrop-filter: blur(10px);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
        </button>

        <button onclick="nextStory()" class="nav-arrow next" style="position: absolute; right: calc(50% - 320px); width: 45px; height: 45px; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 100; transition: 0.3s; backdrop-filter: blur(10px);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
        </button>

        <!-- Preview Stories (Left) -->
        <div class="story-preview-side left" style="position: absolute; left: calc(50% - 500px); width: 180px; height: 320px; background: #1a1c2e; border-radius: 24px; opacity: 0.2; transform: rotateY(20deg) scale(0.9); overflow: hidden; pointer-events: none;">
             <img id="prev-story-thumb" src="" style="width: 100%; height: 100%; object-fit: cover; filter: blur(5px);">
        </div>

        <!-- Active Story Viewer -->
        <div class="active-story-card" style="width: 100%; max-width: 440px; height: 750px; background: #151621; border-radius: 32px; position: relative; overflow: hidden; box-shadow: 0 40px 100px rgba(0,0,0,0.8); border: 1.5px solid rgba(255,255,255,0.05);">
            
            <!-- Top Progress Bars -->
            <div id="progress-container" style="display: flex; gap: 6px; padding: 16px 20px; position: absolute; top: 0; left: 0; right: 0; z-index: 200;">
                <!-- Generated via JS -->
            </div>

            <!-- Content Slot -->
            <div id="media-viewport" style="width: 100%; height: 100%; background: #000; display: flex; align-items: center; justify-content: center;"></div>

            <!-- Header Info -->
            <div style="position: absolute; top: 20px; left: 0; right: 0; padding: 25px 20px; display: flex; align-items: center; gap: 12px; z-index: 150; background: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent);">
                <div style="position: relative;">
                    <img id="active-user-avatar" src="" style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #3390ec; padding: 2px; background: #000;">
                    <div style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; font-size: 7px; font-weight: 900; padding: 2px 5px; border-radius: 4px; border: 1.5px solid #000;">LIVE</div>
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <h4 id="active-user-name" style="color: white; font-size: 15px; font-weight: 800; margin: 0; letter-spacing: -0.3px;"></h4>
                        <div style="width: 14px; height: 14px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        </div>
                    </div>
                    <p id="active-story-time" style="color: rgba(255,255,255,0.6); font-size: 11px; margin: 3px 0 0; font-weight: 700;"></p>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                        <svg width="12" height="12" fill="white" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        <span style="color: white; font-size: 11px; font-weight: 800;">4h</span>
                    </div>
                    <button style="background: transparent; border: none; color: white; cursor: pointer; opacity: 0.7;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>
                </div>
            </div>

            <!-- Premium Overlay (Hidden by default) -->
            <div id="premium-lock-overlay" style="display: none; position: absolute; inset: 0; background: rgba(11, 10, 21, 0.85); backdrop-filter: blur(20px); z-index: 180; flex-direction: column; align-items: center; justify-content: center; padding: 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; border: 1.5px solid rgba(51, 144, 236, 0.3); margin-bottom: 25px; color: #3390ec;">
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h2 style="color: white; font-weight: 900; font-size: 22px; margin-bottom: 10px; letter-spacing: -0.5px;">Conteúdo Exclusivo</h2>
                <p style="color: #64748b; font-size: 13px; font-weight: 600; line-height: 1.6; margin-bottom: 30px;">Este story contém dicas exclusivas de lançamentos para assinantes.</p>
                
                <button style="width: 100%; background: #ef4444; border: none; padding: 18px; border-radius: 16px; color: white; font-weight: 840; font-size: 15px; cursor: pointer; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2); transition: 0.3s; margin-bottom: 20px;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    Desbloquear <span style="font-size: 10px; opacity: 0.8; margin-left: 10px; background: rgba(0,0,0,0.2); padding: 4px 8px; border-radius: 6px;">R$ 4,99</span>
                </button>
                <a href="#" style="color: #ef4444; text-decoration: none; font-weight: 800; font-size: 13px;">Assinar Premium</a>
            </div>

            <!-- Interactivity Footer -->
            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 25px 20px; z-index: 150; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                
                <!-- Bottom Reply Bar -->
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 20px;">
                    <div style="flex: 1; background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 40px; padding: 12px 20px; backdrop-filter: blur(10px);">
                        <input type="text" placeholder="Enviar mensagem..." style="background: transparent; border: none; color: white; width: 100%; outline: none; font-size: 14px; font-weight: 600;">
                    </div>
                    <button style="width: 45px; height: 45px; background: rgba(255,255,255,0.08); border: none; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(10px);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </button>
                    <button style="width: 45px; height: 45px; background: #3390ec; border: none; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 8px 20px rgba(51, 144, 236, 0.3);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>

                <!-- Reaction Counters -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; gap: 20px;">
                        <div style="text-align: center;">
                            <span style="font-size: 20px; display: block;">🔥</span>
                            <span style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 900;">45</span>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 20px; display: block;">😍</span>
                            <span style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 900;">128</span>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 20px; display: block;">👏</span>
                            <span style="color: rgba(255,255,255,0.5); font-size: 10px; font-weight: 900;">12</span>
                        </div>
                    </div>
                    <div style="text-align: center; cursor: pointer;">
                        <div style="width: 38px; height: 38px; background: rgba(239, 68, 68, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1.5px solid rgba(239, 68, 68, 0.3); margin: 0 auto 5px;">
                            <span style="font-size: 18px;">🎁</span>
                        </div>
                        <span style="color: #ef4444; font-size: 10px; font-weight: 900; letter-spacing: 0.5px;">Mimo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Stories (Right) -->
        <div class="story-preview-side right" style="position: absolute; right: calc(50% - 500px); width: 180px; height: 320px; background: #1a1c2e; border-radius: 24px; opacity: 0.2; transform: rotateY(-20deg) scale(0.9); overflow: hidden; pointer-events: none;">
             <img id="next-story-thumb" src="" style="width: 100%; height: 100%; object-fit: cover; filter: blur(5px);">
        </div>
    </main>

    <!-- Social Style Bottom Navigation -->
    <nav style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); background: rgba(11, 13, 31, 0.9); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 24px; padding: 10px 20px; display: flex; gap: 15px; backdrop-filter: blur(25px); z-index: 2000; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        @php
            $navItems = [
                ['route' => 'dashboard', 'label' => 'Início', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>'],
                ['route' => 'stories', 'label' => 'Stories', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>', 'active' => true],
                ['route' => 'dashboard', 'label' => 'Criar', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>', 'is_plus' => true],
                ['route' => 'lives', 'label' => 'Lives', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>'],
                ['route' => 'chat.index', 'label' => 'Chat', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'],
                ['route' => 'profile', 'label' => 'Perfil', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'],
                ['route' => 'dashboard', 'label' => 'Config.', 'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>']
            ];
        @endphp

        @foreach($navItems as $item)
            @if(isset($item['is_plus']))
                <a href="{{ route($item['route']) }}" style="background: #3390ec; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.4); text-decoration: none; margin: 0 5px;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    {!! $item['icon'] !!}
                </a>
            @else
                <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}" style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; padding: 5px 12px; color: {{ isset($item['active']) ? 'white' : 'rgba(255,255,255,0.4)' }}; text-decoration: none; transition: 0.3s; @if(isset($item['active'])) background: rgba(51, 144, 236, 0.1); border-radius: 14px; @endif" onmouseover="this.style.color='white'">
                    {!! $item['icon'] !!}
                    <span style="font-size: 9px; font-weight: 800;">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</div>

<style>
    @font-face {
        font-family: 'Inter';
        src: url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');
    }

    .story-viewport img, .story-viewport video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nav-arrow:hover {
        background: rgba(255,255,255,0.1) !important;
        transform: scale(1.1);
    }

    .filter-pill { transition: 0.3s; }
    .filter-pill:hover { background: rgba(255,255,255,0.1); }
</style>

<script>
    const stories = @json($stories);
    let currentIndex = 0;
    let progressInterval;
    let progressValue = 0;
    const DEFAULT_DURATION = 5000;

    function initStory() {
        if (currentIndex >= stories.length) {
            window.location.href = "{{ route('dashboard') }}";
            return;
        }

        const story = stories[currentIndex];
        const mediaViewport = document.getElementById('media-viewport');
        const userName = document.getElementById('active-user-name');
        const userAvatar = document.getElementById('active-user-avatar');
        const storyTime = document.getElementById('active-story-time');
        const lockOverlay = document.getElementById('premium-lock-overlay');
        const progressContainer = document.getElementById('progress-container');

        // Create Progress Bars
        progressContainer.innerHTML = '';
        stories.forEach((_, idx) => {
            const barWrap = document.createElement('div');
            barWrap.style.cssText = 'flex: 1; height: 3px; background: rgba(255,255,255,0.2); border-radius: 10px; overflow: hidden;';
            const barFill = document.createElement('div');
            barFill.id = `progress-bar-${idx}`;
            barFill.style.cssText = `width: ${idx < currentIndex ? '100' : '0'}%; height: 100%; background: white; border-radius: 10px; transition: 0.1s linear;`;
            barWrap.appendChild(barFill);
            progressContainer.appendChild(barWrap);
        });

        // Set Metadata
        userName.innerText = story.user.name;
        userAvatar.src = story.user.avatar ? `/storage/${story.user.avatar}` : `https://api.dicebear.com/7.x/initials/svg?seed=${story.user.name}`;
        storyTime.innerText = 'há 2h'; // Mock time

        // Preview Thumbs
        const prevThumb = document.getElementById('prev-story-thumb');
        const nextThumb = document.getElementById('next-story-thumb');
        if (currentIndex > 0) prevThumb.src = `/storage/${stories[currentIndex-1].file_path}`;
        if (currentIndex < stories.length - 1) nextThumb.src = `/storage/${stories[currentIndex+1].file_path}`;

        // Handle Logic (Locked Content)
        if (story.is_premium) {
            lockOverlay.style.display = 'flex';
            mediaViewport.innerHTML = `<img src="/storage/${story.file_path}" style="width: 100%; height: 100%; object-fit: cover; filter: blur(40px);">`;
            startProgress(DEFAULT_DURATION); // Still progress even if locked for flow
        } else {
            lockOverlay.style.display = 'none';
            mediaViewport.innerHTML = '';
            
            if (story.type === 'video') {
                const video = document.createElement('video');
                video.src = `/storage/${story.file_path}`;
                video.autoplay = true;
                video.muted = false;
                video.style.maxWidth = '100%';
                video.style.maxHeight = '100%';
                video.style.objectFit = 'cover';
                mediaViewport.appendChild(video);
                video.onloadedmetadata = () => startProgress(video.duration * 1000);
            } else {
                const img = document.createElement('img');
                img.src = `/storage/${story.file_path}`;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                mediaViewport.appendChild(img);
                startProgress(DEFAULT_DURATION);
            }
        }

        // Mark as viewed
        fetch(`/stories/${story.id}/view`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
    }

    function startProgress(duration) {
        clearInterval(progressInterval);
        progressValue = 0;
        const progressBar = document.getElementById(`progress-bar-${currentIndex}`);
        const tick = 50; // 50ms interval
        const step = 100 / (duration / tick);

        progressInterval = setInterval(() => {
            progressValue += step;
            if (progressBar) progressBar.style.width = `${progressValue}%`;
            
            if (progressValue >= 100) {
                clearInterval(progressInterval);
                nextStory();
            }
        }, tick);
    }

    function nextStory() {
        if (currentIndex < stories.length - 1) {
            currentIndex++;
            initStory();
        } else {
            window.location.href = "{{ route('dashboard') }}";
        }
    }

    function prevStory() {
        if (currentIndex > 0) {
            currentIndex--;
            initStory();
        }
    }

    document.addEventListener('DOMContentLoaded', initStory);
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') nextStory();
        if (e.key === 'ArrowLeft') prevStory();
        if (e.key === 'Escape') window.location.href = "{{ route('dashboard') }}";
    });
</script>
@endsection
