<?php

namespace App\Models;

use App\Enums\RateType;
use Carbon\CarbonInterface;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A service offered by a videomaker (or company) on the platform, findable
 * by region and specialty. Rates may be per hour, per day or barter only.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string|null $specialty
 * @property RateType $rate_type
 * @property string|null $rate
 * @property string $currency
 * @property int|null $state_id
 * @property int|null $municipality_id
 * @property string|null $region
 * @property string|null $city
 * @property bool $is_active
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User $user
 * @property-read State|null $state
 * @property-read Municipality|null $municipality
 * @property-read Collection<int, TradeMatch> $matches
 */
#[Fillable([
    'user_id',
    'title',
    'description',
    'specialty',
    'rate_type',
    'rate',
    'currency',
    'state_id',
    'municipality_id',
    'is_active',
])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rate_type' => RateType::class,
            'rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user that offers the service.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the matches created against this service.
     *
     * @return HasMany<TradeMatch, $this>
     */
    public function matches(): HasMany
    {
        return $this->hasMany(TradeMatch::class);
    }

    /**
     * Get the state where the service is provided.
     *
     * @return BelongsTo<State, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the municipality where the service is provided.
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
     * Scope the query to services visible in the marketplace.
     *
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * The rate formatted for display (e.g. "R$ 150,00/hora").
     */
    protected function formattedRate(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->rate === null) {
                return $this->rate_type === RateType::Permuta ? 'Permuta' : null;
            }

            $suffix = match ($this->rate_type) {
                RateType::Hora => '/hora',
                RateType::Diaria => '/diária',
                RateType::Permuta => '',
            };

            return 'R$ '.number_format((float) $this->rate, 2, ',', '.').$suffix;
        });
    }
}
