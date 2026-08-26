<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'São Paulo', 'Rio de Janeiro', 'Minas Gerais', 'Paraná', 'Bahia',
            ]),
            'uf' => fake()->unique()->regexify('[A-Z]{2}'),
            'region' => fake()->randomElement(['Norte', 'Nordeste', 'Centro-Oeste', 'Sudeste', 'Sul']),
            'ibge_code' => fake()->unique()->numberBetween(11, 53),
        ];
    }
}
