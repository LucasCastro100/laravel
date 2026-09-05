<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

test('a user pending first access is redirected from the panel to the first-access page', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => true]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('primeiro-acesso.index'));
});

test('the first-access page renders the selectable user types', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => true]);

    $this->actingAs($user)
        ->get(route('primeiro-acesso.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('primeiro-acesso')
            ->has('tipos', 3));
});

test('a user who already completed first access is redirected to the dashboard', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => false]);

    $this->actingAs($user)
        ->get(route('primeiro-acesso.index'))
        ->assertRedirect(route('dashboard'));
});

test('completing first access stores the chosen type, sets a password and clears the flag', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => true]);
    $user->assignRole(UserRole::Cliente);

    $this->actingAs($user)
        ->post(route('primeiro-acesso.store'), [
            'role' => UserRole::Videomaker->value,
            'password' => 'NovaSenha@123',
            'password_confirmation' => 'NovaSenha@123',
        ])
        ->assertRedirect(route('dashboard'));

    $user->refresh();

    expect($user->mustChangePassword())->toBeFalse()
        ->and($user->hasRole(UserRole::Videomaker))->toBeTrue()
        ->and($user->hasRole(UserRole::Cliente))->toBeFalse()
        ->and(Hash::check('NovaSenha@123', $user->password))->toBeTrue();
});

test('first access requires a valid role and password confirmation', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => true]);

    $this->actingAs($user)
        ->post(route('primeiro-acesso.store'), [
            'role' => 'invalido',
            'password' => 'short',
            'password_confirmation' => 'diferente',
        ])
        ->assertSessionHasErrors(['role', 'password']);
});

test('a user who already completed first access cannot post to first access', function () {
    $user = User::factory()->adminVerified()->create(['must_change_password' => false]);

    $this->actingAs($user)
        ->post(route('primeiro-acesso.store'), [
            'role' => UserRole::Cliente->value,
            'password' => 'NovaSenha@123',
            'password_confirmation' => 'NovaSenha@123',
        ])
        ->assertForbidden();
});
