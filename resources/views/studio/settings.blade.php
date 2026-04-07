@extends('layouts.app')

@section('title', 'Configurações do Perfil - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <main class="main-content" style="background: #0b0a15; flex: 1; overflow-y: auto;">
        <header class="settings-header" style="padding: 2.5rem 3rem 1.5rem;">
            <h1 style="font-size: 2.5rem; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1.5px;">Configurações</h1>
            <p style="color: var(--text-muted); font-size: 15px; font-weight: 700;">Personalize sua identidade e como os fãs veem seu perfil.</p>
        </header>

        <div class="settings-body" style="padding: 0 3rem 3rem;">
            @if(session('success'))
                <div style="background: rgba(34,197,94,0.1); border: 1.5px solid rgba(34,197,94,0.2); border-radius: 16px; padding: 1rem 1.5rem; color: #22c55e; font-weight: 800; font-size: 14px; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('studio.settings.update') }}" method="POST" enctype="multipart/form-data" 
                  class="settings-form" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 3rem; max-width: 800px;">
                @csrf
                
                <div class="settings-avatar-group" style="display: flex; gap: 3rem; align-items: start; margin-bottom:3rem;">
                    <!-- Avatar Upload -->
                    <div style="text-align: center;">
                        <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 1.5rem;">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" id="avatar_preview" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #151621;">
                            @else
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $user->name }}" id="avatar_preview" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #151621;">
                            @endif
                            <label for="avatar_input" style="position: absolute; bottom: 5px; right: 5px; width: 36px; height: 36px; background: #3390ec; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; border: 3px solid #151621; transition: 0.3s; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </label>
                            <input type="file" name="avatar" id="avatar_input" hidden accept="image/*" onchange="previewAvatar(this)">
                        </div>
                        <h4 style="font-size: 14px; color: white; font-weight: 800; margin-bottom: 4px;">Foto de Perfil</h4>
                        <p style="font-size: 11px; color: var(--text-muted);">PNG ou JPG, máx 2MB</p>
                    </div>

                    <!-- Name and Stats -->
                    <div style="flex: 1; padding-top: 1rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Nome Público</label>
                            <input type="text" name="name" value="{{ $user->name }}" 
                                   style="width: 100%; background: rgba(0,0,0,0.2); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 0.875rem 1.25rem; color: white; font-weight: 700; outline: none; transition: 0.3s;"
                                   onfocus="this.style.borderColor='#3390ec'">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Nome de Usuário</label>
                            <input type="text" value="@{{ $user->username }}" disabled
                                   style="width: 100%; background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.03); border-radius: 12px; padding: 0.875rem 1.25rem; color: var(--text-muted); font-weight: 700; cursor: not-allowed;">
                        </div>
                    </div>
                </div>

                <div class="settings-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Sua Cidade</label>
                        <input type="text" name="city" value="{{ $user->city }}" placeholder="Ex: São Paulo, SP"
                               style="width: 100%; background: rgba(0,0,0,0.2); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 0.875rem 1.25rem; color: white; font-weight: 700; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Área de Conteúdo</label>
                        <select name="category" 
                                style="width: 100%; background: rgba(0,0,0,0.3); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 0.875rem 1.25rem; color: #ffffff; font-weight: 700; outline: none; appearance: none; cursor: pointer;">
                            <option value="" style="background: #1a1c2e;">Selecione uma área</option>
                            <option value="Modelagem" {{ $user->category == 'Modelagem' ? 'selected' : '' }} style="background: #1a1c2e;">Modelagem / Moda</option>
                            <option value="Gamer" {{ $user->category == 'Gamer' ? 'selected' : '' }} style="background: #1a1c2e;">Gamer / Streaming</option>
                            <option value="Fitness" {{ $user->category == 'Fitness' ? 'selected' : '' }} style="background: #1a1c2e;">Fitness / Saúde</option>
                            <option value="Lifestyle" {{ $user->category == 'Lifestyle' ? 'selected' : '' }} style="background: #1a1c2e;">Lifestyle</option>
                            <option value="Arte" {{ $user->category == 'Arte' ? 'selected' : '' }} style="background: #1a1c2e;">Arte / Fotografia</option>
                            <option value="Tecnologia" {{ $user->category == 'Tecnologia' ? 'selected' : '' }} style="background: #1a1c2e;">Tecnologia / Programação</option>
                            <option value="Religião" {{ $user->category == 'Religião' ? 'selected' : '' }} style="background: #1a1c2e;">Religião / Mentor</option>
                            <option value="Fé" {{ $user->category == 'Fé' ? 'selected' : '' }} style="background: #1a1c2e;">Espiritualidade / Fé</option>
                            <option value="Educação" {{ $user->category == 'Educação' ? 'selected' : '' }} style="background: #1a1c2e;">Educação / Ensino</option>
                            <option value="Música" {{ $user->category == 'Música' ? 'selected' : '' }} style="background: #1a1c2e;">Música / Produção</option>
                            <option value="Culinária" {{ $user->category == 'Culinária' ? 'selected' : '' }} style="background: #1a1c2e;">Culinária / Gastronomia</option>
                            <option value="Digital" {{ $user->category == 'Digital' ? 'selected' : '' }} style="background: #1a1c2e;">Marketing Digital</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Bio / Descrição do Perfil</label>
                    <textarea name="bio" rows="4" placeholder="Conte um pouco sobre você para seus fãs..."
                              style="width: 100%; background: rgba(0,0,0,0.2); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 1rem 1.25rem; color: white; font-weight: 600; outline: none; resize: none; line-height: 1.5;">{{ $user->bio }}</textarea>
                </div>

                <div class="settings-btn-group" style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="history.back()" class="mogram-btn-secondary" style="padding: 1rem 2rem; border-radius: 14px; font-weight: 800;">Cancelar</button>
                    <button type="submit" class="mogram-btn-primary" style="padding: 1rem 3rem; border-radius: 14px; font-weight: 950; box-shadow: 0 8px 30px rgba(51, 144, 236, 0.3);">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    @media (max-width: 768px) {
        .settings-header { padding: 1.5rem 1rem !important; }
        .settings-body { padding: 0 1rem 2rem !important; }
        .settings-form { padding: 1.5rem !important; border-radius: 20px !important; }
        .settings-avatar-group { flex-direction: column !important; gap: 1.5rem !important; align-items: center !important; text-align: center; }
        .settings-avatar-group > div:last-child { width: 100%; text-align: left; }
        .settings-grid { grid-template-columns: 1fr !important; gap: 1.5rem !important; }
        .settings-btn-group { flex-direction: column-reverse; gap: 1rem !important; }
        .settings-btn-group button { width: 100%; }
        /* Add spacing so content isnt hidden behind mobile bottom nav */
        .settings-body { margin-bottom: 60px; }
    }
</style>
@endsection
