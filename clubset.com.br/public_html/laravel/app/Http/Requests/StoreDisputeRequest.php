<?php

namespace App\Http\Requests;

use App\Enums\DisputeReason;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisputeRequest extends FormRequest
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
            'match_id' => ['required', 'exists:matches,id'],
            'reason' => ['required', Rule::enum(DisputeReason::class)],
            'description' => ['required', 'string', 'max:5000'],
        ];
    }
}
