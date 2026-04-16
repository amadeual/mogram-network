@extends('layouts.app')

@section('title', 'Explorar Criadores | Mogram')

@section('content')
@include('partials.navbar')

<div class="container" style="padding-top: 4rem; padding-bottom: 6rem;">
    <div style="margin-bottom: 4rem; text-align: center;">
        <span style="color: #ff4b1f; font-weight: 950; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem;">Comunidade</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 950; letter-spacing: -2px; margin-top: 1rem;">Nossos Criadores</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 1rem auto;">Conecte-se com as personalidades mais influentes e descubra novos talentos.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 2.5rem;">
        @forelse($creators as $creator)
            <div class="creator-card-premium" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 2.5rem 1.5rem; text-align: center; transition: 0.4s; cursor: pointer;" onclick="window.location.href='{{ route('dashboard') }}'">
                <div style="position: relative; width: 110px; height: 110px; margin: 0 auto 1.5rem;">
                    <img src="{{ $creator->avatar ? Storage::url($creator->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$creator->name }}" style="width: 100%; height: 100%; border-radius: 50%; border: 3px solid #ff4b1f; padding: 5px; object-fit: cover;">
                    <div style="position: absolute; bottom: 5px; right: 5px; width: 22px; height: 22px; background: #22c55e; border: 3px solid #08070e; border-radius: 50%;"></div>
                </div>
                
                <h3 style="font-weight: 900; font-size: 1.25rem; color: white; margin-bottom: 0.25rem;">{{ $creator->name }}</h3>
                <p style="color: #3390ec; font-weight: 700; font-size: 0.85rem; margin-bottom: 1.5rem;">@ {{ $creator->username }}</p>
                
                <div style="display: flex; gap: 1rem; justify-content: center; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <p style="font-weight: 900; font-size: 1.1rem; color: white;">{{ number_format($creator->posts_count, 0, ',', '.') }}</p>
                        <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase;">Publicações</p>
                    </div>
                </div>
                
                <button style="margin-top: 2rem; width: 100%; background: rgba(51, 144, 236, 0.1); color: #3390ec; border: none; padding: 10px; border-radius: 14px; font-weight: 840; font-size: 0.85rem; transition: 0.3s;">Ver Perfil</button>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 6rem; background: rgba(255,255,255,0.01); border: 2px dashed rgba(255,255,255,0.05); border-radius: 32px;">
                <p style="font-size: 1.25rem; color: var(--text-muted); font-weight: 600;">Ainda não temos criadores listados. Seja um pioneiro!</p>
                <a href="{{ route('register') }}" style="display: inline-block; margin-top: 1.5rem; color: var(--primary-blue); font-weight: 800;">Cadastre-se como Criador</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 4rem;">
        {{ $creators->links() }}
    </div>
</div>

<style>
    .creator-card-premium:hover {
        transform: translateY(-12px);
        background: rgba(255, 255, 255, 0.04) !important;
        border-color: #ff4b1f !important;
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.5);
    }
    .creator-card-premium:hover button {
        background: #3390ec !important;
        color: white !important;
    }
</style>

@include('partials.footer')
@endsection
