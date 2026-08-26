<?php

namespace Database\Factories;

use App\Enums\RateType;
use App\Models\Municipality;
use App\Models\Service;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => ucfirst(fake()->words(3, true)),
            'description' => fake()->paragraph(),
            'specialty' => fake()->randomElement(['Filmagem', 'Edição', 'Fotografia', 'Drone', 'Live']),
            'rate_type' => RateType::Hora,
            'rate' => 150,
            'currency' => 'brl',
            'state_id' => State::factory(),
            'municipality_id' => Municipality::factory(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the service is offered on a barter-only basis.
     */
    public function barterOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'rate_type' => RateType::Permuta,
            'rate' => null,
        ]);
    }

    /**
     * Indicate that the service is hidden from the marketplace.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
