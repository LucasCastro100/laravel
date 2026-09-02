<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\PrimeiroAcessoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PrimeiroAcessoController extends Controller
{
    /**
     * Show the first-access page (choose user type + set a password).
     */
    public function index(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user->mustChangePassword()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('primeiro-acesso', [
            'tipoAtual' => $user->hasRole(UserRole::Cliente) ? UserRole::Cliente->value : null,
            'tipos' => collect(UserRole::assignable())
                ->map(fn (UserRole $role) => [
                    'value' => $role->value,
                    'label' => $role->label(),
                ])
                ->values()
                ->all(),
            'passwordRules' => Password::defaults()->toPasswordRulesString(),
        ]);
    }

    /**
     * Complete the first access: store the chosen user type, set a personal
     * password and clear the pending flag.
     */
    public function store(PrimeiroAcessoRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->syncRole(UserRole::from($request->input('role')));
        $user->update(['password' => $request->input('password')]);
        $user->completeFirstAccess();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Primeiro acesso concluído. Bem-vindo!']);

        return to_route('dashboard');
    }
}
