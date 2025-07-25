<?php

namespace App\Http\Requests;

use App\Rules\LoginExists;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo E-MAIL é obrigatório.',
            'email.email' => 'O formato do E-MAIL é inválido. Por favor, insira um endereço de e-mail válido.',

            'password.required' => 'O campo SENHA é obrigatório.',
            'password.min' => 'A SENHA deve ter pelo menos :min caracteres.',
        ];
    }
}
