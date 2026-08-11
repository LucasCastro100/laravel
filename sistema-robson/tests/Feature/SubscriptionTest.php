<?php

use App\Models\Plan;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Plan::factory()->trial()->create();
    Plan::factory()->pro()->create(['stripe_price_id' => 'price_pro']);
    Plan::factory()->max()->create(['stripe_price_id' => 'price_max']);
});

test('guests are redirected to the login page when visiting the billing page', function () {
    $this->get(route('assinatura.index'))->assertRedirect(route('login'));
});

test('authenticated users can visit the billing page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('assinatura.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('assinatura/index')
            ->has('plans', 3)
            ->where('currentPlan.slug', 'trial')
            ->where('paymentGraceDays', User::PAYMENT_GRACE_DAYS)
            ->where('subscription', null)
            ->where('blockedAt', null));
});

test('the billing page lists trial, pro and max plans', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('assinatura.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->has('plans', 3)
            ->where('plans.0.slug', 'trial')
            ->where('plans.0.isFree', true)
            ->where('plans.1.slug', 'pro')
            ->where('plans.1.isFree', false)
            ->where('plans.2.slug', 'max')
            ->where('plans.2.isFree', false));
});

test('a free plan cannot be checked out', function () {
    $user = User::factory()->create();
    $trial = Plan::query()->where('slug', 'trial')->firstOrFail();

    $this->actingAs($user)
        ->post(route('assinatura.checkout', $trial))
        ->assertSessionHasErrors('plan');
});

test('an inactive plan cannot be checked out', function () {
    $user = User::factory()->create();
    $plan = Plan::factory()->create([
        'slug' => 'archived',
        'stripe_price_id' => 'price_archived',
        'is_active' => false,
    ]);

    $this->actingAs($user)
        ->post(route('assinatura.checkout', $plan))
        ->assertSessionHasErrors('plan');
});

test('canceling without a subscription returns an error flash', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('assinatura.cancel'))
        ->assertRedirect();
});

test('resuming without a grace period returns an error flash', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('assinatura.resume'))
        ->assertRedirect();
});
