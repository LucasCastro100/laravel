<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Concerns\HasTeams;
use App\Enums\UserRole;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property int|null $state_id
 * @property int|null $municipality_id
 * @property Carbon|null $admin_verified_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property Carbon|null $trial_ends_at
 * @property Carbon|null $blocked_at
 * @property Carbon|null $payment_due_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $currentTeam
 * @property-read State|null $state
 * @property-read Municipality|null $municipality
 * @property-read string|null $region
 * @property-read string|null $city
 * @property-read Collection<int, Team> $ownedTeams
 * @property-read Collection<int, Membership> $teamMemberships
 * @property-read Collection<int, Team> $teams
 * @property-read Collection<int, Role> $roles
 * @property-read Collection<int, Payment> $payments
 * @property-read Collection<int, Listing> $listings
 * @property-read Collection<int, Service> $services
 * @property-read Collection<int, TradeMatch> $matchesAsSeeker
 * @property-read Collection<int, TradeMatch> $matchesAsProvider
 * @property-read Collection<int, CreditTransaction> $creditTransactions
 * @property-read Collection<int, Dispute> $disputesRaised
 */
#[Fillable([
    'name',
    'email',
    'password',
    'current_team_id',
    'state_id',
    'municipality_id',
    'stripe_id',
    'pm_type',
    'pm_last_four',
    'trial_ends_at',
    'blocked_at',
    'payment_due_at',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use Billable, HasFactory, HasTeams, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    /**
     * The number of days of grace after a failed payment before the
     * account is blocked.
     */
    public const PAYMENT_GRACE_DAYS = 7;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'blocked_at' => 'datetime',
            'payment_due_at' => 'datetime',
            'admin_verified_at' => 'datetime',
        ];
    }

    /**
     * Get the roles that belong to the user.
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the payments for the user.
     *
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the equipment listings created by the user.
     *
     * @return HasMany<Listing, $this>
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Get the services offered by the user.
     *
     * @return HasMany<Service, $this>
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the matches where the user expressed interest.
     *
     * @return HasMany<TradeMatch, $this>
     */
    public function matchesAsSeeker(): HasMany
    {
        return $this->hasMany(TradeMatch::class, 'seeker_id');
    }

    /**
     * Get the matches where the user provided the listing/service.
     *
     * @return HasMany<TradeMatch, $this>
     */
    public function matchesAsProvider(): HasMany
    {
        return $this->hasMany(TradeMatch::class, 'provider_id');
    }

    /**
     * Get the credit ledger entries for the user.
     *
     * @return HasMany<CreditTransaction, $this>
     */
    public function creditTransactions(): HasMany
    {
        return $this->hasMany(CreditTransaction::class);
    }

    /**
     * Get the disputes raised by the user.
     *
     * @return HasMany<Dispute, $this>
     */
    public function disputesRaised(): HasMany
    {
        return $this->hasMany(Dispute::class, 'raised_by');
    }

    /**
     * Get the state where the user is located.
     *
     * @return BelongsTo<State, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the municipality where the user is located.
     *
     * @return BelongsTo<Municipality, $this>
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * The user's state UF (e.g. "SP"), exposed to the frontend as "region".
     */
    protected function getRegionAttribute(): ?string
    {
        return $this->state?->uf;
    }

    /**
     * The user's municipality name, exposed to the frontend as "city".
     */
    protected function getCityAttribute(): ?string
    {
        return $this->municipality?->name;
    }

    /**
     * The user's available credit balance (credits minus debits).
     */
    public function availableBalance(): float
    {
        return (float) $this->creditTransactions()
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'credit' THEN amount ELSE -amount END), 0) as balance")
            ->value('balance');
    }

    /**
     * Determine whether an administrator has validated this registration.
     */
    public function isAdminVerified(): bool
    {
        return $this->admin_verified_at !== null;
    }

    /**
     * The user's available credit balance, exposed to the frontend.
     */
    protected function getCreditBalanceAttribute(): float
    {
        return $this->availableBalance();
    }

    /**
     * Assign the given role to the user.
     */
    public function assignRole(UserRole $role): void
    {
        $role = Role::query()->firstOrCreate(['slug' => $role->value], ['name' => $role->label()]);

        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    /**
     * Determine if the user has the given role.
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->roles()->where('roles.slug', $role->value)->exists();
    }

    /**
     * Determine if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::Administrator);
    }

    /**
     * Determine if the user is an administrator.
     */
    protected function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get the user's active Cashier subscription.
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscription('default');
    }

    /**
     * Get the plan the user is currently on (based on the subscription or
     * falling back to the free "trial" plan).
     */
    public function activePlan(): ?Plan
    {
        if ($subscription = $this->activeSubscription()) {
            return Plan::query()
                ->where('stripe_price_id', $subscription->stripe_price)
                ->first();
        }

        return Plan::query()->where('slug', 'trial')->first();
    }

    /**
     * Determine if the user is on the free trial plan.
     */
    public function onTrialPlan(): bool
    {
        return $this->activePlan()?->isFree() ?? true;
    }

    /**
     * Determine if the user has an active (paying or trialing) subscription.
     */
    public function hasActiveSubscription(): bool
    {
        if (! $subscription = $this->activeSubscription()) {
            return false;
        }

        return $subscription->active() || $subscription->onTrial();
    }

    /**
     * Determine if the account is currently blocked.
     */
    public function accountIsBlocked(): bool
    {
        return $this->blocked_at !== null;
    }

    /**
     * Block the account (used when the payment grace period expires).
     */
    public function blockAccount(?CarbonInterface $at = null): void
    {
        $this->forceFill(['blocked_at' => $at ?? now()])->save();
    }

    /**
     * Unblock the account (used when a payment succeeds).
     */
    public function unblockAccount(): void
    {
        $this->forceFill(['blocked_at' => null, 'payment_due_at' => null])->save();
    }

    /**
     * Mark the payment as due (a recurring charge failed).
     */
    public function markPaymentDue(?CarbonInterface $at = null): void
    {
        $this->forceFill(['payment_due_at' => $at ?? now()])->save();
    }

    /**
     * Clear the pending payment marker.
     */
    public function clearPaymentDue(): void
    {
        $this->forceFill(['payment_due_at' => null])->save();
    }

    /**
     * Determine if the user has an overdue payment waiting to be settled.
     */
    public function hasPaymentDue(): bool
    {
        return $this->payment_due_at !== null;
    }

    /**
     * Determine if the grace period (7 days) for an overdue payment has expired.
     */
    public function gracePeriodExpired(): bool
    {
        if (! $this->payment_due_at) {
            return false;
        }

        return $this->payment_due_at->lte(now()->subDays(self::PAYMENT_GRACE_DAYS));
    }
}
