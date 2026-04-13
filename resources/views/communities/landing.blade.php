@extends('layouts.app')

@section('title', $community->name . ' | Mogram')

@section('content')
<div class="app-layout">
    @include('partials.sidebar')

    <main class="main-content">
        <div style="height: 300px; background: {{ $community->banner ? 'url(\''.Storage::url($community->banner).'\')' : 'linear-gradient(45deg, #1a1c2e, #3390ec)' }}; background-size: cover; background-position: center; position: relative;">
            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(11, 10, 21, 0.9));"></div>
            <a href="{{ route('communities.explore') }}" style="position: absolute; top: 2rem; left: 2rem; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px); width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; border: 1px solid rgba(255,255,255,0.1); transition: 0.2s;" onmouseover="this.style.transform='translateX(-5px)'" onmouseout="this.style.transform='translateX(0)'">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            </a>
        </div>

        <div style="max-width: 800px; margin: -100px auto 0; padding: 0 2rem 5rem; position: relative; z-index: 10;">
            <div style="background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(40px); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 32px; padding: 3rem; text-align: center; box-shadow: 0 40px 80px rgba(0,0,0,0.5);">
                <div style="width: 120px; height: 120px; border-radius: 32px; overflow: hidden; border: 5px solid #0b0a15; background: #1a1c2e; margin: 0 auto 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                    @if($community->avatar)
                        <img src="{{ Storage::url($community->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--primary-blue); color: white; font-size: 32px; font-weight: 900;">{{ substr($community->name, 0, 1) }}</div>
                    @endif
                </div>

                <h1 style="font-size: 2.25rem; font-weight: 900; color: white; margin-bottom: 0.75rem; letter-spacing: -1px;">{{ $community->name }}</h1>
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.75rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(51,144,236,0.1); padding: 6px 12px; border-radius: 10px; color: #3390ec; font-size: 13px; font-weight: 800;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        {{ $community->subscriptions()->where('status', 'active')->count() }} membros
                    </div>
                </div>

                <p style="color: rgba(255,255,255,0.8); font-size: 1rem; line-height: 1.6; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                    {{ $community->description ?? 'Entre para esta comunidade exclusiva e tenha acesso a conteúdos, discussões e uma rede de contatos única.' }}
                </p>

                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem; display: flex; flex-direction: column; align-items: center;">
                    <p style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Acesso Ilimitado</p>
                    <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 2rem;">
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--text-muted);">R$</span>
                        <span style="font-size: 3rem; font-weight: 950; color: white; letter-spacing: -1px;">{{ number_format($community->price, 0) }}</span>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--text-muted);">/mês</span>
                    </div>

                    <form action="{{ route('communities.subscribe', $community->slug) }}" method="POST" style="width: 100%; max-width: 300px;">
                        @csrf
                        <button type="submit" class="mogram-btn-primary" style="width: 100%; padding: 1.25rem; border-radius: 16px; font-weight: 900; font-size: 15px; border: none; background: #3390ec; color: white; cursor: pointer; box-shadow: 0 15px 30px rgba(51, 144, 236, 0.4); transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(51, 144, 236, 0.5)'" onmouseout="this.style.transform='translateY(0)'">Assinar Agora</button>
                    </form>
                    
                    <p style="margin-top: 1.5rem; font-size: 11px; color: var(--text-muted); font-weight: 600;">O valor será descontado do seu saldo Mogram.</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
