<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }   

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        $routes = [
            3 => 'admin.dashBoard',
            2 => 'teacher.dashBoard',
            1 => 'student.dashBoard',
        ];
        
        if (array_key_exists($user->role_id, $routes)) {
            return redirect()->route($routes[$user->role_id]);
        }

        // Fallback com erro 403
        abort(403, 'Você não tem permissão para acessar esta página.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
