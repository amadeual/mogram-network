<div style="display: flex; gap: 12px; align-items: flex-start;">
    <img src="{{ $message->user->avatar ? Storage::url($message->user->avatar) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $message->user->name }}" 
         style="width: 32px; height: 32px; border-radius: 50%;">
    <div style="flex: 1;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <p style="font-size: 0.8rem; font-weight: 800; color: #ffd600;">{{ $message->user->name }}</p>
            @if($message->user->id == $live->user_id)
                <span style="font-size: 8px; font-weight: 900; background: #3390ec; color: white; padding: 2px 4px; border-radius: 4px; text-transform: uppercase;">CRIADOR</span>
            @endif
            <span style="font-size: 0.7rem; color: #555;">{{ $message->created_at->format('H:i') }}</span>
        </div>
        <p style="font-size: 0.85rem; color: #ccc; line-height: 1.4; margin-top: 2px; background: rgba(255,255,255,0.03); padding: 8px 12px; border-radius: 12px; display: inline-block;">
            {{ $message->message }}
        </p>
    </div>
</div>
