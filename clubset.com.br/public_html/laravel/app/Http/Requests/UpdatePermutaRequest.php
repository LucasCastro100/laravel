<?php

namespace App\Http\Requests;

class UpdatePermutaRequest extends StorePermutaRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $permuta = $this->route('permuta');

        return $permuta?->ownedBy($this->user());
    }
}
