<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
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
            'subscription_id' => null,
            'stripe_payment_intent' => fake()->unique()->regexify('pi_[a-zA-Z0-9]{20,30}'),
            'stripe_invoice' => fake()->unique()->regexify('in_[a-zA-Z0-9]{20,30}'),
            'amount' => 99.9,
            'currency' => 'brl',
            'status' => 'succeeded',
            'type' => 'recurring',
            'period_start' => now()->subMonth(),
            'period_end' => now(),
            'meta' => [],
        ];
    }

    /**
     * Indicate that the payment failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
        ]);
    }
}
