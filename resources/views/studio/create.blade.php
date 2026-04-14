@extends('layouts.app')

@section('title', 'Editor de Conteúdo - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include('partials.studio-sidebar')

    <!-- Main Content Area -->
    <main class="main-content">
        <form id="create_post_form" action="{{ route('studio.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAndSync()">
            @csrf
            
            <!-- Fixed Header -->
            <header class="studio-header" style="position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(30px); background: rgba(11, 10, 21, 0.95); border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 2.5rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); font-weight: 800;">
                        <span>Início</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                        <span style="color: white; opacity: 0.7;">Novo Post</span>
                    </div>
                </div>
                <div style="display: flex; gap: 1.25rem; align-items: center;">
                    <a href="{{ route('studio.dashboard') }}" style="color: var(--text-muted); font-size: 13px; font-weight: 800; text-decoration: none; padding: 0.875rem 1.5rem; border-radius: 12px; border: 1.5px solid rgba(255,255,255,0.05); transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.03)';this.style.color='white'" onmouseout="this.style.background='transparent';this.style.color='var(--text-muted)'">
                        Cancelar
                    </a>
                    <button type="submit" class="mogram-btn-primary" style="padding: 0.875rem 2.5rem; border-radius: 12px; font-weight: 950; font-size: 13px; display: flex; align-items: center; gap: 10px; border: none; cursor: pointer; background: #3390ec; color: white; box-shadow: 0 4px 15px rgba(51, 144, 236, 0.3);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Publicar
                    </button>
                </div>
            </header>

            <div class="studio-body" style="display: grid; grid-template-columns: 1fr 340px; gap: 4rem; padding: 3rem 2.5rem;">
                
                <!-- Left Side: Editor -->
                <div style="display: flex; flex-direction: column; gap: 2.5rem;">
                    <div>
                        <h1 style="font-size: 2.8rem; font-weight: 950; color: white; margin-bottom: 0.5rem; letter-spacing: -1.5px;">Editor de Conteúdo</h1>
                        <p style="color: var(--text-muted); font-size: 15px; font-weight: 700;">Configure seu conteúdo e monetize sua audiência com facilidade.</p>
                    </div>

                    @if(session('success'))
                    <div style="background: rgba(34,197,94,0.1); border: 1.5px solid rgba(34,197,94,0.2); border-radius: 16px; padding: 1rem 1.5rem; color: #22c55e; font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 12px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div style="background: rgba(239,68,68,0.1); border: 1.5px solid rgba(239,68,68,0.2); border-radius: 16px; padding: 1rem 1.5rem; color: #ef4444; font-weight: 800; font-size: 14px;">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Editor Box -->
                    <div style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; overflow: hidden;">
                        <div style="padding: 1rem 1.5rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.1);">
                            <div style="display: flex; align-items: center; gap: 1.5rem; color: var(--text-muted);">
                                <div style="display: flex; gap: 0.75rem;">
                                    <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('bold')" title="Negrito">B</button>
                                    <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('italic')" style="font-style: italic;" title="Itálico">I</button>
                                    <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('underline')" style="text-decoration: underline;" title="Sublinhado">S</button>
                                </div>
                                <div style="width: 1px; height: 16px; background: rgba(255,255,255,0.1);"></div>
                                <div style="display: flex; gap: 0.75rem; position: relative;">
                                    <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="toggleEmojiPicker()">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                                    </button>
                                    <!-- Emoji Picker Dropdown -->
                                    <div id="emoji_picker" style="display:none; position: absolute; top: 35px; left: 0; background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1rem; width: 280px; z-index: 200; box-shadow: 0 15px 40px rgba(0,0,0,0.5);">
                                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; font-size: 20px;">
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🔥')">🔥</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('✨')">✨</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('❤️')">❤️</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('😂')">😂</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🚀')">🚀</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('💎')">💎</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('📸')">📸</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🎥')">🎥</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🤩')">🤩</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('👋')">👋</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🙏')">🙏</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🎉')">🎉</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('💯')">💯</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('👀')">👀</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('😎')">😎</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('💥')">💥</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('💪')">💪</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🌟')">🌟</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('👑')">👑</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('💸')">💸</span>
                                            <span class="emoji-item" onmousedown="event.preventDefault();" onclick="insertEmoji('🖤')">🖤</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span style="font-size: 9px; font-weight: 900; color: #a855f7; text-transform: none; letter-spacing: 1px;">Editor Premium</span>
                        </div>
                        <div style="padding: 2rem; position: relative;">
                            <input type="text" name="title" placeholder="Título do Post" required
                                   style="background: transparent; border: none; font-size: 2rem; font-weight: 950; color: white; width: 100%; outline: none; margin-bottom: 1.5rem; letter-spacing: -1px;">
                            
                            <!-- Rich Editor -->
                            <div style="position: relative;">
                                <div id="editor_body" contenteditable="true" 
                                     style="background: transparent; border: none; font-size: 1.15rem; font-weight: 500; color: rgba(255,255,255,0.9); width: 100%; min-height: 250px; outline: none; line-height: 1.7; cursor: text; position: relative; z-index: 2;"
                                     oninput="syncEditor()"></div>
                                <p id="placeholder_custom" style="position: absolute; top: 0; left: 0; color: var(--text-muted); pointer-events: none; font-size: 1.15rem; font-weight: 500; z-index: 1;">O que você está pensando? Escreva sua legenda aqui...</p>
                            </div>
                            
                            <div style="display: flex; justify-content: flex-end; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.03); margin-top: 1rem;">
                                <span id="char_count_display" style="font-size: 11px; font-weight: 800; color: var(--text-muted);">0 / 2200</span>
                            </div>
                            <textarea name="description" id="description_input" hidden required maxlength="2200"></textarea>
                        </div>
                    </div>

                    <!-- Media Upload Box -->
                    <div style="background: #151621; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 28px; padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                            <div style="display: flex; align-items: center; gap: 12px; color: white;">
                                <div style="width: 36px; height: 36px; background: rgba(51, 144, 236, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M7 12h10"/><path d="M12 7v10"/></svg>
                                </div>
                                <h3 style="font-size: 16px; font-weight: 850;">{{ __('Mídia do Post') }}</h3>
                            </div>
                            <span style="font-size: 11px; color: var(--text-muted); font-weight: 700;">Máx. 50MB (Foto, Vídeo ou PDF)</span>
                        </div>

                        <div id="dropzone" style="border: 2px dashed rgba(255,255,255,0.08); border-radius: 24px; padding: 4rem 2rem; text-align: center; background: rgba(0,0,0,0.1); cursor: pointer; transition: 0.3s; margin-bottom: 2rem;">
                            <input type="file" name="file" id="file_input" accept="image/*,video/*,application/pdf" hidden required onchange="handleFileSelect(this)">
                            <input type="hidden" name="type" id="post_type_input" value="image">
                            <div style="width: 56px; height: 56px; background: rgba(51, 144, 236, 0.1); border-radius: 18px; display: flex; align-items: center; justify-content: center; color: #3390ec; margin: 0 auto 1.5rem;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/><polyline points="16 16 12 12 8 16"/></svg>
                            </div>
                            <h4 style="font-size: 18px; font-weight: 900; color: white; margin-bottom: 0.5rem;">{{ __('Arraste seu conteúdo aqui') }}</h4>
                            <p style="font-size: 14px; color: var(--text-muted); font-weight: 600;">ou <span style="color: #3390ec;">clique para procurar</span> no computador</p>
                        </div>

                        <div id="thumbnail_section" style="display: block; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 2rem; margin-top: 2rem;">
                            <div style="display: flex; align-items: center; gap: 12px; color: white; margin-bottom: 1.5rem;">
                                <div style="width: 32px; height: 32px; background: rgba(168, 85, 247, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <div>
                                    <h4 style="font-size: 14px; font-weight: 850;">Thumbnail (Capa)</h4>
                                    <p style="font-size: 10px; color: var(--text-muted);">Recomendado para Vídeos e PDFs</p>
                                </div>
                            </div>
                            <div onclick="document.getElementById('thumbnail_input').click()" style="width: 160px; height: 90px; border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; background: rgba(0,0,0,0.2); overflow: hidden;">
                                <input type="file" name="thumbnail" id="thumbnail_input" accept="image/*" hidden onchange="handleThumbnailSelect(this)">
                                <div id="thumbnail_preview_content" style="text-align: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); margin-bottom: 4px;"><path d="M12 5v14M5 12h14"/></svg>
                                    <span style="font-size: 10px; color: var(--text-muted); font-weight: 800;">Adicionar Capa</span>
                                </div>
                                <div id="thumbnail_img_preview" style="display: none; width: 100%; height: 100%;">
                                    <img src="" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <div id="media_previews_container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <!-- Previews will appear here -->
                        </div>
                    </div>
                </div>

                <!-- Right Side: Settings -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Visibility Panel -->
                    <div class="setting-card">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 2rem;">
                            <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            </div>
                            <h3 style="font-size: 14px; font-weight: 900; color: white;">Visibilidade e Preço</h3>
                        </div>

                        <div style="background: rgba(0,0,0,0.1); border-radius: 12px; padding: 4px; display: grid; grid-template-columns: 1fr 1fr; gap: 4px; margin-bottom: 1.5rem;">
                            <button type="button" class="tab-btn active" onclick="setPostPaid(false)">Grátis</button>
                            <button type="button" class="tab-btn" onclick="setPostPaid(true)">Pago</button>
                        </div>
                        <input type="hidden" name="is_paid" id="is_paid_input" value="0">

                        <div id="price_section" style="display: none;">
                            <label style="font-size: 10px; font-weight: 950; color: var(--text-muted); text-transform: none; margin-bottom: 8px; display: block;">Preço do Post (BRL)</label>
                            <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 1.25rem; display: flex; align-items: center;">
                                <span style="font-weight: 900; color: var(--text-muted); margin-right: 1rem;">R$</span>
                                <input type="number" name="price" id="price_input" value="5.00" step="0.01" min="5" style="background: transparent; border: none; font-size: 1.5rem; font-weight: 950; color: white; width: 100%; outline: none;" placeholder="5,00">
                            </div>
                            <p style="font-size: 10px; color: var(--text-muted); margin-top: 10px; font-weight: 600;">Valor mínimo: R$ 5,00. Taxa da plataforma: 10%.</p>
                        </div>
                    </div>

                    <!-- Config Panel -->
                    <div class="setting-card">
                         <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 2rem;">
                            <div style="width: 32px; height: 32px; background: rgba(51, 144, 236, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <h3 style="font-size: 14px; font-weight: 900; color: white;">Configurações</h3>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="font-size: 11px; font-weight: 950; color: var(--text-muted); text-transform: none; margin-bottom: 12px; display: block;">Categorias</label>
                            <input type="hidden" name="category" id="category_input" value="Fotografia, Lifestyle">
                            
                            <div id="category_tags_container" style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1rem;">
                                <!-- Dynamic tags here -->
                            </div>
                            
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="text" id="new_category_input" placeholder="Nova categoria..." 
                                       style="background: rgba(0,0,0,0.2); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 10px; padding: 8px 12px; color: white; font-size: 12px; outline: none; width: 100%; font-weight: 600;"
                                       onkeydown="if(event.key === 'Enter') { event.preventDefault(); addCategoryTag(); }">
                                <button type="button" onclick="addCategoryTag()" 
                                        style="background: rgba(51, 144, 236, 0.1); color: #3390ec; border: none; padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 900; cursor: pointer; transition: 0.2s;"
                                        onmouseover="this.style.background='#3390ec';this.style.color='white'"
                                        onmouseout="this.style.background='rgba(51, 144, 236, 0.1)';this.style.color='#3390ec'">
                                    Adicionar
                                </button>
                            </div>
                        </div>

                        <div style="margin-bottom: 2rem;">
                            <label style="font-size: 11px; font-weight: 950; color: var(--text-muted); text-transform: none; margin-bottom: 12px; display: block;">Publicação</label>
                            <div style="background: rgba(0,0,0,0.1); border-radius: 12px; padding: 4px; display: grid; grid-template-columns: 1fr 1fr; gap: 4px; margin-bottom: 1rem;">
                                <button type="button" class="tab-btn-schedule active" id="btn_immediate" onclick="setScheduleMode(false)">Imediata</button>
                                <button type="button" class="tab-btn-schedule" id="btn_schedule" onclick="setScheduleMode(true)">Agendar</button>
                            </div>
                            <div id="schedule_input_container" style="display: none;">
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at_input"
                                       style="background: #151621; border: 1.5px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1rem; color: white; outline: none; width: 100%; font-size: 13px; font-weight: 700;">
                                <p style="font-size: 10px; color: var(--text-muted); margin-top: 8px; font-weight: 600;">Selecione o dia e horário que o post será publicado.</p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h4 style="font-size: 13px; font-weight: 850; color: white;">Comentários</h4>
                                <p style="font-size: 10px; color: var(--text-muted);">Permitir interação</p>
                            </div>
                            <label class="toggle-switch-label">
                                <input type="checkbox" name="allow_comments" value="1" checked style="display:none;" id="comments_toggle_input">
                                <div id="comments_toggle_ui" class="toggle-switch active" onclick="toggleComments()"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Tip Panel -->
                    <div style="background: rgba(51, 144, 236, 0.08); border-radius: 20px; padding: 1.5rem; display: flex; gap: 1rem;">
                        <div style="width: 32px; height: 32px; background: #3390ec; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-weight: 950; font-size: 14px; flex-shrink: 0;">i</div>
                        <div>
                             <h4 style="font-size: 11px; font-weight: 950; color: #3390ec; text-transform: none; margin-bottom: 4px;">Dica do Mogram</h4>
                             <p style="font-size: 12px; color: rgba(255,255,255,0.8); font-weight: 600; line-height: 1.4;">Posts com vídeos convertem 40% mais assinantes pagos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<style>
    .tool-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-weight: 900;
        font-size: 16px;
        cursor: pointer;
        padding: 4px 8px;
        transition: 0.2s;
        display: flex; align-items: center;
    }
    .tool-btn:hover { color: white; }
    
    .media-preview-box {
        width: 120px;
        height: 120px;
        border-radius: 18px;
        overflow: hidden;
        background: rgba(0,0,0,0.2);
    }

    .setting-card {
        background: #151621;
        border: 1.5px solid rgba(255,255,255,0.05);
        border-radius: 24px;
        padding: 1.75rem;
    }

    .tab-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-weight: 900;
        font-size: 12px;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }
    .tab-btn.active {
        background: #1f212e;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .tag-badge {
        background: #3390ec;
        color: white;
        font-size: 11px;
        font-weight: 850;
        padding: 6px 12px;
        border-radius: 100px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    .tag-badge.add {
        background: rgba(255,255,255,0.05);
        border: 1.5px dashed rgba(255,255,255,0.1);
        color: var(--text-muted);
    }

    .toggle-switch {
        width: 44px;
        height: 24px;
        background: rgba(255,255,255,0.1);
        border-radius: 100px;
        position: relative;
        cursor: pointer;
        transition: 0.3s;
    }
    .toggle-switch::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        top: 3px;
        left: 3px;
        transition: 0.3s;
    }
    .toggle-switch.active { background: #3390ec; }
    .toggle-switch.active::after { left: 23px; }
    
    #editor_body b, #editor_body strong { font-weight: 950 !important; color: white; }
    #editor_body i, #editor_body em { font-style: italic !important; }
    #editor_body u { text-decoration: underline !important; }

    .emoji-item {
        cursor: pointer;
        padding: 4px;
        border-radius: 8px;
        transition: 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .emoji-item:hover { background: rgba(255,255,255,0.1); transform: scale(1.2); }
    .tab-btn-schedule {
        background: transparent;
        border: none;
        padding: 0.6rem;
        border-radius: 9px;
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.2s;
    }
    .tab-btn-schedule.active {
        background: rgba(255,255,255,0.05);
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editor = document.getElementById('editor_body');
        const descriptionInput = document.getElementById('description_input');
        const placeholder = document.getElementById('placeholder_custom');
        const emojiPicker = document.getElementById('emoji_picker');
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file_input');
        const priceSection = document.getElementById('price_section');
        const isPaidInput = document.getElementById('is_paid_input');

        // Sync editor to hidden input
        window.syncEditor = function() {
            if (editor && descriptionInput) {
                let text = editor.innerText;
                if (text.length > 2200) {
                    editor.innerText = text.substring(0, 2200);
                    // Place cursor at end
                    const range = document.createRange();
                    const sel = window.getSelection();
                    range.setStart(editor.childNodes[0], 2200);
                    range.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(range);
                    text = editor.innerText;
                }
                
                descriptionInput.value = editor.innerHTML;
                const countDisplay = document.getElementById('char_count_display');
                if (countDisplay) {
                    countDisplay.innerText = `${text.length} / 2200`;
                    countDisplay.style.color = text.length >= 2100 ? '#ef4444' : 'var(--text-muted)';
                }

                if (placeholder) {
                    placeholder.style.display = text.trim() === "" ? 'block' : 'none';
                }
            }
        }

        window.validateAndSync = function() {
            // First sync
            window.syncEditor();
            
            const title = document.querySelector('input[name="title"]').value.trim();
            const description = descriptionInput.value.trim();
            const file = fileInput.files.length;
            
            let errors = [];
            if(!title) errors.push("O Título é obrigatório.");
            if(!description || description === "<br>") errors.push("A Legenda/Descrição é obrigatória.");
            if(file === 0) errors.push("Você precisa selecionar ao menos uma Mídia (Foto, Vídeo ou PDF).");
            
            if(errors.length > 0) {
                alert("Ops! Verifique os seguintes campos:\n\n- " + errors.join("\n- "));
                return false;
            }
            return true;
        };

        if(editor) {
            editor.addEventListener('input', window.syncEditor);
            editor.addEventListener('blur', window.syncEditor);
            window.syncEditor();
        }

        // Global functions for inline onclicks
        window.setPostPaid = function(paid) {
            if (isPaidInput) isPaidInput.value = paid ? "1" : "0";
            if (priceSection) {
                priceSection.style.display = paid ? 'block' : 'none';
            }
            
            // Update buttons visually
            const visibilityCard = document.getElementById('is_paid_input').parentElement;
            const buttons = visibilityCard.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            if(paid && buttons[1]) buttons[1].classList.add('active');
            else if(!paid && buttons[0]) buttons[0].classList.add('active');
        };

        window.setScheduleMode = function(isScheduled) {
            const container = document.getElementById('schedule_input_container');
            const btnImmediate = document.getElementById('btn_immediate');
            const btnSchedule = document.getElementById('btn_schedule');
            const input = document.getElementById('scheduled_at_input');

            if(isScheduled) {
                container.style.display = 'block';
                btnSchedule.classList.add('active');
                btnImmediate.classList.remove('active');
                // Set default to now + 1 hour if empty
                if(!input.value) {
                    const now = new Date();
                    now.setHours(now.getHours() + 1);
                    input.value = now.toISOString().slice(0, 16);
                }
            } else {
                container.style.display = 'none';
                btnImmediate.classList.add('active');
                btnSchedule.classList.remove('active');
                input.value = ''; // Clear for immediate
            }
        };

        window.formatDoc = function(cmd, value = null) {
            if(editor) {
                editor.focus();
                document.execCommand(cmd, false, value);
                window.syncEditor();
            }
        };

        window.toggleEmojiPicker = function() {
            if(emojiPicker) {
                emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
            }
        };

        window.insertEmoji = function(emoji) {
            if(editor) {
                editor.focus();
                const sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    const range = sel.getRangeAt(0);
                    range.deleteContents();
                    const textNode = document.createTextNode(emoji);
                    range.insertNode(textNode);
                    range.setStartAfter(textNode);
                    range.setEndAfter(textNode);
                    sel.removeAllRanges();
                    sel.addRange(range);
                } else {
                    document.execCommand('insertText', false, emoji);
                }
                if(emojiPicker) emojiPicker.style.display = 'none';
                window.syncEditor();
            }
        };

        window.toggleComments = function() {
            const input = document.getElementById('comments_toggle_input');
            const ui = document.getElementById('comments_toggle_ui');
            if(input && ui) {
                input.checked = !input.checked;
                if(input.checked) ui.classList.add('active');
                else ui.classList.remove('active');
            }
        };

        window.handleFileSelect = function(input) {
            const container = document.getElementById('media_previews_container');
            const typeInput = document.getElementById('post_type_input');
            if(!container) return;
            container.innerHTML = '';
            
            Array.from(input.files).forEach(file => {
                // Set post type based on first file
                if(typeInput) {
                    if(file.type.startsWith('image/')) typeInput.value = 'image';
                    else if(file.type.startsWith('video/')) typeInput.value = 'video';
                    else if(file.type === 'application/pdf') typeInput.value = 'pdf';
                }

                const wrapper = document.createElement('div');
                wrapper.className = 'media-preview-box';
                wrapper.style.position = 'relative';

                const reader = new FileReader();
                reader.onload = (e) => {
                    if (file.type.startsWith('image/')) {
                        wrapper.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">`;
                    } else if (file.type.startsWith('video/')) {
                        wrapper.innerHTML = `
                            <video src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;"></video>
                            <div style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.6); padding: 3px 6px; border-radius: 4px; font-size: 8px; font-weight: 900; color: white;">VÍDEO</div>
                        `;
                    }
                    
                    const del = document.createElement('div');
                    del.innerHTML = '×';
                    del.style = "position: absolute; top: -8px; right: -8px; width: 20px; height: 20px; background: #ef4444; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 950; cursor: pointer; border: 2px solid #0b0a15; z-index: 10;";
                    del.onclick = () => wrapper.remove();
                    wrapper.appendChild(del);
                };
                reader.readAsDataURL(file);
                container.appendChild(wrapper);

                // Show thumbnail section for all types
                const thumbSection = document.getElementById('thumbnail_section');
                if(thumbSection) {
                    thumbSection.style.display = 'block';
                }
            });
        };

        window.handleThumbnailSelect = function(input) {
            const file = input.files[0];
            if(!file) return;

            const reader = new FileReader();
            const previewImg = document.querySelector('#thumbnail_img_preview img');
            const previewContainer = document.getElementById('thumbnail_img_preview');
            const placeholder = document.getElementById('thumbnail_preview_content');

            reader.onload = (e) => {
                if(previewImg) previewImg.src = e.target.result;
                if(previewContainer) previewContainer.style.display = 'block';
                if(placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        };

        if(dropzone) {
            dropzone.addEventListener('click', () => fileInput && fileInput.click());
        }

        let currentCategories = ['Fotografia', 'Lifestyle'];

        window.renderCategories = function() {
            const container = document.getElementById('category_tags_container');
            const input = document.getElementById('category_input');
            if(!container || !input) return;

            container.innerHTML = '';
            currentCategories.forEach((cat, index) => {
                const badge = document.createElement('div');
                badge.className = 'tag-badge';
                badge.innerHTML = `${cat} <svg onclick="removeCategoryTag(${index})" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" style="cursor:pointer; opacity: 0.7;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
                container.appendChild(badge);
            });
            input.value = currentCategories.join(', ');
        };

        window.addCategoryTag = function() {
            const input = document.getElementById('new_category_input');
            if(!input) return;
            const val = input.value.trim();
            if (val && !currentCategories.includes(val)) {
                currentCategories.push(val);
                window.renderCategories();
                input.value = '';
            }
        };

        window.removeCategoryTag = function(index) {
            currentCategories.splice(index, 1);
            window.renderCategories();
        };

        // Initialize categories
        window.renderCategories();

        document.addEventListener('click', (e) => {
            if (emojiPicker && !emojiPicker.contains(e.target) && !e.target.closest('.tool-btn')) {
                emojiPicker.style.display = 'none';
            }
        });
    });
</script>
@endsection
