<?php

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Cashier\Events\WebhookReceived;

function webhookPayload(User $user, string $type): array
{
    return [
        'id' => 'evt_'.Str::random(16),
        'type' => $type,
        'data' => [
            'object' => [
                'id' => 'in_'.Str::random(16),
                'customer' => $user->stripe_id,
                'payment_intent' => 'pi_'.Str::random(16),
                'subscription' => 'sub_'.Str::random(16),
                'amount_paid' => 9990,
                'amount_due' => 9990,
                'currency' => 'brl',
                'lines' => [
                    'data' => [
                        [
                            'period' => [
                                'start' => now()->subMonth()->timestamp,
                                'end' => now()->timestamp,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
}

test('a successful invoice payment is recorded and unblocks the account', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_'.Str::random(16)]);
    $user->blockAccount();

    event(new WebhookReceived(webhookPayload($user, 'invoice.payment_succeeded')));

    expect(Payment::query()->where('user_id', $user->id)->count())->toBe(1);
    $payment = Payment::query()->where('user_id', $user->id)->firstOrFail();

    expect($payment->status)->toBe('succeeded')
        ->and($payment->amount)->toBe('99.90')
        ->and($user->fresh()->accountIsBlocked())->toBeFalse()
        ->and($user->fresh()->hasPaymentDue())->toBeFalse();
});

test('a failed invoice payment is recorded and flags the account as overdue', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_'.Str::random(16)]);

    event(new WebhookReceived(webhookPayload($user, 'invoice.payment_failed')));

    $payment = Payment::query()->where('user_id', $user->id)->firstOrFail();

    expect($payment->status)->toBe('failed')
        ->and($user->fresh()->payment_due_at)->not->toBeNull();
});

test('duplicate webhook deliveries do not create duplicate payments', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_'.Str::random(16)]);
    $payload = webhookPayload($user, 'invoice.payment_succeeded');

    event(new WebhookReceived($payload));
    event(new WebhookReceived($payload));

    expect(Payment::query()->where('user_id', $user->id)->count())->toBe(1);
});

test('an active subscription update clears the overdue marker', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_'.Str::random(16)]);
    $user->markPaymentDue();

    event(new WebhookReceived([
        'type' => 'customer.subscription.updated',
        'data' => [
            'object' => [
                'customer' => $user->stripe_id,
                'status' => 'active',
            ],
        ],
    ]));

    expect($user->fresh()->hasPaymentDue())->toBeFalse();
});

test('a past due subscription update marks the account as overdue', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_'.Str::random(16)]);

    event(new WebhookReceived([
        'type' => 'customer.subscription.updated',
        'data' => [
            'object' => [
                'customer' => $user->stripe_id,
                'status' => 'past_due',
            ],
        ],
    ]));

    expect($user->fresh()->hasPaymentDue())->toBeTrue();
});
