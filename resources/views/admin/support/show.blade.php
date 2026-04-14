@extends('layouts.admin')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div style="padding: 2.5rem; max-width: 1400px; margin: 0 auto;">
    <div style="margin-bottom: 2.5rem;">
        <a href="{{ route('admin.support.index') }}" style="color: #3390ec; text-decoration: none; font-size: 13px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"/></svg>
            Voltar para Listagem
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2.5rem;">
        <!-- Conversation -->
        <div>
            <header style="margin-bottom: 3rem;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
                    <span class="category-tag {{ Str::slug($ticket->category) }}">{{ $ticket->category }}</span>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 900; color: {{ $ticket->status == 'Aberto' ? '#22c55e' : ($ticket->status == 'Resolvido' ? 'rgba(255,255,255,0.3)' : '#ffd600') }}">
                         <div style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></div>
                         {{ $ticket->status }}
                    </div>
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 950; color: white; letter-spacing: -1.5px; margin: 0;">{{ $ticket->subject }}</h1>
            </header>

            <div style="display: flex; flex-direction: column; gap: 2.5rem; margin-bottom: 4rem;">
                @foreach($ticket->messages->sortBy('created_at') as $message)
                    <div style="display: flex; gap: 1.5rem; {{ $message->user->role == 'admin' ? 'justify-content: flex-end' : '' }}">
                        <div style="max-width: 80%;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; {{ $message->user->role == 'admin' ? 'flex-direction: row-reverse' : '' }}">
                                <span style="font-size: 13px; font-weight: 950; color: white;">{{ $message->user->name }}</span>
                                <span style="font-size: 11px; color: var(--text-muted); font-weight: 700;">{{ $message->created_at->format('d/m, H:i') }}</span>
                            </div>
                            <div style="background: {{ $message->user->role == 'admin' ? 'rgba(51, 144, 236, 0.1)' : 'rgba(255,255,255,0.03)' }}; border: 1.5px solid {{ $message->user->role == 'admin' ? 'rgba(51, 144, 236, 0.2)' : 'rgba(255,255,255,0.06)' }}; padding: 1.5rem; border-radius: 20px;">
                                <p style="color: rgba(255,255,255,0.9); font-size: 14.5px; line-height: 1.7; font-weight: 500; margin: 0; white-space: pre-wrap;">{{ $message->message }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Admin Response Form -->
            <div style="background: rgba(11, 10, 21, 0.4); border: 1.5px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 28px;">
                <form action="{{ route('admin.support.reply', $ticket->id) }}" method="POST">
                    @csrf
                    <textarea name="message" required placeholder="Digite sua resposta oficial aqui..." style="width: 100%; min-height: 180px; background: transparent; border: none; color: white; font-size: 16px; font-weight: 500; outline: none; margin-bottom: 2.5rem; resize: none;"></textarea>
                    
                    <div style="display: flex; gap: 15px; margin-bottom: 2rem; border-top: 1.5px solid rgba(255,255,255,0.03); padding-top: 2rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 11px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Categoria</label>
                            <select name="category" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; color: white; padding: 10px 15px; font-size: 13px; font-weight: 700; cursor: pointer;">
                                <option value="Pagamentos" {{ $ticket->category == 'Pagamentos' ? 'selected' : '' }}>Pagamentos</option>
                                <option value="Técnico" {{ $ticket->category == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="Financeiro" {{ $ticket->category == 'Financeiro' ? 'selected' : '' }}>Financeiro</option>
                                <option value="Moderação" {{ $ticket->category == 'Moderação' ? 'selected' : '' }}>Moderação</option>
                                <option value="Outros" {{ $ticket->category == 'Outros' ? 'selected' : '' }}>Outros</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 11px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Prioridade / Criticidade</label>
                            <select name="priority" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; color: white; padding: 10px 15px; font-size: 13px; font-weight: 700; cursor: pointer;">
                                <option value="baixa" {{ $ticket->priority == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                <option value="normal" {{ $ticket->priority == 'normal' || !$ticket->priority ? 'selected' : '' }}>Normal</option>
                                <option value="alta" {{ $ticket->priority == 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="urgente" {{ $ticket->priority == 'urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-size: 11px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Atribuído Para</label>
                            <select name="assigned_to" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; color: white; padding: 10px 15px; font-size: 13px; font-weight: 700; cursor: pointer;">
                                <option value="">Nenhum Admin</option>
                                @foreach(\App\Models\User::where('role', 'admin')->get() as $admin)
                                <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1.5px solid rgba(255,255,255,0.03); padding-top: 2rem;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="font-size: 11px; font-weight: 900; color: var(--text-muted); text-transform: uppercase;">Alterar Status:</span>
                            <select name="status" style="background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 10px; color: white; padding: 10px 15px; font-size: 13px; font-weight: 800; cursor: pointer;">
                                <option value="Aguardando Resposta" {{ $ticket->status == 'Aguardando Resposta' ? 'selected' : '' }}>Aguardando Resposta</option>
                                <option value="Aberto" {{ $ticket->status == 'Aberto' ? 'selected' : '' }}>Manter Aberto</option>
                                <option value="Resolvido" {{ $ticket->status == 'Resolvido' ? 'selected' : '' }}>Marcar como Resolvido</option>
                            </select>
                        </div>
                        <button type="submit" style="background: #3390ec; color: white; border: none; padding: 14px 40px; border-radius: 16px; font-weight: 950; font-size: 15px; cursor: pointer; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.4); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            Atualizar Chamado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Details -->
        <aside>
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; padding: 2.5rem; position: sticky; top: 120px;">
                <h3 style="font-size: 16px; font-weight: 950; color: white; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1.5px solid rgba(255,255,255,0.03);">Informações do Solicitante</h3>
                
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        @if($ticket->user->avatar)
                            <img src="{{ Storage::url($ticket->user->avatar) }}" style="width: 54px; height: 54px; border-radius: 14px; object-fit: cover;">
                        @else
                            <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $ticket->user->name }}" style="width: 54px; height: 54px; border-radius: 14px;">
                        @endif
                        <div>
                            <h4 style="color: white; font-size: 15px; font-weight: 950; margin: 0 0 2px;">{{ $ticket->user->name }}</h4>
                            <p style="color: var(--text-muted); font-size: 12px; font-weight: 700; margin: 0;">@<span>{{ $ticket->user->username }}</span></p>
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.03); border-radius: 20px; padding: 1.5rem;">
                         <div style="margin-bottom: 1.5rem;">
                             <label style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Data de Abertura</label>
                             <p style="color: white; font-size: 13px; font-weight: 700;">{{ $ticket->created_at->format('d/m/Y \à\s H:i') }}</p>
                         </div>
                         <div>
                             <label style="display: block; font-size: 10px; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Role do Usuário</label>
                             <span style="background: rgba(168, 85, 247, 0.2); color: #a855f7; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 900;">{{ strtoupper($ticket->user->role) }}</span>
                         </div>
                    </div>

                    <a href="{{ route('admin.users.show', $ticket->user->id) }}" style="width: 100%; padding: 1.25rem; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 16px; color: white; text-align: center; text-decoration: none; font-size: 13px; font-weight: 900; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'">Ver Perfil Completo</a>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .category-tag { padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 950; text-transform: none; }
    .category-tag.pagamentos { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .category-tag.tecnico { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .category-tag.financeiro { background: rgba(52, 211, 153, 0.15); color: #34d399; }
    .category-tag.moderacao { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
</style>
@endsection
