<?php

namespace App\Models;

use App\Enums\MatchStatus;
use App\Enums\TradeType;
use Carbon\CarbonInterface;
use Database\Factories\TradeMatchFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * A match connects a user (seeker) to a listing or service offered by a
 * provider, enabling direct barter, credit barter or sale.
 *
 * @property int $id
 * @property int|null $listing_id
 * @property int|null $service_id
 * @property int $seeker_id
 * @property int $provider_id
 * @property TradeType $trade_type
 * @property MatchStatus $status
 * @property string|null $price
 * @property string|null $message
 * @property CarbonInterface|null $completed_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read Listing|null $listing
 * @property-read Service|null $service
 * @property-read User $seeker
 * @property-read User $provider
 * @property-read Dispute|null $dispute
 */
#[Fillable([
    'listing_id',
    'service_id',
    'seeker_id',
    'provider_id',
    'trade_type',
    'status',
    'price',
    'message',
    'completed_at',
])]
class TradeMatch extends Model
{
    /** @use HasFactory<TradeMatchFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'trade_type' => TradeType::class,
            'status' => MatchStatus::class,
            'price' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the listing that is being matched (when applicable).
     *
     * @return BelongsTo<Listing, $this>
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the service that is being matched (when applicable).
     *
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the user who expressed interest.
     *
     * @return BelongsTo<User, $this>
     */
    public function seeker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    /**
     * Get the user who owns the offered listing/service.
     *
     * @return BelongsTo<User, $this>
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * Get the dispute raised against this match.
     *
     * @return HasOne<Dispute, $this>
     */
    public function dispute(): HasOne
    {
        return $this->hasOne(Dispute::class);
    }

    /**
     * The other party in the match, relative to the given user.
     */
    public function counterpart(int $userId): User
    {
        return $userId === (int) $this->provider_id ? $this->seeker : $this->provider;
    }

    /**
     * The price formatted for display (e.g. "R$ 150,00").
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->price === null
            ? null
            : 'R$ '.number_format((float) $this->price, 2, ',', '.'));
    }

    /**
     * Determine whether the user is a participant of this match.
     */
    public function involvesUser(int $userId): bool
    {
        return (int) $this->seeker_id === $userId || (int) $this->provider_id === $userId;
    }
}
