<?php

namespace App\Http\Requests;

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingType;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class StoreListingRequest extends FormRequest
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
            'category' => ['required', Rule::enum(EquipmentCategory::class)],
            'condition' => ['nullable', Rule::enum(EquipmentCondition::class)],
            'intent' => ['required', Rule::enum(ListingIntent::class)],
            'type' => ['required', Rule::enum(ListingType::class)],
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999',
                'required_if:type,venda',
            ],
            'state_id' => ['nullable', new Exists(State::class, 'id')],
            'municipality_id' => ['nullable', new Exists(Municipality::class, 'id')],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'image', 'max:5120', 'mimes:jpeg,jpg,png,webp'],
            'removed_images' => ['nullable', 'array'],
            'removed_images.*' => ['integer', 'exists:listing_images,id'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $price = $this->input('price');
        if ($price !== null && $price !== '' && is_numeric($price)) {
            $price = (float) $price / 100;
        }

        $this->merge([
            'price' => $price === '' || $price === null ? null : $price,
            'condition' => $this->intent === ListingIntent::Procuro->value ? null : $this->input('condition'),
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
