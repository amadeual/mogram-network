@extends('layouts.admin')

@section('title', 'Configurações do Sistema')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Configurações</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Configurações do Sistema</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Gerencie taxas, métodos de pagamento, e-mail e parâmetros globais da plataforma Mogram.</p>
    </div>
    <button class="btn-primary" onclick="alert('Salvo com sucesso!')">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Salvar Alterações
    </button>
</div>

<!-- Tabs Navigation -->
<div style="display: flex; gap: 2rem; border-bottom: 1.5px solid var(--border-gray); margin-bottom: 3rem; padding-bottom: 1rem;">
    <a href="#" style="color: var(--primary-blue); text-decoration: none; font-weight: 800; font-size: 0.9rem; position: relative;">
        Geral
        <div style="position: absolute; bottom: -18px; left: 0; right: 0; height: 3px; background: var(--primary-blue); border-radius: 10px;"></div>
    </a>
    <a href="#" style="color: var(--text-muted); text-decoration: none; font-weight: 800; font-size: 0.9rem;">Financeiro</a>
    <a href="#" style="color: var(--text-muted); text-decoration: none; font-weight: 800; font-size: 0.9rem;">Integrações</a>
    <a href="#" style="color: var(--text-muted); text-decoration: none; font-weight: 800; font-size: 0.9rem;">Segurança</a>
</div>

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
                    <input type="text" value="Mogram Content" style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 600;">
                </div>
            </div>
            <div>
                <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">E-mail de Suporte</label>
                <div style="display: flex; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 0 15px;">
                    <svg style="color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="text" value="suporte@mogram.com" style="width: 100%; border: none; background: transparent; padding: 15px; color: white; outline: none; font-weight: 600;">
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

        <!-- Split Slider (Simplified Visual) -->
        <div style="background: rgba(0,0,0,0.2); border: 1.5px dashed var(--border-gray); border-radius: 20px; padding: 2.5rem; margin-bottom: 2.5rem; position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div style="text-align: left;">
                    <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Criadores</span>
                    <h2 style="font-size: 2rem; font-weight: 950; color: white;">85%</h2>
                </div>
                <div style="text-align: right;">
                    <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Plataforma</span>
                    <h2 style="font-size: 2rem; font-weight: 950; color: var(--primary-blue);">15%</h2>
                </div>
            </div>
            
            <div style="height: 12px; background: rgba(255,255,255,0.05); border-radius: 100px; position: relative; overflow: hidden;">
                <div style="position: absolute; left: 0; width: 85%; height: 100%; background: linear-gradient(to right, #7c3aed, #06b6d4);"></div>
                <div style="position: absolute; right: 0; width: 15%; height: 100%; background: #3390ec;"></div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem;">
            <div>
                <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Comissão da Plataforma (%)</label>
                <div style="background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 15px; color: white; font-weight: 700;">15</div>
            </div>
            <div>
                <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Taxa Fixa (p/ Transação)</label>
                <div style="background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 15px; color: white; font-weight: 700;">R$ 0,50</div>
            </div>
            <div>
                <label style="display: block; color: var(--text-muted); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Moeda Padrão</label>
                <select style="width: 100%; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 12px; padding: 15px; color: white; font-weight: 700; outline: none; cursor: pointer;">
                    <option>BRL - Real Brasileiro (R$)</option>
                    <option>USD - Dollar ($)</option>
                </select>
            </div>
        </div>
        <p style="margin-top: 1.5rem; font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">A parte do criador é calculada automaticamente com base na comissão da plataforma.</p>
    </div>

    <!-- Gateways -->
    <div class="admin-card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
            <div style="width: 42px; height: 42px; background: rgba(51, 144, 236, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 850; margin-bottom: 4px;">Gateways de Pagamento</h3>
                <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600;">Ative e configure provedores para processar pagamentos.</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 16px; padding: 1.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 38px; height: 38px; background: #009ee3; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.2rem;">M</div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 850;">Mercado Pago</h4>
                        <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Processamento de Cartão e PIX</p>
                    </div>
                </div>
                <div style="width: 50px; height: 26px; background: var(--primary-blue); border-radius: 20px; position: relative; cursor: pointer;">
                    <div style="width: 20px; height: 20px; background: white; border-radius: 50%; position: absolute; right: 3px; top: 3px;"></div>
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.2); border: 1.5px solid var(--border-gray); border-radius: 16px; padding: 1.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 38px; height: 38px; background: #635bff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.2rem;">S</div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 850;">Stripe</h4>
                        <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Pagamentos Internacionais</p>
                    </div>
                </div>
                <div style="width: 50px; height: 26px; background: rgba(255,255,255,0.05); border-radius: 20px; position: relative; cursor: pointer;">
                    <div style="width: 20px; height: 20px; background: rgba(255,255,255,0.2); border-radius: 50%; position: absolute; left: 3px; top: 3px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
