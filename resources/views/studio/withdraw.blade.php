@extends('layouts.app')

@section('title', 'Processo de Saque - Mogram Studio')

@section('content')
<div class="app-layout" style="background: #0b0a15; min-height: 100vh; display: flex;">
    <!-- Sidebar (Same as Studio) -->
    @include("partials.studio-sidebar")

    <main class="main-content studio-main-pad" style="flex: 1; padding: 3rem 6rem; overflow-y: auto;">
        <div style="max-width: 800px; margin: 0 auto;">
            <a href="{{ route('studio.finance') }}" style="color: #3390ec; text-decoration: none; font-size: 13px; font-weight: 800; display: flex; align-items: center; gap: 6px; margin-bottom: 2rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Voltar para Carteira
            </a>

            @if(session('error'))
            <div style="background: rgba(239,68,68,0.1); border: 1.5px solid rgba(239,68,68,0.2); border-radius: 16px; padding: 1rem 1.5rem; color: #ef4444; font-weight: 800; font-size: 14px; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif

            <header class="studio-header" style="margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px; margin-bottom: 0.5rem;">Processo de Saque</h1>
                <p style="color: var(--text-muted); font-size: 15px; font-weight: 600;">Gerencie seus ganhos e transfira com facilidade.</p>
            </header>

            <!-- Premium Wallet Card -->
            <div class="studio-card-pad" style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 32px; padding: 2.5rem; margin-bottom: 3rem; position: relative; box-shadow: 0 30px 60px rgba(18, 97, 209, 0.25);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white;">
            <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 24px; padding: 1.75rem; margin-bottom: 2.5rem; box-shadow: 0 15px 40px rgba(18, 97, 209, 0.2); border: 1.5px solid rgba(255,255,255,0.1); display: flex; flex-direction: column; justify-content: center; min-height: 160px;">
                <p style="font-size: 11px; font-weight: 850; color: white; opacity: 0.8; text-transform: none; letter-spacing: 1px; margin-bottom: 0.75rem;">Saldo Disponível</p>
                <h2 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -1.5px; margin: 0;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
                <div style="display: flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.1); width: fit-content; padding: 6px 14px; border-radius: 100px; margin-top: 1rem;">
                    <div style="width: 6px; height: 6px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 8px #4ade80;"></div>
                    <span style="font-size: 10px; color: white; font-weight: 700;">Atualizado em tempo real</span>
                </div>
            </div>

            <form action="{{ route('studio.withdraw') }}" method="POST">
                @csrf
                <input type="hidden" name="method" id="method_input" value="pix">

                <!-- Withdraw Value -->
                <div style="margin-bottom: 3rem;">
                    <label style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 1.5rem; display: block;">Valor do Saque</label>
                    <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2.5rem; display: flex; align-items: center; margin-bottom: 1rem;">
                        <span style="font-size: 2.5rem; font-weight: 950; color: var(--text-muted); margin-right: 1.5rem;">R$</span>
                        <input type="number" id="withdraw_amount" name="amount" placeholder="0,00" step="0.01" min="50" max="5000" value="{{ old('amount') }}" required
                               style="background: transparent; border: none; font-size: 3.5rem; font-weight: 950; color: white; outline: none; width: 100%;">
                    </div>
                    <p style="font-size: 11px; color: var(--text-muted); font-weight: 600;">O valor permitido é entre R$ 50,00 e R$ 5.000,00.</p>
                </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="button" onclick="setPercent(0.25)" style="flex: 1; padding: 1.25rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; color: white; font-weight: 800; cursor: pointer; transition: 0.3s; font-size: 15px;">25%</button>
                        <button type="button" onclick="setPercent(0.50)" style="flex: 1; padding: 1.25rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; color: white; font-weight: 800; cursor: pointer; transition: 0.3s; font-size: 15px;">50%</button>
                        <button type="button" onclick="setPercent(1.00)" style="flex: 1; padding: 1.25rem; border: 1.5px solid #3390ec; background: rgba(51, 144, 236, 0.1); border-radius: 16px; color: white; font-weight: 800; cursor: pointer; transition: 0.3s; font-size: 15px;">100%</button>
                    </div>

                    <!-- Fee Display -->
                    <div id="summary_section" style="margin-top: 2rem; background: rgba(0,0,0,0.2); border-radius: 20px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Taxa de Saque</span>
                            <span style="color: #ef4444; font-size: 14px; font-weight: 800;">- R$ 5,00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid rgba(255,255,255,0.05);">
                            <span style="color: white; font-size: 15px; font-weight: 850;">Você Receberá</span>
                            <span style="color: #22c55e; font-size: 18px; font-weight: 950;" id="net_amount_display">R$ 0,00</span>
                        </div>
                        <p style="font-size: 10px; color: var(--text-muted); margin-top: 10px; font-weight: 600;">O valor líquido será enviado para sua conta pix cadastrada.</p>
                    </div>
                </div>

                <!-- Payment Method -->
                <div style="margin-bottom: 3rem;">
                    <label style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 1.5rem; display: block;">Método de Pagamento</label>
                    <div class="studio-grid-2" style="display: flex; gap: 1.5rem;">
                        <!-- PIX Card -->
                        <div id="pix_card" onclick="selectMethod('pix')" style="flex: 1; background: rgba(255,255,255,0.03); border: 2px solid #3390ec; border-radius: 24px; padding: 2rem; cursor: pointer; position: relative; transition: 0.3s;">
                             <div style="position: absolute; right: 1.5rem; top: 1.5rem; width: 24px; height: 24px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center;" id="pix_check">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                             </div>
                             <div style="width: 52px; height: 52px; background: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_Pix.png" style="width: 32px; height: 32px; object-fit: contain;">
                             </div>
                             <h4 style="font-size: 18px; font-weight: 950; color: white; margin-bottom: 4px;">PIX</h4>
                             <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Brasil (Até 24hrs)</p>
                        </div>
                        <!-- Redotpay Card -->
                        <div id="redotpay_card" onclick="selectMethod('redotpay')" style="flex: 1; background: rgba(255,255,255,0.03); border: 2px solid transparent; border-radius: 24px; padding: 2rem; cursor: pointer; position: relative; transition: 0.3s;">
                             <div style="position: absolute; right: 1.5rem; top: 1.5rem; width: 24px; height: 24px; background: rgba(255,255,255,0.1); border-radius: 50%;" id="redotpay_check"></div>
                             <div style="width: 52px; height: 52px; background: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2.5"><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                             </div>
                             <h4 style="font-size: 18px; font-weight: 950; color: white; margin-bottom: 4px;">RedotPay</h4>
                             <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Internacional (USD)</p>
                        </div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="studio-grid-2" style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 3rem;">
                    <div>
                        <label style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 1rem; display: block;">Tipo</label>
                        <select style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; color: white; outline: none; width: 100%; cursor: pointer;">
                            <option value="cpf" style="background:#111">CPF</option>
                            <option value="email" style="background:#111">E-mail</option>
                            <option value="phone" style="background:#111">Telefone</option>
                        </select>
                    </div>
                    <div>
                        <label id="account_label" style="font-size: 14px; font-weight: 850; color: white; margin-bottom: 1rem; display: block;">Chave PIX</label>
                        <input type="text" name="account_info" placeholder="000.000.000-00" required
                               style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; color: white; outline: none; width: 100%;">
                    </div>
                </div>

                <div style="background: rgba(51, 144, 236, 0.05); border: 1.5px solid rgba(51, 144, 236, 0.1); border-radius: 24px; padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem; margin-bottom: 3rem;">
                    <div style="width: 48px; height: 48px; background: rgba(51, 144, 236, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <h4 style="font-size: 15px; font-weight: 900; color: white; margin-bottom: 2px;">Tempo de Processamento</h4>
                        <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Geralmente concluído em até 24 horas úteis.</p>
                    </div>
                </div>

                <button type="submit" class="mogram-btn-primary" 
                        style="width: 100%; padding: 1.5rem; border-radius: 24px; font-weight: 950; font-size: 18px; letter-spacing: 0.5px; border: none; cursor: pointer; box-shadow: 0 15px 30px rgba(51, 144, 236, 0.25);">
                    Solicitar Saque
                </button>
            </form>
        </div>
    </main>
