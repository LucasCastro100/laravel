<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create(){
        $dados = [
            'titlePage' => 'Registrar - Permuta Brasil',
            'bodyId' => 'auth',
            'bodyClass' => '',
            'fields' => [
                ['name' => 'email', 'label' => 'E-mail', 'type' => 'text', 'formGroup' => ''],
                ['name' => 'password', 'label' => 'Senha', 'type' => 'password', 'formGroup' => ''],
                ['name' => 'password_confirmation', 'label' => 'Confirmar senha', 'type' => 'password', 'formGroup' => ''],
            ]
        ];

        return view('pages.auth.register', $dados);
    }

    public function store(RegisterRequest $request)
    {
        $register = User::create($request->except('_token'));

        if($register){
            return redirect()->route('login')->with('message', 'Cadastro feito com sucesso, acesse com seus dados!')->with('status', 'success');
        }else{
            return redirect()->route('register.create')->with('message', 'Opss..., Tente novamente mais tarde!')->with('status', 'erro');
        }
    }
}
