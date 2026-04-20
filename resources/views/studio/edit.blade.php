@extends('layouts.app')

@section('title', 'Editar Conteúdo - Mogram Studio')

@section('content')
<div class="app-layout">
    <!-- Studio Sidebar -->
    @include("partials.studio-sidebar")

    <!-- Content Area -->
    <main class="main-content" style="background: #0b0a15;">
        <header class="studio-header responsive-header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('studio.dashboard') }}" class="back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <div>
                    <h1 class="header-title">Editar Conteúdo</h1>
                    <p class="header-subtitle">Atualize os detalhes da sua publicação.</p>
                </div>
            </div>
        </header>

        <div class="studio-body-container">
            @if($errors->any())
            <div style="background: rgba(239,68,68,0.1); border: 1.5px solid rgba(239,68,68,0.2); border-radius: 16px; padding: 1rem 1.5rem; color: #ef4444; font-weight: 800; font-size: 14px; margin-bottom: 2rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('studio.update', $post->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAndSync()"
                  class="studio-edit-form-grid">
                @csrf
                @method('PUT')
                
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Basic Info -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: var(--primary-blue); border-radius: 2px;"></div>
                            Título do Conteúdo
                        </label>
                        <input type="text" name="title" value="{{ $post->title }}" required
                               style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 1rem; color: white; font-size: 14px; outline: none; transition: 0.2s;">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: #a855f7; border-radius: 2px;"></div>
                            Descrição do Conteúdo
                        </label>
                        
                        <!-- Rich Editor (Same as Create) -->
                        <div style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden;">
                            <div style="padding: 0.75rem 1.25rem; border-bottom: 1.5px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.2);">
                                <div style="display: flex; align-items: center; gap: 1.25rem; color: var(--text-muted);">
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('bold')" title="Negrito">B</button>
                                        <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('italic')" style="font-style: italic;" title="Itálico">I</button>
                                        <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="formatDoc('underline')" style="text-decoration: underline;" title="Sublinhado">S</button>
                                    </div>
                                    <div style="width: 1px; height: 14px; background: rgba(255,255,255,0.1);"></div>
                                    <div style="display: flex; gap: 0.5rem; position: relative;">
                                        <button type="button" class="tool-btn" onmousedown="event.preventDefault();" onclick="toggleEmojiPicker()">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 1.5rem;">
                                <div id="editor_body" contenteditable="true" 
                                     style="background: transparent; border: none; font-size: 14px; font-weight: 500; color: white; width: 100%; min-height: 180px; outline: none; line-height: 1.6; cursor: text;"
                                     oninput="syncEditor()">{!! $post->description !!}</div>
                                <div style="display: flex; justify-content: flex-end; padding-top: 0.75rem; border-top: 1px solid rgba(255,255,255,0.03);">
                                    <span id="char_count_display" style="font-size: 10px; font-weight: 800; color: var(--text-muted);">0 / 2200</span>
                                </div>
                                <textarea name="description" id="description_input" hidden required maxlength="2200"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px;">
                            <div style="width: 4px; height: 16px; background: #f59e0b; border-radius: 2px;"></div>
                            Mídia do Conteúdo
                        </label>
                        <div style="border: 2px dashed rgba(255,255,255,0.1); border-radius: 24px; padding: 3rem 2rem; text-align: center; background: rgba(255,255,255,0.01); cursor: pointer; transition: 0.3s;"
                             onclick="document.getElementById('file-input').click()">
                            <input type="file" name="file" id="file-input" hidden onchange="handleNewMedia(this)">
                            <div style="width: 56px; height: 56px; background: rgba(51, 144, 236, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin: 0 auto 1.25rem;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: white; margin-bottom: 0.5rem;" id="file-status-title">Clique para trocar a mídia</h4>
                            <p style="font-size: 12px; color: var(--text-muted);" id="file-status-subtitle">Atual: {{ basename($post->file_path) }}</p>
                        </div>

                        <div id="thumbnail_section" style="display: block; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem; margin-top: 1rem;">
                            <label style="font-size: 13px; font-weight: 800; color: white; display: flex; align-items: center; gap: 8px; margin-bottom: 1rem;">
                                <div style="width: 4px; height: 16px; background: #a855f7; border-radius: 2px;"></div>
                                Capa do Conteúdo (Thumbnail)
                            </label>
                            <div onclick="document.getElementById('thumbnail_input').click()" style="width: 200px; height: 112px; border: 1.5px dashed rgba(255,255,255,0.1); border-radius: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; background: rgba(0,0,0,0.2); overflow: hidden; position: relative;">
                                <input type="file" name="thumbnail" id="thumbnail_input" accept="image/*" hidden onchange="handleThumbnailSelect(this)">
                                
                                <div id="thumbnail_preview_content" style="{{ $post->thumbnail ? 'display: none;' : '' }} text-align: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted); margin-bottom: 4px;"><path d="M12 5v14M5 12h14"/></svg>
                                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 800;">Adicionar Capa</span>
                                </div>

                                <div id="thumbnail_img_preview" style="{{ $post->thumbnail ? 'display: block;' : 'display: none;' }} width: 100%; height: 100%;">
                                    <img src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- Settings -->
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="font-size: 13px; font-weight: 800; color: white;">Tipo de Conteúdo</label>
                            <select name="type" required
                                    style="background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0.875rem; color: white; outline: none;">
                                <option value="video" {{ $post->type == 'video' ? 'selected' : '' }}>Vídeo</option>
                                <option value="image" {{ $post->type == 'image' ? 'selected' : '' }}>Imagem</option>
                                <option value="pdf" {{ $post->type == 'pdf' ? 'selected' : '' }}>Documento (PDF)</option>
                                <option value="stories" {{ $post->type == 'stories' ? 'selected' : '' }}>Stories</option>
                            </select>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="font-size: 13px; font-weight: 800; color: white;">Preço de Venda (R$)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 900;">R$</span>
                                <input type="number" name="price" step="0.01" min="5" value="{{ $post->price }}"
                                       style="background: #1a1c2e; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0.875rem 1rem 0.875rem 3rem; color: white; outline: none; width: 100%;">
                            </div>
                            <p style="font-size: 10px; color: var(--text-muted); margin-top: 10px; font-weight: 600;">Valor mínimo: R$ 5,00. Taxa da plataforma: 15%.</p>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem; background: rgba(51, 144, 236, 0.05); padding: 1.25rem; border-radius: 16px;">
                            <div style="flex: 1;">
                                <h5 style="font-size: 13px; font-weight: 800; color: white; margin-bottom: 2px;">Exclusivo PRO</h5>
                                <p style="font-size: 11px; color: var(--text-muted);">Apenas para assinantes.</p>
                            </div>
                            <input type="checkbox" name="is_exclusive" {{ $post->is_exclusive ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--primary-blue);">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <button type="submit" class="mogram-btn-primary" style="padding: 1.25rem; border-radius: 18px; font-weight: 900; font-size: 15px; width: 100%; box-shadow: 0 10px 25px rgba(51, 144, 236, 0.4);">
                            Salvar Alterações
                        </button>
                        <a href="{{ route('studio.dashboard') }}" style="text-align: center; font-size: 13px; font-weight: 800; color: var(--text-muted); text-decoration: none; margin-top: 0.5rem;">Descartar Mudanças</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<style>
    .tool-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-weight: 900;
        font-size: 14px;
        cursor: pointer;
        padding: 4px 8px;
        transition: 0.2s;
        display: flex; align-items: center;
    }
    .tool-btn:hover { color: white; }
    
    .emoji-item {
        cursor: pointer;
        padding: 4px;
        border-radius: 8px;
        transition: 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .emoji-item:hover { background: rgba(255,255,255,0.1); transform: scale(1.2); }

    #editor_body b, #editor_body strong { font-weight: 950 !important; color: white; }
    #editor_body i, #editor_body em { font-style: italic !important; }
    #editor_body u { text-decoration: underline !important; }

    /* Responsive Edits */
    .responsive-header {
        padding: 2.5rem 3rem 1.5rem; 
        display: flex; 
        align-items: center; 
        gap: 1rem;
    }
    .back-btn {
        color: var(--text-muted); 
        cursor: pointer; 
        transition: 0.2s; 
        background: rgba(255,255,255,0.05); 
        padding: 0.5rem; 
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .header-title { font-size: 2.25rem; font-weight: 900; color: white; margin: 0; }
    .header-subtitle { color: var(--text-muted); font-size: 14px; margin: 0; }
    
    .studio-body-container { padding: 0 3rem 3rem; }
    
    .studio-edit-form-grid {
        background: rgba(255, 255, 255, 0.02); 
        border: 1.5px solid rgba(255,255,255,0.05); 
        border-radius: 32px; 
        padding: 2.5rem; 
        display: grid; 
        grid-template-columns: 1.5fr 1fr; 
        gap: 2.5rem;
    }

    @media (max-width: 1024px) {
        .studio-edit-form-grid {
            grid-template-columns: 1fr;
            padding: 1.5rem;
            gap: 2rem;
            border-radius: 24px;
        }
        .studio-body-container {
            padding: 0 1rem 3rem;
        }
        .responsive-header {
            padding: 1.5rem 1rem;
            margin-top: 50px;
        }
        .header-title {
            font-size: 1.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editor = document.getElementById('editor_body');
        const descriptionInput = document.getElementById('description_input');
        const emojiPicker = document.getElementById('emoji_picker');

        // Initial sync from existing content
        if (editor && descriptionInput) {
            descriptionInput.value = editor.innerHTML;
            updateCharCount();
        }

        window.syncEditor = function() {
            if (editor && descriptionInput) {
                let text = editor.innerText;
                if (text.length > 2200) {
                    editor.innerText = text.substring(0, 2200);
                }
                descriptionInput.value = editor.innerHTML;
                updateCharCount();
            }
        }

        window.validateAndSync = function() {
            // First sync to get latest text
            window.syncEditor();
            
            const title = document.querySelector('input[name="title"]').value.trim();
            const description = descriptionInput.value.trim();
            
            let errors = [];
            if(!title) errors.push("O Título é obrigatório.");
            if(!description || description === "<br>") errors.push("A Legenda/Descrição é obrigatória.");
            
            if(errors.length > 0) {
                alert("Ops! Verifique os seguintes campos:\n\n- " + errors.join("\n- "));
                return false;
            }
            return true;
        };

        function updateCharCount() {
            if (editor) {
                const text = editor.innerText;
                const countDisplay = document.getElementById('char_count_display');
                if (countDisplay) {
                    countDisplay.innerText = `${text.length} / 2200`;
                    countDisplay.style.color = text.length >= 2100 ? '#ef4444' : 'var(--text-muted)';
                }
            }
        }

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

        // Close emoji picker on outside click
        document.addEventListener('click', (e) => {
            if (emojiPicker && !emojiPicker.contains(e.target) && !e.target.closest('.tool-btn')) {
                emojiPicker.style.display = 'none';
            }
        });

        window.handleNewMedia = function(input) {
            const file = input.files[0];
            if(!file) return;

            // Update UI feedback
            const title = document.getElementById('file-status-title');
            const subtitle = document.getElementById('file-status-subtitle');
            if(title) title.innerText = "Novo arquivo selecionado!";
            if(subtitle) subtitle.innerText = file.name;
            if(subtitle) subtitle.style.color = "#3390ec";

            // Auto-detect type
            const typeSelect = document.querySelector('select[name="type"]');
            if(typeSelect) {
                if (file.type.startsWith('video/')) typeSelect.value = 'video';
                else if (file.type.startsWith('image/')) typeSelect.value = 'image';
                else if (file.type === 'application/pdf') typeSelect.value = 'pdf';
            }

            // Show thumbnail section for all types
            const thumbSection = document.getElementById('thumbnail_section');
            if(thumbSection) {
                thumbSection.style.display = 'block';
            }
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
    });
</script>
@endsection
