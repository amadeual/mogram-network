@extends('layouts.app')

@section('title', 'Carteira - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include("partials.studio-sidebar")

    <main class="main-content studio-main-pad" style="flex: 1; background: #0b0a15; padding: 2.5rem 3rem; overflow-y: auto;">
        
        <!-- Overview Section -->
        <div id="overview_section">
            <header class="studio-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px;">Carteira</h1>
            </header>

            <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 24px; padding: 1.75rem; margin-bottom: 2.5rem; position: relative; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); width: 340px; max-width: 100%; aspect-ratio: 1.6 / 1; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; border: 1.5px solid rgba(255,255,255,0.1);">
                <!-- Card Chip & Logo -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="width: 40px; height: 30px; background: rgba(255,255,255,0.15); border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);"></div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <svg width="20" height="20" viewBox="0 0 512 512"><rect width="512" height="512" rx="100" fill="white" opacity="0.2"/><path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" /></svg>
                        <span style="font-weight: 950; color: white; font-size: 0.9rem; letter-spacing: -0.5px;">Mogram</span>
                    </div>
                </div>
                
                <!-- Balance Content -->
                <div>
                    <p style="font-size: 11px; font-weight: 850; color: rgba(255,255,255,0.7); text-transform: none; letter-spacing: 1px; margin-bottom: 0.25rem;">Saldo Disponível</p>
                    <h2 style="font-size: 2rem; font-weight: 950; color: white; letter-spacing: -1px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
                </div>
                
                <!-- Card Footer Action -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.5); letter-spacing: 2px;">**** **** **** {{ Auth::id() }}</p>
                    <button onclick="toggleView('withdraw')" style="background: white; border: none; padding: 6px 12px; border-radius: 8px; color: #1261d1; font-size: 11px; font-weight: 900; cursor: pointer; transition: 0.3s;">
                        Sacar Agora
                    </button>
                </div>

                <!-- Absolute decorative glow -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: white; filter: blur(80px); opacity: 0.15;"></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                <!-- Conteúdo (Real) -->
                <div class="premium-finance-card" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem; transition: all 0.4s; cursor: pointer;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    </div>
                    <p style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; margin-bottom: 4px; letter-spacing: 0.5px;">Conteúdo</p>
                    <h4 style="font-size: 1.4rem; font-weight: 950; color: white;">R$ {{ number_format($postRevenue, 2, ',', '.') }}</h4>
                </div>

                <!-- Lives (Real) -->
                <div class="premium-finance-card" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem; transition: all 0.4s; cursor: pointer;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; background: rgba(236, 72, 153, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ec4899;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
                        </div>
                    </div>
                    <p style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; margin-bottom: 4px; letter-spacing: 0.5px;">Lives</p>
                    <h4 style="font-size: 1.4rem; font-weight: 950; color: white;">R$ {{ number_format($liveRevenue, 2, ',', '.') }}</h4>
                </div>

                <!-- Assinaturas (Future/Placeholder) -->
                <div class="premium-finance-card" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem; transition: all 0.4s; cursor: pointer; opacity: 0.6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; background: rgba(168, 85, 247, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                    </div>
                    <p style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; margin-bottom: 4px; letter-spacing: 0.5px;">Assinaturas</p>
                    <h4 style="font-size: 1.4rem; font-weight: 950; color: white;">R$ 0,00</h4>
                </div>

                <!-- Mimos (Future/Placeholder) -->
                <div class="premium-finance-card" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem; transition: all 0.4s; cursor: pointer; opacity: 0.6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                        </div>
                    </div>
                    <p style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; margin-bottom: 4px; letter-spacing: 0.5px;">Mimos</p>
                    <h4 style="font-size: 1.4rem; font-weight: 950; color: white;">R$ 0,00</h4>
                </div>
            </div>

            <!-- Filter Bar -->
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.25rem 1.75rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('studio.finance') }}" method="GET" style="display: flex; align-items: center; gap: 2rem; flex: 1; flex-wrap: wrap;" id="filterForm">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; letter-spacing: 0.5px;">Período</span>
                        <select name="period" onchange="document.getElementById('filterForm').submit()" 
                                style="background: #151621; border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 8px 36px 8px 15px; color: white; font-size: 13px; font-weight: 700; outline: none; cursor: pointer; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22white%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center; background-size: 14px;">
                            <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Todo o tempo</option>
                            <option value="1" {{ request('period') == '1' ? 'selected' : '' }}>Hoje</option>
                            <option value="7" {{ request('period') == '7' ? 'selected' : '' }}>Últimos 7 dias</option>
                            <option value="30" {{ request('period') == '30' ? 'selected' : '' }}>Últimos 30 dias</option>
                            <option value="90" {{ request('period') == '90' ? 'selected' : '' }}>Últimos 90 dias</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 11px; font-weight: 850; color: var(--text-muted); text-transform: none; letter-spacing: 0.5px;">Tipo</span>
                        <select name="type" onchange="document.getElementById('filterForm').submit()" 
                                style="background: #151621; border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 8px 36px 8px 15px; color: white; font-size: 13px; font-weight: 700; outline: none; cursor: pointer; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22white%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center; background-size: 14px;">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Todas Categorias</option>
                            <option value="content" {{ request('type') == 'content' ? 'selected' : '' }}>Venda de Conteúdo</option>
                            <option value="gifts" {{ request('type') == 'gifts' ? 'selected' : '' }}>Presentes / Gifts</option>
                            <option value="tickets" {{ request('type') == 'tickets' ? 'selected' : '' }}>Live Tickets</option>
                            <option value="withdrawals" {{ request('type') == 'withdrawals' ? 'selected' : '' }}>Saques Realizados</option>
                        </select>
                    </div>
                </form>
                <div style="font-size: 12px; font-weight: 800; color: var(--primary-blue); background: rgba(51,144,236,0.1); padding: 6px 14px; border-radius: 10px;">
                    {{ $history->count() }} Transações
                </div>
            </div>

            <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 1.5rem;">Histórico de Transações</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @forelse($history as $item)
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.35rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: {{ $item['direction'] == 'in' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(255, 255, 255, 0.05)' }}; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: {{ $item['direction'] == 'in' ? '#22c55e' : 'white' }};">
                            @if($item['direction'] == 'in')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                            @endif
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 3px;">{{ $item['type'] }}</h4>
                            <p style="font-size: 11px; color: var(--text-muted); font-weight: 600;">{{ $item['user'] }} • {{ (new \DateTime($item['date']))->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 16px; font-weight: 950; color: {{ $item['direction'] == 'in' ? '#22c55e' : 'white' }};">
                            {{ $item['direction'] == 'in' ? '+' : '-' }} R$ {{ number_format($item['amount'], 2, ',', '.') }}
                        </p>
                        <p style="font-size: 10px; color: var(--text-muted); font-weight: 800; text-transform: none; letter-spacing: 0.5px;">{{ $item['status'] }}</p>
                    </div>
                </div>
                @empty
                <p style="color: var(--text-muted); font-size: 13px;">Nenhuma transação registrada.</p>
                @endforelse
            </div>
        </div>

        <!-- Withdrawal Section -->
        <div id="withdraw_section" style="display:none; max-width: 850px; margin: 0 auto;">
            @if(session('error'))
                <div style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1.25rem; border-radius: 16px; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; font-weight: 700;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <a href="javascript:void(0)" onclick="toggleView('overview')" style="color: #3390ec; text-decoration: none; font-size: 13px; font-weight: 900; display: flex; align-items: center; gap: 8px; margin-bottom: 2.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"/></svg>
                Voltar para Carteira
            </a>

            <header class="studio-header" style="margin-bottom: 3rem;">
                <h1 style="font-size: 2.8rem; font-weight: 950; color: white; letter-spacing: -2px; margin-bottom: 0.5rem;">Processo de Saque</h1>
                <p style="color: var(--text-muted); font-size: 15px; font-weight: 700;">Gerencie seus ganhos e transfira com facilidade.</p>
            </header>

            <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 32px; padding: 2.5rem; margin-bottom: 3rem; box-shadow: 0 30px 60px rgba(18, 97, 209, 0.25);">
                <p style="font-size: 13px; font-weight: 900; color: white; opacity: 0.8; text-transform: none; letter-spacing: 1px; margin-bottom: 2rem;">Saldo Disponível</p>
                <h2 style="font-size: 4rem; font-weight: 950; color: white; letter-spacing: -3px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
                <div style="display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.1); width: fit-content; padding: 8px 16px; border-radius: 100px; margin-top: 1.5rem;">
                    <div style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 10px #4ade80;"></div>
                    <span style="font-size: 12px; color: white; font-weight: 700;">Atualizado em tempo real</span>
                </div>
            </div>

            <form action="{{ route('studio.withdraw') }}" method="POST">
                @csrf
                <input type="hidden" name="method" id="method_input" value="pix">

                <div style="margin-bottom: 3rem;">
                    <label style="font-size: 14px; font-weight: 900; color: white; margin-bottom: 1.5rem; display: block; text-transform: none; letter-spacing: 0.5px;">Valor do saque</label>
                    <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem; display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <span style="font-size: 2.5rem; font-weight: 950; color: var(--text-muted); margin-right: 1.5rem;">R$</span>
                        <input type="number" id="withdraw_amount" name="amount" placeholder="0,00" step="0.01" min="50" value="{{ old('amount') }}" required
                               style="background: transparent; border: none; font-size: 3.5rem; font-weight: 950; color: white; outline: none; width: 100%;">
                    </div>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label style="font-size: 14px; font-weight: 900; color: white; margin-bottom: 1.5rem; display: block; text-transform: none;">Método de Pagamento</label>
                    <div class="studio-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div id="pix_card" onclick="selectMethod('pix')" style="flex: 1; background: #151621; border: 2.5px solid #3390ec; border-radius: 28px; padding: 2.5rem; cursor: pointer; transition: 0.3s; position: relative;">
                             <div style="position: absolute; right: 2rem; top: 2rem; width: 24px; height: 24px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center;" id="pix_check">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                             </div>
                             <h4 style="font-size: 20px; font-weight: 950; color: white; margin-bottom: 6px;">PIX</h4>
                             <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Brasil (Instantâneo)</p>
                        </div>
                        <div id="redotpay_card" onclick="selectMethod('redotpay')" style="flex: 1; background: #151621; border: 2.5px solid transparent; border-radius: 28px; padding: 2.5rem; cursor: pointer; transition: 0.3s; position: relative;">
                             <h4 style="font-size: 20px; font-weight: 950; color: white; margin-bottom: 6px;">RedotPay</h4>
                             <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Internacional (USD)</p>
                        </div>
                    </div>
                </div>

                <div id="pix_details" class="studio-grid-2" style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 3rem;">
                    <div>
                        <label style="font-size: 14px; font-weight: 900; color: white; margin-bottom: 1rem; display: block;">Tipo de Chave</label>
                        <select id="pix_type_select" name="pix_type" onchange="updatePixPlaceholder()" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; color: white; outline: none; width: 100%; cursor: pointer;">
                            <option value="cpf" style="background:#111" {{ old('pix_type') == 'cpf' ? 'selected' : '' }}>CPF</option>
                            <option value="email" style="background:#111" {{ old('pix_type') == 'email' ? 'selected' : '' }}>E-mail</option>
                            <option value="phone" style="background:#111" {{ old('pix_type') == 'phone' ? 'selected' : '' }}>Celular</option>
                            <option value="random" style="background:#111" {{ old('pix_type') == 'random' ? 'selected' : '' }}>Chave Aleatória</option>
                        </select>
                    </div>
                    <div>
                        <label id="account_label" style="font-size: 14px; font-weight: 900; color: white; margin-bottom: 1rem; display: block;">Chave PIX</label>
                        <input type="text" id="pix_info_input" name="account_info" placeholder="000.000.000-00" value="{{ old('account_info') }}" required
                               style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; color: white; outline: none; width: 100%; font-size: 16px; font-weight: 700;">
                    </div>
                </div>

                <button type="submit" class="mogram-btn-primary" style="width: 100%; padding: 1.5rem; border-radius: 24px; font-weight: 950; font-size: 20px; border: none; cursor: pointer; box-shadow: 0 15px 40px rgba(51, 144, 236, 0.4); transition: 0.3s;"
                        onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    Finalizar Solicitação
                </button>
            </form>
        </div>

    </main>
</div>

<script>
    function toggleView(view) {
        const overview = document.getElementById('overview_section');
        const withdraw = document.getElementById('withdraw_section');
        
        if (view === 'withdraw') {
            overview.style.opacity = '0';
            setTimeout(() => {
                overview.style.display = 'none';
                withdraw.style.display = 'block';
                withdraw.style.opacity = '1';
            }, 300);
        } else {
            withdraw.style.opacity = '0';
            setTimeout(() => {
                withdraw.style.display = 'none';
                overview.style.display = 'block';
                overview.style.opacity = '1';
            }, 300);
        }
    }

    function updatePixPlaceholder() {
        const type = document.getElementById('pix_type_select').value;
        const input = document.getElementById('pix_info_input');
        
        if (type === 'cpf') input.placeholder = '000.000.000-00';
        else if (type === 'email') input.placeholder = 'seuemail@exemplo.com';
        else if (type === 'phone') input.placeholder = '(00) 00000-0000';
        else if (type === 'random') input.placeholder = 'Chave aleatória de 32 caracteres';
    }

    function selectMethod(m) {
        document.getElementById('method_input').value = m;
        const pixCard = document.getElementById('pix_card');
        const redotCard = document.getElementById('redotpay_card');
        const pixCheck = document.getElementById('pix_check');
        const accountLabel = document.getElementById('account_label');
        const pixDetails = document.getElementById('pix_details');

        if (m === 'pix') {
            pixCard.style.borderColor = '#3390ec';
            redotCard.style.borderColor = 'transparent';
            if(pixCheck) pixCheck.style.display = 'flex';
            accountLabel.innerText = 'Chave PIX';
            pixDetails.style.display = 'grid';
        } else {
            redotCard.style.borderColor = '#3390ec';
            pixCard.style.borderColor = 'transparent';
            if(pixCheck) pixCheck.style.display = 'none';
            accountLabel.innerText = 'Email RedotPay';
            pixDetails.style.display = 'none';
        }
    }
</script>

<style>
    #overview_section, #withdraw_section {
        transition: opacity 0.3s ease-in-out;
    }
    .premium-finance-card:hover {
        transform: translateY(-8px);
        background: #1a1b2a !important;
        border-color: rgba(255,255,255,0.1) !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }
</style>
@endsection
