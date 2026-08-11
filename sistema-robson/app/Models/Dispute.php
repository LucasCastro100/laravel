<?php

namespace App\Models;

use App\Enums\DisputeReason;
use App\Enums\DisputeStatus;
use Carbon\CarbonInterface;
use Database\Factories\DisputeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A dispute raised by one of the match participants and resolved by an
 * administrator.
 *
 * @property int $id
 * @property int $match_id
 * @property int $raised_by
 * @property DisputeReason $reason
 * @property string $description
 * @property DisputeStatus $status
 * @property string|null $resolution
 * @property int|null $resolved_by
 * @property CarbonInterface|null $resolved_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read TradeMatch $match
 * @property-read User $raiser
 * @property-read User|null $resolver
 */
#[Fillable([
    'match_id',
    'raised_by',
    'reason',
    'description',
    'status',
    'resolution',
    'resolved_by',
    'resolved_at',
])]
class Dispute extends Model
{
    /** @use HasFactory<DisputeFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reason' => DisputeReason::class,
            'status' => DisputeStatus::class,
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Get the match the dispute refers to.
     *
     * @return BelongsTo<TradeMatch, $this>
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(TradeMatch::class);
    }

    /**
     * Get the user who raised the dispute.
     *
     * @return BelongsTo<User, $this>
     */
    public function raiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'raised_by');
    }

    /**
     * Get the administrator who resolved the dispute.
     *
     * @return BelongsTo<User, $this>
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
