<?php

namespace Database\Factories;

use App\Enums\TeamRole;
use App\Enums\UserRole;
use App\Models\Role;
use App\Models\State;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'region' => null,
            'city' => null,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function ($user) {
            $team = Team::factory()->personal()->create([
                'name' => $user->name."'s Team",
            ]);

            $team->members()->attach($user, [
                'role' => TeamRole::Owner->value,
            ]);

            $user->switchTeam($team);

            $user->roles()->attach(
                Role::query()->firstOrCreate(
                    ['slug' => UserRole::default()->value],
                    ['name' => UserRole::default()->label()],
                )->id,
            );
        });
    }

    /**
     * Indicate that the user has the given role.
     */
    public function withRole(UserRole $role): static
    {
        return $this->afterCreating(fn (User $user) => $user->roles()->attach(
            Role::query()->firstOrCreate(
                ['slug' => $role->value],
                ['name' => $role->label()],
            )->id,
        ));
    }

    /**
     * Indicate that the user is an administrator.
     */
    public function admin(): static
    {
        return $this->withRole(UserRole::Administrator);
    }

    /**
     * Indicate that the user is located in the given region (UF).
     */
    public function inRegion(string $region): static
    {
        return $this->afterCreating(function (User $user) use ($region) {
            $user->update([
                'state_id' => State::factory()->create(['uf' => strtoupper($region)])->id,
            ]);
        });
    }

    /**
     * Indicate that an administrator validated the registration.
     */
    public function adminVerified(): static
    {
        return $this->state(fn (array $attributes) => [
            'admin_verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }
}
