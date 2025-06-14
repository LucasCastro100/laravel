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
            'sales_link' => 'required|string',
            // 'certificate' => 'required|string',
            'description' => 'required|string',            
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => 'O título do curso é obrigatório.',
            'sales_link.required' => 'O link de vendas do curso é obrigatório.',
            // 'certificate.required' => 'O certificado do curso é obrigatório.',
            'description.required' => 'A descrição do curso é obrigatória.',            
            'image.image' => 'O arquivo enviado não é uma imagem válida.',
            'image.mimes' => 'A imagem deve ser do tipo jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}
