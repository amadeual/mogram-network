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
                            <p style="font-size: 12px; color: #3390ec; font-weight: 800; margin: 2px 0 0;">Digitando...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Content -->
            <div style="flex: 1; display: flex; flex-direction: column; background: #0b0a15; position: relative;">
                
                <!-- Chat Header -->
                <header style="padding: 1.5rem 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; z-index: 10;">
                    <div style="display: flex; align-items: center; gap: 12px;">
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
                            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0; font-weight: 700;">Ativo agora</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <button style="background: rgba(255,255,255,0.05); border: none; width: 44px; height: 44px; border-radius: 12px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </button>
                        <button style="background: rgba(255,255,255,0.05); border: none; width: 44px; height: 44px; border-radius: 12px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </div>
                </header>

                <!-- Messages -->
                <div id="chat_messages" style="flex: 1; overflow-y: auto; padding: 2rem 2.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                    @foreach($messages as $msg)
                        <div style="display: flex; flex-direction: column; align-items: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }}; max-width: 80%;">
                            <div style="background: {{ $msg->sender_id == Auth::id() ? 'var(--primary-blue)' : 'rgba(255,255,255,0.05)' }}; padding: 1rem 1.25rem; border-radius: {{ $msg->sender_id == Auth::id() ? '20px 20px 4px 20px' : '20px 20px 20px 4px' }}; color: white; font-size: 15px; line-height: 1.5; font-weight: 500; align-self: {{ $msg->sender_id == Auth::id() ? 'flex-end' : 'flex-start' }};">
                                {!! nl2br(e($msg->message)) !!}
                            </div>
                            <span style="font-size: 10px; color: var(--text-muted); margin-top: 6px; font-weight: 800;">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Chat Input Area -->
                <div style="padding: 1.5rem 2.5rem 2.5rem; background: #0b0a15;">
                    <form action="{{ route('chat.send', $user->id) }}" method="POST" id="chat_form" 
                          style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 0.75rem 0.75rem 0.75rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
                        @csrf
                        <div style="display: flex; gap: 12px; color: var(--text-muted);">
                            <button type="button" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='inherit'">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                            </button>
                            <div style="position: relative;">
                                <button type="button" onclick="toggleEmojiPicker()" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='inherit'">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                                </button>
                                {{-- Emoji Picker Popover --}}
                                <div id="emoji_picker" style="display: none; position: absolute; bottom: 50px; left: 0; background: #151621; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 16px; width: 280px; padding: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.5); z-index: 100;">
                                    <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; font-size: 20px;">
                                        @foreach(['😀','😃','😄','😁','😆','😅','😂','🤣','😊','😇','🙂','😉','😍','🥰','😘','😋','😛','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬'] as $emoji)
                                            <span onclick="insertEmoji('{{ $emoji }}')" style="cursor: pointer; padding: 4px; border-radius: 8px; text-align: center; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">{{ $emoji }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="text" id="message_input" name="message" placeholder="Escreva uma mensagem..." autocomplete="off" required
                               style="flex: 1; background: transparent; border: none; color: white; outline: none; font-size: 15px; font-weight: 500; font-family: inherit;">
                        
                        <button type="submit" style="background: #3390ec; color: white; border: none; padding: 0.85rem 1.75rem; border-radius: 14px; font-weight: 850; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.2);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>
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
</script>

<style>
.main-content { margin-left: 280px; }
@media (max-width: 991px) {
    .main-content { margin-left: 0 !important; }
    .chat-list-sidebar { display: none !important; }
}
</style>
@endsection
