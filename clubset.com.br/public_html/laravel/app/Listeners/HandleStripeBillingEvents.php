<?php

namespace App\Listeners;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;

class HandleStripeBillingEvents
{
    /**
     * Handle the webhook payload.
     */
    public function handle(WebhookReceived $event): void
    {
        $type = $event->payload['type'] ?? null;

        match ($type) {
            'invoice.payment_succeeded' => $this->handlePaymentSucceeded($event->payload),
            'invoice.payment_failed' => $this->handlePaymentFailed($event->payload),
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($event->payload),
            default => null,
        };
    }

    /**
     * Record a successful payment and unblock the account.
     *
     * @param  array<string, mixed>  $payload
     */
    protected function handlePaymentSucceeded(array $payload): void
    {
        $user = $this->billableFromPayload($payload);

        if (! $user) {
            return;
        }

        $invoice = $payload['data']['object'];

        $this->recordPayment($user, $invoice, 'succeeded');

        $user->unblockAccount();
    }

    /**
     * Record a failed payment and flag the account as overdue.
     *
     * @param  array<string, mixed>  $payload
     */
    protected function handlePaymentFailed(array $payload): void
    {
        $user = $this->billableFromPayload($payload);

        if (! $user) {
            return;
        }

        $invoice = $payload['data']['object'];

        $this->recordPayment($user, $invoice, 'failed');

        if (! $user->hasPaymentDue()) {
            $user->markPaymentDue();
        }
    }

    /**
     * Keep the overdue marker in sync with the subscription status.
     *
     * @param  array<string, mixed>  $payload
     */
    protected function handleSubscriptionUpdated(array $payload): void
    {
        $user = $this->billableFromPayload($payload);

        if (! $user) {
            return;
        }

        $status = $payload['data']['object']['status'] ?? null;

        if ($status === 'active' || $status === 'trialing') {
            $user->clearPaymentDue();
        } elseif (in_array($status, ['past_due', 'unpaid', 'incomplete'], true)) {
            if (! $user->hasPaymentDue()) {
                $user->markPaymentDue();
            }
        }
    }

    /**
     * Persist a payment from the invoice payload (idempotent).
     *
     * @param  array<string, mixed>  $invoice
     */
    protected function recordPayment(User $user, array $invoice, string $status): void
    {
        $paymentIntent = $invoice['payment_intent'] ?? null;
        $invoiceId = $invoice['id'] ?? null;
        $stripeSubscriptionId = data_get($invoice, 'parent.subscription_details.subscription')
            ?? $invoice['subscription']
            ?? null;

        $period = data_get($invoice, 'lines.data.0.period');
        $periodStart = isset($period['start']) ? Carbon::createFromTimestamp($period['start']) : null;
        $periodEnd = isset($period['end']) ? Carbon::createFromTimestamp($period['end']) : null;

        $attributes = [
            'user_id' => $user->id,
            'subscription_id' => $stripeSubscriptionId
                ? $user->subscriptions()->where('stripe_id', $stripeSubscriptionId)->value('id')
                : null,
            'stripe_invoice' => $invoiceId,
            'amount' => ($invoice['amount_paid'] ?? $invoice['amount_due'] ?? 0) / 100,
            'currency' => strtoupper($invoice['currency'] ?? 'brl'),
            'status' => $status,
            'type' => $stripeSubscriptionId ? 'recurring' : 'manual',
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
        ];

        if ($paymentIntent) {
            Payment::query()->firstOrCreate(
                ['stripe_payment_intent' => $paymentIntent],
                $attributes,
            );

            return;
        }

        Payment::query()->create($attributes);
    }

    /**
     * Resolve the billable user from the webhook payload.
     */
    protected function billableFromPayload(array $payload): ?User
    {
        $customerId = $payload['data']['object']['customer'] ?? null;

        if (! $customerId) {
            return null;
        }

        $billable = Cashier::findBillable($customerId);

        return $billable instanceof User ? $billable : null;
    }
}
