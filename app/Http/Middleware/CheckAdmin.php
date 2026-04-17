<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado. Apenas administradores.');
        }

        if ($permission && !auth()->user()->canAccess($permission)) {
            return redirect()->route('admin.dashboard')->with('error', 'Você não tem permissão para acessar esta funcionalidade.');
        }

        return $next($request);
    }
}
