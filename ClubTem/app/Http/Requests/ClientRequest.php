<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'cnpj' => ['required', 'string'],
            'responsible' => ['nullable'],
            'whatsapp' => ['required', 'string'],
            'instagram' => ['nullable'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'state_id' => ['required', 'in:'.implode(',', range(0, 27))],
            'city_id' => ['required'],
            'type_service_id' => ['required'],            
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo NOME e obrigatório.',
            
            'cnpj.required' => 'O campo CNPJ e obrigatório.',      

            'whatsapp.required' => 'O campo WHATSAPP e obrigatório.',

            'photo.file' => 'O arquivo deve ser uma imagem.',
            'photo.mimes' => 'O FOTO deve ser uma imagem de formato (JPEG, JPG, PNG, WEBP).',

            'state_id.required' => 'O campo ESTADO e obrigatório.',
            'state_id.in' => 'O valor selecionado para ESTADO é inválido. Selecione uma opção válida.', 

            'city_id.required' => 'O campo CIDADE e obrigatório.', 

            'type_service_id.required' => 'O campo SERVIÇO e obrigatório.', 
        ];
    }
}
