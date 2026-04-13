@extends('layouts.app')

@section('title', 'Explorar Comunidades | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <header style="height: 70px; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-gray); background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;">
            <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Explorar Comunidades</h2>
            <div style="display: flex; gap: 1rem;">
                <button onclick="openCreateModal()" class="mogram-btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px;">Criar Comunidade</button>
            </div>
        </header>

        <div class="feed-container" style="padding: 2rem;">
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.5rem; font-weight: 900; color: white; margin-bottom: 0.5rem;">Descubra novos grupos</h3>
                <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Comunidades exclusivas para aprender, compartilhar e evoluir.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @forelse($communities as $c)
                <div class="community-card" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden; transition: 0.3s; position: relative;">
                    <div style="height: 120px; background: {{ $c->banner ? 'url('.Storage::url($c->banner).')' : 'linear-gradient(45deg, #1a1c2e, #3390ec)' }}; background-size: cover; background-position: center;"></div>
                    <div style="padding: 1.5rem; margin-top: -40px; position: relative;">
                        <div style="width: 80px; height: 80px; border-radius: 20px; overflow: hidden; border: 4px solid #0b0a15; background: #1a1c2e; margin-bottom: 1rem; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                            @if($c->avatar)
                                <img src="{{ Storage::url($c->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--primary-blue); color: white; font-size: 24px; font-weight: 900;">{{ substr($c->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <h4 style="font-size: 16px; font-weight: 800; color: white; margin-bottom: 0.25rem;">{{ $c->name }}</h4>
                        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.4; height: 3.2em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $c->description ?? 'Sem descrição disponível.' }}</p>
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.03);">
                            <div>
                                <p style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Mensalidade</p>
                                <p style="font-size: 16px; font-weight: 900; color: #3390ec;">R$ {{ number_format($c->price, 2, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('communities.show', $c->slug) }}" class="mogram-btn-secondary" style="padding: 0.6rem 1.25rem; border-radius: 12px; font-size: 12px; font-weight: 800; text-decoration: none; color: white; background: rgba(51,144,236,0.1); border: 1px solid rgba(51,144,236,0.2);">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1.5px dashed rgba(255,255,255,0.05);">
                    <h3 style="font-size: 18px; font-weight: 900; color: white;">Nenhuma comunidade encontrada</h3>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

<!-- Create Community Modal -->
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

<style>
    .community-card:hover { transform: translateY(-8px); border-color: rgba(51, 144, 236, 0.3) !important; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
</style>
@endsection
