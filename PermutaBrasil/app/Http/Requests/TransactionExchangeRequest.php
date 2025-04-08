<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionExchangeRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'contract' => ['nullable', 'file', 'mimes:doc,docx,pdf'],
            'value' => ['required', 'numeric'],
            'status' => ['required', 'integer', 'in:0,1'],
            'type_payment' => ['required', 'integer', 'in:0,1,2,3,4'],
            'proof_payment' => ['nullable', 'file', 'mimes:doc,docx,pdf'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'contract.file' => 'O arquivo deve ser um documento.',
            'contract.mimes' => 'O CONTRATO deve ser um documento de formato (DOC, DOCX, PDF).',

            'status.required' => 'O campo STATUS é obrigatório.',
            'status.in' => 'O valor selecionado para STATUS é inválido. Selecione uma opção válida.',

            'type_payment.required' => 'O campo TIPO PAGAMENTO é obrigatório.',
            'type_payment.in' => 'O valor selecionado para TIPO PAGAMENTO é inválido. Selecione uma opção válida.',

            'proof_payment.file' => 'O arquivo deve ser um documento.',
            'proof_payment.mimes' => 'O CONTRATO deve ser um documento de formato (DOC, DOCX, PDF).',            
        ];
    }
}
