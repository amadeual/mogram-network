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

            <div style="display: block;">
                <!-- Main Content Area -->
                <div>
                    <!-- Filter Tabs -->
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                        <div style="display: flex; background: rgba(11, 10, 21, 0.4); border: 1.5px solid rgba(255,255,255,0.05); padding: 5px; border-radius: 14px; gap: 5px;">
                            <button class="support-tab active">Todos os Tickets</button>
                            <button class="support-tab">Abertos <span class="badge">{{ $tickets->where('status', 'Aberto')->count() }}</span></button>
                        </div>
                        
                        <div style="position: relative; flex: 1; max-width: 400px; margin-left: 1.5rem;">
                            <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.2);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" id="ticketSearchInput" onkeyup="filterTickets()" placeholder="Pesquisar por número do chamado, título, categoria ou status..." style="width: 100%; background: transparent; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 10px 15px 10px 40px; color: white; font-size: 13px; font-weight: 600; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='#3390ec'">
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
                                        <p style="font-size: 11px; color: rgba(255,255,255,0.3); font-weight: 600;">{{ $ticket->lastMessage?->message ? \Illuminate\Support\Str::limit($ticket->lastMessage->message, 40) : 'Sem mensagens' }}</p>
                                    </td>
                                    <td style="padding: 1.5rem;">
                                        <span class="category-tag {{ \Illuminate\Support\Str::slug($ticket->category) }}">{{ $ticket->category }}</span>
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
                    <option value="" disabled selected style="background: #1a1c2e; color: rgba(255,255,255,0.5);">Selecione uma categoria...</option>
                    <option value="Pagamentos" style="background: #1a1c2e; color: white;">Pagamentos</option>
                    <option value="Técnico" style="background: #1a1c2e; color: white;">Técnico</option>
                    <option value="Financeiro" style="background: #1a1c2e; color: white;">Financeiro</option>
                    <option value="Moderação" style="background: #1a1c2e; color: white;">Moderação</option>
                    <option value="Outros" style="background: #1a1c2e; color: white;">Outros</option>
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
    
    // Live Search Filter functionality
    function filterTickets() {
        let input = document.getElementById('ticketSearchInput');
        let filter = input.value.toUpperCase();
        let tableRows = document.querySelectorAll('.ticket-row');
        
        tableRows.forEach(row => {
            let textContent = row.textContent || row.innerText;
            if (textContent.toUpperCase().indexOf(filter) > -1) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>
@endsection
