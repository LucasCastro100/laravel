<?php

namespace Database\Factories;

use App\Enums\CreditReason;
use App\Models\CreditTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreditTransaction>
 */
class CreditTransactionFactory extends Factory
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
            'match_id' => null,
            'type' => 'credit',
            'amount' => 0,
            'reason' => CreditReason::AdminAdjustment,
            'description' => null,
            'balance_after' => 0,
        ];
    }

    /**
     * Indicate a credit that adds balance.
     */
    public function credit(float $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'credit',
            'amount' => $amount,
        ]);
    }

    /**
     * Indicate a debit that subtracts balance.
     */
    public function debit(float $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'debit',
            'amount' => $amount,
        ]);
    }
}
