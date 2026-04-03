@extends('layouts.app')

@section('title', 'Mogram - Story View')

@section('content')
<div class="stories-layout">
    <!-- Close btn -->
    <a href="/dashboard" style="position: absolute; top: 2rem; right: 2rem; color: white; text-decoration: none; font-size: 2rem; z-index: 100;">&times;</a>

    <div class="story-card">
        <!-- Progress Bars -->
        <div style="display: flex; gap: 4px; padding: 10px 20px; position: absolute; top: 0; left: 0; right: 0; z-index: 20;">
            <div style="flex: 1; height: 3px; background: white; border-radius: 2px;"></div>
            <div style="flex: 1; height: 3px; background: rgba(255,255,255,0.3); border-radius: 2px;"></div>
            <div style="flex: 1; height: 3px; background: rgba(255,255,255,0.3); border-radius: 2px;"></div>
        </div>

        <header class="story-header">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #555; border: 2px solid var(--primary-blue);"></div>
            <div style="flex: 1;">
                <p style="font-weight: 700; font-size: 0.9rem;">Rafaela Silva <svg style="display: inline; color: var(--primary-blue);" width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></p>
                <p style="font-size: 0.7rem; opacity: 0.8;">há 2h</p>
            </div>
            <div style="background: rgba(0,0,0,0.4); padding: 4px 10px; border-radius: 10px; font-size: 0.75rem; display: flex; align-items: center; gap: 5px;">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> 4h
            </div>
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
        </header>

        <img src="{{ asset('images/story_1.png') }}" class="story-image" alt="Story Content">

        <footer class="story-footer">
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 30px;">
                <input type="text" placeholder="Enviar mensagem..." style="flex: 1; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 0.8rem 1.2rem; border-radius: 25px; color: white; backdrop-filter: blur(10px);">
                <div class="mimo-btn" style="background: var(--primary-blue); color: white;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </div>
            </div>

            <div style="display: flex; justify-content: space-around; align-items: center;">
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem;">🔥</div>
                    <div style="font-size: 0.75rem; font-weight: 700;">45</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem;">😍</div>
                    <div style="font-size: 0.75rem; font-weight: 700;">128</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem;">👏</div>
                    <div style="font-size: 0.75rem; font-weight: 700;">12</div>
                </div>
                <div style="text-align: center; color: var(--accent-pink);">
                    <div class="mimo-btn" style="background: rgba(255, 75, 108, 0.2); color: var(--accent-pink); margin-bottom: 5px;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"></path><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"></path><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"></path></svg>
                    </div>
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Mimo</div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bottom Nav (Mockup context) -->
    <nav class="bottom-nav">
        <a href="/dashboard" style="color: var(--text-gray);"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg></a>
        <a href="/stories" style="color: var(--primary-blue);"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg></a>
        <div style="width: 50px; height: 50px; background: var(--gradient-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-top: -30px; border: 4px solid var(--bg-color); color: white;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </div>
        <a href="/lives" style="color: var(--text-gray);"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></a>
        <a href="#" style="color: var(--text-gray);"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
    </nav>
</div>
@endsection
