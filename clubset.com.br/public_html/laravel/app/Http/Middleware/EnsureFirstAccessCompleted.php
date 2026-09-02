<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFirstAccessCompleted
{
    /**
     * Redirect users who still need to complete their first-access setup
     * (choose a user type and set a personal password).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->mustChangePassword()) {
            return redirect()->route('primeiro-acesso.index');
        }

        return $next($request);
    }
}
