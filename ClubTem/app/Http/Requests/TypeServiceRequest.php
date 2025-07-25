<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeServiceRequest extends FormRequest
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
            'type_service' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'type_service.required' => 'O campo TIPO SERVIÇO é obrigatório.'
        ];
    }
}
