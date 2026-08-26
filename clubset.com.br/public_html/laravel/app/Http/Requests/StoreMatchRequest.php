<?php

namespace App\Http\Requests;

use App\Enums\TradeType;
use App\Models\Listing;
use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class StoreMatchRequest extends FormRequest
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
            'listing_id' => ['nullable', new Exists(Listing::class, 'id')],
            'service_id' => ['nullable', new Exists(Service::class, 'id')],
            'trade_type' => ['required', Rule::enum(TradeType::class)],
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999',
                'required_if:trade_type,credito',
                'required_if:trade_type,venda',
            ],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => $this->input('price') === '' ? null : $this->input('price'),
        ]);
    }

    /**
     * Ensure exactly one target (listing or service) is provided.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ((bool) $this->filled('listing_id') === (bool) $this->filled('service_id')) {
                $validator->errors()->add(
                    'listing_id',
                    'Informe exatamente um anúncio ou um serviço para o match.',
                );
            }
        });
    }
}
