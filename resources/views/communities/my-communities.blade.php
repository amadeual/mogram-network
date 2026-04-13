@extends('layouts.app')

@section('title', 'Minhas Comunidades | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <header style="height: 70px; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-gray); background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;">
            <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Minhas Comunidades</h2>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('communities.explore') }}" class="mogram-btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px; text-decoration: none; color: white; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">Explorar</a>
                <button onclick="openCreateModal()" class="mogram-btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px;">Criar nova</button>
            </div>
        </header>

        <div class="feed-container" style="padding: 2rem;">
            <!-- My Owned Communities -->
            <div style="margin-bottom: 4rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 32px; height: 32px; background: rgba(51,144,236,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Minhas Criações</h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @forelse($myCommunities as $c)
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.25rem; display: flex; align-items: center; gap: 1.25rem; transition: 0.2s; cursor: pointer;" onclick="window.location='{{ route('communities.dashboard', $c->slug) }}'" onmouseover="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(51,144,236,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.05)'">
                        <div style="width: 60px; height: 60px; border-radius: 14px; overflow: hidden; background: #1a1c2e; flex-shrink: 0;">
                            @if($c->avatar)
                                <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--primary-blue); color: white; font-size: 18px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 15px; font-weight: 800; color: white; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</h4>
                            <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">{{ $c->subscriptions()->where('status', 'active')->count() }} membros ativos</p>
                        </div>
                        <div style="color: var(--text-muted);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 3rem; text-align: center; background: rgba(255,255,255,0.02); border-radius: 20px; border: 1.25px dashed rgba(255,255,255,0.05);">
                        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Você ainda não criou nenhuma comunidade.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Subscribed Communities -->
            <div>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 32px; height: 32px; background: rgba(34, 197, 94, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Assinaturas Ativas</h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @forelse($subscribedCommunities as $c)
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 1.25rem; display: flex; align-items: center; gap: 1.25rem; transition: 0.2s; cursor: pointer;" onclick="window.location='{{ route('communities.show', $c->slug) }}'" onmouseover="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(34, 197, 94, 0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.05)'">
                        <div style="width: 60px; height: 60px; border-radius: 14px; overflow: hidden; background: #1a1c2e; flex-shrink: 0;">
                            @if($c->avatar)
                                <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #22c55e; color: white; font-size: 18px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 15px; font-weight: 800; color: white; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</h4>
                            <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Criado por {{ '@' . $c->user->username }}</p>
                        </div>
                        <div style="color: var(--text-muted);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 3rem; text-align: center; background: rgba(255,255,255,0.02); border-radius: 20px; border: 1.25px dashed rgba(255,255,255,0.05);">
                        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Você ainda não assinou nenhuma comunidade.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Create Modal same as explore -->
<div id="createCommunityModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 20000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #1a1c2e; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Criar nova comunidade</h3>
            <button onclick="closeCreateModal()" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Nome da Comunidade</label>
                <input type="text" name="name" required style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s;" placeholder="Ex: Mastermind de Marketing">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Descrição Curta</label>
                <textarea name="description" rows="3" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s; resize: none;" placeholder="Descreva o que os membros encontrarão aqui..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Preço Mensal (R$)</label>
                    <input type="number" name="price" step="0.01" required value="0.00" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Teste Grátis (Dias)</label>
                    <input type="number" name="free_trial_days" value="0" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Imagens</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div onclick="document.getElementById('avatar-input').click()" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 14px; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(51,144,236,0.05)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p style="font-size: 10px; color: var(--text-muted); margin-top: 5px; font-weight: 800;">AVATAR</p>
                        <input type="file" id="avatar-input" name="avatar" style="display: none;">
                    </div>
                    <div onclick="document.getElementById('banner-input').click()" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 14px; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(51,144,236,0.05)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p style="font-size: 10px; color: var(--text-muted); margin-top: 5px; font-weight: 800;">BANNER</p>
                        <input type="file" id="banner-input" name="banner" style="display: none;">
                    </div>
                </div>
            </div>

            <button type="submit" class="mogram-btn-primary" style="width: 100%; padding: 1rem; border-radius: 14px; font-weight: 900; font-size: 14px; border: none; background: #3390ec; color: white; cursor: pointer; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.3);">Criar Comunidade</button>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createCommunityModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeCreateModal() {
        document.getElementById('createCommunityModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
