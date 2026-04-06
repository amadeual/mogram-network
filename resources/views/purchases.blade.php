@extends('layouts.app')

@section('title', 'Minhas Compras - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <!-- Main Feed -->
    <main class="main-content">
        <header style="height: 70px; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-gray);">
            <h1 style="font-size: 1.15rem; font-weight: 800;">Minhas Compras</h1>
            <div style="display: flex; gap: 1rem; position: relative;">
                <a href="{{ route('chat.index') }}" style="background: transparent; border: none; color: white; cursor: pointer; display: flex; align-items: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </a>
            </div>
        </header>

        <div class="feed-container" style="padding-top: 1.5rem;">
            @forelse($purchases as $purchase)
                @php $post = $purchase->post; @endphp
                <div class="post-card">
                    <div class="post-header">
                        <a href="{{ route('creator.profile', $post->user->username) }}" style="text-decoration: none;">
                            @if($post->user->avatar)
                                <img src="{{ Storage::url($post->user->avatar) }}" class="post-author-img" style="object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
                            @else
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $post->user->name }}" class="post-author-img">
                            @endif
                        </a>
                        <div style="flex: 1;">
                            <a href="{{ route('creator.profile', $post->user->username) }}" style="text-decoration: none;">
                                <h4 style="font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 4px; color: white;">
                                    {{ $post->user->name }} 
                                    @if($post->user->is_verified)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#3390ec"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    @endif
                                </h4>
                            </a>
                            <p style="font-size: 11px; color: var(--text-muted);">Comprado em {{ $purchase->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            PAGO
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
                        @if($post->type == 'video')
                            <video src="{{ Storage::url($post->file_path) }}" poster="{{ $post->thumbnail ? Storage::url($post->thumbnail) : '' }}" controls controlsList="nodownload" style="width: 100%; border-radius: 16px; background: black; max-height: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);"></video>
                        @elseif($post->type == 'image')
                            <div class="purchased-image" style="position: relative;">
                                <img src="{{ Storage::url($post->file_path) }}" style="width: 100%; border-radius: 16px; object-fit: contain; max-height: 600px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                            </div>
                        @elseif($post->type == 'pdf')
                            <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                                <div style="display: flex; align-items: center; gap: 1.5rem;">
                                    @if($post->thumbnail)
                                        <div style="width: 80px; height: 110px; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.3); flex-shrink: 0;">
                                            <img src="{{ Storage::url($post->thumbnail) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    @else
                                        <div style="width: 50px; height: 50px; background: rgba(239,68,68,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </div>
                                    @endif
                                    <div style="flex: 1;">
                                        <p style="font-size: 14px; font-weight: 800; color: white; margin-bottom: 2px;">Documento PDF</p>
                                        <p style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Seu acesso exclusivo está liberado</p>
                                    </div>
                                </div>
                                @php
                                    $ext = pathinfo($post->file_path, PATHINFO_EXTENSION);
                                    $safeName = \Illuminate\Support\Str::slug($post->title ?: 'mogram') . '.' . ($ext ?: 'pdf');
                                @endphp
                                <div style="display: flex; gap: 0.75rem; width: 100%;">
                                    <a href="{{ Storage::url($post->file_path) }}" target="_blank" class="mogram-btn-secondary" style="flex: 1; text-align: center; padding: 0.8rem; border-radius: 12px; font-size: 12px; font-weight: 800; text-decoration: none; color: white; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">Visualizar</a>
                                    <a href="{{ Storage::url($post->file_path) }}" download="{{ $safeName }}" class="mogram-btn-primary" style="flex: 1; text-align: center; padding: 0.8rem; border-radius: 12px; font-size: 12px; font-weight: 800; text-decoration: none; color: white;">Baixar</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    <div class="post-footer" style="padding: 1.5rem 1.5rem 1.25rem; border-top: 1px solid rgba(255,255,255,0.03); margin-top: 1rem;">
                        <div style="display: flex; gap: 1.5rem;">
                            <button onclick="toggleLike(this, '{{ $post->id }}')" 
                                    style="background: transparent; border: none; display: flex; align-items: center; gap: 0.6rem; font-size: 14px; font-weight: 800; color: {{ $post->isLikedBy(auth()->user()) ? '#ef4444' : 'var(--text-muted)' }}; cursor: pointer; transition: 0.2s; padding: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <span class="likes-count">{{ $post->likes->count() }}</span>
                            </button>
                            <a href="{{ route('dashboard') }}?post={{ $post->id }}" 
                               style="background: transparent; border: none; display: flex; align-items: center; gap: 0.6rem; font-size: 14px; font-weight: 800; color: var(--text-muted); cursor: pointer; transition: 0.2s; padding: 0; text-decoration: none;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                <span class="comments-count">{{ $post->comments->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                    <div style="width: 64px; height: 64px; background: rgba(51,144,236,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M16 10a4 4 0 0 1-8 0"/><path d="M3 21h18"/></svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 0.5rem;">Nenhuma compra ainda</h3>
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Desbloqueie conteúdos exclusivos dos seus criadores favoritos!</p>
                    <a href="{{ route('dashboard') }}" class="mogram-btn-primary" style="display: inline-block; margin-top: 1.5rem; text-decoration: none; padding: 0.75rem 2rem; border-radius: 12px;">Explorar Feed</a>
                </div>
            @endforelse

            <div style="margin-top: 2rem;">
                {{ $purchases->links() }}
            </div>
        </div>
    </main>

    <!-- Right Sidebar Placeholder to maintain layout consistency -->
    <aside class="right-sidebar">
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.5rem;">
            <h3 style="font-size: 14px; font-weight: 800; color: white; margin-bottom: 1rem;">Central de Compras</h3>
            <p style="font-size: 12px; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem;">
                Aqui você encontra todos os conteúdos que desbloqueou. O acesso é vitalício enquanto o conteúdo estiver disponível na plataforma.
            </p>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                    <span style="color: var(--text-muted);">Total de itens:</span>
                    <span style="color: white; font-weight: 800;">{{ $purchases->total() }}</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                    <span style="color: var(--text-muted);">Investimento total:</span>
                    <span style="color: #22c55e; font-weight: 800;">R$ {{ number_format($purchases->sum('amount'), 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </aside>
</div>

@section('scripts')
<script>
    function showFullDesc(postId) {
        document.getElementById(`short_desc_${postId}`).style.display = 'none';
        document.getElementById(`full_desc_${postId}`).style.display = 'block';
    }

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
                btn.style.color = '#ef4444';
                btn.querySelector('svg').setAttribute('fill', 'currentColor');
            } else {
                btn.style.color = 'var(--text-muted)';
                btn.querySelector('svg').setAttribute('fill', 'none');
            }
        });
    }
</script>
@endsection
@endsection
