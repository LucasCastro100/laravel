<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\actingAs;

test('a pending user is redirected to their profile when visiting the dashboard', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('profile.edit'));
});

test('a pending user can view their own profile', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('settings/profile'));
});

test('a pending user can update their own profile', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'Novo Nome',
            'email' => $user->email,
        ])
        ->assertRedirect(route('profile.edit'));

    expect($user->fresh()->name)->toBe('Novo Nome');
});

test('a pending user can log out', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});

test('a pending user is redirected away from the subscription area', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('assinatura.index'))
        ->assertRedirect(route('profile.edit'));
});

test('a pending user is redirected away from the first-access flow', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('primeiro-acesso.index'))
        ->assertRedirect(route('profile.edit'));
});

test('a pending user is redirected away from creating content', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('listings.store'), [])
        ->assertRedirect(route('profile.edit'));
});

test('a verified user is not blocked from the dashboard', function () {
    $user = User::factory()->adminVerified()->create();

    actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();
});

test('an admin is not blocked even without an admin verification timestamp', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();
});
