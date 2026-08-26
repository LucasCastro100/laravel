<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription / billing page.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('assinatura/index', [
            'currentPlan' => $this->planPayload($user->activePlan()),
            'plans' => Plan::query()->active()->ordered()->get()->map(
                fn (Plan $plan) => $this->planPayload($plan),
            ),
            'subscription' => $this->subscriptionPayload($user),
            'blockedAt' => $user->blocked_at?->toIso8601String(),
            'paymentDueAt' => $user->payment_due_at?->toIso8601String(),
            'paymentGraceDays' => User::PAYMENT_GRACE_DAYS,
        ]);
    }

    /**
     * Start a Stripe Checkout session for the given paid plan.
     */
    public function checkout(Request $request, Plan $plan): SymfonyResponse
    {
        if (! $plan->is_active || $plan->isFree()) {
            throw ValidationException::withMessages([
                'plan' => 'Este plano não pode ser assinado.',
            ]);
        }

        $checkout = $request->user()
            ->newSubscription('default', $plan->stripe_price_id)
            ->trialDays($plan->trial_days > 0 ? $plan->trial_days : null)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('assinatura.index'),
                'cancel_url' => route('assinatura.index'),
            ]);

        return Inertia::location($checkout->url);
    }

    /**
     * Cancel the user's subscription at the end of the billing period.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $subscription = $request->user()->activeSubscription();

        if (! $subscription || $subscription->canceled() || $subscription->onTrial()) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Não foi possível cancelar a assinatura.',
            ]);

            return back();
        }

        $subscription->cancel();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Assinatura cancelada. Ela permanece ativa até o fim do período atual.',
        ]);

        return back();
    }

    /**
     * Resume a subscription that is still within its grace period.
     */
    public function resume(Request $request): RedirectResponse
    {
        $subscription = $request->user()->activeSubscription();

        if (! $subscription || ! $subscription->onGracePeriod()) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Não há assinatura para reativar.',
            ]);

            return back();
        }

        $subscription->resume();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Assinatura reativada com sucesso.',
        ]);

        return back();
    }

    /**
     * Build a safe serializable representation of a plan.
     *
     * @return array<string, mixed>
     */
    protected function planPayload(?Plan $plan): ?array
    {
        if (! $plan) {
            return null;
        }

        return [
            'slug' => $plan->slug,
            'name' => $plan->name,
            'description' => $plan->description,
            'price' => $plan->price,
            'formattedPrice' => $plan->formattedPrice(),
            'currency' => $plan->currency,
            'trialDays' => $plan->trial_days,
            'features' => $plan->features ?? [],
            'isFree' => $plan->isFree(),
        ];
    }

    /**
     * Build a safe serializable representation of the user's subscription.
     *
     * @return array<string, mixed>|null
     */
    protected function subscriptionPayload(User $user): ?array
    {
        $subscription = $user->activeSubscription();

        if (! $subscription) {
            return null;
        }

        return [
            'status' => $subscription->stripe_status,
            'stripePrice' => $subscription->stripe_price,
            'onTrial' => $subscription->onTrial(),
            'active' => $subscription->active(),
            'canceled' => $subscription->canceled(),
            'onGracePeriod' => $subscription->onGracePeriod(),
            'hasIncompletePayment' => $subscription->hasIncompletePayment(),
            'trialEndsAt' => $subscription->trial_ends_at?->toIso8601String(),
            'endsAt' => $subscription->ends_at?->toIso8601String(),
            'latestPaymentId' => $subscription->latestPayment()?->id,
        ];
    }
}
