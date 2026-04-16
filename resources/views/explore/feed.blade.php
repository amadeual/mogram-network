@extends('layouts.app')

@section('title', 'Explorar Feed | Mogram')

@section('content')
@include('partials.navbar')

<div class="container" style="padding-top: 4rem; padding-bottom: 6rem;">
    <div style="margin-bottom: 4rem; text-align: center;">
        <span style="color: #ff4b1f; font-weight: 950; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem;">Descoberta</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 950; letter-spacing: -2px; margin-top: 1rem;">Explorar Feed</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 1rem auto;">Descubra novos conteúdos e criadores que estão bombando no Mogram.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @forelse($posts as $post)
            <div class="post-card-premium" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; overflow: hidden; transition: 0.3s; cursor: pointer;" onclick="window.location.href='{{ route('dashboard') }}'">
                {{-- Media Preview --}}
                <div style="position: relative; aspect-ratio: 1; background: #111; overflow: hidden;">
                    @if($post->media->first())
                        @if($post->media->first()->type == 'image')
                            <img src="{{ Storage::url($post->media->first()->path) }}" style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s;">
                        @else
                            <video src="{{ Storage::url($post->media->first()->path) }}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>
                            <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.5); padding: 5px; border-radius: 8px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </div>
                        @endif
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #333;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m16 16-4-4-4 4"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Content Info --}}
                <div style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.25rem;">
                        <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed='.$post->user->name }}" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid var(--primary-blue);">
                        <div>
                            <p style="font-weight: 800; font-size: 0.9rem; color: white;">{{ $post->user->name }}</p>
                            <p style="font-size: 0.75rem; color: #3390ec; font-weight: 700;">@ {{ $post->user->username }}</p>
                        </div>
                    </div>
                    <p style="font-size: 0.9rem; color: #ccc; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->content }}</p>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 6rem; background: rgba(255,255,255,0.01); border: 2px dashed rgba(255,255,255,0.05); border-radius: 32px;">
                <p style="font-size: 1.25rem; color: var(--text-muted); font-weight: 600;">Nenhum conteúdo público disponível no momento.</p>
                <a href="{{ route('home') }}" style="display: inline-block; margin-top: 1.5rem; color: var(--primary-blue); font-weight: 800;">Voltar ao início</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 4rem;">
        {{ $posts->links() }}
    </div>
</div>

<style>
    .post-card-premium:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 75, 31, 0.2);
        background: rgba(255,255,255,0.04) !important;
    }
    .post-card-premium:hover img {
        transform: scale(1.1);
    }
</style>

@include('partials.footer')
@endsection
