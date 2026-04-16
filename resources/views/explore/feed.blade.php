@extends('layouts.app')

@section('title', 'Explorar Feed | Mogram')

@section('content')
@include('partials.navbar')

<main class="container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="margin-bottom: 3rem; text-align: center;">
        <h1 style="font-size: 2.5rem; font-weight: 950; letter-spacing: -1px; margin-bottom: 0.5rem;">Explorar <span class="grad-text">Feed</span></h1>
        <p style="color: var(--text-muted); font-weight: 600;">Descubra o melhor conteúdo da nossa comunidade.</p>
    </div>

    @if($posts->count() > 0)
        <!-- Post Grid/List -->
        <div style="max-width: 600px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
            @foreach($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>

        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $posts->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem 0;">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--text-muted);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <h3 style="font-weight: 800; color: white;">Nenhum conteúdo encontrado</h3>
            <p style="color: var(--text-muted); font-weight: 600; margin-top: 0.5rem;">Tente novamente mais tarde.</p>
        </div>
    @endif
</main>

@include('partials.footer')
@endsection
