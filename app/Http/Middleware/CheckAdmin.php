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
    public function handle(Request $request, Closure $next): Response
    {
        $superAdmins = ['bomboadmar@gmail.com', 'criptovida@gmail.com'];

        if (auth()->check() && (auth()->user()->role === 'admin' || in_array(auth()->user()->email, $superAdmins))) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
    }
}
