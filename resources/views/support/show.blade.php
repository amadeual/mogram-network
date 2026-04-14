@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id . ' | Mogram Support')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div style="padding: 2.5rem 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Breadcrumbs -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2.5rem; color: var(--text-muted); font-size: 13px; font-weight: 700;">
                <a href="{{ route('dashboard') }}" style="color: #3390ec; text-decoration: none;">Feed</a>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('support.index') }}" style="color: #3390ec; text-decoration: none;">Suporte</a>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                <span style="color: white;">Ticket #{{ $ticket->id }}</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 320px; gap: 2.5rem; align-items: start;">
                <!-- Conversation Area -->
                <div>
                    <header style="margin-bottom: 3rem;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                            <span class="category-tag {{ Str::slug($ticket->category) }}">{{ $ticket->category }}</span>
                            <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; color: {{ $ticket->status == 'Aberto' ? '#22c55e' : ($ticket->status == 'Resolvido' ? 'rgba(255,255,255,0.4)' : '#ffd600') }}">
                                <div style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></div>
                                {{ $ticket->status }}
                            </div>
                        </div>
                        <h1 style="font-size: 2.25rem; font-weight: 950; color: white; letter-spacing: -1.5px; margin: 0;">{{ $ticket->subject }}</h1>
                    </header>

                    <!-- Message History -->
                    <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 4rem;">
                        @foreach($ticket->messages->sortBy('created_at') as $message)
                            <div style="display: flex; gap: 1.5rem; {{ $message->user_id == Auth::id() ? '' : 'flex-direction: row-reverse;' }}">
                                <div style="flex-shrink: 0;">
                                    @if($message->user->avatar)
                                        <img src="{{ Storage::url($message->user->avatar) }}" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover;">
                                    @else
                                        <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $message->user->name }}" style="width: 44px; height: 44px; border-radius: 12px;">
                                    @endif
                                </div>
                                <div style="flex: 1; max-width: 80%;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; {{ $message->user_id == Auth::id() ? '' : 'justify-content: flex-end;' }}">
                                        <span style="font-size: 13px; font-weight: 800; color: white;">{{ $message->user->name }}</span>
                                        <span style="font-size: 11px; color: var(--text-muted); font-weight: 600;">{{ $message->created_at->format('d M, H:i') }}</span>
                                        @if($message->user->role == 'admin')
                                            <span style="background: rgba(51, 144, 236, 0.2); color: #3390ec; font-size: 9px; font-weight: 900; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Suporte</span>
                                        @endif
                                    </div>
                                    <div style="background: {{ $message->user_id == Auth::id() ? 'rgba(255,255,255,0.03)' : 'rgba(51, 144, 236, 0.1)' }}; border: 1.5px solid {{ $message->user_id == Auth::id() ? 'rgba(255,255,255,0.06)' : 'rgba(51, 144, 236, 0.2)' }}; padding: 1.5rem; border-radius: 20px; border-top-{{ $message->user_id == Auth::id() ? 'left' : 'right' }}-radius: 2px;">
                                        <p style="color: rgba(255,255,255,0.9); font-size: 14px; line-height: 1.7; font-weight: 500; white-space: pre-wrap; margin: 0;">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($ticket->status != 'Resolvido')
                    <!-- Reply Form -->
                    <div style="background: rgba(11, 10, 21, 0.4); border: 1.5px solid rgba(255,255,255,0.05); padding: 2rem; border-radius: 28px;">
                        <form action="{{ route('support.reply', $ticket->id) }}" method="POST">
                            @csrf
                            <textarea name="message" required placeholder="Digite sua resposta aqui..." style="width: 100%; min-height: 150px; background: transparent; border: none; color: white; font-size: 15px; font-weight: 500; outline: none; margin-bottom: 2rem; resize: none;"></textarea>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1.5px solid rgba(255,255,255,0.03); padding-top: 1.5rem;">
                                <div style="display: flex; gap: 10px;">
                                    <button type="button" class="action-icon-btn">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    </button>
                                </div>
                                <button type="submit" style="background: #3390ec; color: white; border: none; padding: 12px 32px; border-radius: 14px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 10px 25px rgba(51, 144, 236, 0.3); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    Enviar Resposta
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 28px; text-align: center;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" style="margin-bottom: 1.5rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <h3 style="color: white; font-size: 18px; font-weight: 950; margin-bottom: 0.5rem;">Este ticket foi resolvido</h3>
                        <p style="color: var(--text-muted); font-size: 13px; font-weight: 600; margin-bottom: 2rem;">Se você ainda possui dúvidas, envie uma nova mensagem abaixo para reabrir o chamado.</p>
                        
                        <form action="{{ route('support.reply', $ticket->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="message" value="Reabrindo ticket para mais informações.">
                            <button type="submit" style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.06); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 13px; cursor: pointer;">Reabrir Chamado</button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Info -->
                <aside>
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; padding: 2rem; position: sticky; top: 100px;">
                        <h3 style="font-size: 16px; font-weight: 950; color: white; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1.5px solid rgba(255,255,255,0.03);">Detalhes do Ticket</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <div>
                                <label style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Criado em</label>
                                <p style="color: white; font-size: 13px; font-weight: 700;">{{ $ticket->created_at->format('d/m/Y \à\s H:i') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Última atualização</label>
                                <p style="color: white; font-size: 13px; font-weight: 700;">{{ $ticket->updated_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Prioridade</label>
                                <span style="background: rgba(255, 214, 0, 0.1); color: #ffd600; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 900; display: inline-block;">Normal</span>
                            </div>
                        </div>

                        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1.5px solid rgba(255,255,255,0.03);">
                             <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem;">
                                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3390ec" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                 <p style="color: white; font-size: 13px; font-weight: 800;">Precisa de mais?</p>
                             </div>
                             <p style="font-size: 12px; color: var(--text-muted); line-height: 1.6; font-weight: 600;">Nosso tempo médio de resposta para esta categoria é de <strong>2 horas</strong>.</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</div>

<style>
    .category-tag { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: none; }
    .category-tag.pagamentos { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
    .category-tag.tecnico { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .category-tag.financeiro { background: rgba(52, 211, 153, 0.1); color: #34d399; }
    .category-tag.moderacao { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .action-icon-btn { background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.06); width: 44px; height: 44px; border-radius: 12px; color: rgba(255,255,255,0.4); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
    .action-icon-btn:hover { background: rgba(255,255,255,0.08); color: white; }
</style>
@endsection
