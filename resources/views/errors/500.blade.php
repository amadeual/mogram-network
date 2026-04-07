@extends('layouts.app')

@section('title', '500 - Erro Interno | Mogram')

@section('content')
<div style="min-height: 100vh; background: #0b0a15; display: flex; align-items: center; justify-content: center; padding: 2rem; position: relative; overflow: hidden;">
    <!-- Background Decor -->
    <div style="position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(239, 68, 68, 0.1) 0%, transparent 70%); filter: blur(80px); z-index: 1;"></div>
    <div style="position: absolute; bottom: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255, 140, 45, 0.1) 0%, transparent 70%); filter: blur(80px); z-index: 1;"></div>

    <div style="text-align: center; position: relative; z-index: 10; max-width: 600px;">
        <!-- Logo -->
        <div style="margin-bottom: 3rem; display: flex; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 512 512">
                <defs>
                    <linearGradient id="errorLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#ef4444;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect width="512" height="512" rx="120" fill="url(#errorLogoGrad)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
        </div>

        <h1 style="font-size: 8rem; font-weight: 900; color: white; line-height: 1; margin: 0; letter-spacing: -5px; opacity: 0.8;">500</h1>
        <div style="height: 4px; width: 60px; background: #ef4444; margin: 2rem auto; border-radius: 2px;"></div>
        
        <h2 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 1rem;">Ocorreu um Erro Inesperado.</h2>
        <p style="color: #888; font-size: 1.1rem; font-weight: 600; line-height: 1.6; margin-bottom: 3rem;">
            Nossos servidores encontraram um problema técnico. Já notificamos nossa equipe para corrigir isso o mais rápido possível. 
        </p>

        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('dashboard') }}" style="background: rgba(255, 140, 45, 0.2); color: #ff8c2d; text-decoration: none; padding: 1.25rem 2.5rem; border-radius: 20px; font-weight: 800; font-size: 1rem; border: 1.5px solid #ff8c2d; transition: 0.3s;" onmouseover="this.style.background='rgba(255, 140, 45, 0.3)'" onmouseout="this.style.background='rgba(255, 140, 45, 0.2)'">
                Voltar para o Feed
            </a>
            <button onclick="window.location.reload()" style="background: white; color: black; border: none; padding: 1.25rem 2.5rem; border-radius: 20px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                Tentar Novamente
            </button>
        </div>
    </div>
</div>

<style>
    body, html {
        margin: 0;
        padding: 0;
        background: #0b0a15;
    }
    
    .navbar, .sidebar {
        display: none !important;
    }
    
    .main-content {
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
    }
</style>
@endsection
