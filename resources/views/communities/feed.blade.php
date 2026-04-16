@extends('layouts.app')

@section('title', $community->name . ' | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <!-- Community Header -->
        <div class="community-header-container" style="height: 200px; background: {{ $community->banner ? 'url(\''.Storage::url($community->banner).'\')' : 'linear-gradient(45deg, #1a1c2e, #3390ec)' }}; background-size: cover; background-position: center; position: relative;">
            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(11, 10, 21, 0.9));"></div>
            
            <div class="community-info-wrapper" style="position: absolute; bottom: -40px; left: 2rem; display: flex; align-items: flex-end; gap: 1.5rem;">
                <div style="width: 100px; height: 100px; border-radius: 24px; overflow: hidden; border: 4px solid #0b0a15; background: #1a1c2e; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                    @if($community->avatar)
                        <img src="{{ Storage::url($community->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--primary-blue); color: white; font-size: 28px; font-weight: 900;">{{ substr($community->name, 0, 1) }}</div>
                    @endif
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px; margin: 0;">{{ $community->name }}</h2>
                    <p style="font-size: 13px; color: var(--text-muted); font-weight: 700; margin: 0;">{{ $onlineMembersCount }} membros ativos</p>
                </div>
            </div>

            <div class="community-actions-wrapper" style="position: absolute; bottom: 1rem; right: 2rem; display: flex; gap: 0.75rem;">
                @if(Auth::id() === $community->user_id)
                    <a href="{{ route('communities.dashboard', $community->slug) }}" class="mogram-btn-secondary" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 0.75rem 1.25rem; border-radius: 12px; font-size: 13px; font-weight: 800; text-decoration: none;">Gerenciar</a>
                @endif
                <button class="mogram-btn-secondary" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 0.75rem 1.25rem; border-radius: 12px; font-size: 13px; font-weight: 800;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                </button>
            </div>
        </div>

        <div style="margin-top: 4rem; display: grid; grid-template-columns: 1fr 300px; gap: 2rem; padding: 0 2rem 5rem;" class="responsive-grid-feed">
            <!-- Main Content -->
            <div class="community-feed">
                <!-- Create Post -->
                @if(Auth::id() === $community->user_id)
                <div class="community-post-box" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem; margin-bottom: 2rem;">
                    <form action="{{ route('communities.posts.store', $community->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                            <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . Auth::user()->name }}" style="width: 44px; height: 44px; border-radius: 14px; object-fit: cover;">
                            <textarea name="content" placeholder="O que você quer compartilhar com a comunidade?" style="flex: 1; background: transparent; border: none; color: white; font-size: 15px; font-weight: 600; outline: none; resize: none; min-height: 60px; min-width: 0;" required></textarea>
                        </div>
                        
                        <!-- Media Preview Container -->
                        <div id="media-preview-container" style="display: none; margin-bottom: 1.5rem; position: relative; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1);">
                            <img id="post-image-preview" style="display: none; width: 100%; max-height: 250px; object-fit: contain; background: #000;">
                            <video id="post-video-preview" style="display: none; width: 100%; max-height: 250px; background: #000;" controls></video>
                            <div id="post-file-preview" style="display: none; padding: 1rem; background: rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                <span id="file-name" style="font-size: 13px; color: white;"></span>
                            </div>
                            <button type="button" onclick="clearMedia()" style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.5); border: none; color: white; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; backdrop-filter: blur(10px);">×</button>
                        </div>

                        <div class="post-create-footer" style="display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.03);">
                            <div style="display: flex; gap: 1rem;">
                                <button type="button" onclick="document.getElementById('post-media').click()" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </button>
                                <input type="file" id="post-media" name="media" style="display: none;" onchange="handlePostMedia(this)">
                            </div>
                            <button type="submit" class="mogram-btn-primary" style="padding: 0.75rem 2rem; border-radius: 12px; font-weight: 800; font-size: 13px;">Publicar</button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Feed Filters -->
                <div style="display: flex; gap: 1rem; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 0.5rem; scrollbar-width: none;">
                    <a href="{{ route('communities.show', $community->slug) }}" class="filter-tab {{ !request('type') || request('type') == 'all' ? 'active' : '' }}" style="text-decoration: none; background: {{ !request('type') || request('type') == 'all' ? '#3390ec' : 'rgba(255,255,255,0.03)' }}; border: none; color: {{ !request('type') || request('type') == 'all' ? 'white' : 'var(--text-muted)' }}; padding: 8px 20px; border-radius: 10px; font-size: 12px; font-weight: 800; white-space: nowrap; cursor: pointer;">Todos</a>
                    <a href="{{ route('communities.show', [$community->slug, 'type' => 'video']) }}" class="filter-tab {{ request('type') == 'video' ? 'active' : '' }}" style="text-decoration: none; background: {{ request('type') == 'video' ? '#3390ec' : 'rgba(255,255,255,0.03)' }}; border: none; color: {{ request('type') == 'video' ? 'white' : 'var(--text-muted)' }}; padding: 8px 20px; border-radius: 10px; font-size: 12px; font-weight: 800; white-space: nowrap; cursor: pointer;">Vídeos</a>
                    <a href="{{ route('communities.show', [$community->slug, 'type' => 'image']) }}" class="filter-tab {{ request('type') == 'image' ? 'active' : '' }}" style="text-decoration: none; background: {{ request('type') == 'image' ? '#3390ec' : 'rgba(255,255,255,0.03)' }}; border: none; color: {{ request('type') == 'image' ? 'white' : 'var(--text-muted)' }}; padding: 8px 20px; border-radius: 10px; font-size: 12px; font-weight: 800; white-space: nowrap; cursor: pointer;">Fotos</a>
                    <a href="{{ route('communities.show', [$community->slug, 'type' => 'pdf']) }}" class="filter-tab {{ request('type') == 'pdf' ? 'active' : '' }}" style="text-decoration: none; background: {{ request('type') == 'pdf' ? '#3390ec' : 'rgba(255,255,255,0.03)' }}; border: none; color: {{ request('type') == 'pdf' ? 'white' : 'var(--text-muted)' }}; padding: 8px 20px; border-radius: 10px; font-size: 12px; font-weight: 800; white-space: nowrap; cursor: pointer;">Cursos</a>
                    <a href="{{ route('communities.show', [$community->slug, 'type' => 'spreadsheet']) }}" class="filter-tab {{ request('type') == 'spreadsheet' ? 'active' : '' }}" style="text-decoration: none; background: {{ request('type') == 'spreadsheet' ? '#3390ec' : 'rgba(255,255,255,0.03)' }}; border: none; color: {{ request('type') == 'spreadsheet' ? 'white' : 'var(--text-muted)' }}; padding: 8px 20px; border-radius: 10px; font-size: 12px; font-weight: 800; white-space: nowrap; cursor: pointer;">Planilhas</a>
                </div>

                <!-- Community Posts -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @forelse($posts as $post)
                    <div class="post-card" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden; animation: fadeInUp 0.4s ease-out;">
                        <div style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.03);">
                            <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $post->user->name }}" style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover;">
                            <div style="flex: 1;">
                                <h4 style="font-size: 14px; font-weight: 800; color: white; margin: 0; display: flex; align-items: center; gap: 6px;">
                                    {{ $post->user->name }}
                                    @if($post->user_id === $community->user_id)
                                        <span style="background: rgba(51,144,236,0.1); color: #3390ec; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 900;">CRIADOR</span>
                                    @endif
                                </h4>
                                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div style="padding: 1.5rem;">
                            <p style="font-size: 14px; color: rgba(255,255,255,0.9); line-height: 1.6; margin-bottom: 1rem;">{!! $post->formatted_content !!}</p>
                            
                            @if($post->media)
                                <div style="margin-top: 1rem; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
                                    @if($post->media_type === 'image')
                                        <img src="{{ Storage::url($post->media) }}" style="width: 100%; max-height: 320px; object-fit: cover; background: rgba(0,0,0,0.2);">
                                    @elseif($post->media_type === 'video')
                                        <video src="{{ Storage::url($post->media) }}" controls style="width: 100%; max-height: 320px; background: #000;"></video>
                                    @else
                                        <!-- File download card -->
                                        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 44px; height: 44px; background: rgba(51,144,236,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                            </div>
                                            <div style="flex: 1;">
                                                <p style="font-size: 13px; font-weight: 800; color: white;">Recurso Exclusivo (.{{ pathinfo($post->media, PATHINFO_EXTENSION) }})</p>
                                            </div>
                                            <a href="{{ Storage::url($post->media) }}" download class="mogram-btn-secondary" style="padding: 0.6rem 1rem; border-radius: 10px; font-size: 11px; font-weight: 800; text-decoration: none; color: white; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">Baixar</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.03); display: flex; gap: 1.5rem;">
                            <button onclick="toggleLike({{ $post->id }}, this)" style="background: transparent; border: none; color: {{ $post->isLikedByUser(Auth::id()) ? '#ef4444' : 'var(--text-muted)' }}; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: 0.2s;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $post->isLikedByUser(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <span class="likes-count">{{ $post->likes_count }}</span>
                            </button>
                            <button onclick="toggleComments({{ $post->id }})" style="background: transparent; border: none; color: var(--text-muted); font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                <span>{{ $post->comments_count }} Comentários</span>
                            </button>
                        </div>
                        
                        <!-- Comment Section (Hidden by default) -->
                        <div id="comments-{{ $post->id }}" style="display: none; padding: 0 1.5rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.02); background: rgba(0,0,0,0.1);">
                            <div style="padding: 1.5rem 0; display: flex; flex-direction: column; gap: 1rem;">
                                @php $comments = []; try { $comments = $post->comments()->with('user')->get(); } catch(\Exception $e) {} @endphp
                                @foreach($comments as $comment)
                                <div style="display: flex; gap: 0.75rem;">
                                    <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $comment->user->name }}" style="width: 28px; height: 28px; border-radius: 8px;">
                                    <div style="flex: 1; background: rgba(255,255,255,0.03); padding: 0.75rem 1rem; border-radius: 12px;">
                                        <p style="font-size: 12px; font-weight: 800; color: white; margin: 0 0 4px;">{{ $comment->user->name }}</p>
                                        <p style="font-size: 13px; color: rgba(255,255,255,0.8); margin: 0; line-height: 1.4;">{!! $comment->formatted_content !!}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <form action="{{ route('communities.posts.comment', [$community->slug, $post->id]) }}" method="POST" style="display: flex; gap: 0.75rem; align-items: flex-end;">
                                @csrf
                                <div style="flex: 1;">
                                    <textarea name="content" placeholder="Escreva um comentário..." required style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 10px 12px; color: white; font-size: 13px; font-weight: 600; outline: none; resize: none; min-height: 40px;"></textarea>
                                </div>
                                <button type="submit" style="background: #3390ec; border: none; color: white; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Seja o primeiro a publicar nesta comunidade!</p>
                    </div>
                    @endforelse
                    
                    <div style="margin-top: 2rem;">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside style="display: flex; flex-direction: column; gap: 2rem;">
                <!-- About -->
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <h3 style="font-size: 14px; font-weight: 900; color: white; margin-bottom: 1rem;">Sobre a Comunidade</h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem;">{{ $community->description ?? 'Nenhuma descrição detalhada disponível.' }}</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <img src="{{ $community->user->avatar ? Storage::url($community->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $community->user->name }}" style="width: 32px; height: 32px; border-radius: 10px; object-fit: cover;">
                        <div>
                            <p style="font-size: 12px; color: white; font-weight: 800; margin: 0;">{{ $community->user->name }}</p>
                            <p style="font-size: 10px; color: var(--text-muted); margin: 0; font-weight: 600;">Criador</p>
                        </div>
                    </div>
                </div>

                <!-- Members (Mocking as per Image 4) -->
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 14px; font-weight: 900; color: white;">Membros Ativos</h3>
                        <span style="font-size: 11px; color: #22c55e; font-weight: 900; background: rgba(34, 197, 94, 0.1); padding: 2px 8px; border-radius: 6px;">ONLINE</span>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Using subscribers or mocking for high fidelity -->
                        @foreach($community->subscriptions()->where('status', 'active')->with('user')->take(6)->get() as $sub)
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="position: relative;">
                                <img src="{{ $sub->user->avatar ? Storage::url($sub->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $sub->user->name }}" style="width: 32px; height: 32px; border-radius: 10px; object-fit: cover; border: 1.5px solid rgba(255,255,255,0.05);">
                                <div style="position: absolute; bottom: -2px; right: -2px; width: 8px; height: 8px; background: #22c55e; border-radius: 50%; border: 2.5px solid #0b0a15;"></div>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.8);">{{ $sub->user->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </main>
