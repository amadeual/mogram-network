@extends('layouts.app')

@section('title', 'Explorar Comunidades | Mogram')

@section('content')
<div class="app-layout" style="background: #000; color: white; font-family: 'Inter', sans-serif; min-height: 100vh;">
    @include('partials.sidebar')

    <main class="main-content" style="margin-left: 280px; width: calc(100% - 280px); min-height: 100vh; display: flex; flex-direction: column;">
        
        <!-- Premium Header -->
        <header style="height: 70px; padding: 0 40px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.03); background: rgba(0,0,0,0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;">
            <div style="display: flex; align-items: center; gap: 30px;">
                <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Explorar</h2>
                <nav style="display: flex; gap: 24px;">
                    <a href="{{ route('communities.my') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700;">Minhas Comunidades</a>
                    <a href="{{ route('chat.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700;">Mensagens</a>
                    <a href="{{ route('studio.dashboard') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700;">Painel</a>
                </nav>
            </div>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.1);">
            </div>
        </header>

        <div style="flex: 1; padding: 60px 5%; max-width: 1400px; margin: 0 auto; width: 100%;">
            
            <!-- Hero Search Section -->
            <div style="text-align: center; margin-bottom: 60px;">
                <h1 style="font-size: 48px; font-weight: 900; letter-spacing: -2px; margin-bottom: 20px;">Explorar Comunidades</h1>
                <p style="font-size: 18px; color: rgba(255,255,255,0.6); font-weight: 500; margin-bottom: 40px;">Encontre e conecte-se com os melhores criadores do Mogram. Acesse<br>conteúdos exclusivos e cresça com a sua tribo.</p>
                
                <form action="{{ route('communities.index') }}" method="GET" style="max-width: 700px; margin: 0 auto; position: relative; margin-bottom: 30px;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 24px; color: rgba(255,255,255,0.3);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, nicho ou criador..." 
                               style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 50px; padding: 20px 140px 20px 60px; color: white; font-size: 16px; font-weight: 600; outline: none; transition: 0.3s; focus: border-color: #3390ec;">
                        <button type="submit" style="position: absolute; right: 10px; background: #3390ec; color: white; border: none; border-radius: 50px; padding: 12px 30px; font-weight: 800; font-size: 14px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#2b7bcc'" onmouseout="this.style.background='#3390ec'">Buscar</button>
                    </div>
                </form>

                <!-- Category Pills -->
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    @foreach(['Todos', 'Games', 'Negócios', 'Arte', 'Música', 'Estilo de Vida', 'Tecnologia'] as $cat)
                        <a href="{{ route('communities.index', ['category' => $cat]) }}" 
                           style="padding: 10px 24px; border-radius: 50px; background: {{ request('category', 'Todos') == $cat ? '#3390ec' : 'rgba(255,255,255,0.04)' }}; border: 1px solid rgba(255,255,255,0.05); color: {{ request('category', 'Todos') == $cat ? 'white' : 'rgba(255,255,255,0.6)' }}; text-decoration: none; font-size: 14px; font-weight: 700; transition: 0.2s;"
                           onmouseover="this.style.background='rgba(51, 144, 236, 0.1)'; this.style.color='white'"
                           onmouseout="this.style.background='{{ request('category', 'Todos') == $cat ? '#3390ec' : 'rgba(255,255,255,0.04)' }}'; this.style.color='{{ request('category', 'Todos') == $cat ? 'white' : 'rgba(255,255,255,0.6)' }}'">
                           {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Recommended Section -->
            <div style="margin-bottom: 80px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="color: #3390ec;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </span>
                        <h2 style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Recomendados para Você</h2>
                    </div>
                    <a href="#" style="color: #3390ec; text-decoration: none; font-weight: 800; font-size: 13px;">Ver tudo</a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                    @forelse($recommended as $c)
                    <div class="premium-card">
                        <div style="height: 180px; position: relative;">
                            <img src="{{ $c->banner ? Storage::url($c->banner) : 'https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=800' }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 24px 24px 0 0;">
                            <div style="position: absolute; top: 15px; right: 15px; background: #3390ec; color: white; padding: 6px 14px; border-radius: 50px; font-weight: 900; font-size: 11px; letter-spacing: 0.5px;">
                                {{ $c->price > 0 ? 'R$ '.number_format($c->price, 2, ',', '.').'/MÊS' : 'GRATUITO' }}
                            </div>
                        </div>
                        <div style="padding: 25px; background: #111; border-radius: 0 0 24px 24px; border: 1px solid rgba(255,255,255,0.05); border-top: none; position: relative;">
                            <div style="position: absolute; top: -35px; left: 25px; width: 60px; height: 60px; border-radius: 18px; overflow: hidden; border: 4px solid #111; box-shadow: 0 10px 20px rgba(0,0,0,0.5);">
                                <img src="{{ $c->avatar ? Storage::url($c->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$c->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div style="margin-top: 30px;">
                                <h3 style="font-size: 18px; font-weight: 840; margin-bottom: 8px;">{{ $c->name }}</h3>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.5; margin-bottom: 20px; height: 3em; overflow: hidden;">{{ Str::limit($c->description, 80) }}</p>
                                
                                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: rgba(255,255,255,0.4); font-weight: 700;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        {{ number_format($c->subscriptions_count ?? 1200, 0, ',', '.') }} membros
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #fbbf24; font-weight: 800;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        4.9
                                    </div>
                                </div>

                                <div style="display: flex; gap: 10px;">
                                    <a href="{{ route('communities.show', $c->slug) }}" style="flex: 1; background: #3390ec; color: white; text-align: center; padding: 14px; border-radius: 14px; font-weight: 800; font-size: 13px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Participar</a>
                                    <button style="width: 45px; height: 45px; border-radius: 14px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: white; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>

            <!-- Categories Grid -->
            <div style="margin-bottom: 100px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                    <h2 style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Descobrir Categorias</h2>
                    <div style="display: flex; gap: 10px;">
                        <button class="arrow-btn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
                        <button class="arrow-btn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    @foreach($allCommunities->skip(3)->take(8) as $c)
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 15px; display: flex; gap: 15px; align-items: center; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.05)'">
                        <div style="width: 80px; height: 80px; border-radius: 12px; overflow: hidden; flex-shrink: 0; position: relative;">
                            <img src="{{ $c->avatar ? Storage::url($c->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$c->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 5px; right: 5px; background: #22c55e; color: white; font-size: 7px; font-weight: 940; padding: 2px 5px; border-radius: 4px; border: 1px solid rgba(0,0,0,0.2);">
                                {{ $c->price > 0 ? 'R$ '.number_format($c->price, 0) : 'GRATUITO' }}
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $c->name }}</h4>
                            <p style="font-size: 11px; color: rgba(255,255,255,0.4); font-weight: 700; margin-bottom: 8px;">{{ number_format(rand(100, 10000)) }} membros</p>
                            <a href="{{ route('communities.show', $c->slug) }}" style="color: #3390ec; font-size: 11px; font-weight: 900; text-decoration: none;">Ver Detalhes</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Create Community Banner -->
            <div style="background: linear-gradient(135deg, #110e2e 0%, #05040d 100%); border: 1px solid rgba(51,144,236,0.1); border-radius: 40px; padding: 60px; text-align: center; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(51,144,236,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -100px; left: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(51,144,236,0.05) 0%, transparent 70%); border-radius: 50%;"></div>
                
                <h2 style="font-size: 36px; font-weight: 900; margin-bottom: 15px; letter-spacing: -1px;">Crie sua própria comunidade</h2>
                <p style="font-size: 16px; color: rgba(255,255,255,0.5); font-weight: 600; margin-bottom: 40px;">Comece a monetizar seu conteúdo hoje mesmo com as melhores<br>ferramentas do mercado.</p>
                <button onclick="openCreateModal()" style="background: #3390ec; color: white; border: none; border-radius: 50px; padding: 18px 45px; font-weight: 900; font-size: 15px; cursor: pointer; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3); transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Criar agora</button>
            </div>

        </div>

        <!-- Detailed Footer -->
        <footer style="background: #000; border-top: 1px solid rgba(255,255,255,0.03); padding: 80px 5% 40px;">
            <div style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 60px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                            <defs><linearGradient id="footerLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                            <rect width="512" height="512" rx="100" fill="url(#footerLogoGrad)" />
                            <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                        </svg>
                        <span style="font-size: 20px; font-weight: 900; letter-spacing: -0.5px;">Mogram</span>
                    </div>
                    <p style="color: rgba(255,255,255,0.4); font-size: 14px; line-height: 1.6; max-width: 300px; font-weight: 600;">A plataforma definitiva para criadores de elite. Transforme sua audiência em uma comunidade lucrativa.</p>
                </div>

                <div>
                    <h4 style="font-size: 14px; font-weight: 840; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px;">Plataforma</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px;">
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">Explorar</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">Recursos</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">Preços</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-size: 14px; font-weight: 840; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px;">Suporte</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px;">
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">FAQ</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">Central de Ajuda</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 13px; font-weight: 700;">Termos de Uso</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-size: 14px; font-weight: 840; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px;">Newsletter</h4>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="email" placeholder="Seu email" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 15px; color: white; font-size: 14px; outline: none;">
                        <button style="position: absolute; right: 8px; width: 32px; height: 32px; border-radius: 8px; background: #3390ec; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="22 2 11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div style="max-width: 1400px; margin: 60px auto 0; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.03); display: flex; justify-content: space-between; align-items: center;">
                <p style="color: rgba(255,255,255,0.2); font-size: 12px; font-weight: 700;">&copy; 2024 Mogram. Todos os direitos reservados.</p>
                <div style="display: flex; gap: 24px;">
                    <a href="#" style="color: rgba(255,255,255,0.3); text-decoration: none; font-size: 12px; font-weight: 800;">Instagram</a>
                    <a href="#" style="color: rgba(255,255,255,0.3); text-decoration: none; font-size: 12px; font-weight: 800;">TikTok</a>
                    <a href="#" style="color: rgba(255,255,255,0.3); text-decoration: none; font-size: 12px; font-weight: 800;">Telegram</a>
                </div>
            </div>
        </footer>
    </main>
</div>

<!-- Create Community Modal -->
<div id="createCommunityModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 20000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #111; border: 1px solid rgba(255,255,255,0.08); border-radius: 32px; padding: 2.5rem; width: 100%; max-width: 550px; box-shadow: 0 40px 100px rgba(0,0,0,0.8); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.5rem; font-weight: 940; color: white; letter-spacing: -1px;">Inicie sua Tribo</h3>
            <button onclick="closeCreateModal()" style="background: rgba(255,255,255,0.05); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 12px; font-weight: 840; color: rgba(255,255,255,0.4); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Nome da Comunidade</label>
                <input type="text" name="name" required style="width: 100%; background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 18px 20px; color: white; font-size: 15px; font-weight: 700; outline: none; transition: 0.3s;" placeholder="Ex: Elite Design Academy">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 12px; font-weight: 840; color: rgba(255,255,255,0.4); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Categoria</label>
                <select name="category" required style="width: 100%; background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 18px 20px; color: white; font-size: 15px; font-weight: 700; outline: none; transition: 0.3s; appearance: none; cursor: pointer;">
                    @foreach(['Games', 'Negócios', 'Arte', 'Música', 'Estilo de Vida', 'Tecnologia'] as $cat)
                        <option value="{{ $cat }}" style="background: #111;">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 12px; font-weight: 840; color: rgba(255,255,255,0.4); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Visão Geral</label>
                <textarea name="description" rows="3" style="width: 100%; background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 18px 20px; color: white; font-size: 15px; font-weight: 700; outline: none; transition: 0.3s; resize: none;" placeholder="Descreva brevemente sua proposta de valor..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 840; color: rgba(255,255,255,0.4); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Acesso Mensal (R$)</label>
                    <input type="number" name="price" step="0.01" min="5" max="250000" required value="49.90" style="width: 100%; background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 18px 20px; color: white; font-size: 15px; font-weight: 900; outline: none; transition: 0.3s;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 840; color: rgba(255,255,255,0.4); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Avatar do Criador</label>
                    <div onclick="document.getElementById('avatar-input').click()" style="width: 100%; height: 56px; background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s;">
                        <span id="avatar-status-text" style="color: rgba(255,255,255,0.4); font-size: 13px; font-weight: 800;">Selecionar Foto</span>
                        <input type="file" id="avatar-input" name="avatar" style="display: none;" onchange="updateFileLabel(this, 'avatar-status-text')">
                    </div>
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 20px; border-radius: 18px; font-weight: 900; font-size: 15px; border: none; background: #3390ec; color: white; cursor: pointer; box-shadow: 0 15px 35px rgba(51, 144, 236, 0.3); transition: 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 45px rgba(51, 144, 236, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(51, 144, 236, 0.3)'">Lançar Comunidade</button>
        </form>
    </div>
</div>

<style>
    .premium-card {
        background: #111;
        border-radius: 24px;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .premium-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 40px 80px rgba(0,0,0,0.6);
    }
    .arrow-btn {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .arrow-btn:hover {
        background: #3390ec;
        border-color: #3390ec;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    /* Hide default scrollbar for categories if needed */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function openCreateModal() {
        document.getElementById('createCommunityModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeCreateModal() {
        document.getElementById('createCommunityModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    function updateFileLabel(input, labelId) {
        if (input.files && input.files[0]) {
            document.getElementById(labelId).innerText = 'Foto Selecionada ✓';
            document.getElementById(labelId).style.color = '#22c55e';
        }
    }
</script>
@endsection
