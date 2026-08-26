<?php

namespace App\Models;

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingStatus;
use App\Enums\ListingType;
use Carbon\CarbonInterface;
use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; /**
 * An equipment advertisement: a user offers or seeks equipment through
 * barter, sale or both. New listings require admin moderation before going live.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property EquipmentCategory $category
 * @property EquipmentCondition|null $condition
 * @property ListingIntent $intent
 * @property ListingType $type
 * @property string|null $price
 * @property string $currency
 * @property int|null $state_id
 * @property int|null $municipality_id
 * @property string|null $region
 * @property string|null $city
 * @property ListingStatus $status
 * @property string|null $moderation_reason
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User $owner
 * @property-read State|null $state
 * @property-read Municipality|null $municipality
 * @property-read Collection<int, TradeMatch> $matches
 */
#[Fillable([
    'user_id',
    'title',
    'description',
    'category',
    'condition',
    'intent',
    'type',
    'price',
    'currency',
    'state_id',
    'municipality_id',
    'status',
    'moderation_reason',
])]
class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => EquipmentCategory::class,
            'condition' => EquipmentCondition::class,
            'intent' => ListingIntent::class,
            'type' => ListingType::class,
            'status' => ListingStatus::class,
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the listing.
     *
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the matches created against this listing.
     *
     * @return HasMany<TradeMatch, $this>
     */
    public function matches(): HasMany
    {
        return $this->hasMany(TradeMatch::class);
    }

    /**
     * Get the images for this listing.
     *
     * @return HasMany<ListingImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    /**
     * Get the state where the item is located.
     *
     * @return BelongsTo<State, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the municipality where the item is located.
     *
     * @return BelongsTo<Municipality, $this>
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * The state UF (e.g. "SP"), exposed to the frontend as "region".
     */
    protected function getRegionAttribute(): ?string
    {
        return $this->state?->uf;
    }

    /**
     * The municipality name, exposed to the frontend as "city".
     */
    protected function getCityAttribute(): ?string
    {
        return $this->municipality?->name;
    }

    /**
     * Scope the query to listings currently visible to the public.
     *
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ListingStatus::Active->value);
    }

    /**
     * Scope the query to listings awaiting moderation.
     *
     * @param  Builder<self>  $query
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', ListingStatus::Pending->value);
    }

    /**
     * The price formatted for display (e.g. "R$ 1.200,00").
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->price === null
            ? null
            : 'R$ '.number_format((float) $this->price, 2, ',', '.'));
    }

    /**
     * Determine whether the listing is open for new matches.
     */
    public function isOpen(): bool
    {
        return $this->status === ListingStatus::Active;
    }
}
