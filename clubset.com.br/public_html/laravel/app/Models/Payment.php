<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $subscription_id
 * @property string|null $stripe_payment_intent
 * @property string|null $stripe_invoice
 * @property string $amount
 * @property string $currency
 * @property string $status
 * @property string $type
 * @property Carbon|null $period_start
 * @property Carbon|null $period_end
 * @property array<string, mixed>|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Subscription|null $subscription
 */
#[Fillable([
    'user_id',
    'subscription_id',
    'stripe_payment_intent',
    'stripe_invoice',
    'amount',
    'currency',
    'status',
    'type',
    'period_start',
    'period_end',
    'meta',
])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'period_start' => 'datetime',
            'period_end' => 'datetime',
            'meta' => 'array',
        ];
    }

    /**
     * Get the user that owns the payment.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription that the payment belongs to.
     *
     * @return BelongsTo<Subscription, $this>
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Determine if the payment succeeded.
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'succeeded';
    }

    /**
     * Determine if the payment failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Get the formatted amount.
     */
    public function formattedAmount(): string
    {
        return 'R$ '.number_format((float) $this->amount, 2, ',', '.');
    }
}
