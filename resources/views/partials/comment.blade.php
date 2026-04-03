<div class="comment-item" style="display: flex; gap: 1rem; margin-bottom: 1.5rem; {{ $comment->parent_id ? 'margin-left: 3rem; border-left: 2px solid rgba(255,255,255,0.05); padding-left: 1rem;' : '' }}">
    <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $comment->user->name }}" 
         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
    <div style="flex: 1;">
        <div style="background: rgba(255,255,255,0.03); border-radius: 16px; padding: 0.75rem 1rem;">
            <div style="display: flex; gap: 1rem; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <h5 style="font-size: 13px; font-weight: 800; color: white; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; min-width: 0;">{{ $comment->user->name }}</h5>
                <span style="font-size: 10px; color: var(--text-muted); flex-shrink: 0;">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p style="font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.4; margin: 0;">{{ $comment->content }}</p>
        </div>
        <div style="padding-top: 6px; padding-left: 4px; display: flex; gap: 1.25rem; align-items: center;">
            <button onclick="replyTo('{{ $comment->id }}', '{{ $comment->user->name }}', '{{ $comment->post_id }}')" 
                    style="background: transparent; border: none; font-size: 11px; font-weight: 800; color: var(--primary-blue); cursor: pointer; padding: 0;">Responder</button>
            
            @if(Auth::id() == $comment->user_id && $comment->created_at->diffInMinutes(now()) < 5)
                <button onclick="deleteComment('{{ $comment->id }}')" 
                        style="background: transparent; border: none; font-size: 11px; font-weight: 800; color: #ef4444; cursor: pointer; padding: 0;">Excluir</button>
            @endif
        </div>
        
        @if(!$comment->parent_id && $comment->replies->count() > 0)
            <div class="replies-container" style="margin-top: 1rem;">
                @foreach($comment->replies as $reply)
                    @include('partials.comment', ['comment' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>
