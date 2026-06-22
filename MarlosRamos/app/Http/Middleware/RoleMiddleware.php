<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Admin (role_id=3) pode acessar tudo
        // Para os demais, verifica se o role_id corresponde exatamente
        if (Auth::user()->role_id == $role || Auth::user()->role_id == 3) {
            return $next($request);            
        }

        abort(403, 'Acesso não autorizado');        
    }
}
