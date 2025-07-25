<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
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
            'date_service' => ['required', 'date'],
            // 'value_total' => ['required', 'numeric'],            
            'value_exchange' => ['required', 'numeric'],                 
            'service_product' => ['required', 'string'],           
            'contract' => ['nullable', 'file', 'mimes:doc,docx,pdf'],
            'description' => ['required', 'string'],   
        ];
    }

    public function messages(): array
    {
        return [
            'date_service.required' => 'O campo DATA é obrigatório.',
            'date_service.date' => 'O campo DATA deve conter uma data válida.',

            // 'value_total' => 'O campo VALOR TOTAL é obrigatório.',

            'value_exchange' => 'O campo VALOR PERMUTA é obrigatório.',            

            'service_product' => 'O campo SERVIÇO|PRODUTO é obrigatório.',            

            'contract.file' => 'O arquivo deve ser um documento.',
            'contract.mimes' => 'O CONTRATO deve ser um documento de formato (DOC, DOCX, PDF).',

            'description' => 'O campo DESCRIÇÃO é obrigatório.'
        ];
    }
}
