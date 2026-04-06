@extends('layouts.app')

@section('title', 'Feed Principal - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <!-- Main Feed -->
    <main class="main-content">
        <header style="height: 70px; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-gray);">
            <h1 style="font-size: 1.15rem; font-weight: 800;">Feed Principal</h1>
            <div style="display: flex; gap: 1rem; position: relative;">
                <button class="notif-bell" onclick="toggleNotifs()" style="background: transparent; border: none; color: white; cursor: pointer; position: relative;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div style="position: absolute; top: 0; right: 0; width: 10px; height: 10px; background: #FF3B30; border-radius: 50%; border: 2px solid #0b0a15;"></div>
                </button>
                <a href="{{ route('chat.index') }}" style="background: transparent; border: none; color: white; cursor: pointer; display: flex; align-items: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </a>
            </div>
        </header>

        <div class="feed-container">
            <!-- Stories -->
            <div class="stories-bar">
                <div class="story-circle">
                    <div class="story-avatar-wrapper empty" style="position: relative;">
                        <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" class="story-avatar">
                        <div style="position: absolute; bottom: -2px; right: -2px; width: 22px; height: 22px; background: var(--primary-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #0b0a15;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                    </div>
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Seu Story</span>
                </div>
                <div class="story-circle">
                    <div class="story-avatar-wrapper">
                        <img src="{{ asset('images/creators/ana.png') }}" class="story-avatar">
                    </div>
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Ana Clara</span>
                </div>
                <div class="story-circle">
                    <div class="story-avatar-wrapper">
                        <img src="{{ asset('images/creators/marcos.png') }}" class="story-avatar">
                    </div>
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">João M.</span>
                </div>
                <!-- ... More stories -->
            </div>

            <!-- Dynamic Posts Feed -->
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
                        {!! $post->description !!}
                    </div>
                </div>
                
                @if($post->file_path)
                <div class="post-media" style="margin-top: 1rem; position: relative;">
                    @if($post->is_exclusive && auth()->id() != $post->user_id)
                        <img src="{{ Storage::url($post->file_path) }}" style="filter: blur(40px) brightness(0.5); width: 100%; border-radius: 16px;">
                        <div class="exclusive-overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(0,0,0,0.4); border-radius: 16px;">
                            <div style="width: 50px; height: 50px; background: rgba(51, 144, 236, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3390ec" stroke-width="3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <p style="font-size: 12px; font-weight: 900; color: white; margin-bottom: 1rem;">Conteúdo Exclusivo</p>
                            <button class="mogram-btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 12px;">Desbloquear R$ {{ number_format($post->price, 2, ',', '.') }}</button>
                        </div>
                    @else
                        @if($post->type == 'video')
                            <video src="{{ Storage::url($post->file_path) }}" controls style="width: 100%; border-radius: 16px; background: black; max-height: 500px;"></video>
                        @elseif($post->type == 'image')
                            <img src="{{ Storage::url($post->file_path) }}" style="width: 100%; border-radius: 16px; object-fit: contain; max-height: 600px;">
                        @elseif($post->type == 'pdf')
                            <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                                <div style="width: 50px; height: 50px; background: rgba(239,68,68,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div style="flex: 1;">
                                    <p style="font-size: 13px; font-weight: 800; color: white; margin-bottom: 2px;">Documento PDF</p>
                                    <p style="font-size: 11px; color: var(--text-muted);">Clique para baixar e visualizar</p>
                                </div>
                                <a href="{{ Storage::url($post->file_path) }}" download class="mogram-btn-secondary" style="padding: 0.6rem 1rem; border-radius: 10px; font-size: 11px;">Baixar</a>
                            </div>
                        @endif
                    @endif
                </div>
                @endif

                <div class="post-footer" style="padding: 1.5rem 1.5rem 1.25rem; border-top: 1px solid rgba(255,255,255,0.03); margin-top: 1rem;">
                    <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <button onclick="toggleLike(this, '{{ $post->id }}')" 
                                style="background: transparent; border: none; display: flex; align-items: center; gap: 0.6rem; font-size: 14px; font-weight: 800; color: {{ $post->isLikedBy(auth()->user()) ? '#3390ec' : 'var(--text-muted)' }}; cursor: pointer; transition: 0.2s; padding: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            <span class="likes-count">{{ $post->likes->count() }}</span>
                        </button>
                        <button onclick="toggleComments('{{ $post->id }}')" 
                                style="background: transparent; border: none; display: flex; align-items: center; gap: 0.6rem; font-size: 14px; font-weight: 800; color: var(--text-muted); cursor: pointer; transition: 0.2s; padding: 0;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                            <span class="comments-count">{{ $post->comments->count() }}</span>
                        </button>
                        <a href="{{ route('chat.show', $post->user_id) }}" 
                                style="background: transparent; border: none; display: flex; align-items: center; gap: 0.6rem; font-size: 14px; font-weight: 800; color: var(--text-muted); cursor: pointer; transition: 0.2s; padding: 0; text-decoration: none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </a>
                    </div>

                    <!-- Comment Section -->
                    <div id="comments_section_{{ $post->id }}" style="display: none; border-top: 1px solid rgba(255,255,255,0.03); padding-top:1.5rem;">
                        <div id="comments_list_{{ $post->id }}">
                            @foreach($post->comments as $comment)
                                @include('partials.comment', ['comment' => $comment])
                            @endforeach
                        </div>
                        
                        <!-- Reply Indicator (Hidden by default) -->
                        <div id="reply_indicator_{{ $post->id }}" style="display: none; background: rgba(51,144,236,0.1); padding: 8px 12px; border-radius: 8px; margin-bottom: 1rem; align-items: center; justify-content: space-between;">
                            <span style="font-size: 11px; color: var(--primary-blue); font-weight: 800;">Respondendo a <span id="reply_name_{{ $post->id }}"></span></span>
                            <button onclick="cancelReply('{{ $post->id }}')" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 12px;">×</button>
                        </div>

                        <!-- Comment form -->
                        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . auth()->user()->name }}" 
                                 style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #3390ec;">
                            <div style="flex: 1; position: relative;">
                                <input type="text" id="comment_input_{{ $post->id }}" 
                                       placeholder="Escreva um comentário..."
                                       style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 0.75rem 3.5rem 0.75rem 1rem; color: white; font-size: 13px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.borderColor='#3390ec'"
                                       onkeydown="if(event.key === 'Enter') { event.preventDefault(); submitComment('{{ $post->id }}'); }">
                                <button onclick="showEmojiPicker('{{ $post->id }}')" 
                                        style="position: absolute; right: 2.5rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; font-size: 18px; cursor: pointer; opacity: 0.6; padding: 0;">😊</button>
                                <button onclick="submitComment('{{ $post->id }}')" 
                                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--primary-blue); padding: 0;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                </button>

                                <!-- Simple Emoji Picker -->
                                <div id="emoji_picker_{{ $post->id }}" style="display: none; position: absolute; bottom: 100%; right: 0; background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); z-index: 10; width: 200px; grid-template-columns: repeat(5, 1fr); gap: 8px;">
                                    @php $emojis = ['❤️', '🔥', '👏', '😍', '🙌', '✨', '😂', '💯', '🚀', '🌟']; @endphp
                                    @foreach($emojis as $emoji)
                                        <button onclick="insertEmoji('{{ $post->id }}', '{{ $emoji }}')" 
                                                style="background: transparent; border: none; font-size: 20px; cursor: pointer; padding: 4px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.2)'" onmouseout="this.style.background='transparent'">
                                            {{ $emoji }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                <div style="width: 64px; height: 64px; background: rgba(51,144,236,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 0.5rem;">O feed está vazio</h3>
                <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Siga alguns criadores ou publique seu primeiro conteúdo!</p>
            </div>
            @endforelse

            <div style="margin-top: 2rem;">
                {{ $posts->links() }}
            </div>
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="right-sidebar">
        <div style="margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Lives em alta</h3>
                <a href="#" style="font-size: 11px; color: var(--primary-blue); font-weight: 700; text-decoration: none;">Ver tudo</a>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 12px; border: 1px solid var(--border-gray);">
                <div style="position: relative;">
                    <img src="{{ asset('images/creators/marcos.png') }}" style="width: 44px; height: 44px; border-radius: 50%;">
                    <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; font-size: 8px; font-weight: 900; padding: 2px 4px; border-radius: 4px; border: 2px solid #0b0a15;">AO VIVO</div>
                </div>
                <div>
                    <h4 style="font-size: 13px; font-weight: 700;">Gameplay Sábado</h4>
                    <p style="font-size: 11px; color: var(--text-muted);">Marcos Gamer • 1.2k assistindo</p>
                </div>
            </div>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Sugestões para você</h3>
                <a href="#" style="font-size: 11px; color: var(--primary-blue); font-weight: 700; text-decoration: none;">Ver tudo</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Julia" style="width: 36px; height: 36px; border-radius: 50%;">
                        <div>
                            <h4 style="font-size: 13px; font-weight: 700;">Julia Design</h4>
                            <p style="font-size: 11px; color: var(--text-muted);">Seguido por ana.c</p>
                        </div>
                    </div>
                    <a href="#" style="font-size: 12px; color: var(--primary-blue); font-weight: 700; text-decoration: none;">Seguir</a>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Pedro" style="width: 36px; height: 36px; border-radius: 50%;">
                        <div>
                            <h4 style="font-size: 13px; font-weight: 700;">Pedro Tech</h4>
                            <p style="font-size: 11px; color: var(--text-muted);">Novo no Mogram</p>
                        </div>
                    </div>
                    <a href="#" style="font-size: 12px; color: var(--primary-blue); font-weight: 700; text-decoration: none;">Seguir</a>
                </div>
            </div>
        </div>

        <footer style="margin-top: 4rem; opacity: 0.5;">
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
                <a href="#" style="font-size: 10px; color: white; text-decoration: none;">Sobre</a>
                <a href="#" style="font-size: 10px; color: white; text-decoration: none;">Ajuda</a>
                <a href="#" style="font-size: 10px; color: white; text-decoration: none;">Privacidade</a>
                <a href="#" style="font-size: 10px; color: white; text-decoration: none;">Termos</a>
            </div>
            <p style="font-size: 10px;">© 2026 Mogram do Brasil</p>
        </footer>
    </aside>
</div>
@section('scripts')
<script>
    const replyData = {};
    const submittingPosts = {};

    function toggleLike(btn, postId) {
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const countSpan = btn.querySelector('.likes-count');
            countSpan.innerText = data.likes_count;
            if (data.status === 'liked') {
                btn.style.color = '#3390ec';
                btn.querySelector('svg').setAttribute('fill', 'currentColor');
            } else {
                btn.style.color = 'var(--text-muted)';
                btn.querySelector('svg').setAttribute('fill', 'none');
            }
        });
    }

    function toggleComments(postId) {
        const section = document.getElementById(`comments_section_${postId}`);
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }

    function showEmojiPicker(postId) {
        const picker = document.getElementById(`emoji_picker_${postId}`);
        picker.style.display = picker.style.display === 'none' ? 'grid' : 'none';
    }

    function insertEmoji(postId, emoji) {
        const input = document.getElementById(`comment_input_${postId}`);
        input.value += emoji;
        input.focus();
        showEmojiPicker(postId);
    }

    function replyTo(commentId, userName, postId) {
        replyData[postId] = commentId;
        const indicator = document.getElementById(`reply_indicator_${postId}`);
        const nameSpan = document.getElementById(`reply_name_${postId}`);
        const input = document.getElementById(`comment_input_${postId}`);
        
        if (indicator) {
            nameSpan.innerText = userName;
            indicator.style.display = 'flex';
        }
        input.focus();
    }

    function cancelReply(postId) {
        delete replyData[postId];
        const indicator = document.getElementById(`reply_indicator_${postId}`);
        if(indicator) indicator.style.display = 'none';
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style = `position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: ${type === 'success' ? '#3390ec' : '#ef4444'}; color: white; padding: 12px 24px; border-radius: 99px; font-size: 14px; font-weight: 800; z-index: 10000; box-shadow: 0 10px 30px rgba(0,0,0,0.5); animation: toastUp 0.3s ease-out;`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = '0.5s';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    const style = document.createElement('style');
    style.innerHTML = `@keyframes toastUp { from { transform: translate(-50%, 50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }`;
    document.head.appendChild(style);

    function submitComment(postId) {
        if (submittingPosts[postId]) return;
        
        const input = document.getElementById(`comment_input_${postId}`);
        const content = input.value.trim();
        if (!content) return;

        submittingPosts[postId] = true;
        input.disabled = true;

        const body = {
            content: content,
            parent_id: replyData[postId] || null
        };

        fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(body)
        })
        .then(res => res.json())
        .then(data => {
            if (body.parent_id) {
                showToast('Resposta enviada!');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                const list = document.getElementById(`comments_list_${postId}`);
                if(list && data.html) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    const commentNode = tempDiv.querySelector('.comment-item');
                    list.prepend(commentNode);
                    showToast('Comentário enviado!');
                }
                input.value = '';
                input.disabled = false;
                delete submittingPosts[postId];
                cancelReply(postId);
            }
        })
        .catch(err => {
            console.error(err);
            input.disabled = false;
            delete submittingPosts[postId];
            showToast('Erro ao enviar', 'error');
        });
    }

    function deleteComment(commentId) {
        openMogramModal(
            'Excluir Comentário?', 
            'Esta ação não pode ser desfeita e o comentário será removido permanentemente.',
            () => {
                fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Comentário excluído!');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast(data.error || 'Erro ao excluir', 'error');
                    }
                });
            }
        );
    }
</script>
@endsection
@endsection
