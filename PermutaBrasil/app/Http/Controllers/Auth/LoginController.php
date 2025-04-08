<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Acessar - Permuta Brasil',
            'bodyId' => 'auth',
            'bodyClass' => '',
            'fields' => [
                ['name' => 'email', 'label' => 'E-mail', 'type' => 'text', 'formGroup' => ''],
                ['name' => 'password', 'label' => 'Senha', 'type' => 'password', 'formGroup' => '']
            ]
        ];

        return view('pages.auth.login', $dados);
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Buscar o usuário para verificar o campo `actived`
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->actived == 1) {
            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard.index');
            } else {
                return redirect()->route('login')->with('message', 'E-mail ou Senha inválidos!')->with('status', 'erro');
            }
        } else {
            return redirect()->route('login')->with('message', 'Sua conta não está ativada, entre em contato com o suporte!')->with('status', 'erro');
        }
    }
}
