<?php

namespace Database\Factories;

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Models\Listing;
use App\Models\Municipality;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
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
            'category' => fake()->randomElement(EquipmentCategory::cases()),
            'condition' => fake()->randomElement(EquipmentCondition::cases()),
            'intent' => ListingIntent::Ofereco,
            'type' => fake()->randomElement(ListingType::cases()),
            'price' => null,
            'currency' => 'brl',
            'state_id' => State::factory(),
            'municipality_id' => Municipality::factory(),
            'status' => ListingStatus::Active,
            'moderation_reason' => null,
        ];
    }

    /**
     * Indicate that the listing awaits moderation.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ListingStatus::Pending,
        ]);
    }

    /**
     * Indicate that the listing was rejected by an administrator.
     */
    public function rejected(?string $reason = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ListingStatus::Rejected,
            'moderation_reason' => $reason ?? fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the listing is a "wanted" ad.
     */
    public function wanted(): static
    {
        return $this->state(fn (array $attributes) => [
            'intent' => ListingIntent::Procuro,
            'condition' => null,
            'price' => null,
        ]);
    }

    /**
     * Indicate that the listing has a sale price.
     */
    public function priced(float $price = 1200): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ListingType::Venda,
            'price' => $price,
        ]);
    }
}
