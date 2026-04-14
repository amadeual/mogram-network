@extends('layouts.app')

@section('title', 'Suporte e Tickets | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div style="padding: 2.5rem 2rem;">
            <!-- Breadcrumbs -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2.5rem; color: var(--text-muted); font-size: 13px; font-weight: 700;">
                <a href="{{ route('dashboard') }}" style="color: #3390ec; text-decoration: none;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </a>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Central de Ajuda</span>
            </div>

            <header style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3rem;">
                <div>
                    <h1 style="font-size: 2.75rem; font-weight: 950; color: white; margin-bottom: 0.75rem; letter-spacing: -1.5px;">Suporte e Tickets</h1>
                    <p style="color: var(--text-muted); font-size: 15px; font-weight: 600; max-width: 600px; line-height: 1.6;">
                        Gerencie seus chamados, acompanhe o status das solicitações e encontre ajuda rápida da nossa equipe especializada.
                    </p>
                </div>
                <button onclick="openNewTicketModal()" style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.06); padding: 12px 24px; border-radius: 12px; color: white; font-weight: 800; font-size: 14px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(51,144,236,0.1)'; this.style.borderColor='rgba(51,144,236,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.06)'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Criar Novo Ticket
                </button>
            </header>

            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem;">
                <!-- Main Content Area -->
                <div>
                    <!-- Filter Tabs -->
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                        <div style="display: flex; background: rgba(11, 10, 21, 0.4); border: 1.5px solid rgba(255,255,255,0.05); padding: 5px; border-radius: 14px; gap: 5px;">
                            <button class="support-tab active">Todos os Tickets</button>
                            <button class="support-tab">Abertos <span class="badge">{{ $tickets->where('status', 'Aberto')->count() }}</span></button>
                        </div>
                        
                        <div style="position: relative; flex: 1; max-width: 300px; margin-left: 1.5rem;">
                            <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.2);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" placeholder="Buscar por ID ou assunto..." style="width: 100%; background: transparent; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 10px 15px 10px 40px; color: white; font-size: 13px; font-weight: 600; outline: none;">
                        </div>
                    </div>

                    <!-- Tickets Table -->
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1.5px solid rgba(255,255,255,0.03);">
                                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">ID</th>
                                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Assunto</th>
                                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Categoria</th>
                                    <th style="padding: 1.5rem; color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                <tr class="ticket-row" onclick="window.location.href='{{ route('support.show', $ticket->id) }}'" style="cursor: pointer; border-bottom: 1px solid rgba(255,255,255,0.02); transition: 0.2s;">
                                    <td style="padding: 1.5rem; color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;">#{{ $ticket->id }}</td>
                                    <td style="padding: 1.5rem;">
                                        <h4 style="color: white; font-size: 14px; font-weight: 800; margin-bottom: 2px;">{{ $ticket->subject }}</h4>
                                        <p style="font-size: 11px; color: rgba(255,255,255,0.3); font-weight: 600;">{{ $ticket->lastMessage?->message ? Str::limit($ticket->lastMessage->message, 40) : 'Sem mensagens' }}</p>
                                    </td>
                                    <td style="padding: 1.5rem;">
                                        <span class="category-tag {{ Str::slug($ticket->category) }}">{{ $ticket->category }}</span>
                                    </td>
                                    <td style="padding: 1.5rem;">
                                        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: {{ $ticket->status == 'Aberto' ? '#22c55e' : ($ticket->status == 'Resolvido' ? 'rgba(255,255,255,0.4)' : '#ffd600') }}">
                                            <div style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></div>
                                            {{ $ticket->status }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="padding: 5rem; text-align: center;">
                                        <p style="color: rgba(255,255,255,0.2); font-weight: 800; font-size: 14px;">Nenhum ticket encontrado.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        @if($tickets->count() > 0)
                        <div style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-top: 1.5px solid rgba(255,255,255,0.03);">
                             <p style="font-size: 12px; color: rgba(255,255,255,0.3); font-weight: 700;">Mostrando 1-{{ $tickets->count() }} de {{ $tickets->count() }} tickets</p>
                             <div style="display: flex; gap: 8px;">
                                 <button class="page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"/></svg></button>
                                 <button class="page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg></button>
                             </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Info Area -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Real-time Help Card -->
                    <div style="background: rgba(51, 144, 236, 0.05); border: 1.5px solid rgba(51, 144, 236, 0.1); border-radius: 32px; padding: 2.5rem; position: relative; overflow: hidden;">
                        <div style="width: 44px; height: 44px; background: rgba(51, 144, 236, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #3390ec; margin-bottom: 2rem;">
                             <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <div style="position: absolute; top: 2.5rem; right: 2.5rem; display: flex; align-items: center; gap: 6px; background: rgba(34, 197, 94, 0.1); padding: 4px 10px; border-radius: 20px; color: #22c55e; font-size: 10px; font-weight: 900;">
                            <div style="width: 5px; height: 5px; background: #22c55e; border-radius: 50%;"></div>
                            ONLINE AGORA
                        </div>
                        <h3 style="font-size: 20px; font-weight: 950; color: white; margin-bottom: 0.75rem;">Chat em Tempo Real</h3>
                        <p style="color: var(--text-muted); font-size: 13px; line-height: 1.6; margin-bottom: 2rem; font-weight: 600;">Precisa de ajuda urgente? Nossa equipe de suporte está disponível para resolver seu problema agora.</p>
                        
                        <div style="display: flex; align-items: center; margin-bottom: 2.5rem;">
                            <div style="display: flex; -webkit-mask: linear-gradient(to right, black 80%, transparent 100%);">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" style="width: 38px; height: 38px; border-radius: 50%; border: 3px solid #0b0a15;">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aneka" style="width: 38px; height: 38px; border-radius: 50%; border: 3px solid #0b0a15; margin-left: -12px;">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Casper" style="width: 38px; height: 38px; border-radius: 50%; border: 3px solid #0b0a15; margin-left: -12px;">
                            </div>
                            <span style="font-size: 12px; font-weight: 800; color: var(--text-muted); margin-left: 10px;">+5 atendentes</span>
                        </div>

                        <button onclick="openNewTicketModal()" style="width: 100%; padding: 1.25rem; border-radius: 18px; border: none; background: #3390ec; color: white; font-weight: 900; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.4); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            Iniciar Conversa <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                        </button>
                    </div>

                    <!-- Knowledge Base -->
                    <div style="background: rgba(255, 255, 255, 0.02); border: 1.5px solid rgba(255, 255, 255, 0.05); border-radius: 32px; padding: 2.5rem;">
                         <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 2.5rem;">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #3390ec;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                             <h3 style="font-size: 18px; font-weight: 950; color: white;">Base de Conhecimento</h3>
                         </div>

                         <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                             <a href="#" class="kb-article">
                                 <div>
                                     <h4>Como verificar minha conta?</h4>
                                     <p>Guia passo a passo • 3 min</p>
                                 </div>
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                             </a>
                             <a href="#" class="kb-article">
                                 <div>
                                     <h4>Entendendo as taxas</h4>
                                     <p>Financeiro • 5 min</p>
                                 </div>
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                             </a>
                             <a href="#" class="kb-article">
                                 <div>
                                     <h4>Conteúdo Exclusivo</h4>
                                     <p>Dicas de Creator • 4 min</p>
                                 </div>
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                             </a>
                         </div>

                         <button style="width: 100%; margin-top: 3rem; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); padding: 1rem; border-radius: 14px; color: white; font-weight: 800; font-size: 13px; cursor: pointer;">Ver todos os artigos</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- New Ticket Modal -->
<div id="newTicketModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); z-index: 10002; align-items: center; justify-content: center; padding: 2rem;">
    <div style="background: #1a1c2e; width: 100%; max-width: 500px; border-radius: 32px; border: 1.5px solid rgba(255,255,255,0.05); padding: 3rem; box-shadow: 0 40px 100px rgba(0,0,0,0.8);">
        <h2 style="font-size: 24px; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1px;">Abrir Novo Chamado</h2>
        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; margin-bottom: 2.5rem;">Descreva seu problema ou dúvida em detalhes para que possamos ajudar.</p>
        
        <form action="{{ route('support.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Assunto do Chamado</label>
                <input type="text" name="subject" required placeholder="Ex: Problema com saque via PIX" style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 15px; color: white; font-size: 14px; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='#3390ec'; this.style.background='rgba(51,144,236,0.05)'">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Categoria</label>
                <select name="category" required style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 15px; color: white; font-size: 14px; outline: none; cursor: pointer; appearance: none;">
                    <option value="Pagamentos">Pagamentos</option>
                    <option value="Técnico">Técnico</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Moderação">Moderação</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>

            <div style="margin-bottom: 3rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Sua Mensagem</label>
                <textarea name="message" required placeholder="Como podemos te ajudar hoje?" style="width: 100%; min-height: 120px; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 15px; color: white; font-size: 14px; outline: none; transition: 0.3s; resize: none;" onfocus="this.style.borderColor='#3390ec'; this.style.background='rgba(51,144,236,0.05)'"></textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="button" onclick="closeNewTicketModal()" style="flex: 1; padding: 1.25rem; border: none; background: rgba(255,255,255,0.03); color: white; font-weight: 800; border-radius: 16px; cursor: pointer; transition: 0.2s;">Cancelar</button>
                <button type="submit" style="flex: 1.5; padding: 1.25rem; border: none; background: #3390ec; color: white; font-weight: 900; border-radius: 16px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3);">Enviar Chamado</button>
            </div>
        </form>
    </div>
</div>

<style>
    .support-tab {
        background: transparent;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: rgba(255,255,255,0.4);
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .support-tab.active { background: #3390ec; color: white; }
    .support-tab .badge { background: rgba(255,255,255,0.15); padding: 1px 6px; border-radius: 6px; font-size: 10px; }
    
    .ticket-row:hover { background: rgba(255,255,255,0.04) !important; }
    
    .category-tag { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: none; }
    .category-tag.pagamentos { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
    .category-tag.tecnico { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .category-tag.financeiro { background: rgba(52, 211, 153, 0.1); color: #34d399; }
    .category-tag.moderacao { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    
    .page-btn { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; }
    .page-btn:hover { background: rgba(255,255,255,0.08); color: white; }

    .kb-article { display: flex; justify-content: space-between; align-items: center; text-decoration: none; padding: 0.5rem 0; border-bottom: 1.5px solid rgba(255,255,255,0.02); transition: 0.2s; }
    .kb-article:hover { transform: translateX(5px); }
    .kb-article h4 { color: white; font-size: 14px; font-weight: 700; margin: 0 0 4px; }
    .kb-article p { font-size: 11px; color: var(--text-muted); margin: 0; font-weight: 600; }
    .kb-article svg { color: rgba(255,255,255,0.1); }
</style>

<script>
    function openNewTicketModal() {
        document.getElementById('newTicketModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeNewTicketModal() {
        document.getElementById('newTicketModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    // Close on overlay click
    window.onclick = function(e) {
        const modal = document.getElementById('newTicketModal');
        if (e.target == modal) closeNewTicketModal();
    }
</script>
@endsection