</div>

<script>
    function handlePostMedia(input) {
        const container = document.getElementById('media-preview-container');
        const img = document.getElementById('post-image-preview');
        const vid = document.getElementById('post-video-preview');
        const file = document.getElementById('post-file-preview');
        const fileName = document.getElementById('file-name');

        if (input.files && input.files[0]) {
            const f = input.files[0];
            const reader = new FileReader();
            
            container.style.display = 'block';
            img.style.display = 'none';
            vid.style.display = 'none';
            file.style.display = 'none';

            if (f.type.startsWith('image/')) {
                reader.onload = (e) => {
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(f);
            } else if (f.type.startsWith('video/')) {
                const url = URL.createObjectURL(f);
                vid.src = url;
                vid.style.display = 'block';
            } else {
                fileName.textContent = f.name;
                file.style.display = 'flex';
            }
        }
    }

    function clearMedia() {
        const input = document.getElementById('post-media');
        input.value = '';
        document.getElementById('media-preview-container').style.display = 'none';
    }

    async function toggleLike(postId, btn) {
        try {
            const response = await fetch(`/communities/{{ $community->slug }}/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                const countSpan = btn.querySelector('.likes-count');
                countSpan.textContent = data.count;
                const svg = btn.querySelector('svg');
                if (data.liked) {
                    btn.style.color = '#ef4444';
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.style.color = 'var(--text-muted)';
                    svg.setAttribute('fill', 'none');
                }
            }
        } catch (e) { 
            console.error(e); 
            window.location.reload(); // Fallback for migration issues or session expiry
        }
    }

    function toggleComments(postId) {
        const div = document.getElementById(`comments-${postId}`);
        if (div) {
            div.style.display = div.style.display === 'none' ? 'block' : 'none';
        }
    }
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .filter-tab:hover { background: rgba(255,255,255,0.08) !important; color: white !important; }
    
    * { box-sizing: border-box; }

    @media (max-width: 991px) {
        .community-header-container { height: 260px !important; }
        
        .community-info-wrapper {
            bottom: 70px !important;
            left: 1rem !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.75rem !important;
        }
        .community-actions-wrapper {
            bottom: 1.5rem !important;
            left: 1rem !important;
            right: auto !important;
        }
        .responsive-grid-feed {
            grid-template-columns: 1fr !important;
            padding: 0 0.5rem 5rem !important;
            margin-top: 4rem !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .community-post-box {
            padding: 1rem !important;
            border-radius: 18px !important;
            margin-bottom: 1.5rem !important;
        }
        .post-create-footer {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
        }
        .mogram-btn-primary {
            padding: 0.8rem !important;
            font-size: 13px !important;
            width: 100% !important;
            text-align: center !important;
            display: block !important;
        }
        .post-card {
            border-radius: 18px !important;
        }
        .post-card-content {
            padding: 1rem 1.25rem !important;
        }
    }
</style>
@endsection
