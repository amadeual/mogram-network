@extends('layouts.app')

@section('title', 'Minha Carteira - Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content" style="flex: 1; background: #0b0a15; padding: 2.5rem 3rem; overflow-y: auto;">
        
        <header class="studio-header" style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; letter-spacing: -2px;">Minha Carteira v1.2</h1>
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

        <div style="background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%); border-radius: 24px; padding: 1.75rem; margin-bottom: 2.5rem; position: relative; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); width: 340px; max-width: 100%; aspect-ratio: 1.6 / 1; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; border: 1.5px solid rgba(255,255,255,0.1);">
            <!-- Card Chip & Logo -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 40px; height: 30px; background: rgba(255,255,255,0.15); border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);"></div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <svg width="20" height="20" viewBox="0 0 512 512"><rect width="512" height="512" rx="100" fill="white" opacity="0.2"/><path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" /></svg>
                    <span style="font-weight: 950; color: white; font-size: 0.9rem; letter-spacing: -0.5px;">MOGRAM</span>
                </div>
            </div>
            
            <!-- Balance Content -->
            <div>
                <p style="font-size: 11px; font-weight: 850; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.25rem;">Saldo em Conta</p>
                <h2 style="font-size: 2rem; font-weight: 950; color: white; letter-spacing: -1px;">R$ {{ number_format($availableBalance, 2, ',', '.') }}</h2>
            </div>
            
            <!-- Card Footer Action -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.5); letter-spacing: 2px;">**** **** **** {{ Auth::id() }}</p>
            <button onclick="openDepositModal()" style="background: rgba(255,255,255,0.2); border: none; padding: 6px 12px; border-radius: 8px; color: white; font-size: 11px; font-weight: 900; cursor: pointer; transition: 0.3s; backdrop-filter: blur(5px);">
                Depositar
            </button>
        </div>

        <!-- Deposit Modal -->
        <div id="depositModal" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
            <div style="background: #151621; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 32px; width: 100%; max-width: 400px; padding: 2.5rem; position: relative; box-shadow: 0 25px 50px rgba(0,0,0,0.5);">
                <button onclick="closeDepositModal()" style="position: absolute; right: 1.5rem; top: 1.5rem; background: rgba(255,255,255,0.05); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">✕</button>
                
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="width: 60px; height: 60px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 950; color: white; letter-spacing: -1px; margin-bottom: 0.5rem;">Adicionar Saldo</h3>
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 700;">Escolha o valor que deseja depositar via Abacate Pay (Pix ou Cartão).</p>
                </div>

                <form action="{{ route('wallet.deposit') }}" method="POST">
                    @csrf
                    <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 1.25rem; display: flex; align-items: center; margin-bottom: 1rem;">
                        <span style="font-size: 1.5rem; font-weight: 950; color: var(--text-muted); margin-right: 1rem;">R$</span>
                        <input type="number" name="amount" placeholder="Valor (mín. 10)" step="0.01" min="10" required
                               style="background: transparent; border: none; font-size: 1.5rem; font-weight: 950; color: white; outline: none; width: 100%;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <input type="text" id="cpfInput" name="taxId" placeholder="CPF (somente números)" required
                               maxlength="11"
                               oninput="validateCPF(this)"
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 0.75rem 1rem; color: white; outline: none; width: 100%; font-size: 14px;">
                        <span id="cpfError" style="color: #ef4444; font-size: 11px; font-weight: 700; margin-top: 4px; display: none;">CPF Inválido</span>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <input type="text" name="cellphone" placeholder="Celular (ex: 11999999999)" required
                               pattern="[0-9]{10,11}" title="O Celular deve conter o DDD seguido de 8 ou 9 números."
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 0.75rem 1rem; color: white; outline: none; width: 100%; font-size: 14px;">
                    </div>

                    <button type="submit" id="submitDeposit" class="mogram-btn-primary" style="width: 100%; padding: 1.25rem; border-radius: 16px; font-weight: 950; font-size: 16px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        Continuar para Pagamento
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    
                    <p style="text-align: center; font-size: 11px; color: var(--text-muted); margin-top: 1.5rem; font-weight: 700; opacity: 0.7;">
                        Pagamento processado com segurança por Abacate Pay.
                    </p>
                </form>
            </div>
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
            #depositModal { transition: opacity 0.3s ease; }
        </style>

        <h3 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 1.5rem;">Histórico de Gastos</h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($history as $item)
            <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.35rem; display: flex; align-items: center; justify-content: space-between; transition: 0.3s;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: {{ $item['direction'] == 'in' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: {{ $item['direction'] == 'in' ? '#22c55e' : '#ef4444' }};">
                        @if($item['direction'] == 'in')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
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
                    <p style="font-size: 10px; color: #22c55e; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">{{ $item['status'] }}</p>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem; background: rgba(255,255,255,0.01); border-radius: 24px; border: 1px dashed rgba(255,255,255,0.05);">
                <p style="color: var(--text-muted); font-size: 13px;">Você ainda não realizou nenhum desbloqueio de conteúdo.</p>
            </div>
            @endforelse
        </div>

    </main>
</div>
@endsection
