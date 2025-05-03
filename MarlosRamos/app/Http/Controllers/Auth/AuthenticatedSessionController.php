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

        if ($user->role_id === 3) {
            return redirect()->route('admin.dashBoard');
        }

        if ($user->role_id === 2) {
            return redirect()->route('teacher.dashBoard');
        }

        if ($user->role_id === 1) {
            return redirect()->route('student.dashBoard');
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
