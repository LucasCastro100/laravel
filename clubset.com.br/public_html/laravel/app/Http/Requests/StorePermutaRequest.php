<?php

namespace App\Http\Requests;

use App\Enums\PermutaStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class StorePermutaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contato_id' => ['nullable', new Exists(User::class, 'id')],
            'contato_nome' => ['nullable', 'string', 'max:255'],
            'contato_email' => ['nullable', 'email', 'max:255'],
            'titulo' => ['nullable', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:5000'],
            'valor' => ['required', 'numeric', 'min:0', 'max:9999999'],
            'data' => ['nullable', 'date'],
            'status' => ['required', Rule::enum(PermutaStatus::class)],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $valor = $this->input('valor');

        if ($valor !== null && $valor !== '' && is_numeric($valor)) {
            $valor = (float) $valor / 100;
        }

        $this->merge([
            'valor' => $valor,
        ]);
    }

    /**
     * Ensure exactly one linked party is provided (registered user or free name),
     * and the linked user is not the creator.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ((bool) $this->filled('contato_id') === (bool) $this->filled('contato_nome')) {
                $validator->errors()->add(
                    'contato_id',
                    'Vincule um usuário cadastrado ou informe os dados da pessoa.',
                );
            }

            if ($this->filled('contato_id') && (int) $this->input('contato_id') === (int) $this->user()->id) {
                $validator->errors()->add(
                    'contato_id',
                    'Você não pode vincular a permuta a você mesmo.',
                );
            }

            if ($this->filled('contato_nome') && ! $this->filled('contato_id')) {
                if (! $this->filled('contato_nome')) {
                    $validator->errors()->add('contato_nome', 'Informe o nome completo da pessoa.');
                }

                if (! $this->filled('contato_email')) {
                    $validator->errors()->add('contato_email', 'Informe o email da pessoa.');
                } elseif ($this->input('contato_email') === $this->user()->email) {
                    $validator->errors()->add('contato_email', 'Você não pode usar o seu próprio email.');
                }
            }
        });
    }
}
