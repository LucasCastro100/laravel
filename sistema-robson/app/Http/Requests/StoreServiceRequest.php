<?php

namespace App\Http\Requests;

use App\Enums\RateType;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class StoreServiceRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'specialty' => ['nullable', 'string', 'max:120'],
            'rate_type' => ['required', Rule::enum(RateType::class)],
            'rate' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999',
                'required_unless:rate_type,permuta',
            ],
            'state_id' => ['nullable', new Exists(State::class, 'id')],
            'municipality_id' => ['nullable', new Exists(Municipality::class, 'id')],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'rate' => $this->input('rate') === '' ? null : $this->input('rate'),
        ]);
    }

    /**
     * Ensure the municipality belongs to the selected state.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->filled('municipality_id') || ! $this->filled('state_id')) {
                return;
            }

            $belongs = Municipality::query()
                ->where('id', $this->input('municipality_id'))
                ->where('state_id', $this->input('state_id'))
                ->exists();

            if (! $belongs) {
                $validator->errors()->add(
                    'municipality_id',
                    'O município selecionado não pertence ao estado escolhido.',
                );
            }
        });
    }
}
