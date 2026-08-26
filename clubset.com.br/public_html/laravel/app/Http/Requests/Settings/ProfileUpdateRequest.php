<?php

namespace App\Http\Requests\Settings;

use App\Concerns\ProfileValidationRules;
use App\Models\Municipality;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    use ProfileValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->profileRules($this->user()->id);
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
