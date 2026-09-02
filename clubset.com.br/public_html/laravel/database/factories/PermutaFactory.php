<?php

namespace Database\Factories;

use App\Enums\PermutaStatus;
use App\Models\Permuta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permuta>
 */
class PermutaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'contato_id' => null,
            'contato_nome' => null,
            'titulo' => ucfirst(fake()->words(3, true)),
            'descricao' => fake()->sentence(),
            'valor' => fake()->randomFloat(2, 100, 5000),
            'data' => fake()->date(),
            'status' => PermutaStatus::Completed,
        ];
    }

    /**
     * Indicate that the permuta links another registered user (expense side).
     */
    public function withContact(User $contact): static
    {
        return $this->state(fn () => [
            'contato_id' => $contact->id,
            'contato_nome' => $contact->name,
        ]);
    }
}
