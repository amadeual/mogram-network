@extends('layouts.app')

@section('title', 'Mensagens - Mogram')

@section('content')
<div class="app-layout">
    @include("partials.sidebar")

    <main class="main-content" style="background: #0b0a15; padding: 0;">
        <div style="display: flex; height: 100vh;">
            
            <!-- Chat List Sidebar -->
            <div class="chat-sidebar">
                <div style="padding: 2.5rem 2rem 1.5rem;">
                    <h1 style="font-size: 1.75rem; font-weight: 950; color: white; letter-spacing: -1px; margin-bottom: 1.5rem;">Mensagens</h1>
                    <div style="position: relative;">
                        <input type="text" placeholder="Pesquisar conversas..." 
                               style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.05); border-radius: 14px; padding: 0.85rem 1rem 0.85rem 2.75rem; color: white; outline: none; font-size: 14px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" 
                             style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                </div>

                <div style="flex: 1; overflow-y: auto; padding: 0 1rem;">
                    @forelse($chatUsers as $user)
                    <a href="{{ route('chat.show', $user->id) }}" style="display: flex; align-items: center; gap: 12px; padding: 1rem; border-radius: 18px; text-decoration: none; transition: 0.2s; margin-bottom: 4px;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='transparent'">
                        <div style="position: relative;">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.05);">
                            @else
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $user->name }}" style="width: 52px; height: 52px; border-radius: 50%;">
                            @endif
                            <div style="position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background: #22c55e; border: 2px solid #0b0a15; border-radius: 50%;"></div>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <h4 style="font-size: 15px; font-weight: 800; color: white; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->name }}</h4>
                                @php
                                    $unreadCount = \App\Models\Message::where('sender_id', $user->id)
                                        ->where('receiver_id', Auth::id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span style="background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 950; box-shadow: 0 5px 15px rgba(239,68,68,0.3);">
                                        {{ $unreadCount }}
                                    </span>
                                @else
                                    <span style="font-size: 11px; color: var(--text-muted);">{{ $user->receivedMessages()->latest()->first()?->created_at->format('H:i') ?? '' }}</span>
                                @endif
                            </div>
                            <p style="font-size: 13px; color: {{ $unreadCount > 0 ? 'white' : 'var(--text-muted)' }}; font-weight: {{ $unreadCount > 0 ? '700' : '500' }}; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $user->receivedMessages()->latest()->first()?->message ?? 'Clique para abrir a conversa' }}
                            </p>
                        </div>
                    </a>
                    @empty
                    <div style="text-align: center; padding: 4rem 2rem;">
                        <div style="width: 64px; height: 64px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <h3 style="font-size: 16px; font-weight: 800; color: white; margin-bottom: 0.5rem;">Nenhuma conversa</h3>
                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5;">Inicie uma nova conversa encontrando um criador no feed.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Empty State / Welcome -->
            <div class="chat-welcome-state">
                <div style="text-align: center; max-width: 320px;">
                    <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.03); border-radius: 28px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2); margin: 0 auto 2rem;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 900; color: white; margin-bottom: 1rem;">Suas mensagens</h2>
                    <p style="font-size: 15px; color: var(--text-muted); line-height: 1.6;">Envie fotos e mensagens privadas para seus criadores favoritos.</p>
                    <button style="margin-top: 2rem; background: #3390ec; color: white; border: none; padding: 1rem 2rem; border-radius: 16px; font-weight: 800; cursor: pointer; transition: 0.3s; width: 100%; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.2);">
                        Nova Mensagem
                    </button>
                </div>
            </div>

        </div>
    </main>
</div>

<style>
.main-content { margin-left: 280px; }
.chat-sidebar { width: 380px; border-right: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; background: rgba(255,255,255,0.01); }
.chat-welcome-state { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #0b0a15; }

@media (max-width: 991px) {
    .main-content { margin-left: 0 !important; }
    .chat-sidebar { width: 100% !important; border-right: none !important; }
    .chat-welcome-state { display: none !important; }
}
</style>
@endsection
