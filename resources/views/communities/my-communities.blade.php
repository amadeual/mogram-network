@extends('layouts.app')

@section('title', 'Minhas Comunidades | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <header class="studio-header" style="border-bottom: 1px solid rgba(255,255,255,0.03); background: rgba(0,0,0,0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Minhas Comunidades</h2>
                <div style="display: flex; gap: 1rem; margin-top: 4px;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 700;">Gerencie suas tribos e assinaturas</span>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('communities.explore') }}" class="mogram-btn-secondary studio-header-btn" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px; text-decoration: none; color: white; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); transition: 0.3s; display: flex; align-items: center; justify-content: center;">Explorar</a>
                <button onclick="openCreateModal()" class="mogram-btn-primary studio-header-btn" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px; background: #3390ec; border: none; color: white; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;">Criar nova</button>
            </div>
        </header>

        <div class="studio-body">
            <!-- My Owned Communities -->
            <div style="margin-bottom: 5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 36px; height: 36px; background: rgba(51,144,236,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Minhas Criações</h3>
                    </div>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 700; background: rgba(255,255,255,0.03); padding: 4px 12px; border-radius: 20px;">{{ count($myCommunities) }} comunidades</span>
                </div>                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem;">
                    @forelse($myCommunities as $c)
                    <div class="community-premium-card" style="--delay: {{ $loop->index }}" onclick="window.location='{{ route('communities.dashboard', $c->slug) }}'">
                        <div class="card-glow"></div>
                        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 1.25rem;">
                            <div style="width: 76px; height: 76px; border-radius: 20px; overflow: hidden; background: #0f111a; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 12px 24px rgba(0,0,0,0.4);">
                                @if($c->avatar)
                                    <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #3390ec, #00d2ff); color: white; font-size: 26px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 18px; font-weight: 850; color: white; margin-bottom: 6px; letter-spacing: -0.3px;">{{ $c->name }}</h4>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="background: rgba(34, 197, 94, 0.1); padding: 4px 8px; border-radius: 6px; display: flex; align-items: center; gap: 4px;">
                                        <div style="width: 5px; height: 5px; background: #22c55e; border-radius: 50%; box-shadow: 0 0 8px #22c55e;"></div>
                                        <span style="font-size: 11px; color: #4ade80; font-weight: 800;">{{ $c->subscriptions()->where('status', 'active')->count() }} Ativos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="arrow-container" style="width: 38px; height: 38px; background: rgba(255,255,255,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2); transition: 0.3s;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 5rem 2rem; text-align: center; background: rgba(255,255,255,0.01); border-radius: 32px; border: 2px dashed rgba(255,255,255,0.04);">
                        <div style="width: 80px; height: 80px; background: rgba(51,144,236,0.05); border-radius: 24px; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <h4 style="color: white; font-size: 20px; font-weight: 850; margin-bottom: 8px;">Nenhuma Tribo Criada</h4>
                        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; max-width: 300px; margin: 0 auto 2rem;">Comece a construir sua própria comunidade exclusiva hoje mesmo.</p>
                        <button onclick="openCreateModal()" style="background: #3390ec; border: none; color: white; padding: 14px 32px; border-radius: 16px; font-weight: 900; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.2);">Criar minha Tribo</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Subscribed Communities -->
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 36px; height: 36px; background: rgba(168, 85, 247, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Assinaturas</h3>
                    </div>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 700; background: rgba(255,255,255,0.03); padding: 4px 12px; border-radius: 20px;">{{ count($subscribedCommunities) }} tribos</span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem;">
                    @forelse($subscribedCommunities as $c)
                    <div class="community-premium-card sub" style="--delay: {{ $loop->index + 4 }}" onclick="window.location='{{ route('communities.show', $c->slug) }}'">
                        <div class="card-glow"></div>
                        <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 1.25rem;">
                            <div style="width: 76px; height: 76px; border-radius: 20px; overflow: hidden; background: #0f111a; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 12px 24px rgba(0,0,0,0.4);">
                                @if($c->avatar)
                                    <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #a855f7, #ec4899); color: white; font-size: 26px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 18px; font-weight: 850; color: white; margin-bottom: 6px; letter-spacing: -0.3px;">{{ $c->name }}</h4>
                                <p style="font-size: 12px; color: var(--text-muted); font-weight: 700;">Admin: <span style="color: #3390ec;">{{ '@' . $c->user->username }}</span></p>
                            </div>
                            <div class="arrow-container" style="width: 38px; height: 38px; background: rgba(255,255,255,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2); transition: 0.3s;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 5rem 2rem; text-align: center; background: rgba(255,255,255,0.01); border-radius: 32px; border: 2px dashed rgba(255,255,255,0.04);">
                        <div style="width: 80px; height: 80px; background: rgba(168,85,247,0.05); border-radius: 24px; display: flex; align-items: center; justify-content: center; color: #a855f7; margin: 0 auto 1.5rem;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h7"/></svg>
                        </div>
                        <h4 style="color: white; font-size: 20px; font-weight: 850; margin-bottom: 8px;">Nenhuma Assinatura</h4>
                        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600; max-width: 300px; margin: 0 auto 2rem;">Explore tribos incríveis e conecte-se com seus criadores favoritos.</p>
                        <a href="{{ route('communities.explore') }}" style="display: inline-block; background: #a855f7; color: white; padding: 14px 32px; border-radius: 16px; font-weight: 900; font-size: 14px; text-decoration: none; transition: 0.3s; box-shadow: 0 10px 20px rgba(168, 85, 247, 0.2);">Descobrir Tribos</a>
                    </div>
                    @endforelse
                </div>
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
                    <input type="number" name="price" step="0.01" min="5" max="250000" required value="5.00" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Teste Grátis (Dias)</label>
                    <input type="number" name="free_trial_days" value="0" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 12px 15px; color: white; font-size: 14px; font-weight: 600; outline: none; transition: 0.3s;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Imagens (Opcional)</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div onclick="document.getElementById('avatar-input').click()" id="avatar-preview-container" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 14px; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s; height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        <div id="avatar-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <p style="font-size: 10px; color: var(--text-muted); margin-top: 5px; font-weight: 800;">AVATAR</p>
                        </div>
                        <img id="avatar-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                        <input type="file" id="avatar-input" name="avatar" style="display: none;" onchange="previewImage(this, 'avatar-preview', 'avatar-placeholder')">
                    </div>
                    <div onclick="document.getElementById('banner-input').click()" id="banner-preview-container" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 14px; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s; height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        <div id="banner-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p style="font-size: 10px; color: var(--text-muted); margin-top: 5px; font-weight: 800;">CAPA (BANNER)</p>
                        </div>
                        <img id="banner-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                        <input type="file" id="banner-input" name="banner" style="display: none;" onchange="previewImage(this, 'banner-preview', 'banner-placeholder')">
                    </div>
                </div>
            </div>

            <button type="submit" class="mogram-btn-primary" style="width: 100%; padding: 1rem; border-radius: 14px; font-weight: 900; font-size: 14px; border: none; background: #3390ec; color: white; cursor: pointer; box-shadow: 0 10px 20px rgba(51, 144, 236, 0.3);">Criar Comunidade</button>
        </form>
    </div>
</div>

<style>
    .community-premium-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 24px;
        padding: 1.25rem;
        cursor: pointer;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        max-width: 450px;
        margin: 0 auto;
        width: 100%;
    }

    .community-premium-card:hover {
        transform: translateY(-8px) scale(1.01);
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(51, 144, 236, 0.3);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    }

    .community-premium-card.sub:hover {
        border-color: rgba(168, 85, 247, 0.3);
    }

    .card-glow {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(51, 144, 236, 0.1), transparent 70%);
        opacity: 0;
        transition: 0.4s;
    }

    .community-premium-card.sub .card-glow {
        background: radial-gradient(circle at 50% 0%, rgba(168, 85, 247, 0.1), transparent 70%);
    }

    .community-premium-card:hover .card-glow {
        opacity: 1;
    }

    .community-premium-card:hover .arrow-container {
        background: rgba(51, 144, 236, 0.1) !important;
        color: #3390ec !important;
        transform: translateX(4px);
    }

    .community-premium-card.sub:hover .arrow-container {
        background: rgba(168, 85, 247, 0.1) !important;
        color: #a855f7 !important;
    }

    @keyframes premiumFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .community-premium-card {
        animation: premiumFadeIn 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        animation-fill-mode: both;
        animation-delay: calc(var(--delay) * 0.08s);
    }
</style>

<script>
    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
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
