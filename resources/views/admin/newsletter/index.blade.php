@extends('layouts.admin')

@section('title', 'Newsletter Subscriptions')

@section('admin_content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
    <div>
        <p style="color: var(--primary-blue); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Home / Marketing / Newsletter</p>
        <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem;">Newsletter Subscriptions</h1>
        <p style="color: var(--text-muted); font-weight: 600;">Visualize e gerencie os e-mails inscritos na newsletter.</p>
    </div>
</div>

<!-- Subscriptions Table -->
<div class="admin-card" style="padding: 0; overflow: visible;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1.5px solid var(--border-gray);">
                <th style="padding: 1.5rem 2rem; text-align: left; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">E-mail</th>
                <th style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Data de Inscrição</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $sub)
            <tr style="border-bottom: 1px solid var(--border-gray); transition: 0.2s;">
                <td style="padding: 1.5rem 2rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 32px; height: 32px; background: rgba(51,144,236,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3390ec;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: white;">{{ $sub->email }}</h4>
                    </div>
                </td>
                <td style="padding: 1.5rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; font-weight: 700;">
                    {{ $sub->created_at->format('d/m/Y H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="padding: 5rem 2rem; text-align: center;">
                    <p style="color: var(--text-muted); font-weight: 600;">Nenhuma inscrição encontrada.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1);">
        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700;">Mostrando <strong>{{ $subscriptions->firstItem() ?? 0 }}</strong> a <strong>{{ $subscriptions->lastItem() ?? 0 }}</strong> de <strong>{{ $subscriptions->total() ?? 0 }}</strong> inscrições</p>
        <div>
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection
