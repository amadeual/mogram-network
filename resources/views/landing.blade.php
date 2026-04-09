@extends('layouts.app')

@section('title', 'Mogram | A Rede Social que Valoriza o Criador de Conteúdo')
@section('meta_description', 'Junte-se ao Mogram e transforme sua influência em receita. Explore conteúdos exclusivos, assista a lives e conecte-se com seus criadores favoritos na plataforma que mais cresce no Brasil.')

@section('content')
@include('partials.navbar')

<!-- Hero Social Section -->
<header class="hero-social">
    <div class="container hero-grid">
        <div class="hero-content">
            <h1 class="hero-title">
                Siga, Assista, <br><span class="grad-text">Monetize.</span>
            </h1>
            <p class="text-muted" style="font-size: 1.25rem; max-width: 500px; line-height: 1.6; margin-bottom: 3.5rem; color: #aaa;">
                A rede social onde sua influência se transforma em receita direta. Conteúdo exclusivo, lives imersivas e conexões reais.
            </p>
            
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <a href="{{ route('register') }}" class="mogram-btn-primary hero-cta-btn">
                    <span class="hero-cta-short">Começar</span>
                    <span class="hero-cta-full">Começar Agora</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #22C55E; font-weight: 800; font-size: 0.9rem;">
                    <span style="width: 10px; height: 10px; background: #22C55E; border-radius: 50%; display: block; animation: pulse 2s infinite;"></span>
                    1,240 LIVES AGORA
                </div>
            </div>
        </div>
        
        <div class="hero-visual" style="position: relative;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; transform: perspective(1200px) rotateY(-12deg) rotateX(8deg); filter: drop-shadow(0 30px 60px rgba(0,0,0,0.5));">
                {{-- Top Left: Macbook Creator Setup --}}
                <div style="background: url('https://images.unsplash.com/photo-1527443154391-507e99c51f46?auto=format&fit=crop&w=800&q=80') center; background-size: cover; height: 320px; border-radius: 32px; border: 1px solid rgba(255,255,255,0.1); margin-top: 2rem; box-shadow: inset 0 0 40px rgba(0,0,0,0.3);"></div>
                
                {{-- Top Right: Professional Camera --}}
                <div style="background: url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=800&q=80') center; background-size: cover; height: 380px; border-radius: 32px; border: 1px solid rgba(255,255,255,0.1); box-shadow: inset 0 0 40px rgba(0,0,0,0.3);"></div>
                
                {{-- Bottom Left: Creator Collaboration --}}
                <div style="background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80') center; background-size: cover; height: 380px; border-radius: 32px; border: 1px solid rgba(255,255,255,0.1); margin-top: -3rem; box-shadow: inset 0 0 40px rgba(0,0,0,0.3);"></div>
                
                {{-- Bottom Right: Live Card --}}
                <div style="grid-column: 2; margin-top: -1.5rem; background: rgba(25, 25, 35, 0.7); backdrop-filter: blur(25px); padding: 1.75rem; border-radius: 32px; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #ff4b1f; object-fit: cover;">
                        <div>
                            <p style="font-weight: 800; font-size: 1rem; color: white; margin: 0;">Isabella Costa</p>
                            <p style="font-size: 0.75rem; color: #ef4444; font-weight: 900; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%; display: inline-block;"></span>
                                AO VIVO
                            </p>
                        </div>
                    </div>
                    <div style="height: 140px; background: rgba(0,0,0,0.4); border-radius: 20px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
                        <div style="position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80') center; background-size: cover; opacity: 0.4; filter: blur(2px);"></div>
                        <div style="width: 48px; height: 48px; background: #ff4b1f; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 1; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(255,75,31,0.3);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Top Live Spotlight -->
<section style="padding: 8rem 0; background: #0b0a15;">
    <div class="container">
        <div class="section-header-row">
            <div>
                <span style="color: #ef4444; font-weight: 900; text-transform: none; letter-spacing: 2px; font-size: 0.75rem;">Spotlight</span>
                <h2 class="section-title-responsive">Top 3 Lives</h2>
            </div>
            <a href="{{ route('lives') }}" class="text-blue font-bold" style="text-decoration: none;">Ver todas as lives &rarr;</a>
        </div>

        <div class="lives-grid">
            @forelse($topLives as $live)
            <div class="live-card-home" onclick="window.location.href='{{ route('live.watch', $live->id) }}'" style="position: relative; cursor: pointer; transition: 0.4s;">
                <div style="position: relative; border-radius: 24px; overflow: hidden; aspect-ratio: 16/10;">
                    <img src="{{ Storage::url($live->thumbnail) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 1rem; left: 1rem; background: {{ $live->status == 'online' ? '#ef4444' : '#3390ec' }}; padding: 0.25rem 0.75rem; border-radius: 6px; color: white; font-size: 0.7rem; font-weight: 900;">
                        {{ strtoupper($live->status == 'online' ? 'AO VIVO' : 'AGENDADA') }}
                    </div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 2rem 1.5rem 1.5rem; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);">
                        <h4 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $live->title }}</h4>
                        <p style="font-size: 0.8rem; opacity: 0.7;">com {{ $live->user->name }}</p>
                    </div>
                </div>
            </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1px dashed rgba(255,255,255,0.1);">
                    <p class="text-muted">Nenhuma live acontecendo no momento. <a href="{{ route('register') }}" class="text-blue">Seja o primeiro!</a></p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Creators Grid -->
