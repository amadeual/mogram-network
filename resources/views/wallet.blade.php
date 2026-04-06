@extends('layouts.app')

@section('title', 'Minha Carteira - Mogram')

@section('content')
<div class="app-layout">
    @include("partials.sidebar")

    <main class="main-content" style="flex: 1; background: #0b0a15; padding: 2.5rem 3rem; overflow-y: auto;">
        
        <header class="studio-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px;">Minha Carteira</h1>
        </header>

        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); border: 1.5px solid rgba(34, 197, 94, 0.2); color: #22c55e; padding: 1.25rem; border-radius: 16px; margin-bottom: 2rem; font-weight: 700;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1.25rem; border-radius: 16px; margin-bottom: 2rem; font-weight: 700;">
                @if(session('error'))
                    {{ session('error') }}
                @endif
                @if($errors->any())
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; align-items: stretch; margin-bottom: 3.5rem;">
            <!-- Credit Card Style (Compact & Elegant) -->
            <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 28px; padding: 1.75rem; position: relative; box-shadow: 0 15px 40px rgba(18, 97, 209, 0.3); border: 1.5px solid rgba(255,255,255,0.1); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; height: 210px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="font-size: 28px;">💰</div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="24" height="24" viewBox="0 0 512 512"><rect width="512" height="512" rx="100" fill="white" opacity="0.2"/><path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" /></svg>
                        <span style="font-weight: 950; color: white; font-size: 0.9rem; letter-spacing: -0.5px; opacity: 0.9;">MOGRAM</span>
                    </div>
                </div>

                <div>
                    <p style="font-size: 11px; font-weight: 850; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.25rem;">SALDO ATUAL</p>
                    <h2 style="font-size: 2.1rem; font-weight: 950; color: white; letter-spacing: -1.5px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                     <p style="font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.5); letter-spacing: 3px; font-family: monospace;">**** {{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</p>
                     <div style="font-size: 22px; opacity: 0.8;">💳</div>
                </div>

                <!-- Decorative glow -->
                <div style="position: absolute; top: -10%; right: -10%; width: 50%; height: 50%; background: white; filter: blur(70px); opacity: 0.12;"></div>
            </div>

            <!-- Quick Add Saldo (Optimized Size) -->
            <div class="premium-finance-card" onclick="openDepositModal()" style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; padding: 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; height: 210px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden;">
                <div style="width: 60px; height: 60px; background: rgba(34, 197, 94, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 1rem; box-shadow: 0 10px 25px rgba(34, 197, 94, 0.1);">
                    💸
                </div>
                <h3 style="font-size: 20px; font-weight: 950; color: white; margin-bottom: 0.25rem; letter-spacing: -0.5px;">Recarga Rápida</h3>
                <p style="color: var(--text-muted); font-size: 14px; font-weight: 700; opacity: 0.8;">Adicionar saldo via PIX / Cartão</p>
                
                <!-- Small action indicator -->
                <div style="background: #22c55e; color: white; font-size: 10px; font-weight: 950; padding: 4px 10px; border-radius: 6px; margin-top: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    AGORA
                </div>
            </div>
        </div>

        <h3 style="font-size: 1.4rem; font-weight: 950; color: white; margin-bottom: 1.5rem; letter-spacing: -0.5px;">Histórico de Transações</h3>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($history as $item)
            <div class="transaction-item" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.35rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s; cursor: default;">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="width: 52px; height: 52px; background: {{ $item['direction'] == 'in' ? 'linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.05) 100%)' : 'rgba(255, 255, 255, 0.05)' }}; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: {{ $item['direction'] == 'in' ? '#22c55e' : 'white' }};">
                        @if($item['direction'] == 'in')
                            <span style="font-size: 20px;">💵</span>
                        @else
                            <span style="font-size: 20px;">🛍️</span>
                        @endif
                    </div>
                    <div>
                        <h4 style="font-size: 15px; font-weight: 900; color: white; margin-bottom: 4px; letter-spacing: -0.3px;">{{ $item['type'] }}</h4>
                        <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">{{ $item['description'] }} • {{ (new \DateTime($item['date']))->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 17px; font-weight: 950; color: {{ $item['direction'] == 'in' ? '#22c55e' : 'white' }}; letter-spacing: -0.5px;">
                        {{ $item['direction'] == 'in' ? '+' : '-' }} R$ {{ number_format($item['amount'], 2, ',', '.') }}
                    </p>
                    <div style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: {{ $item['direction'] == 'in' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(255, 255, 255, 0.05)' }}; border-radius: 6px; margin-top: 6px;">
                        <span style="font-size: 9px; color: {{ $item['direction'] == 'in' ? '#22c55e' : 'var(--text-muted)' }}; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">{{ $item['status'] }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.01); border-radius: 32px; border: 2px dashed rgba(255,255,255,0.05); display: flex; flex-direction: column; align-items: center; gap: 1.25rem;">
                <div style="font-size: 48px; opacity: 0.2;">📭</div>
                <p style="color: var(--text-muted); font-size: 14px; font-weight: 700;">Você ainda não possui transações registradas.</p>
            </div>
            @endforelse
        </div>

        <!-- Deposit Modal -->
        <div id="depositModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(15px); z-index: 9999; align-items: center; justify-content: center; padding: 1.5rem; transition: 0.3s; opacity: 0;">
            <div style="background: #0b0a15; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; width: 100%; max-width: 480px; padding: 2.5rem; position: relative; box-shadow: 0 30px 100px rgba(0,0,0,0.5);">
                <button onclick="closeDepositModal()" style="position: absolute; right: 1.5rem; top: 1.5rem; background: rgba(255,255,255,0.05); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>

                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="width: 72px; height: 72px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 1.5rem;">
                        🪙
                    </div>
                    <h2 style="font-size: 24px; font-weight: 950; color: white; letter-spacing: -0.5px; margin-bottom: 0.5rem;">Adicionar Saldo</h2>
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 700;">Recarga via PIX e Cartão</p>
                </div>

                <form action="{{ route('wallet.deposit') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 18px; padding: 0.25rem 1.25rem;">
                            <span style="font-size: 20px; font-weight: 950; color: var(--text-muted); margin-right: 0.75rem;">R$</span>
                            <input type="number" name="amount" placeholder="0,00" step="0.01" min="10" required
                                   style="background: transparent; border: none; padding: 1.25rem 0; color: white; outline: none; width: 100%; font-size: 22px; font-weight: 950;">
                        </div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px; font-weight: 700; margin-left: 0.5rem;">Valor mínimo: R$ 10,00</p>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <input type="text" id="cpfInput" name="taxId" placeholder="CPF (somente números)" required
                               maxlength="11"
                               oninput="validateCPF(this)"
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 14px; padding: 0.9rem 1.25rem; color: white; outline: none; width: 100%; font-size: 14px; font-weight: 700;">
                        <span id="cpfError" style="color: #ef4444; font-size: 11px; font-weight: 700; margin-top: 5px; display: none; margin-left: 0.5rem;">CPF Inválido</span>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <input type="text" name="cellphone" placeholder="Celular (ex: 11999999999)" required
                               pattern="[0-9]{10,11}" title="O Celular deve conter o DDD seguido de 8 ou 9 números."
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 14px; padding: 0.9rem 1.25rem; color: white; outline: none; width: 100%; font-size: 14px; font-weight: 700;">
                    </div>

                    <button type="submit" id="submitDeposit" class="mogram-btn-primary" style="width: 100%; padding: 1.5rem; border-radius: 20px; font-weight: 950; font-size: 18px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3);">
                        Gerar Pagamento
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    
                    <p style="text-align: center; font-size: 11px; color: var(--text-muted); margin-top: 1.5rem; font-weight: 850; opacity: 0.7;">
                        Pagamento processado com segurança por <span style="color: #22c55e;">Abacate Pay</span>.
                    </p>
                </form>
            </div>
        </div>

    </main>
</div>

<script>
    function validateCPF(input) {
        const cpf = input.value.replace(/\D/g, '');
        const errorSpan = document.getElementById('cpfError');
        const submitBtn = document.getElementById('submitDeposit');

        if (cpf.length === 11) {
            if (isValidCPF(cpf)) {
                errorSpan.style.display = 'none';
                input.style.borderColor = 'rgba(255,255,255,0.05)';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            } else {
                errorSpan.style.display = 'block';
                input.style.borderColor = '#ef4444';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            }
        } else {
            errorSpan.style.display = 'none';
            submitBtn.disabled = false;
        }
    }

    function isValidCPF(cpf) {
        if (cpf.length !== 11 || !!cpf.match(/(\d)\1{10}/)) return false;
        const cpfs = cpf.split('').map(el => +el);
        const rest = (count) => (cpfs.slice(0, count-12).reduce((soma, el, index) => (soma + el * (count - index)), 0) * 10) % 11 % 10;
        return rest(10) === cpfs[9] && rest(11) === cpfs[10];
    }

    function openDepositModal() {
        const modal = document.getElementById('depositModal');
        modal.style.display = 'flex';
        modal.style.opacity = '0';
        setTimeout(() => modal.style.opacity = '1', 10);
    }
    function closeDepositModal() {
        const modal = document.getElementById('depositModal');
        modal.style.opacity = '0';
        setTimeout(() => modal.style.display = 'none', 300);
    }
</script>

<style>
    .premium-finance-card:hover {
        transform: translateY(-8px);
        background: #1a1b2a !important;
        border-color: rgba(255,255,255,0.1) !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }
    #depositModal {
        transition: opacity 0.3s ease-in-out;
    }
    .transaction-item:hover {
        background: rgba(255,255,255,0.04) !important;
        border-color: rgba(255,255,255,0.1) !important;
        transform: translateY(-3px);
    }
</style>
@endsection
