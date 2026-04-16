@extends('layouts.app')

@section('title', 'Explorar Criadores | Mogram')

@section('content')
@include('partials.navbar')

<main class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
    <div style="margin-bottom: 4rem; text-align: center;">
        <h1 style="font-size: 2.75rem; font-weight: 950; letter-spacing: -1.5px; margin-bottom: 1rem;">Explorar <span class="grad-text">Criadores</span></h1>
        <p style="color: var(--text-muted); font-size: 1.125rem; font-weight: 600; max-width: 600px; margin: 0 auto;">Encontre e conecte-se com os criadores mais influentes da plataforma.</p>
    </div>

    <!-- Filters & Search -->
    <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 4rem;">
        <form action="{{ route('explore.creators') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
            <div style="position: relative; width: 400px; max-width: 100%;">
                <svg style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome ou @usuário..." style="width: 100%; background: rgba(255,255,255,0.03); border: 1.5px solid var(--border-gray); border-radius: 99px; padding: 12px 15px 12px 45px; color: white; outline: none; font-weight: 600; transition: 0.3s; focus: border-color: var(--primary-blue);">
            </div>

            <select name="category" onchange="this.form.submit()" style="background: rgba(255,255,255,0.03); border: 1.5px solid var(--border-gray); border-radius: 99px; padding: 0 25px; color: white; font-weight: 700; outline: none; cursor: pointer;">
                <option value="">Todas as Categorias</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @if($creators->count() > 0)
        <!-- Creators Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
            @foreach($creators as $creator)
                <div style="background: var(--bg-card); border: 1px solid var(--border-gray); border-radius: 28px; padding: 2.5rem 1.5rem; text-align: center; position: relative; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='var(--primary-blue)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border-gray)'">
                    <a href="{{ route('creator.profile', $creator->username) }}" style="text-decoration: none; display: block;">
                        @if($creator->avatar)
                            <img src="{{ Storage::url($creator->avatar) }}" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1.5rem; object-fit: cover; border: 3px solid var(--primary-blue);">
                        @else
                            <div style="width: 100px; height: 100px; border-radius: 50%; background: #3390ec; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2.5rem; font-weight: 900; border: 3px solid var(--border-gray);">
                                {{ substr($creator->name, 0, 1) }}
                            </div>
                        @endif

                        <h3 style="color: white; font-size: 1.25rem; font-weight: 850; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; gap: 5px;">
                            {{ $creator->name }}
                            @if($creator->is_verified)
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="var(--primary-blue)"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            @endif
                        </h3>
                        <p style="color: var(--primary-blue); font-size: 0.875rem; font-weight: 700; margin-bottom: 0.75rem;">@ {{ $creator->username }}</p>
                        
                        @if($creator->category)
                            <span style="display: inline-block; background: rgba(51, 144, 236, 0.1); color: var(--primary-blue); padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">{{ $creator->category }}</span>
                        @endif

                        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 2rem;">
                            <div>
                                <p style="color: white; font-weight: 900; font-size: 1.1rem; margin-bottom: 2px;">{{ number_format($creator->followers_count, 0, ',', '.') }}</p>
                                <p style="color: var(--text-muted); font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Fãs</p>
                            </div>
                        </div>
                    </a>

                    @auth
                        @if(auth()->id() !== $creator->id)
                            <button onclick="toggleFollowForExplore({{ $creator->id }}, this)" style="margin-top: 2rem; width: 100%; padding: 12px; border-radius: 12px; border: none; font-weight: 800; cursor: pointer; transition: 0.3s; {{ auth()->user()->isFollowing($creator) ? 'background: rgba(255,255,255,0.05); color: white;' : 'background: white; color: black;' }}">
                                {{ auth()->user()->isFollowing($creator) ? 'Seguindo' : 'Seguir' }}
                            </button>
                        @endif
                    @else
                        <a href="{{ route('register') }}" style="margin-top: 2rem; width: 100%; padding: 12px; border-radius: 12px; background: white; color: black; font-weight: 800; text-decoration: none; display: block;">Seguir</a>
                    @endauth
                </div>
            @endforeach
        </div>

        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $creators->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem 0;">
            <p style="color: var(--text-muted); font-size: 1.25rem; font-weight: 700;">Nenhum criador encontrado.</p>
        </div>
    @endif
</main>

<script>
    async function toggleFollowForExplore(userId, btn) {
        try {
            const resp = await fetch(\`/profile/\${userId}/follow\`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await resp.json();
            
            if (data.status === 'followed') {
                btn.innerText = 'Seguindo';
                btn.style.background = 'rgba(255,255,255,0.05)';
                btn.style.color = 'white';
            } else if (data.status === 'unfollowed') {
                btn.innerText = 'Seguir';
                btn.style.background = 'white';
                btn.style.color = 'black';
            }
        } catch (e) {
            console.error('Erro ao seguir:', e);
        }
    }
</script>

@include('partials.footer')
@endsection
