<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:6']
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'O campo SENHA é obrigatório.',
            'password.min' => 'A SENHA deve ter pelo menos :min caracteres.',
        ];
    }
}
