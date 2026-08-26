<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Videomaker',
            'slug' => 'videomaker',
            'description' => 'Videomaker / freelancer que oferece serviços.',
        ];
    }

    /**
     * Indicate that the role matches the given user type.
     */
    public function forType(UserRole $role): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $role->label(),
            'slug' => $role->value,
            'description' => null,
        ]);
    }
}
