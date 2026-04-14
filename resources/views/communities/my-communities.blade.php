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
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                    @forelse($myCommunities as $c)
                    <div class="community-desktop-card" style="--delay: {{ $loop->index }}" onclick="window.location='{{ route('communities.dashboard', $c->slug) }}'">
                        <div class="card-glow"></div>
                        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 1.5rem;">
                            <div style="width: 70px; height: 70px; border-radius: 18px; overflow: hidden; background: #1a1c2e; flex-shrink: 0; box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
                                @if($c->avatar)
                                    <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #3390ec, #00d2ff); color: white; font-size: 24px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 17px; font-weight: 800; color: white; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</h4>
                                <p style="font-size: 13px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                    <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></span>
                                    {{ $c->subscriptions()->where('status', 'active')->count() }} membros ativos
                                </p>
                            </div>
                            <div class="arrow-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 4rem; text-align: center; background: rgba(255,255,255,0.01); border-radius: 24px; border: 2px dashed rgba(255,255,255,0.05);">
                        <div style="margin-bottom: 1.5rem; color: rgba(255,255,255,0.1);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <p style="color: var(--text-muted); font-size: 15px; font-weight: 600;">Você ainda não criou nenhuma comunidade.</p>
                        <button onclick="openCreateModal()" style="margin-top: 1.5rem; background: transparent; border: 1px solid #3390ec; color: #3390ec; padding: 8px 24px; border-radius: 50px; font-weight: 800; cursor: pointer;">Começar agora</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Subscribed Communities -->
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 36px; height: 36px; background: rgba(34, 197, 94, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Assinaturas Ativas</h3>
                    </div>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 700; background: rgba(255,255,255,0.03); padding: 4px 12px; border-radius: 20px;">{{ count($subscribedCommunities) }} assinaturas</span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                    @forelse($subscribedCommunities as $c)
                    <div class="community-desktop-card sub" style="--delay: {{ $loop->index + 5 }}" onclick="window.location='{{ route('communities.show', $c->slug) }}'">
                        <div class="card-glow"></div>
                        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 1.5rem;">
                            <div style="width: 70px; height: 70px; border-radius: 18px; overflow: hidden; background: #1a1c2e; flex-shrink: 0; box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
                                @if($c->avatar)
                                    <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #22c55e, #4ade80); color: white; font-size: 24px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 17px; font-weight: 800; color: white; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $c->name }}</h4>
                                <p style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Criado por <span style="color: #3390ec;">{{ '@' . $c->user->username }}</span></p>
                            </div>
                            <div class="arrow-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; padding: 4rem; text-align: center; background: rgba(255,255,255,0.01); border-radius: 24px; border: 2px dashed rgba(255,255,255,0.05);">
                        <div style="margin-bottom: 1.5rem; color: rgba(255,255,255,0.1);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h7"/></svg>
                        </div>
                        <p style="color: var(--text-muted); font-size: 15px; font-weight: 600;">Você ainda não assinou nenhuma comunidade.</p>
                        <a href="{{ route('communities.explore') }}" style="display: inline-block; margin-top: 1.5rem; background: #3390ec; color: white; padding: 10px 30px; border-radius: 50px; font-weight: 800; text-decoration: none;">Explorar agora</a>
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
    .community-desktop-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1.5px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 1.5rem;
        cursor: pointer;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .community-desktop-card:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(51, 144, 236, 0.3);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .community-desktop-card.sub:hover {
        border-color: rgba(34, 197, 94, 0.3);
    }

    .card-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 0%, rgba(51, 144, 236, 0.1), transparent 70%);
        opacity: 0;
        transition: 0.4s;
    }

    .community-desktop-card.sub .card-glow {
        background: radial-gradient(circle at 50% 0%, rgba(34, 197, 94, 0.1), transparent 70%);
    }

    .community-desktop-card:hover .card-glow {
        opacity: 1;
    }

    .arrow-icon {
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.15);
        transition: 0.3s;
    }

    .community-desktop-card:hover .arrow-icon {
        background: rgba(51, 144, 236, 0.1);
        color: #3390ec;
        transform: translateX(4px);
    }

    .community-desktop-card.sub:hover .arrow-icon {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    @keyframes premiumFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .community-desktop-card {
        animation: premiumFadeIn 0.5s forwards;
        animation-delay: calc(var(--delay) * 0.1s);
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
