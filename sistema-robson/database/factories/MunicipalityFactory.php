<?php

namespace Database\Factories;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Municipality>
 */
class MunicipalityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city(),
            'state_id' => State::factory(),
            'ibge_code' => fake()->unique()->numberBetween(1000000, 9999999),
        ];
    }
}
