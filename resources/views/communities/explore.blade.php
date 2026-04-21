@extends('layouts.app')

@section('title', 'Explorar Comunidades | Mogram')

@section('content')
<div class="app-layout" style="background: #000; color: white; font-family: 'Inter', sans-serif; min-height: 100vh; overflow-x: hidden;">
    @include('partials.sidebar')

    <main class="main-content">
        
        <!-- Premium Header -->
        <header class="communities-explore-header" style="border-bottom: 1px solid rgba(255,255,255,0.03); background: rgba(0,0,0,0.8); backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 30px;">
                <h2 style="font-size: 1.25rem; font-weight: 900; color: white; letter-spacing: -0.5px;">Explorar</h2>
                <nav style="display: flex; gap: 24px;">
                    <a href="{{ route('communities.my') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700;">Minhas</a>
                    <a href="{{ route('chat.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; font-weight: 700;">Mensagens</a>
                </nav>
            </div>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.1);">
            </div>
        </header>

        <div class="explore-container" style="flex: 1; padding: 40px 12px; max-width: 1400px; margin: 0 auto; width: 100%; box-sizing: border-box;">
            
            <!-- Hero Search Section -->
            <div style="text-align: center; margin-bottom: 60px;">
                <h1 class="communities-hero-title" style="font-size: clamp(2rem, 8vw, 3rem); font-weight: 900; letter-spacing: -2px; margin-bottom: 20px;">Explorar Comunidades</h1>
                <p class="communities-hero-subtitle" style="font-size: clamp(1rem, 3vw, 1.125rem); color: rgba(255,255,255,0.6); font-weight: 500; margin-bottom: 40px;">Encontre e conecte-se com os melhores criadores do Mogram.</p>
                
                <form action="{{ route('communities.explore') }}" method="GET" style="max-width: 700px; margin: 0 auto; position: relative; margin-bottom: 30px;">
                    <div style="position: relative; display: flex; align-items: center; flex-direction: inherit;" class="communities-search-container">
                        <span style="position: absolute; left: 24px; color: rgba(255,255,255,0.3);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar..." class="communities-search-input"
                               style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 50px; padding: 20px 140px 20px 60px; color: white; font-size: 16px; font-weight: 600; outline: none; transition: 0.3s;">
                        <button type="submit" class="communities-search-btn" style="position: absolute; right: 10px; background: #3390ec; color: white; border: none; border-radius: 50px; padding: 12px 30px; font-weight: 800; font-size: 14px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#2b7bcc'" onmouseout="this.style.background='#3390ec'">Buscar</button>
                    </div>
                </form>

                <!-- Category Pills -->
                <div class="communities-category-pills" style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    @foreach(['Todos', 'Games', 'Negócios', 'Arte', 'Música', 'Estilo de Vida', 'Tecnologia'] as $cat)
                        <a href="{{ route('communities.explore', ['category' => $cat]) }}" 
                           style="padding: 10px 24px; border-radius: 50px; background: {{ request('category', 'Todos') == $cat ? '#3390ec' : 'rgba(255,255,255,0.04)' }}; border: 1px solid rgba(255,255,255,0.05); color: {{ request('category', 'Todos') == $cat ? 'white' : 'rgba(255,255,255,0.6)' }}; text-decoration: none; font-size: 14px; font-weight: 700; transition: 0.2s; white-space: nowrap;">
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
                        <h2 class="communities-section-title" style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Recomendados</h2>
                    </div>
                    <a href="#" style="color: #3390ec; text-decoration: none; font-weight: 800; font-size: 13px;">Ver tudo</a>
                </div>

                <div class="premium-card-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">
                    @forelse($recommended as $c)
                    <div class="premium-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 24px; overflow: hidden; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; width: 100%;">
                        <div style="height: 160px; position: relative; overflow: hidden;" class="card-banner-wrapper">
                            <img src="{{ $c->banner ? Storage::url($c->banner) : 'https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=800' }}" style="width: 100%; height: 100%; object-fit: cover; transition: 0.6s ease;" class="card-banner">
                            <div style="position: absolute; top: 12px; right: 12px; background: rgba(51, 144, 236, 0.9); backdrop-filter: blur(10px); color: white; padding: 4px 12px; border-radius: 50px; font-weight: 900; font-size: 10px; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(51, 144, 236, 0.3);">
                                {{ $c->price > 0 ? 'R$ '.number_format($c->price, 2, ',', '.').'/M' : 'GRÁTIS' }}
                            </div>
                            <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,0.8)); opacity: 0.8;"></div>
                        </div>
                        
                        <div style="padding: 20px; position: relative; z-index: 2;">
                            <div style="position: absolute; top: -35px; left: 20px; width: 60px; height: 60px; border-radius: 16px; overflow: hidden; border: 3px solid #0b0a15; box-shadow: 0 10px 30px rgba(0,0,0,0.8); background: #1a1a1a;">
                                <img src="{{ $c->avatar ? Storage::url($c->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$c->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div style="margin-top: 30px;">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px;">
                                    <h3 style="font-size: 18px; font-weight: 850; letter-spacing: -0.4px; color: white; margin: 0; line-height: 1.2;">{{ $c->name }}</h3>
                                    <div style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; padding: 2px 6px; border-radius: 6px; font-size: 10px; font-weight: 900; display: flex; align-items: center; gap: 3px; flex-shrink: 0;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        4.9
                                    </div>
                                </div>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.5; margin-bottom: 20px; height: 3em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 500;">{{ $c->description }}</p>
                                
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 10px 14px; background: rgba(255,255,255,0.03); border-radius: 12px;">
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-size: 9px; color: rgba(255,255,255,0.3); font-weight: 800; text-transform: uppercase;">Membros</span>
                                        <span style="font-size: 13px; font-weight: 850; color: white;">{{ number_format($c->members_count, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.06);"></div>
                                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                        <span style="font-size: 9px; color: rgba(255,255,255,0.3); font-weight: 800; text-transform: uppercase;">Categoria</span>
                                        <span style="font-size: 11px; font-weight: 800; color: #3390ec;">{{ $c->category }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('communities.show', $c->slug) }}" class="community-card-btn" style="display: block; width: 100%; background: #3390ec; color: white; text-align: center; padding: 12px; border-radius: 14px; font-weight: 900; font-size: 13px; text-decoration: none; transition: 0.3s; box-shadow: 0 4px 15px rgba(51, 144, 236, 0.2);">Acessar Tribo</a>
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
                    <h2 class="communities-section-title" style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px;">Descobrir Mais</h2>
                </div>

                <div class="categories-grid-small" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
                    @foreach($allCommunities->skip(3)->take(8) as $c)
                    <div class="small-community-item" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 10px; display: flex; gap: 12px; align-items: center; cursor: pointer; transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; width: 100%;" onclick="window.location.href='{{ route('communities.show', $c->slug) }}'">
                        <div style="width: 56px; height: 56px; border-radius: 12px; overflow: hidden; flex-shrink: 0; position: relative; z-index: 2;">
                            <img src="{{ $c->avatar ? Storage::url($c->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$c->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="flex: 1; min-width: 0; position: relative; z-index: 2;">
                            <h4 style="font-size: 14px; font-weight: 800; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: white;">{{ $c->name }}</h4>
                            <p style="font-size: 10px; color: rgba(255,255,255,0.4); font-weight: 700; margin-bottom: 4px;">{{ number_format($c->members_count, 0, ',', '.') }} membros</p>
                            <span style="display: inline-flex; align-items: center; gap: 4px; color: #3390ec; font-size: 10px; font-weight: 900;">
                                Ver
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </span>
                        </div>
                        <div class="item-hover-effect" style="position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(51,144,236,0.03)); opacity: 0; transition: 0.3s;"></div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Create Community Banner -->
            <div class="cta-banner" style="background: linear-gradient(135deg, #110e2e 0%, #05040d 100%); border: 1px solid rgba(51,144,236,0.1); border-radius: 24px; padding: 40px 16px; text-align: center; position: relative; overflow: hidden;">
                <h2 style="font-size: clamp(1.25rem, 5vw, 2rem); font-weight: 900; margin-bottom: 12px; letter-spacing: -0.5px;">Crie sua comunidade</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.5); font-weight: 600; margin-bottom: 30px;">Comece a monetizar seu conteúdo hoje.</p>
                <button onclick="openCreateModal()" style="background: #3390ec; color: white; border: none; border-radius: 50px; padding: 14px 36px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 10px 30px rgba(51, 144, 236, 0.3); transition: 0.3s;">Criar agora</button>
            </div>

        </div>

        <!-- Simplified Mobile-First Footer -->
        <footer style="background: #000; border-top: 1px solid rgba(255,255,255,0.03); padding: 30px 12px 20px; overflow: hidden; box-sizing: border-box;">
            <div class="communities-footer" style="max-width: 1400px; margin: 0 auto;">
                <div style="margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                            <defs><linearGradient id="footerLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                            <rect width="512" height="512" rx="100" fill="url(#footerLogoGrad)" />
                            <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                        </svg>
                        <span style="font-size: 18px; font-weight: 900; letter-spacing: -0.5px;">Mogram</span>
                    </div>
                    <p style="color: rgba(255,255,255,0.4); font-size: 13px; line-height: 1.6; font-weight: 600;">A plataforma definitiva para criadores de elite.</p>
                </div>

                <div class="footer-links-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <h4 style="font-size: 12px; font-weight: 840; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.5px; color: white;">Plataforma</h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                            <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">Explorar</a></li>
                            <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">Recursos</a></li>
                            <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">Preços</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 style="font-size: 12px; font-weight: 840; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.5px; color: white;">Suporte</h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                            <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">FAQ</a></li>
                            <li><a href="{{ route('help') }}" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">Central de Ajuda</a></li>
                            <li><a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 12px; font-weight: 700;">Termos de Uso</a></li>
                        </ul>
                    </div>
                </div>

                <div style="margin-bottom: 24px; max-width: 300px;">
                    <h4 style="font-size: 12px; font-weight: 840; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: white;">Newsletter</h4>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="email" name="email" placeholder="Seu email" required style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 10px 40px 10px 12px; color: white; font-size: 13px; outline: none; box-sizing: border-box;">
                            <button type="submit" style="position: absolute; right: 6px; width: 28px; height: 28px; border-radius: 6px; background: #3390ec; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="22 2 11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            </button>
                        </div>
                        @error('email')
                            <p style="color: #ef4444; font-size: 11px; margin-top: 5px; font-weight: 600;">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>

            <div style="max-width: 1400px; margin: 0 auto; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.03); display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; text-align: center;">
                <p style="color: rgba(255,255,255,0.2); font-size: 11px; font-weight: 700; width: 100%;">&copy; 2024 Mogram. Todos os direitos reservados.</p>
                <div style="display: flex; gap: 16px;">
                    <a href="https://www.instagram.com/mogramlatam" target="_blank" style="color: rgba(255,255,255,0.3); text-decoration: none; font-size: 11px; font-weight: 800;">Instagram</a>
                    <a href="https://www.tiktok.com/@mogramnetwork" target="_blank" style="color: rgba(255,255,255,0.3); text-decoration: none; font-size: 11px; font-weight: 800;">TikTok</a>
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
    .premium-card:hover .card-banner {
        transform: scale(1.05);
    }
    .premium-card:hover .card-overlay {
        opacity: 1 !important;
    }
    .premium-card:hover {
        border-color: rgba(51, 144, 236, 0.4) !important;
        box-shadow: 0 40px 80px rgba(0,0,0,0.6);
    }
    .small-community-item:hover {
        background: rgba(255,255,255,0.05) !important;
        border-color: rgba(255,255,255,0.1) !important;
        transform: translateY(-4px);
    }
    .small-community-item:hover .item-hover-effect {
        opacity: 1 !important;
    }
    .community-card-btn:hover {
        background: #2b7bcc !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(51, 144, 236, 0.4) !important;
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
