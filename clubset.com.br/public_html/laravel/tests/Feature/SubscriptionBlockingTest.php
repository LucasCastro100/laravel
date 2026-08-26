<?php

use App\Models\User;
use Illuminate\Support\Str;

function makeSubscription(User $user, string $status, ?string $price = null): void
{
    $user->subscriptions()->create([
        'type' => 'default',
        'stripe_id' => 'sub_'.Str::random(16),
        'stripe_status' => $status,
        'stripe_price' => $price ?? 'price_'.Str::random(16),
    ]);
}

test('unblocked users can visit the dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();
});

test('blocked users are redirected to the billing page', function () {
    $user = User::factory()->create();
    $user->blockAccount();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('assinatura.index'));
});

test('blocked users can still access the billing page', function () {
    $user = User::factory()->create();
    $user->blockAccount();

    $this->actingAs($user)
        ->get(route('assinatura.index'))
        ->assertOk();
});

test('blockAccount and unblockAccount toggle the blocked flag', function () {
    $user = User::factory()->create();

    expect($user->accountIsBlocked())->toBeFalse();

    $user->markPaymentDue(now()->subDays(3));
    $user->blockAccount();

    expect($user->fresh()->accountIsBlocked())->toBeTrue();
    expect($user->fresh()->hasPaymentDue())->toBeTrue();

    $user->unblockAccount();

    expect($user->fresh()->accountIsBlocked())->toBeFalse();
    expect($user->fresh()->hasPaymentDue())->toBeFalse();
});

test('the grace period has not expired before 7 days', function () {
    $user = User::factory()->create();
    $user->markPaymentDue(now()->subDays(6));

    expect($user->gracePeriodExpired())->toBeFalse();
});

test('the grace period expires after 7 days', function () {
    $user = User::factory()->create();
    $user->markPaymentDue(now()->subDays(8));

    expect($user->gracePeriodExpired())->toBeTrue();
});

test('the overdue command blocks accounts past the grace period', function () {
    $user = User::factory()->create();
    makeSubscription($user, 'past_due');
    $user->markPaymentDue(now()->subDays(8));

    $this->artisan('subscriptions:check-overdue')->assertExitCode(0);

    expect($user->fresh()->accountIsBlocked())->toBeTrue();
});

test('the overdue command does not block accounts within the grace period', function () {
    $user = User::factory()->create();
    makeSubscription($user, 'past_due');
    $user->markPaymentDue(now()->subDays(2));

    $this->artisan('subscriptions:check-overdue')->assertExitCode(0);

    expect($user->fresh()->accountIsBlocked())->toBeFalse();
});

test('the overdue command unblocks accounts with an active subscription', function () {
    $user = User::factory()->create();
    $user->blockAccount();
    makeSubscription($user, 'active');

    $this->artisan('subscriptions:check-overdue')->assertExitCode(0);

    expect($user->fresh()->accountIsBlocked())->toBeFalse();
});

test('the overdue command does not block users without a subscription', function () {
    $user = User::factory()->create();
    $user->markPaymentDue(now()->subDays(8));

    $this->artisan('subscriptions:check-overdue')->assertExitCode(0);

    expect($user->fresh()->accountIsBlocked())->toBeFalse();
});
