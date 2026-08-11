<?php

namespace Database\Factories;

use App\Enums\TradeType;
use App\Models\Listing;
use App\Models\Service;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TradeMatch>
 */
class TradeMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'listing_id' => null,
            'service_id' => null,
            'seeker_id' => User::factory(),
            'provider_id' => User::factory(),
            'trade_type' => TradeType::PermutaDireta,
            'status' => 'pending',
            'price' => null,
            'message' => null,
            'completed_at' => null,
        ];
    }

    /**
     * Indicate that the match targets the given listing.
     */
    public function forListing(Listing $listing): static
    {
        return $this->state(fn (array $attributes) => [
            'listing_id' => $listing->id,
            'provider_id' => $listing->user_id,
        ]);
    }

    /**
     * Indicate that the match targets the given service.
     */
    public function forService(Service $service): static
    {
        return $this->state(fn (array $attributes) => [
            'service_id' => $service->id,
            'provider_id' => $service->user_id,
        ]);
    }

    /**
     * Indicate that the match is paid with credits.
     */
    public function withCredits(float $price = 150): static
    {
        return $this->state(fn (array $attributes) => [
            'trade_type' => TradeType::Credito,
            'price' => $price,
        ]);
    }

    /**
     * Indicate the match status.
     */
    public function withStatus(string $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the match was completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
