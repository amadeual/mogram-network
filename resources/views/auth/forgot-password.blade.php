@extends('layouts.app')

@section('title', 'Esqueceu a Senha - Mogram')

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

        <h2 style="color: white; font-size: 1.5rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem;">Esqueceu sua senha?</h2>
        <p style="color: #888; text-align: center; margin-bottom: 2rem; font-size: 0.95rem;">Digite seu e-mail e enviaremos um link para você redefinir sua senha.</p>
        
        @if (session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #22c55e; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="color: white; font-size: 0.9rem; font-weight: 700;">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="seu@email.com" 
                       style="width: 100%; background: rgba(0,0,0,0.5); border: 1.5px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; color: white; outline: none; transition: 0.3s;"
                       onfocus="this.style.borderColor='#ff4b1f'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                @error('email') <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" style="background: linear-gradient(135deg, #ff8c2d 0%, #ff4b1f 100%); color: white; border: none; padding: 1.2rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(255, 75, 31, 0.2);">
                Enviar Link de Recuperação
            </button>
            
            <p style="text-align: center; color: #888; font-size: 0.9rem; margin-top: 1rem;">
                Lembrou a senha? <a href="{{ route('login') }}" style="color: #ff4b1f; text-decoration: none; font-weight: 800;">Voltar ao login</a>
            </p>
        </form>
    </div>
</div>
@endsection
