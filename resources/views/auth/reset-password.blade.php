@extends('layouts.app')

@section('title', 'Redefinir Senha - Mogram')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at top right, #1e1b4b, #000000); padding: 2rem;">
    <div style="width: 100%; max-width: 480px; background: rgba(11, 10, 21, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 3rem;">
        
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2rem; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
                <defs><linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                <rect width="512" height="512" rx="100" fill="url(#logoGrad)" />
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
            <span style="font-size: 1.5rem; font-weight: 900; color: white;">Mogram</span>
        </div>

        <h2 style="color: white; font-size: 1.5rem; font-weight: 800; text-align: center; margin-bottom: 2rem;">Criar Nova Senha</h2>
        
        <form action="{{ route('password.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="color: white; font-size: 0.9rem; font-weight: 700;">E-mail</label>
                <input type="email" name="email" value="{{ $_GET['email'] ?? old('email') }}" required placeholder="seu@email.com" 
                       style="width: 100%; background: rgba(0,0,0,0.5); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; color: white; outline: none; transition: 0.3s;"
                       onfocus="this.style.borderColor='#ff4b1f'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                @error('email') <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="color: white; font-size: 0.9rem; font-weight: 700;">Nova Senha</label>
                <input type="password" name="password" required placeholder="Sua nova senha segura" 
                       style="width: 100%; background: rgba(0,0,0,0.5); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; color: white; outline: none; transition: 0.3s;"
                       onfocus="this.style.borderColor='#ff4b1f'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                @error('password') <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">{{ $message }}</span> @enderror
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="color: white; font-size: 0.9rem; font-weight: 700;">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation" required placeholder="Confirme sua nova senha" 
                       style="width: 100%; background: rgba(0,0,0,0.5); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; color: white; outline: none; transition: 0.3s;"
                       onfocus="this.style.borderColor='#ff4b1f'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
            </div>

            <button type="submit" style="background: linear-gradient(135deg, #ff8c2d 0%, #ff4b1f 100%); color: white; border: none; padding: 1.2rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(255, 75, 31, 0.2);">
                Salvar Nova Senha
            </button>
            
        </form>
    </div>
</div>
@endsection