<section style="padding: 5rem 0 10rem; background: #0b0a15;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 5rem;">
            <h2 style="font-size: 3rem; font-weight: 950; letter-spacing: -2px;">Criadores em Ascensão</h2>
            <p class="text-muted" style="max-width: 600px; margin: 1rem auto;">Conheça os criadores que estão redefinindo as redes sociais com conteúdo premium e interativo.</p>
        </div>

        <div class="creators-grid">
            @php
                $demoCreators = [
                    ['name' => 'Isabella Costa', 'handle' => '@isabella_fit', 'fans' => '12.4K', 'img' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Isabella'],
                    ['name' => 'Rafael Souza', 'handle' => '@rafael.tech', 'fans' => '8.2K', 'img' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rafael'],
                    ['name' => 'Julia Medeiros', 'handle' => '@julia_art', 'fans' => '25.7K', 'img' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Julia'],
                    ['name' => 'Rodrigo Gois', 'handle' => '@rodrigo.fit', 'fans' => '42.1K', 'img' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rodrigo'],
                ];
            @endphp

            @foreach($demoCreators as $creator)
            <div class="creator-card-social" style="background: rgba(255,255,255,0.03); padding: 2rem; border-radius: 30px; border: 1px solid rgba(255,255,255,0.05); text-align: center; transition: 0.3s; cursor: pointer;">
                <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 1.5rem;">
                    <img src="{{ $creator['img'] }}" style="width: 100%; height: 100%; border-radius: 50%; border: 3px solid #ff4b1f; padding: 4px;">
                    <div style="position: absolute; bottom: 0; right: 0; background: #22c55e; border: 3px solid #0b0a15; width: 24px; height: 24px; border-radius: 50%;"></div>
                </div>
                <h4 style="font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $creator['name'] }}</h4>
                <p style="color: #3390ec; font-weight: 700; font-size: 0.8rem; margin-bottom: 1.5rem;">{{ $creator['handle'] }}</p>
                
                <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <p style="font-weight: 900; font-size: 1.1rem;">{{ $creator['fans'] }}</p>
                        <p style="font-size: 0.6rem; color: #555; text-transform: none; font-weight: 800;">Fãs</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Social -->
<section style="padding: 8rem 0;">
    <div class="container">
        <div class="cta-card">
            <!-- Decorative icons -->
            <div style="position: absolute; top: -20px; left: -20px; opacity: 0.1; font-size: 10rem; transform: rotate(-15deg); font-weight: 900; color: white;">#</div>
            <div style="position: absolute; bottom: -20px; right: -20px; opacity: 0.1; font-size: 10rem; transform: rotate(15deg); font-weight: 900; color: white;">@</div>

            <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 950; margin-bottom: 1.5rem; color: white;">Pronto para sua própria <br> comunidade?</h2>
            <p style="font-size: 1.25rem; font-weight: 600; opacity: 0.9; max-width: 600px; margin: 0 auto 3.5rem; color: white;">A única rede social que coloca o criador em primeiro lugar. 100% de liberdade, ganhos reais e suporte total.</p>
            
            <a href="{{ route('register') }}" style="background: white; color: #ff4b1f; padding: 1.5rem 4rem; border-radius: 99px; font-weight: 900; font-size: 1.125rem; text-decoration: none; display: inline-block;">
                Criar Minha Rede Agora
            </a>
        </div>
    </div>
</section>

@include('partials.footer')

<style>
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
    
    .hero-title {
        font-size: clamp(2.5rem, 6vw, 5.5rem);
        line-height: 1;
        font-weight: 950;
        letter-spacing: -3px;
        margin-bottom: 2rem;
    }

    .hero-cta-btn {
        padding: 1rem 2rem;
        font-size: 1rem;
        border-radius: 99px;
        box-shadow: 0 20px 40px rgba(255, 75, 31, 0.3);
    }

    .hero-cta-full { display: none; }
    .hero-cta-short { display: inline; }

    @media (min-width: 768px) {
        .hero-cta-btn {
            padding: 1.5rem 3rem;
            font-size: 1.1rem;
        }
        .hero-cta-full { display: inline; }
        .hero-cta-short { display: none; }
    }

    .section-header-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 3rem;
        gap: 1rem;
    }

    .section-title-responsive {
        font-size: clamp(1.75rem, 4vw, 3rem);
        font-weight: 900;
        margin-top: 0.5rem;
        letter-spacing: -1px;
    }

    .cta-card {
        background: linear-gradient(135deg, #ff8c2d 0%, #ff4b1f 100%);
        padding: 5rem;
        border-radius: 50px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 40px 100px -20px rgba(255, 75, 31, 0.4);
    }

    .live-card-home:hover {
        transform: scale(1.05) translateY(-5px);
    }
    
    .creator-card-social:hover {
        background: rgba(255,255,255,0.06) !important;
        transform: translateY(-10px);
        border-color: #ff4b1f !important;
    }
    
    .mogram-btn-primary:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(255, 75, 31, 0.4) !important;
    }

    @media (max-width: 768px) {
        .hero-title {
            letter-spacing: -2px;
        }

        .section-header-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .cta-card {
            padding: 3rem 1.5rem;
            border-radius: 24px;
        }

        .cta-card h2 {
            font-size: 1.75rem !important;
        }

        .cta-card p {
            font-size: 1rem !important;
        }

        .cta-card a {
            padding: 1rem 2.5rem !important;
            font-size: 1rem !important;
        }
    }
</style>
@endsection
