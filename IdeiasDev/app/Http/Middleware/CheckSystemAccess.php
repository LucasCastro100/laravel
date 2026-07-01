<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSystemAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            throw new AuthenticationException('Unauthenticated.');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $path = $request->path();
        $userSystem = $user->system?->slug;

        $systemRoutes = [
            'dashboard/tbr'        => 'tbr',
            'dashboard/financeiro' => 'financeiro',
            'dashboard/clientes'   => 'clientes',
            'dashboard/admin'      => 'admin',
        ];

        $matchedSystem = null;
        foreach ($systemRoutes as $prefix => $slug) {
            if (str_starts_with($path, $prefix)) {
                $matchedSystem = $slug;
                break;
            }
        }

        if (!$matchedSystem) {
            return $next($request);
        }

        if ($matchedSystem === 'admin') {
            abort(403, 'Acesso restrito ao Super Admin.');
        }

        if ($matchedSystem !== $userSystem) {
            abort(403, 'Você não tem acesso a este sistema.');
        }

        return $next($request);
    }
}
