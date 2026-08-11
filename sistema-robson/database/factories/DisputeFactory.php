<?php

namespace Database\Factories;

use App\Enums\DisputeReason;
use App\Enums\DisputeStatus;
use App\Models\Dispute;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dispute>
 */
class DisputeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'match_id' => TradeMatch::factory(),
            'raised_by' => fn (array $attributes) => TradeMatch::query()
                ->find($attributes['match_id'])?->seeker_id ?? User::factory(),
            'reason' => DisputeReason::Other,
            'description' => fake()->paragraph(),
            'status' => DisputeStatus::Open,
            'resolution' => null,
            'resolved_by' => null,
            'resolved_at' => null,
        ];
    }

    /**
     * Indicate that the dispute was resolved by an administrator.
     */
    public function resolved(?string $resolution = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => DisputeStatus::Resolved,
            'resolution' => $resolution ?? fake()->sentence(),
            'resolved_by' => User::factory()->admin(),
            'resolved_at' => now(),
        ]);
    }
}
