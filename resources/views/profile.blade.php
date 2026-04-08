@extends('layouts.app')

@section('title', $user->name . ' - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div class="creator-header" style="text-align: center; padding: 3rem 2rem; background: linear-gradient(to bottom, rgba(51, 144, 236, 0.05), transparent); border-bottom: 1px solid var(--border-gray);">
            <div style="position: relative; display: inline-block; margin-bottom: 1.5rem;">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" style="width: 120px; height: 120px; border-radius: 40px; object-fit: cover; border: 4px solid #3390ec; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                @else
                    <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $user->name }}" style="width: 120px; height: 120px; border-radius: 40px; object-fit: cover; border: 4px solid #3390ec;">
                @endif
                
                @if($user->is_verified)
                <div style="position: absolute; bottom: -5px; right: -5px; width: 32px; height: 32px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid #0b0a15;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                </div>
                @endif
            </div>
            
            <h1 style="font-size: 2rem; font-weight: 950; color: white; letter-spacing: -1px; margin-bottom: 0.5rem;">{{ $user->name }}</h1>
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 1.5rem;">
                <span style="font-size: 12px; color: var(--primary-blue); font-weight: 800; text-transform: none; letter-spacing: 1px; background: rgba(51, 144, 236, 0.1); padding: 4px 12px; border-radius: 20px;">@<span>{{ $user->username }}</span></span>
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: none;">•</span>
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: none; letter-spacing: 1px;">{{ $user->category ?: 'Membro Mogram' }}</span>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 3rem; margin-bottom: 2rem;">
                <div style="text-align: center;">
                    <p style="font-size: 18px; font-weight: 950; color: white; margin: 0;" id="followers_count">{{ number_format($followersCount, 0, ',', '.') }}</p>
                    <p style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: none; letter-spacing: 0.5px;">Seguidores</p>
                </div>
                <div style="text-align: center;">
                    <p style="font-size: 18px; font-weight: 950; color: white; margin: 0;">{{ $posts->count() }}</p>
                    <p style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: none; letter-spacing: 0.5px;">Posts</p>
                </div>
                <div style="text-align: center;">
                    <p style="font-size: 18px; font-weight: 950; color: white; margin: 0;">{{ $lives->count() }}</p>
                    <p style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: none; letter-spacing: 0.5px;">Lives</p>
                </div>
            </div>

            <p style="max-width: 480px; margin: 0 auto 2.5rem; line-height: 1.6; color: rgba(255,255,255,0.8); font-size: 14px; font-weight: 500;">
                {{ $user->bio ?: 'Este usuário ainda não adicionou uma biografia.' }}
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem;">
                @if(Auth::id() !== $user->id)
                    <button id="follow_btn" onclick="toggleFollow('{{ $user->id }}')" 
                            style="padding: 0.85rem 2.5rem; border-radius: 14px; font-weight: 900; font-size: 14px; cursor: pointer; transition: 0.3s; 
                            @if($isFollowing) 
                                background: rgba(255,255,255,0.05); color: white; border: 1.5px solid rgba(255,255,255,0.1);
                            @else 
                                background: var(--primary-blue); color: white; border: none; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.2);
                            @endif">
                        {{ $isFollowing ? 'Deixar de Seguir' : 'Seguir' }}
                    </button>
                    <a href="{{ route('chat.show', $user->id) }}" 
                       style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; transition: 0.3s; text-decoration: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </a>
                @else
                    <a href="{{ route('studio.settings') }}" 
                       style="padding: 0.85rem 2.5rem; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; font-weight: 900; font-size: 14px; color: white; text-decoration: none; transition: 0.3s;">
                        Editar Perfil
                    </a>
                @endif
            </div>
        </div>

        <div style="display: flex; justify-content: center; border-bottom: 1px solid var(--border-gray); background: rgba(0,0,0,0.2); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(10px);">
            <div style="display: flex; gap: 4rem;">
                <button onclick="switchTab('posts')" class="tab-btn active" id="tab_posts_btn" style="padding: 1.25rem 1rem; background: none; border: none; color: var(--text-muted); font-size: 13px; font-weight: 800; text-transform: none; letter-spacing: 1px; cursor: pointer; position: relative; transition: 0.3s;">
                    Posts
                    <div class="tab-indicator" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--primary-blue); border-radius: 3px 3px 0 0; opacity: 1;"></div>
                </button>
                <button onclick="switchTab('lives')" class="tab-btn" id="tab_lives_btn" style="padding: 1.25rem 1rem; background: none; border: none; color: var(--text-muted); font-size: 13px; font-weight: 800; text-transform: none; letter-spacing: 1px; cursor: pointer; position: relative; transition: 0.3s;">
                    Lives
                    <div class="tab-indicator" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--primary-blue); border-radius: 3px 3px 0 0; opacity: 0;"></div>
                </button>
            </div>
        </div>

        <div class="feed-container" id="content_posts" style="padding-top: 2rem;">
            @forelse($posts as $post)
                <div class="post-card">
                    <div class="post-header">
                        @if($post->user->avatar)
                            <img src="{{ Storage::url($post->user->avatar) }}" class="post-author-img" style="object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
                        @else
                            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $post->user->name }}" class="post-author-img">
                        @endif
                        <div style="flex: 1;">
                            <h4 style="font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                                {{ $post->user->name }} 
                                @if($post->user->is_verified)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#3390ec"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                @endif
                            </h4>
                            <p style="font-size: 11px; color: var(--text-muted);">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <h3 style="font-size: 15px; font-weight: 900; color: white; margin-bottom: 0.5rem;">{{ $post->title }}</h3>
                        <div style="font-size: 13px; color: rgba(255,255,255,0.9); line-height: 1.5;">
                            @php
                                $plainText = strip_tags($post->description);
                                $isLong = mb_strlen($plainText) > 500;
                            @endphp

                            @if($isLong)
                                <div id="short_desc_{{ $post->id }}">
                                    {{ mb_substr($plainText, 0, 500) }}...
                                    <span onclick="showFullDesc('{{ $post->id }}')" style="color: #3390ec; cursor: pointer; font-weight: 800; margin-left: 4px;">Mais+</span>
                                </div>
                                <div id="full_desc_{{ $post->id }}" style="display: none;">
                                    {!! $post->description !!}
                                </div>
                            @else
                                {!! $post->description !!}
                            @endif
                        </div>
                    </div>
                    
                    @if($post->file_path)
                    <div class="post-media" style="margin-top: 1rem; position: relative;">
                        @php 
                            $isPurchased = auth()->check() && $post->isPurchasedBy(auth()->user());
                            $isOwner = auth()->id() == $post->user_id;
                            $shouldShow = !$post->is_exclusive || $isOwner || $isPurchased;
                        @endphp

                        @if(!$shouldShow)
                            <div style="position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; border-radius: 16px; background: #000;">
                                @if($post->thumbnail)
                                    <img src="{{ Storage::url($post->thumbnail) }}" style="filter: blur(40px) brightness(0.6); width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                                @elseif($post->type == 'image')
                                    <img src="{{ Storage::url($post->file_path) }}" style="filter: blur(40px) brightness(0.6); width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(45deg, #1a1c2e, #0b0a15); display: flex; align-items: center; justify-content: center; opacity: 0.5;">
                                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                                
                                <div class="exclusive-overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(0,0,0,0.4);">
                                    <div style="width: 50px; height: 50px; background: rgba(51, 144, 236, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; border: 1.5px solid rgba(51, 144, 236, 0.3);">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3390ec" stroke-width="3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </div>
                                    <h4 style="font-size: 15px; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -0.5px;">Conteúdo Exclusivo</h4>
                                    <form onsubmit="unlockPost(event, '{{ $post->id }}', '{{ $post->price }}')" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="mogram-btn-primary" style="padding: 0.875rem 2rem; border-radius: 12px; font-weight: 850; font-size: 13px; background: #3390ec; border: none; color: white; cursor: pointer; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.3);">Desbloquear R$ {{ number_format($post->price, 2, ',', '.') }}</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            @if($post->type == 'video')
                                <video src="{{ Storage::url($post->file_path) }}" poster="{{ $post->thumbnail ? Storage::url($post->thumbnail) : '' }}" controls controlsList="nodownload" style="width: 100%; border-radius: 16px; background: black; max-height: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);"></video>
                            @elseif($post->type == 'image')
                                <div class="purchased-image" style="position: relative;">
                                    <img src="{{ Storage::url($post->file_path) }}" style="width: 100%; border-radius: 16px; object-fit: contain; max-height: 600px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                                    @if($isPurchased && !$isOwner)
                                        <div style="position: absolute; top: 12px; right: 12px; background: rgba(34, 197, 94, 0.9); color: white; padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(5px);">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                            DESBLOQUEADO
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                    @endif
                </div>
            @empty
                <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Este usuário ainda não publicou nenhum post.</p>
                </div>
            @endforelse
        </div>

        <div class="feed-container" id="content_lives" style="display: none; padding-top: 2rem;">
            @forelse($lives as $live)
                <div class="post-card" style="padding: 1.5rem; background: rgba(51, 144, 236, 0.05); border: 1px solid rgba(51, 144, 236, 0.1);">
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div style="position: relative; width: 100px; height: 100px; flex-shrink: 0;">
                             <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $user->name }}" style="width: 100%; height: 100%; border-radius: 16px; object-fit: cover;">
                             <div style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; font-size: 9px; font-weight: 900; padding: 2px 8px; border-radius: 6px; border: 2px solid #0b0a15; white-space: nowrap;">AO VIVO</div>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 18px; font-weight: 950; color: white; margin-bottom: 0.5rem;">{{ $live->title }}</h4>
                            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem;">{{ $live->description }}</p>
                            <a href="{{ route('live.watch', $live->id) }}" class="mogram-btn-primary" style="padding: 0.75rem 2rem; font-size: 13px; font-weight: 800; text-decoration: none; display: inline-block;">Assistir Live Agora</a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">O usuário não está em live no momento.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>

