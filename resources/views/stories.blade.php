@extends('layouts.app')

@section('title', 'Stories - Mogram')

@section('content')
<div class="stories-viewer-container" style="background: #000; height: 100vh; position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; display: flex; align-items: center; justify-content: center; overflow: hidden;">
    
    <!-- Header/Close -->
    <a href="{{ route('dashboard') }}" style="position: absolute; top: 20px; right: 20px; color: white; text-decoration: none; font-size: 32px; z-index: 1000; opacity: 0.7; transition: 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">&times;</a>

    <!-- Story Content Card -->
    <div class="story-viewport" style="width: 100%; max-width: 450px; height: 95vh; background: #1a1926; position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.8);">
        
        <!-- Progress Bars -->
        <div class="progress-container" style="display: flex; gap: 4px; padding: 12px 16px; position: absolute; top: 0; left: 0; right: 0; z-index: 50;">
            @foreach($stories as $index => $story)
                <div class="progress-item" style="flex: 1; height: 2px; background: rgba(255,255,255,0.2); border-radius: 2px; overflow: hidden;">
                    <div id="progress-bar-{{ $index }}" style="width: 0%; height: 100%; background: white; border-radius: 2px;"></div>
                </div>
            @endforeach
        </div>

        <!-- Current Story Header -->
        <div class="story-overlay-header" style="position: absolute; top: 15px; left: 0; right: 0; padding: 20px 16px; display: flex; align-items: center; gap: 12px; z-index: 40; background: linear-gradient(to bottom, rgba(0,0,0,0.5), transparent);">
             <img id="active-user-avatar" src="" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid white;">
             <div style="flex: 1;">
                 <h4 id="active-user-name" style="color: white; font-size: 14px; font-weight: 800; margin: 0;"></h4>
                 <p id="active-story-time" style="color: rgba(255,255,255,0.7); font-size: 10px; margin: 0; font-weight: 600;"></p>
             </div>
             <button style="background: transparent; border: none; color: white; cursor: pointer;">
                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
             </button>
        </div>

        <!-- Media Container -->
        <div id="media-viewport" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #000;">
            <!-- Content will be injected here via JS -->
        </div>

        <!-- Navigation Areas -->
        <div style="position: absolute; top: 0; left: 0; width: 30%; height: 100%; z-index: 30; cursor: pointer;" onclick="prevStory()"></div>
        <div style="position: absolute; top: 0; right: 0; width: 70%; height: 100%; z-index: 30; cursor: pointer;" onclick="nextStory()"></div>

        <!-- Reply Footer -->
        <div class="story-overlay-footer" style="position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; z-index: 40; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
            <div style="display: flex; gap: 12px; align-items: center;">
                <div style="flex: 1; position: relative;">
                    <input type="text" placeholder="Enviar mensagem..." style="width: 100%; background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.15); border-radius: 30px; padding: 12px 20px; color: white; font-size: 13px; font-weight: 600; outline: none; backdrop-filter: blur(10px);">
                </div>
                <button style="background: transparent; border: none; color: white; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>
                <button style="background: transparent; border: none; color: white; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const stories = @json($stories);
    let currentIndex = 0;
    let progressInterval;
    let progressValue = 0;
    const STORY_DURATION = 5000; // 5 seconds per story

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

        // Reset all progress bars
        document.querySelectorAll('.progress-item div').forEach((bar, idx) => {
            bar.style.width = idx < currentIndex ? '100%' : '0%';
        });

        // Set metadata
        userName.innerText = story.user.name;
        userAvatar.src = story.user.avatar ? `/storage/${story.user.avatar}` : `https://api.dicebear.com/7.x/initials/svg?seed=${story.user.name}`;
        storyTime.innerText = 'há 1h'; // You can format story.created_at here

        // Injet Media
        mediaViewport.innerHTML = '';
        if (story.type === 'video') {
            const video = document.createElement('video');
            video.src = `/storage/${story.file_path}`;
            video.autoplay = true;
            video.muted = false;
            video.style.maxWidth = '100%';
            video.style.maxHeight = '100%';
            mediaViewport.appendChild(video);
            
            // For videos, duration might depend on the video itself
            video.onloadedmetadata = function() {
                startProgress(video.duration * 1000);
            };
        } else {
            const img = document.createElement('img');
            img.src = `/storage/${story.file_path}`;
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            img.style.objectFit = 'contain';
            mediaViewport.appendChild(img);
            startProgress(STORY_DURATION);
        }

        // Mark as viewed
        fetch(`/stories/${story.id}/view`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
    }

    function startProgress(duration) {
        clearInterval(progressInterval);
        progressValue = 0;
        const progressBar = document.getElementById(`progress-bar-${currentIndex}`);
        const step = 100 / (duration / 100);

        progressInterval = setInterval(() => {
            progressValue += step;
            if (progressBar) progressBar.style.width = `${progressValue}%`;
            
            if (progressValue >= 100) {
                clearInterval(progressInterval);
                nextStory();
            }
        }, 100);
    }

    function nextStory() {
        currentIndex++;
        if (currentIndex < stories.length) {
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

    // Initialize on load
    document.addEventListener('DOMContentLoaded', () => {
        initStory();
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') nextStory();
        if (e.key === 'ArrowLeft') prevStory();
        if (e.key === 'Escape') window.location.href = "{{ route('dashboard') }}";
    });
</script>
@endsection
