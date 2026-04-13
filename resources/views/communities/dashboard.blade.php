@extends('layouts.app')

@section('title', 'Gerenciar | ' . $community->name . ' | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <header style="height: 70px; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-gray); background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('communities.show', $community->slug) }}" style="color: var(--text-muted); transition: 0.2s;" onmouseover="this.style.color='white'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                </a>
                <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Gerenciar Comunidade</h2>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button onclick="openEditModal()" class="mogram-btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 800; font-size: 13px; color: white; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">Editar Configurações</button>
            </div>
        </header>

        <div class="feed-container" style="padding: 2rem;">
            <!-- Stats -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Membros Ativos</p>
                    <h3 style="font-size: 1.75rem; font-weight: 950; color: white;">{{ $community->subscriptions()->where('status', 'active')->count() }}</h3>
                </div>
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Receita Mensal</p>
                    <h3 style="font-size: 1.75rem; font-weight: 950; color: #22c55e;">R$ {{ number_format($community->subscriptions()->where('status', 'active')->sum('amount'), 2, ',', '.') }}</h3>
                </div>
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Publicações</p>
                    <h3 style="font-size: 1.75rem; font-weight: 950; color: white;">{{ $community->posts()->count() }}</h3>
                </div>
                 <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 1.5rem;">
                    <p style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Status</p>
                    <h3 style="font-size: 1.25rem; font-weight: 950; color: #3390ec;">Ativa</h3>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
                <!-- Recent Members -->
                <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 900; color: white; margin-bottom: 2rem;">Membros Recentes</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 1.5px solid rgba(255,255,255,0.05);">
                                    <th style="padding: 1rem; font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Usuário</th>
                                    <th style="padding: 1rem; font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Assinado em</th>
                                    <th style="padding: 1rem; font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Valor</th>
                                    <th style="padding: 1rem; font-size: 12px; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Expira em</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($community->subscriptions()->with('user')->latest()->take(10)->get() as $sub)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                    <td style="padding: 1.25rem 1rem; display: flex; align-items: center; gap: 0.75rem;">
                                        <img src="{{ $sub->user->avatar ? Storage::url($sub->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $sub->user->name }}" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover;">
                                        <div>
                                            <p style="font-size: 13px; font-weight: 800; color: white; margin: 0;">{{ $sub->user->name }}</p>
                                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">{{ '@' . $sub->user->username }}</p>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.8);">{{ $sub->created_at->format('d/m/Y') }}</td>
                                    <td style="padding: 1rem; font-size: 13px; font-weight: 800; color: #22c55e;">R$ {{ number_format($sub->amount, 2, ',', '.') }}</td>
                                    <td style="padding: 1rem; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.8);">{{ $sub->expires_at ? $sub->expires_at->format('d/m/Y') : 'Vitalício' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Settings/Actions -->
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem;">
                        <h3 style="font-size: 1rem; font-weight: 900; color: white; margin-bottom: 1.5rem;">Link de Convite</h3>
                        <p style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 1rem;">Compartilhe o link abaixo para atrair novos membros.</p>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" value="{{ route('communities.show', $community->slug) }}" readonly style="flex: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 10px 12px; color: var(--text-muted); font-size: 12px; outline: none;">
                            <button onclick="copyLink()" style="background: #3390ec; border: none; color: white; padding: 0 1rem; border-radius: 10px; cursor: pointer;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                            </button>
                        </div>
                    </div>

                    <div style="background: rgba(239,68,68,0.05); border: 1.5px solid rgba(239,68,68,0.1); border-radius: 24px; padding: 2rem;">
                        <h3 style="font-size: 1rem; font-weight: 900; color: #ef4444; margin-bottom: 1rem;">Zona de Perigo</h3>
                        <p style="font-size: 12px; color: rgba(239,68,68,0.7); font-weight: 600; margin-bottom: 1.5rem;">Ao arquivar a comunidade, nenhum novo membro poderá entrar e o conteúdo ficará restrito aos atuais assinantes.</p>
                        <button class="mogram-btn-secondary" style="width: 100%; border-color: rgba(239,68,68,0.3); color: #ef4444; padding: 0.75rem;">Arquivar Comunidade</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Edit Modal (Simplified for now) -->
<div id="editCommunityModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 20000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #1a1c2e; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
         <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Editar Comunidade</h3>
            <button onclick="closeEditModal()" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('communities.update', $community->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Apresentação</label>
                <input type="text" name="name" value="{{ $community->name }}" required style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-size: 13px; margin-bottom: 1rem;">
                <textarea name="description" rows="3" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-size: 13px; resize: none;">{{ $community->description }}</textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Financeiro</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <input type="number" name="price" step="0.01" min="5" max="250000" value="{{ $community->price }}" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-size: 13px;">
                    <input type="number" name="free_trial_days" value="{{ $community->free_trial_days }}" style="width: 100%; background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 15px; color: white; font-size: 13px;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase;">Imagens (Opcional)</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div onclick="document.getElementById('edit-avatar-input').click()" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 12px; height: 100px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; cursor: pointer;">
                        @if($community->avatar)
                            <img src="{{ Storage::url($community->avatar) }}" id="edit-avatar-preview" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div id="edit-avatar-placeholder" style="text-align: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <p style="font-size: 9px; color: var(--text-muted); margin-top: 4px;">AVATAR</p>
                            </div>
                            <img id="edit-avatar-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                        @endif
                        <input type="file" id="edit-avatar-input" name="avatar" style="display: none;" onchange="previewUpdateImage(this, 'edit-avatar-preview', 'edit-avatar-placeholder')">
                    </div>
                    <div onclick="document.getElementById('edit-banner-input').click()" style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 12px; height: 100px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; cursor: pointer;">
                        @if($community->banner)
                            <img src="{{ Storage::url($community->banner) }}" id="edit-banner-preview" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div id="edit-banner-placeholder" style="text-align: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <p style="font-size: 9px; color: var(--text-muted); margin-top: 4px;">CAPA</p>
                            </div>
                            <img id="edit-banner-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                        @endif
                        <input type="file" id="edit-banner-input" name="banner" style="display: none;" onchange="previewUpdateImage(this, 'edit-banner-preview', 'edit-banner-placeholder')">
                    </div>
                </div>
            </div>

            <button type="submit" class="mogram-btn-primary" style="width: 100%; padding: 1rem; border-radius: 12px; font-weight: 900;">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
    function previewUpdateImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if(preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.position = 'absolute';
                    preview.style.inset = '0';
                }
                if(placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function openEditModal() {
        document.getElementById('editCommunityModal').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('editCommunityModal').style.display = 'none';
    }
    function copyLink() {
        const input = document.querySelector('input[readonly]');
        input.select();
        document.execCommand('copy');
        alert('Link copiado!');
    }
</script>
@endsection