<style>
    .tab-btn.active { color: white !important; }
    .tab-btn.active .tab-indicator { opacity: 1 !important; }
</style>

@section('scripts')
<script>
    function showFullDesc(postId) {
        document.getElementById(`short_desc_${postId}`).style.display = 'none';
        document.getElementById(`full_desc_${postId}`).style.display = 'block';
    }

    function toggleFollow(userId) {
        const btn = document.getElementById('follow_btn');
        btn.disabled = true;
        
        fetch(`/profile/${userId}/follow`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            document.getElementById('followers_count').innerText = data.followers_count;
            
            if (data.status === 'followed') {
                btn.innerText = 'Deixar de Seguir';
                btn.style.background = 'rgba(255,255,255,0.05)';
                btn.style.border = '1.5px solid rgba(255,255,255,0.1)';
                btn.style.boxShadow = 'none';
            } else {
                btn.innerText = 'Seguir';
                btn.style.background = 'var(--primary-blue)';
                btn.style.border = 'none';
                btn.style.boxShadow = '0 10px 20px rgba(51, 144, 236, 0.2)';
            }
        });
    }

    function switchTab(tab) {
        document.getElementById('content_posts').style.display = tab === 'posts' ? 'block' : 'none';
        document.getElementById('content_lives').style.display = tab === 'lives' ? 'block' : 'none';
        
        const postsBtn = document.getElementById('tab_posts_btn');
        const livesBtn = document.getElementById('tab_lives_btn');
        
        if (tab === 'posts') {
            postsBtn.classList.add('active');
            livesBtn.classList.remove('active');
        } else {
            livesBtn.classList.add('active');
            postsBtn.classList.remove('active');
        }
    }

    function unlockPost(e, postId, price) {
        e.preventDefault();
        
        // Basic confirmation for demo - ideally matches dashboard.blade.php's modal
        if (!confirm(`Deseja desbloquear este conteúdo por R$ ${price}?`)) return;

        fetch(`/posts/${postId}/unlock`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.error || 'Erro ao processar');
            }
        });
    }
</script>
@endsection
@endsection
