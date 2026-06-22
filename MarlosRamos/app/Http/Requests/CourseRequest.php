<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => 'O título do curso é obrigatório.',
            'description.required' => 'A descrição do curso é obrigatória.',
            'image_cover.image' => 'A imagem de capa não é uma imagem válida.',
            'image_cover.mimes' => 'A imagem de capa deve ser do tipo jpeg, png, jpg ou gif.',
            'image_cover.max' => 'A imagem de capa não pode ter mais de 2MB.',
            'image_banner.image' => 'A imagem banner não é uma imagem válida.',
            'image_banner.mimes' => 'A imagem banner deve ser do tipo jpeg, png, jpg ou gif.',
            'image_banner.max' => 'A imagem banner não pode ter mais de 2MB.',
        ];
    }
}
