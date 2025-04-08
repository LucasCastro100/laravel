<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'permission_level' => ['required', 'array', 'min:1'],
            'permission_level.*' => ['in:0, 1, 2'],
            'situation' => ['required', 'numeric', 'in:0, 1, 2'],
            'description' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo TITULO é obrigatório.',

            'permission_level.required' => 'Pelo menos uma opção deve ser selecionada.',
            'permission_level.min' => 'Pelo menos uma opção deve ser selecionada.',
            'permission_level.*.in' => 'Opção inválida selecionada.',

            'situation.required' => 'Pelo menos uma SITUAÇÃO deve ser selecionada.',            
            'situation.in' => 'Situação inválida selecionada.',

            'description.required' => 'O campo DESCRIÇÃO é obrigatório.',
        ];
    }
}
