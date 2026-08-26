<?php

namespace App\Http\Requests;

class UpdateListingRequest extends StoreListingRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('listing')->user_id === $this->user()->id;
    }
}
