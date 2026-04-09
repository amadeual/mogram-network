@extends('layouts.app')

@section('title', 'Mogram - Criar Conteúdo')

@section('content')
<div class="dash-layout">
    <!-- Left Sidebar -->
    <aside class="sidebar">
        <div class="logo" style="display: flex; align-items: center; gap: 10px; margin-bottom: 3rem;">
            <div style="width: 35px; height: 35px; background: var(--primary-blue); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z"/></svg>
            </div>
            <span style="font-size: 1.5rem; font-weight: 800;">Mogram</span>
        </div>

        <nav style="flex: 1;">
            <a href="/dashboard" class="sidebar-item">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                Início
            </a>
            <a href="/stories" class="sidebar-item">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
                Stories
            </a>
            <a href="/create" class="sidebar-item active">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
                Criar
            </a>
            <a href="/lives" class="sidebar-item">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                Lives
            </a>
        </nav>

        <div style="background: rgba(255,255,255,0.03); border-radius: 16px; padding: 1rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem; margin-top: 2rem;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #444; border: 2px solid var(--primary-blue); background-image: url('{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->name }}'); background-size: cover;"></div>
            <div style="flex: 1;">
                <p style="font-size: 0.85rem; font-weight: 700;">{{ auth()->user()->name }}</p>
                <p style="font-size: 0.75rem; color: var(--text-gray);">@<span>{{ auth()->user()->username }}</span></p>
            </div>
        </div>
    </aside>

    <main class="main-content" style="padding: 1.5rem 3rem;">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <p style="font-size: 0.8rem; color: var(--text-gray); margin-bottom: 0.5rem;">Início › <span style="color: white;">Criar Novo Post</span></p>
                <h2 style="font-size: 2rem; font-weight: 800;">Editor de Conteúdo</h2>
                <p style="color: var(--text-gray); font-size: 0.9rem;">Configure seu conteúdo e monetize sua audiência com facilidade.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn btn-outline" style="padding: 0.8rem 1.5rem; border-radius: 12px; border: 1px solid var(--border-color); background: rgba(255,255,255,0.05);">Visualizar</button>
                <button id="publish-btn" class="btn btn-primary" style="padding: 0.8rem 2rem; border-radius: 12px; font-weight: 700;">Publicar Agora</button>
            </div>
        </header>

        <div class="editor-layout">
            <div class="editor-main">
                <div class="editor-card">
                    <div class="editor-toolbar">
                        <button class="toolbar-btn" onmousedown="event.preventDefault(); document.execCommand('bold', false, null);"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M15.6 10.79c.97-.67 1.65-1.77 1.65-2.79 0-2.26-1.75-4-4-4H7v14h7.04c2.09 0 3.71-1.7 3.71-3.79 0-1.52-.86-2.82-2.15-3.42zM10 6.5h3c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-3v-3zm3.5 9H10v-3h3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5z"/></svg></button>
                        <button class="toolbar-btn" onmousedown="event.preventDefault(); document.execCommand('italic', false, null);"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"/></svg></button>
                        <button class="toolbar-btn" onmousedown="event.preventDefault(); document.execCommand('underline', false, null);"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17c3.31 0 6-2.69 6-6V3h-2.5v8c0 1.93-1.57 3.5-3.5 3.5S8.5 12.93 8.5 11V3H6v8c0 3.31 2.69 6 6 6zm-7 2v2h14v-2H5z"/></svg></button>
                        <div style="width: 1px; background: var(--border-color); height: 20px; align-self: center;"></div>
                        
                        <div class="emoji-picker-container">
                            <button class="toolbar-btn" id="emoji-trigger" onclick="toggleEmojiPalette('editor-emoji-palette')">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                            </button>
                            <div id="editor-emoji-palette" class="emoji-palette" style="bottom: auto; top: 100%; left: 0;">
                                <div class="emoji-btn" onclick="insertEmoji('editor', '😊')">😊</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '🔥')">🔥</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '🎉')">🎉</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '❤️')">❤️</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '🚀')">🚀</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '✨')">✨</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '📸')">📸</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '🌅')">🌅</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '👏')">👏</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '🙌')">🙌</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '💰')">💰</div>
                                <div class="emoji-btn" onclick="insertEmoji('editor', '📍')">📍</div>
                            </div>
                        </div>

                        <span style="margin-left: auto; font-size: 0.7rem; font-weight: 800; letter-spacing: 1px;">EDITOR PREMIUM</span>
                    </div>
                    <input type="text" id="post-title" placeholder="Título do Post (opcional)" style="width: 100%; background: transparent; border: none; font-size: 1.5rem; font-weight: 700; color: white; margin-bottom: 2rem; outline: none;">
                    <div id="post-content" contenteditable="true" class="rich-editor" data-placeholder="O que você está pensando? Escreva sua legenda aqui..."></div>
                </div>

                <div class="editor-card" style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <p style="font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <svg width="20" height="20" fill="var(--primary-blue)" viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg> 
                            Mídia do Post
                        </p>
                        <span style="font-size: 0.75rem; color: #555;">Máx. 10 arquivos (Fotos, Vídeos ou PDFs)</span>
                    </div>
                    <input type="file" id="media-input" multiple accept="image/*,video/*,application/pdf" style="display: none;">
                    <div class="upload-area" onclick="document.getElementById('media-input').click()">
                        <div style="width: 44px; height: 44px; background: rgba(0,133,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <svg width="24" height="24" fill="var(--primary-blue)" viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                        </div>
                        <p style="font-weight: 700; margin-bottom: 0.5rem;">Arraste e solte seus arquivos aqui</p>
                    </div>
                    <div id="media-preview-container" class="media-grid"></div>
                </div>
            </div>

            <div class="editor-side">
                <div class="editor-card">
                    <p style="font-weight: 700; display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
                        <svg width="20" height="20" fill="var(--primary-blue)" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                        Visibilidade e Preço
                    </p>
                    <div class="tab-group">
                        <div id="tab-gratis" class="tab-btn active" onclick="switchMode('gratis')">Grátis</div>
                        <div id="tab-pago" class="tab-btn" onclick="switchMode('pago')">Pago</div>
                    </div>
                    <div id="price-section" style="opacity: 0.3; pointer-events: none; transition: 0.3s;">
                        <p style="font-size: 0.7rem; font-weight: 800; color: var(--text-gray); text-transform: none;">Preço do Post (BRL)</p>
                        <div class="price-input-wrapper">
                            <span class="price-prefix">R$</span>
                            <input type="text" id="price-input" class="price-input" value="0.00">
                        </div>
                    </div>
                </div>

                <div class="editor-card">
                    <p style="font-size: 0.75rem; font-weight: 700; margin-bottom: 0.8rem;">AGENDAR PUBLICAÇÃO</p>
                    <div class="dropdown-container">
                        <div id="schedule-box" onclick="toggleSchedule()" style="background: #1C222D; padding: 1rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border-color); cursor: pointer;">
                            <div style="flex: 1;">
                                <p id="schedule-title" style="font-size: 0.9rem; font-weight: 700;">Imediata</p>
                                <p id="schedule-desc" style="font-size: 0.7rem; color: #555;">Publicar assim que salvar</p>
                            </div>
                        </div>
                        <div id="schedule-menu" class="dropdown-menu">
                            <div class="dropdown-item" onclick="selectSchedule('Imediata', 'Publicar assim que salvar')">Imediata</div>
                            <div class="dropdown-item" onclick="selectSchedule('Agendar', 'Escolher data e hora')">Agendar Publicação</div>
                        </div>
                    </div>
                    <input type="datetime-local" id="calendar-input" class="schedule-input">
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Emoji Library
    function toggleEmojiPalette(id) {
        document.getElementById(id).classList.toggle('show');
    }

    function insertEmoji(target, emoji) {
        if (target === 'editor') {
            document.getElementById('post-content').focus();
            document.execCommand('insertText', false, emoji);
            document.getElementById('editor-emoji-palette').classList.remove('show');
        }
    }

    // Media Logic
    const mediaInput = document.getElementById('media-input');
    const previewContainer = document.getElementById('media-preview-container');
    let selectedFiles = [];

    mediaInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        files.forEach(file => {
            selectedFiles.push(file);
            const url = URL.createObjectURL(file);
            const thumb = document.createElement('div');
            thumb.className = 'media-item';
            thumb.innerHTML = `<img src="${url}" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; top:4px; right:4px; background:rgba(0,0,0,0.5); width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;" onclick="this.parentElement.remove()">×</div>`;
            previewContainer.appendChild(thumb);
        });
    });

    // Tab Logic
    function switchMode(mode) {
        document.getElementById('tab-gratis').classList.toggle('active', mode === 'gratis');
        document.getElementById('tab-pago').classList.toggle('active', mode === 'pago');
        const priceSection = document.getElementById('price-section');
        priceSection.style.opacity = mode === 'gratis' ? '0.3' : '1';
        priceSection.style.pointerEvents = mode === 'gratis' ? 'none' : 'all';
    }

    // Schedule
    function toggleSchedule() { document.getElementById('schedule-menu').classList.toggle('show'); }
    function selectSchedule(t, d) {
        document.getElementById('schedule-title').innerText = t;
        document.getElementById('schedule-desc').innerText = d;
        document.getElementById('schedule-menu').classList.remove('show');
        document.getElementById('calendar-input').classList.toggle('show', t === 'Agendar');
    }

    // Publish
    document.getElementById('publish-btn').addEventListener('click', () => {
        const postContent = document.getElementById('post-content');
        if (postContent.innerText.trim() === '') { alert('Escreva algo.'); return; }
        const newPost = {
            id: Date.now(),
            content: postContent.innerHTML,
            user: '{{ auth()->user()->name }}',
            image: selectedFiles.length > 0 ? URL.createObjectURL(selectedFiles[0]) : '/images/thumb_plant.png',
            time: 'Agora mesmo',
            type: document.getElementById('tab-pago').classList.contains('active') ? 'locked' : 'standard',
            price: document.getElementById('price-input').value
        };
        const existing = JSON.parse(localStorage.getItem('mogram_new_posts') || '[]');
        existing.unshift(newPost);
        localStorage.setItem('mogram_new_posts', JSON.stringify(existing));
        window.location.href = '/dashboard';
    });
</script>
@endsection
