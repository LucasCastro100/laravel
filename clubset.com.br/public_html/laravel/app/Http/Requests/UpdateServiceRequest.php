<?php

namespace App\Http\Requests;

class UpdateServiceRequest extends StoreServiceRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('service')->user_id === $this->user()->id;
    }
}
