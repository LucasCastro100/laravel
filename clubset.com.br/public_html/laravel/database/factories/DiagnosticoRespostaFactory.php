<?php

namespace Database\Factories;

use App\Models\DiagnosticoResposta;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiagnosticoResposta>
 */
class DiagnosticoRespostaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $state = State::factory()->create();

        return [
            'nome' => fake()->name(),
            'instagram' => '@'.fake()->userName(),
            'celular' => fake()->phoneNumber(),
            'state_id' => $state->id,
            'municipality_id' => Municipality::factory()->create(['state_id' => $state->id])->id,
            'participa_grupo_whatsapp' => false,
            'grupo_whatsapp_qual' => null,
            'renda' => fake()->randomElement(DiagnosticoResposta::RENDAS),
            'respostas' => [],
            'resultado' => [
                'geral' => 0,
                'faixa_geral' => 'critico',
                'faixa_geral_label' => 'Critico',
                'areas' => [],
                'criticos' => [],
            ],
        ];
    }
}
