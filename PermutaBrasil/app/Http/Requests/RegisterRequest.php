<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo E-MAIL é obrigatório.',
            'email.email' => 'O formato do E-MAIL é inválido. Por favor, insira um endereço de E-MAIL válido.',
            'email.unique' => 'Este E-MAIL já está em uso. Por favor, use um endereço diferente.',
    
            'password.required' => 'O campo SENHA é obrigatório.',
            'password.min' => 'A SENHA deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da SENHA não corresponde.',
        ];
    }
}