</div>

<script>
    const availableBalance = {{ $availableBalance }};
    const amountInput = document.getElementById('withdraw_amount');
    const methodInput = document.getElementById('method_input');
    const netAmountDisplay = document.getElementById('net_amount_display');
    
    function updateNetAmount() {
        const val = parseFloat(amountInput.value) || 0;
        const fee = 5.00;
        const net = Math.max(0, val - fee);
        netAmountDisplay.innerText = net > 0 ? `R$ ${net.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}` : 'R$ 0,00';
    }

    amountInput.addEventListener('input', updateNetAmount);

    function setPercent(p) {
        amountInput.value = (availableBalance * p).toFixed(2);
        updateNetAmount();
    }

    function selectMethod(m) {
        methodInput.value = m;
        const pixCard = document.getElementById('pix_card');
        const redotCard = document.getElementById('redotpay_card');
        const pixCheck = document.getElementById('pix_check');
        const redotCheck = document.getElementById('redotpay_check');
        const accountLabel = document.getElementById('account_label');

        if (m === 'pix') {
            pixCard.style.borderColor = '#3390ec';
            redotCard.style.borderColor = 'transparent';
            pixCheck.style.display = 'flex';
            redotCheck.innerHTML = '';
            accountLabel.innerText = 'Chave PIX';
        } else {
            redotCard.style.borderColor = '#3390ec';
            pixCard.style.borderColor = 'transparent';
            pixCheck.style.display = 'none';
            redotCheck.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>';
            redotCheck.style.display = 'flex';
            redotCheck.style.justifyContent = 'center';
            redotCheck.style.alignItems = 'center';
            redotCheck.style.background = '#3390ec';
            accountLabel.innerText = 'Email RedotPay';
        }
    }

    // Initialize
    updateNetAmount();
</script>
@endsection
