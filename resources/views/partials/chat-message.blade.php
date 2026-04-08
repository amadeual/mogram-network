<div style="display: flex; gap: 12px; align-items: flex-start; margin-bottom: 15px; animation: giftPulse 1s ease-out;">
    <img src="{{ $message->user->avatar ? Storage::url($message->user->avatar) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $message->user->name }}" 
         style="width: 38px; height: 38px; border-radius: 50%; border: 2px solid {{ str_contains($message->message, 'enviou') ? '#ffd600' : 'transparent' }};">
    <div style="flex: 1;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
            <p style="font-size: 0.85rem; font-weight: 800; color: {{ str_contains($message->message, 'enviou') ? '#ffd600' : '#3390ec' }};">{{ $message->user->name }}</p>
            @if($message->user->id == $live->user_id)
                <span style="font-size: 8px; font-weight: 900; background: #3390ec; color: white; padding: 2px 4.5px; border-radius: 4px; text-transform: none;">CRIADOR</span>
            @endif
            <span style="font-size: 0.65rem; color: #444;">{{ $message->created_at->format('H:i') }}</span>
        </div>
        
        @if(str_contains($message->message, 'enviou'))
            <div style="background: linear-gradient(135deg, rgba(255, 214, 0, 0.15), rgba(255, 145, 0, 0.05)); border: 1.5px solid rgba(255, 214, 0, 0.3); padding: 12px 18px; border-radius: 20px; display: inline-flex; align-items: center; gap: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                <span style="font-size: 2rem; filter: drop-shadow(0 0 5px rgba(255,214,0,0.5));">{{ Str::after(Str::before($message->message, '!'), 'enviou ') }}</span>
                <div>
                    <p style="margin: 0; color: #ffd600; font-weight: 900; font-size: 0.9rem; letter-spacing: -0.5px;">{{ $message->message }}</p>
                    <p style="margin: 0; color: rgba(255,214,0,0.6); font-size: 0.65rem; font-weight: 800; text-transform: none;">Presente de Apoio</p>
                </div>
            </div>
        @else
            <p style="font-size: 0.9rem; color: #eee; line-height: 1.5; margin: 0; background: rgba(30, 32, 53, 0.8); padding: 10px 15px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.03); display: inline-block; max-width: 90%;">
                {{ $message->message }}
            </p>
        @endif
    </div>
</div>

<style>
    @keyframes giftPulse {
        0% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
