<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->unique()->slug(2),
            'description' => fake()->sentence(),
            'stripe_price_id' => null,
            'price' => 0,
            'currency' => 'brl',
            'trial_days' => 0,
            'features' => [],
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    /**
     * Indicate that the plan is free (no Stripe price).
     */
    public function trial(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Trial',
            'slug' => 'trial',
            'stripe_price_id' => null,
            'price' => 0,
            'trial_days' => 0,
            'sort_order' => 1,
        ]);
    }

    /**
     * Indicate that the plan is the "pro" tier.
     */
    public function pro(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Pro',
            'slug' => 'pro',
            'price' => 99.9,
            'trial_days' => 7,
            'sort_order' => 2,
        ]);
    }

    /**
     * Indicate that the plan is the "max" tier.
     */
    public function max(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Max',
            'slug' => 'max',
            'price' => 199.9,
            'trial_days' => 7,
            'sort_order' => 3,
        ]);
    }
}
