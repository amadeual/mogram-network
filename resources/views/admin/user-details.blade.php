@extends('layouts.admin')

@section('title', 'Detalhes do Usuário: ' . $user->name)

@section('admin_content')
<div style="margin-bottom: 3rem;">
    <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
        <a href="{{ route('admin.users') }}" style="color: inherit; text-decoration: none;">Usuários</a> / Detalhes / {{ $user->username }}
    </p>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px;">Detalhes do Perfil</h1>
        <div style="display: flex; gap: 1rem;">
            <form action="{{ route('admin.users.toggle', [$user->id, $user->status == 'suspended' ? 'activate' : 'suspend']) }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary" style="background: {{ $user->status == 'suspended' ? 'var(--success)' : 'var(--danger)' }}; box-shadow: 0 8px 20px {{ $user->status == 'suspended' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)' }};">
                    {{ $user->status == 'suspended' ? 'Reativar Usuário' : 'Suspender Usuário' }}
                </button>
            </form>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Profile Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <div class="admin-card" style="text-align: center; padding: 3rem 2rem;">
            <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$user->name }}" style="width: 120px; height: 120px; border-radius: 32px; margin-bottom: 1.5rem; border: 4px solid rgba(51, 144, 236, 0.2);">
            <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
            <p style="color: var(--primary-blue); font-weight: 800; font-size: 0.9rem; margin-bottom: 1.5rem;">@<span>{{ $user->username }}</span></p>
            
            <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem;">
                <div style="background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 840;">
                    {{ ucfirst($user->role) }}
                </div>
                <div style="background: {{ $user->status == 'suspended' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(34, 197, 94, 0.1)' }}; color: {{ $user->status == 'suspended' ? 'var(--danger)' : 'var(--success)' }}; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 840;">
                    {{ $user->status == 'suspended' ? 'Suspenso' : 'Ativo' }}
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem; border-top: 1px solid var(--border-gray); padding-top: 1.5rem;">
                <div style="background: rgba(51, 144, 236, 0.05); border: 1px solid rgba(51, 144, 236, 0.1); padding: 1rem; border-radius: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 850; text-transform: uppercase;">Saldo Gasto</span>
                    <span style="font-size: 1rem; font-weight: 950; color: var(--primary-blue);">R$ {{ number_format($user->balance, 2, ',', '.') }}</span>
                </div>
                <div style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.1); padding: 1rem; border-radius: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 850; text-transform: uppercase;">Saldo Lucros</span>
                    <span style="font-size: 1rem; font-weight: 950; color: var(--success);">R$ {{ number_format($user->studio_balance, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card" style="padding: 2rem;">
            <h3 style="font-size: 1rem; font-weight: 900; margin-bottom: 1.5rem;">Informações de Segurança</h3>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.25rem;">Endereço de E-mail</p>
                    <p style="font-weight: 700; font-size: 0.9rem;">{{ $user->email }}</p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.25rem;">Último IP de Acesso</p>
                    <p style="font-weight: 700; font-size: 0.9rem; font-family: monospace;">{{ $user->last_ip ?? '192.168.1.1 (Demo)' }}</p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.25rem;">Autenticação 2FA</p>
                    <p style="font-weight: 800; font-size: 0.85rem; color: {{ $user->two_factor_secret ? 'var(--success)' : 'var(--danger)' }}">
                        {{ $user->two_factor_secret ? 'ATIVADO' : 'DESATIVADO' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="admin-card" style="padding: 2rem; border: 1.5px solid rgba(51, 144, 236, 0.1);">
            <h3 style="font-size: 1rem; font-weight: 900; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Controle de Acesso
            </h3>
            
            <form action="{{ route('admin.users.update_role', $user->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="font-size: 0.7rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.5rem;">Base de Função</label>
                    <select name="role" class="mogram-input-field" style="height: 48px; background: rgba(0,0,0,0.2); border-radius: 10px; font-weight: 700;">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuário Padrão</option>
                        <option value="creator" {{ $user->role == 'creator' ? 'selected' : '' }}>Criador</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="font-size: 0.7rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.5rem;">Função Administrativa</label>
                    <select name="admin_role_id" class="mogram-input-field" style="height: 48px; background: rgba(0,0,0,0.2); border-radius: 10px; font-weight: 700;">
                        <option value="">Nenhuma (Acesso Negado)</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->admin_role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="mogram-btn-primary" style="width: 100%; height: 48px; border-radius: 10px; font-size: 0.8rem; font-weight: 850;">ATUALIZAR ACESSO</button>
            </form>

            @if($user->isAdmin())
                <p style="font-size: 0.65rem; color: var(--text-muted); margin-top: 1rem; line-height: 1.4; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 0.75rem;">
                    <strong>Nota:</strong> Usuários com Função Administrativa selecionada serão automaticamente promovidos a 'admin'.
                </p>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 900; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Informações Detalhadas
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Cidade / Estado</p>
                        <p style="font-weight: 800; font-size: 1rem;">{{ $user->city ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">País</p>
                        <p style="font-weight: 800; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                            {{ $user->country ?? 'Brasil' }}
                        </p>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Biografia / Descrição</p>
                        <p style="font-weight: 600; font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            {{ $user->bio ?? 'Nenhuma biografia disponível para este usuário.' }}
                        </p>
                    </div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Cadastro realizado em</p>
                        <p style="font-weight: 800; font-size: 1rem;">{{ $user->created_at->format('d \d\e F \d\e Y') }}</p>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Verificação</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="background: {{ $user->is_verified ? 'rgba(34, 197, 94, 0.1)' : 'rgba(255, 255, 255, 0.05)' }}; color: {{ $user->is_verified ? 'var(--success)' : 'var(--text-muted)' }}; padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840;">
                                {{ $user->is_verified ? 'CONTA VERIFICADA' : 'NÃO VERIFICADO' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">Restrições Financeiras</p>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @if($user->withdrawals_frozen)
                                <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840;">SAQUES BLOQUEADOS</span>
                            @endif
                            @if($user->deposits_frozen)
                                <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840;">DEPÓSITOS BLOQUEADOS</span>
                            @endif
                            @if(!$user->withdrawals_frozen && !$user->deposits_frozen)
                                <span style="background: rgba(34, 197, 94, 0.1); color: var(--success); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 840;">SEM RESTRIÇÕES</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Balance Management -->
        <div class="admin-card" style="padding: 2.5rem; border: 1px solid rgba(51, 144, 236, 0.15); background: linear-gradient(145deg, rgba(17, 20, 30, 0.4) 0%, rgba(13, 15, 23, 0.2) 100%); overflow: hidden; position: relative;">
            <!-- Decorative Glow -->
            <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: var(--primary-blue); filter: blur(100px); opacity: 0.05;"></div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 950; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 12px; letter-spacing: -0.5px;">
                        <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        Ajuste de Saldo Manual
                    </h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">Credit ou debite valores diretamente das carteiras do usuário.</p>
                </div>
            </div>
            
            <form action="{{ route('admin.users.adjust_balance', $user->id) }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- First Row: Selectors -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <label style="font-size: 0.7rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.75rem;">Destino do Saldo</label>
                            <select name="wallet" class="mogram-input-field" style="height: 54px; width: 100%; padding: 0 1.25rem; background: rgba(0,0,0,0.3); border: 1.5px solid rgba(255,255,255,0.08); font-weight: 700; cursor: pointer; border-radius: 14px; color: white;">
                                <option value="balance">💳 Carteira Principal (Gasto)</option>
                                <option value="studio_balance">💰 Saldo Studio (Lucros)</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.7rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.75rem;">Tipo de Operação</label>
                            <select name="type" class="mogram-input-field" style="height: 54px; width: 100%; padding: 0 1.25rem; background: rgba(0,0,0,0.3); border: 1.5px solid rgba(255,255,255,0.08); font-weight: 700; cursor: pointer; border-radius: 14px; color: white;">
                                <option value="credit" style="color: var(--success);">📈 Creditar (+)</option>
                                <option value="debit" style="color: var(--danger);">📉 Debitar (-)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Second Row: Value and Button -->
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; align-items: end;">
                        <div>
                            <label style="font-size: 0.7rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.75rem;">Valor Estimado</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); font-weight: 900; color: var(--text-muted); font-size: 0.9rem;">R$</span>
                                <input type="text" name="amount" class="mogram-input-field" placeholder="0,00" style="height: 54px; width: 100%; padding-left: 3.5rem; background: rgba(0,0,0,0.3); border: 1.5px solid rgba(255,255,255,0.08); font-weight: 900; font-size: 1.1rem; border-radius: 14px; color: white;">
                            </div>
                        </div>
                        <button type="submit" class="mogram-btn-primary" style="height: 54px; width: 100%; border-radius: 14px; font-weight: 900; font-size: 0.85rem; letter-spacing: 0.5px; box-shadow: 0 10px 25px rgba(51, 144, 236, 0.25);">
                            CONFIRMAR AJUSTE
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-card" style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; font-weight: 900;">Logs de Atividade Recente</h3>
                <button style="background: rgba(255,255,255,0.05); border: none; color: var(--text-white); padding: 8px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">Ver todos os logs</button>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <!-- Placeholder for logs -->
                <div style="display: flex; align-items: center; gap: 15px; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 14px; border: 1px solid var(--border-gray);">
                    <div style="width: 10px; height: 10px; background: var(--primary-blue); border-radius: 50%;"></div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.85rem; font-weight: 700;">Login realizado com sucesso</p>
                        <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">{{ now()->subHours(2)->format('d/m/Y H:i') }} • IP: {{ $user->last_ip ?? '192.168.1.1' }}</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 15px; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 14px; border: 1px solid var(--border-gray);">
                    <div style="width: 10px; height: 10px; background: var(--success); border-radius: 50%;"></div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.85rem; font-weight: 700;">Depósito confirmado via Pix</p>
                        <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">{{ now()->subDays(1)->format('d/m/Y H:i') }} • Valor: R$ 50,00</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 15px; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 14px; border: 1px solid var(--border-gray);">
                    <div style="width: 10px; height: 10px; background: #a855f7; border-radius: 50%;"></div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.85rem; font-weight: 700;">Seguiu um novo perfil</p>
                        <p style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">{{ now()->subDays(3)->format('d/m/Y H:i') }} • Perfil: @mogram_oficial</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activity Logs Card -->
        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 950; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Atividade Recente (Logs)
                </div>
                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Últimos 20 Registros</span>
            </h3>

            @if($logs->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($logs as $log)
                <div style="padding: 1.25rem; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1.5px solid rgba(255,255,255,0.04); display: flex; justify-content: space-between; align-items: center; transition: 0.3s;" onmouseover="this.style.background='rgba(51, 144, 236, 0.04)'; this.style.borderColor='rgba(51, 144, 236, 0.1)';" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.04)';">
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div style="width: 42px; height: 42px; background: {{ $log->type == 'financial' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(51, 144, 236, 0.1)' }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: {{ $log->type == 'financial' ? '#22c55e' : '#3390ec' }}; font-weight: 900; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            @if($log->type == 'financial')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                            @endif
                        </div>
                        <div>
                            <p style="font-weight: 850; font-size: 0.95rem; color: rgba(255,255,255,0.95); margin-bottom: 0.25rem;">{{ $log->description }}</p>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 0.725rem; color: var(--text-muted); font-weight: 700;">{{ $log->created_at->translatedFormat('d M, Y \à\s H:i') }}</span>
                                @if($log->admin)
                                    <span style="width: 4px; height: 4px; background: rgba(255,255,255,0.2); border-radius: 50%;"></span>
                                    <span style="font-size: 0.725rem; color: var(--primary-blue); font-weight: 800; text-transform: uppercase;">ADMIN: {{ $log->admin->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($log->amount)
                    <div style="text-align: right;">
                        <span style="font-weight: 950; font-size: 1.1rem; color: {{ $log->amount > 0 ? '#22c55e' : '#ef4444' }}; display: block;">
                            {{ $log->amount > 0 ? '+' : '' }}R$ {{ number_format($log->amount, 2, ',', '.') }}
                        </span>
                        <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 850; text-transform: uppercase; letter-spacing: 0.5px;">{{ $log->wallet_type == 'balance' ? 'Carteira Principal' : 'Saldo Studio' }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align: center; padding: 4rem 2rem; border: 1.5px dashed rgba(255,255,255,0.08); border-radius: 20px;">
                <p style="font-weight: 700; color: var(--text-muted); font-size: 0.9rem;">Este usuário ainda não possui registros de atividade.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
