<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role_id' => ['required', 'integer', 'in:1,2,3'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'cpf' => ['required', 'string', 'max:14', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string válida.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.lowercase' => 'O e-mail deve ser em minúsculas.',
            'email.unique' => 'Já existe uma conta com esse e-mail.',

            'cpf.required' => 'O cpf é obrigatório.',
            'cpf.string' => 'O cpf deve ser uma string válida.',
            'cpf.max' => 'O cpf não pode ter mais de 17 caracteres.',
            'cpf.unique' => 'Já existe uma conta com esse cpf.',

            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',

            'role_id.required' => 'O tipo de usuário é obrigatório.',
            'role_id.integer' => 'O tipo de usuário deve ser um número inteiro.',
            'role_id.in' => 'O tipo de usuário deve ser  (Aluno) ou (Professor).'
        ]);

        if ((int) $request->role_id === 2) {
            $request->validate([
                'specialty' => ['required', 'string', 'min:3', 'max:255'],
            ], [
                'specialty.required' => 'A categoria é obrigatória.',
                'specialty.string' => 'A categoria deve ser uma string válida.',
                'specialty.min' => 'A categoria deve ter pelo menos 3 caracteres.',
                'specialty.max' => 'A categoria não pode ter mais de 255 caracteres.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,            
            'password' => Hash::make($request->password),
            'role_id' => (int) $request->role_id,
        ]);

        if ((int) $request->role_id === 1) {
            Student::create(['user_id' => $user->id]);
        } elseif ((int) $request->role_id === 2) {
            Teacher::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty
            ]);
        }

        Auth::login($user);

        return redirect()->route(match ((int) $request->role_id) {
            1 => 'student.dashBoard',
            2 => 'teacher.dashBoard',
            3 => 'admin.dashBoard',
        });
    }
}
