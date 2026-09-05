<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    /**
     * The routes a pending (not yet admin-verified) user may still access.
     *
     * @var array<int, string>
     */
    private const ALLOWED_ROUTES = [
        'profile.edit',
        'profile.update',
        'logout',
    ];

    /**
     * Block users whose registration has not been accepted by an admin.
     * Pending users may log in and review their own profile, but nothing
     * else until an administrator verifies them.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isAdmin() && ! $user->isAdminVerified()) {
            $routeName = $request->route()?->getName();

            if (! in_array($routeName, self::ALLOWED_ROUTES, true)) {
                return redirect()->route('profile.edit');
            }
        }

        return $next($request);
    }
}
