<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
});

test('dashboard renders the correct inertia component', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('dashboard')
        ->has('metrics')
        ->has('metrics.listings')
        ->has('metrics.services')
        ->has('metrics.matches')
        ->has('metrics.credits')
        ->has('recentListings')
        ->has('recentMatches'),
    );
});

test('dashboard shows user metrics with zero counts for new user', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->where('metrics.listings.total', 0)
        ->where('metrics.listings.active', 0)
        ->where('metrics.listings.pending', 0)
        ->where('metrics.services.total', 0)
        ->where('metrics.matches.total', 0)
        ->where('metrics.credits.balance', 0),
    );
});
