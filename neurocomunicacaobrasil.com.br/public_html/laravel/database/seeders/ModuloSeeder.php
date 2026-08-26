<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        Module::create([
            'title'       => 'Módulo 1 — Fundamentos da PNL',
            'description' => "Neste primeiro módulo, você será introduzido aos princípios fundamentais da Programação Neurolinguística (PNL).
Abordamos o que é a PNL, como ela surgiu, seus principais pilares e de que forma essa metodologia pode transformar comportamentos, emoções e resultados.
Este módulo estabelece a base necessária para avançar com segurança nos próximos conteúdos do curso.",
            'course_id'   => 1,
        ]);
    }
}
