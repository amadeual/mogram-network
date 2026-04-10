@extends('layouts.admin')

@section('title', 'Configurações do Sistema')

@section('admin_content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
        <div>
            <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Configurações</p>
            <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Configurações do Sistema</h1>
            <p style="color: var(--text-muted); font-weight: 600;">Gerencie taxas, métodos de pagamento, e-mail e parâmetros globais da plataforma Mogram.</p>
        </div>
        <button type="submit" class="btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Salvar Alterações
        </button>
    </div>

    @if(session('success'))
        <div style="background: rgba(34,197,94,0.1); border: 1.5px solid rgba(34,197,94,0.2); border-radius: 12px; padding: 1rem; color: #22c55e; font-weight: 700; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 2.5rem;">
        
        <!-- Basic Information -->
        <div class="admin-card">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
                <div style="width: 42px; height: 42px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 850;">Informações Básicas</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Nome da Aplicação</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                        <svg style="color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Mogram' }}" style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 600;">
                    </div>
                </div>
                <div>
                    <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">E-mail de Suporte</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                        <svg style="color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="text" name="support_email" value="{{ $settings['support_email'] ?? 'suporte@mogram.com' }}" style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 600;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Taxes & Commissions -->
        <div class="admin-card">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
                <div style="width: 42px; height: 42px; background: rgba(34, 197, 94, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--success);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 850; margin-bottom: 4px;">Taxas e Comissões</h3>
                    <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600;">Defina a repartição de receita entre plataforma e criadores.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem;">
                <div>
                    <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Comissão da Plataforma (%)</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                        <input type="number" name="commission_percentage" value="{{ $settings['commission_percentage'] ?? '15' }}" style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 700;">
                        <span style="color: var(--text-muted); font-weight: 800;">%</span>
                    </div>
                </div>
                <div>
                    <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Taxa de Saque Fixa</label>
                    <div style="display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                        <span style="color: var(--text-muted); font-weight: 800;">{{ $settings['currency'] ?? 'R$' }}</span>
                        <input type="number" step="0.01" name="withdrawal_fee" value="{{ $settings['withdrawal_fee'] ?? '5.00' }}" style="width: 100%; border: none; background: transparent; padding: 15px; color: #22c55e; outline: none; font-weight: 900;">
                    </div>
                </div>
                <div>
                    <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Moeda Padrão</label>
                    <select name="currency" style="width: 100%; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
                        <option value="R$" {{ ($settings['currency'] ?? 'R$') == 'R$' ? 'selected' : '' }}>BRL - Real Brasileiro (R$)</option>
                        <option value="$" {{ ($settings['currency'] ?? '') == '$' ? 'selected' : '' }}>USD - Dollar ($)</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(51, 144, 236, 0.05); border-radius: 14px; border: 1px solid rgba(51, 144, 236, 0.1);">
                <p style="font-size: 0.8rem; color: var(--primary-blue); font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Nota sobre a repartição
                </p>
                <p style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; line-height: 1.5;">
                    Ao definir a comissão em <b><span id="comm_val">{{ $settings['commission_percentage'] ?? '15' }}</span>%</b>, os criadores receberão automaticamente <b><span id="creat_val">{{ 100 - ($settings['commission_percentage'] ?? 15) }}</span>%</b> do valor líquido. A taxa de saque é descontada do saldo do criador no momento da solicitação.
                </p>
            </div>
        </div>

        <!-- Gateways -->
        <div class="admin-card">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
                <div style="width: 42px; height: 42px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 850; margin-bottom: 4px;">Gateways de Pagamento</h3>
                    <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600;">Provedores ativos para processamento de depósitos.</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div style="display: flex; flex-direction: column; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 20px; padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 48px; height: 48px; background: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.5rem;">A</div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 850;">AbacatePay</h4>
                                <p style="font-size: 0.75rem; color: var(--success); font-weight: 800;">ATIVADO (PIX / CARTÃO)</p>
                            </div>
                        </div>
                        <div style="background: rgba(34, 197, 94, 0.1); color: var(--success); padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 840;">
                            SINCROZINADO COM .ENV
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <div>
                            <label style="display: block; color: var(--text-muted); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">Abacate Pay API Key</label>
                            <div style="display: flex; align-items: center; background: rgba(0,0,0,0.3); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                                <svg style="color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3L15.5 7.5z"/></svg>
                                <input type="password" name="ABACATE_PAY_KEY" value="{{ env('ABACATE_PAY_KEY') }}" placeholder="abc_..." style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 600; font-family: monospace;">
                            </div>
                            <p style="margin-top: 8px; font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Esta chave será salva tanto no banco quanto no seu arquivo .env automaticamente.</p>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02); border: 1.5px solid var(--border-gray); border-radius: 20px; padding: 1.5rem; opacity: 0.4; filter: grayscale(1);">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: #635bff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.5rem;">S</div>
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 850;">Stripe</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">INDISPONÍVEL</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.querySelector('input[name="commission_percentage"]').addEventListener('input', function(e) {
        const val = e.target.value;
        document.getElementById('comm_val').innerText = val;
        document.getElementById('creat_val').innerText = 100 - val;
    });
</script>
@endsection
