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
        $rules = [
            'title' => 'required|string|max:255',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096|dimensions:ratio=1/1',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096|dimensions:min_width=800,min_height=300',
            'certificate_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];

        if ($this->isMethod('POST')) {
            $rules['description'] = 'required|string';
        } else {
            $rules['description'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages():array
    {
        return [
            'title.required' => 'O título do curso é obrigatório.',
            'description.required' => 'A descrição do curso é obrigatória.',
            'image_cover.image' => 'A imagem de capa não é uma imagem válida.',
            'image_cover.mimes' => 'A imagem de capa deve ser do tipo jpeg, png, jpg ou gif.',
            'image_cover.max' => 'A imagem de capa não pode ter mais de 4MB.',
            'image_cover.dimensions' => 'A imagem de capa deve ser quadrada (largura = altura, ex.: 600x600).',
            'image_banner.image' => 'A imagem banner não é uma imagem válida.',
            'image_banner.mimes' => 'A imagem banner deve ser do tipo jpeg, png, jpg ou gif.',
            'image_banner.max' => 'A imagem banner não pode ter mais de 4MB.',
            'image_banner.dimensions' => 'A imagem banner deve ser retangular (ex.: 1920x500, mínimo 800x300).',
        ];
    }
}
