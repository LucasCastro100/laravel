<?php

namespace App\Models;

use App\Enums\CreditReason;
use Carbon\CarbonInterface;
use Database\Factories\CreditTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A single credit ledger entry. The user's balance is derived from the sum
 * of credits minus debits.
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $match_id
 * @property string $type credit|debit
 * @property string $amount
 * @property CreditReason $reason
 * @property string|null $description
 * @property string $balance_after
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User $user
 * @property-read TradeMatch|null $match
 */
#[Fillable([
    'user_id',
    'match_id',
    'type',
    'amount',
    'reason',
    'description',
    'balance_after',
])]
class CreditTransaction extends Model
{
    /** @use HasFactory<CreditTransactionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reason' => CreditReason::class,
            'amount' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the transaction.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the match this transaction refers to, when applicable.
     *
     * @return BelongsTo<TradeMatch, $this>
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(TradeMatch::class);
    }

    /**
     * Whether this transaction adds credits to the balance.
     */
    public function isCredit(): bool
    {
        return $this->type === 'credit';
    }
}
