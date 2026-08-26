<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountNotBlocked
{
    /**
     * Redirect blocked users to the billing page so they can settle
     * their overdue payment.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->accountIsBlocked()) {
            return redirect()->route('assinatura.index');
        }

        return $next($request);
    }
}
