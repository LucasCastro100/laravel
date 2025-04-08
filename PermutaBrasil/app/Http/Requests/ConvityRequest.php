<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'enterprise' => ['required', 'string'],
            'document' => ['required'],
            'email' => ['required', 'email'],
            'whats' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo NOME é obrigatório.',

            'enterprise.required' => 'O campo EMPRESA é obrigatório.',

            'document.required' => 'O campo CNPJ é obrigatório.',

            'email.required' => 'O campo E-MAIL é obrigatório.',
            'email.email' => 'O formato do E-MAIL é inválido. Por favor, insira um endereço de e-mail válido.',

            'whats.required' => 'O campo WHATSAPP é obrigatório.',
        ];
    }
}
