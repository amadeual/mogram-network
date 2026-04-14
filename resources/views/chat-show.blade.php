@extends('layouts.app')

@section('title', 'Chat com ' . $user->name . ' - Mogram')

@section('content')
<div class="app-layout">
    @include("partials.sidebar")

    <main class="main-content" style="background: #0b0a15; padding: 0;">
        <div style="display: flex; height: 100vh;">
            
            <!-- Chat List Sidebar (Same as Index, but hidden on smaller mobile if conversation is open) -->
            <div class="chat-list-sidebar" style="width: 380px; border-right: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; background: rgba(255,255,255,0.01);">
                <div style="padding: 2.5rem 2rem 1.5rem;">
                    <a href="{{ route('chat.index') }}" style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-size: 13px; font-weight: 800; margin-bottom: 1.5rem; transition: 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        Voltar
                    </a>
                    <h1 style="font-size: 1.75rem; font-weight: 950; color: white; letter-spacing: -1px; margin-bottom: 1rem;">Conversas</h1>
                </div>

                <div style="flex: 1; overflow-y: auto;">
                    {{-- Active User --}}
                    <div style="background: rgba(51, 144, 236, 0.1); border-left: 3px solid #3390ec; display: flex; align-items: center; gap: 12px; padding: 1.25rem 2rem; transition: 0.2s;">
                        <div style="position: relative;">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #3390ec;">
                            @else
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $user->name }}" style="width: 52px; height: 52px; border-radius: 50%;">
                            @endif
                            <div style="position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background: #22c55e; border: 2px solid #0b0a15; border-radius: 50%;"></div>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 15px; font-weight: 900; color: white; margin: 0;">{{ $user->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Content -->
            <div style="flex: 1; display: flex; flex-direction: column; background: #0b0a15; position: relative;">
                
                <!-- Chat Header -->
                <header class="chat-header">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <a href="{{ route('chat.index') }}" class="mobile-only" style="color: white; margin-right: 8px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover;">
                        @else
                            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $user->name }}" style="width: 44px; height: 44px; border-radius: 12px;">
                        @endif
                        <div>
                            <h3 style="font-size: 16px; font-weight: 950; color: white; margin: 0; display: flex; align-items: center; gap: 6px;">
                                {{ $user->name }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#3390ec" style="color: white;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </h3>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 2px 0 0; font-weight: 700;">Ativo agora</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button style="background: rgba(255,255,255,0.05); border: none; width: 40px; height: 40px; border-radius: 10px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </button>
                    </div>
                </header>

                <!-- Messages -->
                <div id="chat_messages" class="chat-messages-container">
                    @foreach($messages as $msg)
                        <div style="display: flex; flex-direction: column; align-items: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }}; max-width: 80%; margin-bottom: 10px;">
                            @php $isGift = str_contains($msg->message, '🎁 enviou'); @endphp
                            
                            @if($isGift)
                                <div style="background: linear-gradient(135deg, rgba(255, 214, 0, 0.2), rgba(255, 145, 0, 0.1)); border: 2px solid #ffd600; padding: 1.25rem; border-radius: 24px; color: white; box-shadow: 0 10px 30px rgba(255,214,0,0.2); animation: giftPulse 1s ease-out; display: flex; align-items: center; gap: 15px; align-self: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }};">
                                    <div style="font-size: 2.5rem; filter: drop-shadow(0 0 10px rgba(255,214,0,0.5));">
                                        {{ Str::after(Str::before($msg->message, '!'), 'enviou ') }}
                                    </div>
                                    <div>
                                        <p style="margin: 0; color: #ffd600; font-weight: 950; font-size: 1rem;">{{ $msg->message }}</p>
                                        <p style="margin: 0; color: rgba(255,214,0,0.7); font-size: 0.7rem; font-weight: 800; text-transform: none;">Presente de Apoio</p>
                                    </div>
                                </div>
                            @else
                                <div style="background: {{ $msg->sender_id == Auth::id() ? '#3390ec' : 'rgba(255,255,255,0.05)' }}; padding: 1rem 1.25rem; border-radius: {{ $msg->sender_id == Auth::id() ? '20px 20px 4px 20px' : '20px 20px 20px 4px' }}; color: white; font-size: 15px; line-height: 1.5; font-weight: 500; align-self: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }};">
                                    {!! nl2br(e($msg->message)) !!}
                                </div>
                            @endif
                            <span style="font-size: 10px; color: rgba(255,255,255,0.3); margin-top: 6px; font-weight: 800; align-self: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }};">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Chat Input Area -->
                <div class="chat-input-container">
                    <form action="{{ route('chat.send', $user->id) }}" method="POST" id="chat_form" 
                          style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 0.75rem 0.75rem 0.75rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
                        @csrf
                        <div style="display: flex; gap: 12px; color: var(--text-muted);">
                            <button type="button" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='inherit'">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                            </button>
                            <button type="button" onclick="toggleGiftModal()" style="background: none; border: none; padding: 0; color: #ffd600; cursor: pointer; transition: 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                <span style="font-size: 20px;">🎁</span>
                            </button>
                            <div style="position: relative;">
                                <button type="button" onclick="toggleEmojiPicker()" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='inherit'">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                                </button>
                                {{-- Emoji Picker Popover --}}
                                <div id="emoji_picker" style="display: none; position: absolute; bottom: 50px; left: 0; background: #151621; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 16px; width: 280px; padding: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.5); z-index: 100;">
                                    <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; font-size: 20px;">
                                        @foreach(['😂','😊','😍','🥰','😉','😎','🤔','🤨','🙄','😒','😔','😭','😱','😡','👍','👎','❤️','🔥','✨','💯','🙌','👏','🙏','🎉'] as $emoji)
                                            <span onclick="insertEmoji('{{ $emoji }}')" style="cursor: pointer; padding: 4px; border-radius: 8px; text-align: center; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">{{ $emoji }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="text" id="message_input" name="message" placeholder="Escreva uma mensagem..." autocomplete="off" required
                               style="flex: 1; background: transparent; border: none; color: white; outline: none; font-size: 15px; font-weight: 500; font-family: inherit;">
                        
                        <button type="submit" 
                                style="background: #3390ec; border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s; flex-shrink: 0; box-shadow: 0 4px 10px rgba(51, 144, 236, 0.2);" 
                                onmouseover="this.style.transform='scale(1.1)'; this.style.background='#2b83d8'" 
                                onmouseout="this.style.transform='scale(1)'; this.style.background='#3390ec'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="margin-left: 2px;">
                                <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- 🎁 Optimized Gift Popover (TikTok & Mogram Hybrid) -->
<div id="gift_modal" style="display: none; position: fixed; bottom: 120px; right: 30px; z-index: 10000; width: 360px; max-width: calc(100% - 60px); animation: giftSheetUp 0.4s cubic-bezier(0.19, 1, 0.22, 1);">
    <div style="background: rgba(21, 22, 33, 0.9); backdrop-filter: blur(25px); border-radius: 28px; border: 1.2px solid rgba(255,255,255,0.08); box-shadow: 0 40px 100px rgba(0,0,0,0.8); overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Header -->
        <div style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <div>
                <h3 style="color: white; font-weight: 900; font-size: 1rem; margin: 0; letter-spacing: -0.5px;">Presentes</h3>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 3px;">
                    <div style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></div>
                    <p style="color: rgba(255,255,255,0.4); font-size: 0.7rem; font-weight: 700; margin: 0;">Saldo: <span style="color: white;">R$ {{ number_format(Auth::user()->balance, 2, ',', '.') }}</span></p>
                </div>
            </div>
            <button onclick="toggleGiftModal()" style="background: rgba(255,255,255,0.05); border: none; color: white; cursor: pointer; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">&times;</button>
        </div>

        <!-- Scrollable Grid (High-Density) -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 1.25rem; max-height: 320px; overflow-y: auto;" class="custom-scroll">
            @foreach($gifts as $gift)
            <div onclick="selectGift('{{ $gift->id }}', this)" class="gift-card-v3" style="cursor: pointer; padding: 12px 6px; text-align: center; border-radius: 18px; transition: 0.2s; border: 1px solid transparent;">
                <div style="font-size: 1.75rem; margin-bottom: 6px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3)); transition: 0.2s;" class="gift-icon-v3">{{ $gift->icon }}</div>
                <div style="font-size: 0.65rem; font-weight: 800; color: rgba(255,255,255,0.5); margin-bottom: 3px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $gift->name }}</div>
                <div style="font-size: 0.7rem; font-weight: 900; color: #ffd600;">R$ {{ number_format($gift->price, 2, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        <!-- Footer / Action -->
        <div style="padding: 1.25rem; background: rgba(255,255,255,0.02);">
            <button id="send_gift_btn" disabled onclick="confirmSendGift()" style="width: 100%; background: linear-gradient(135deg, #ffd600, #ff9100); color: black; border: none; padding: 1rem; border-radius: 16px; font-weight: 950; cursor: pointer; transition: 0.3s; font-size: 0.85rem; box-shadow: 0 10px 30px rgba(255,214,0,0.15); opacity: 0.3; text-transform: none; letter-spacing: 0.5px;">
                Enviar Agora
            </button>
        </div>
    </div>
</div>

<script>
    // Scroll to bottom of chat
    const chatBox = document.getElementById('chat_messages');
    chatBox.scrollTop = chatBox.scrollHeight;

    function toggleEmojiPicker() {
        const picker = document.getElementById('emoji_picker');
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
    }

    function insertEmoji(emoji) {
        const input = document.getElementById('message_input');
        input.value += emoji;
        input.focus();
        toggleEmojiPicker();
    }

    // Close emoji picker when clicking outside
    document.addEventListener('click', function(e) {
        const picker = document.getElementById('emoji_picker');
        const trigger = e.target.closest('button[onclick="toggleEmojiPicker()"]');
        if (!picker.contains(e.target) && !trigger) {
            picker.style.display = 'none';
        }
    });

    // Auto-scroll on submit (for UX before page reload)
    document.getElementById('chat_form').addEventListener('submit', function() {
        setTimeout(() => { chatBox.scrollTop = chatBox.scrollHeight; }, 50);
    });

    let selectedGiftId = null;

    function toggleGiftModal() {
        const modal = document.getElementById('gift_modal');
        modal.style.display = modal.style.display === 'none' ? 'flex' : 'none';
    }

    function selectGift(id, element) {
        selectedGiftId = id;
        document.querySelectorAll('.gift-card-v3').forEach(el => {
            el.style.borderColor = 'transparent';
            el.style.background = 'transparent';
        });
        element.style.borderColor = '#ffd600';
        element.style.background = 'rgba(255,214,0,0.05)';
        
        const btn = document.getElementById('send_gift_btn');
        btn.disabled = false;
        btn.style.opacity = '1';
    }

    function confirmSendGift() {
        if (!selectedGiftId) return;
        
        const btn = document.getElementById('send_gift_btn');
        btn.disabled = true;
        btn.innerText = 'ENVIANDO...';

        fetch('{{ route('chat.gift', $user->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ gift_id: selectedGiftId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload(); // Simple reload for simplicity in regular chat
            } else {
                alert(data.message || 'Erro ao enviar presente');
                btn.disabled = false;
                btn.innerText = 'ENVIAR PRESENTE';
            }
        });
    }
</script>

<style>
.main-content { margin-left: 280px; }
.chat-header { padding: 1.5rem 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; z-index: 10; background: #0b0a15; }
.chat-messages-container { flex: 1; overflow-y: auto; padding: 2rem 2.5rem; display: flex; flex-direction: column; gap: 1.5rem; }
.chat-input-container { padding: 1.5rem 2.5rem 2.5rem; background: #0b0a15; }

/* 🎁 Gift Card V3 Styles */
.gift-card-v3:hover {
    background: rgba(255,255,255,0.05) !important;
}
.gift-card-v3:hover .gift-icon-v3 {
    transform: scale(1.2) rotate(5deg);
}

@keyframes giftPulse {
    0% { transform: scale(0.95); opacity: 0.5; }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes giftSheetUp {
    from { transform: translateY(100%) scale(0.9); opacity: 0; }
    to   { transform: translateY(0) scale(1); opacity: 1; }
}

.custom-scroll::-webkit-scrollbar { width: 5px; }
.custom-scroll::-webkit-scrollbar-track { background: transparent; }
.custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

@media (max-width: 991px) {
    .main-content { margin-left: 0 !important; height: calc(100vh - 60px); }
    .chat-list-sidebar { display: none !important; }
    .chat-header { padding: 1rem 1.25rem; }
    .chat-messages-container { padding: 1.25rem; gap: 1rem; }
    .chat-input-container { padding: 1rem 1.25rem 1.5rem; }
    #gift_modal { right: 10px; bottom: 85px; width: calc(100% - 20px); }
}
</style>
@endsection
