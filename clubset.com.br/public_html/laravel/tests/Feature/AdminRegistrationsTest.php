<?php

use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\Municipality;
use App\Models\State;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

function adminRegistrationsUser(string $city = 'São Paulo'): User
{
    $state = State::factory()->create();
    $municipality = Municipality::factory()->create([
        'state_id' => $state->id,
        'name' => $city,
    ]);

    return User::factory()->create([
        'state_id' => $state->id,
        'municipality_id' => $municipality->id,
    ]);
}

function adminRegistrationFactory(string $city = 'São Paulo')
{
    $state = State::factory()->create();
    $municipality = Municipality::factory()->create([
        'state_id' => $state->id,
        'name' => $city,
    ]);

    return User::factory()->state([
        'state_id' => $state->id,
        'municipality_id' => $municipality->id,
    ]);
}

test('only admins can access the registrations list', function () {
    $this->get(route('admin.registrations'))->assertRedirect(route('login'));

    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.registrations'))->assertForbidden();
});

test('admin sees all registrations with name, city and role', function () {
    $admin = User::factory()->admin()->adminVerified()->create();
    $pending = adminRegistrationsUser('Campinas');
    $verified = adminRegistrationFactory('Ribeirão Preto')
        ->adminVerified()
        ->create();
    $verified->syncRole(UserRole::Cliente);

    $this->actingAs($admin)
        ->get(route('admin.registrations'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/registrations')
            ->has('users', 3)
            ->where('users.0.name', $verified->name)
            ->where('users.0.role', 'cliente')
            ->where('users.0.verifiedAt', $verified->admin_verified_at->toIso8601String())
            ->where('users.1.name', $pending->name)
            ->where('users.1.verifiedAt', null)
            ->where('users.2.name', $admin->name));
});

test('registrations can be filtered by role', function () {
    $admin = User::factory()->admin()->create();
    adminRegistrationsUser()->syncRole(UserRole::Cliente);
    adminRegistrationsUser()->syncRole(UserRole::Empresa);

    $this->actingAs($admin)
        ->get(route('admin.registrations', ['role' => 'cliente']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/registrations')
            ->has('users', 1)
            ->where('users.0.role', 'cliente'));
});

test('registrations can be filtered by city and name', function () {
    $admin = User::factory()->admin()->create();
    $campinas = adminRegistrationsUser('Campinas');
    adminRegistrationsUser('São Paulo');

    $this->actingAs($admin)
        ->get(route('admin.registrations', ['cidade' => 'Campin']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/registrations')
            ->has('users', 1)
            ->where('users.0.name', $campinas->name));

    $this->actingAs($admin)
        ->get(route('admin.registrations', ['nome' => $campinas->name]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/registrations')
            ->has('users', 1)
            ->where('users.0.name', $campinas->name));
});

test('only pending registrations are shown with the pending filter', function () {
    $admin = User::factory()->admin()->adminVerified()->create();
    $pending = adminRegistrationsUser();
    adminRegistrationFactory()->adminVerified()->create();

    $this->actingAs($admin)
        ->get(route('admin.registrations', ['pending' => 1]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/registrations')
            ->has('users', 1)
            ->where('users.0.name', $pending->name));
});

test('an admin can verify a pending registration', function () {
    $admin = User::factory()->admin()->create();
    $user = adminRegistrationsUser();

    expect($user->fresh()->admin_verified_at)->toBeNull();

    $this->actingAs($admin)
        ->post(route('admin.verify', $user))
        ->assertRedirect();

    expect($user->fresh()->admin_verified_at)->not->toBeNull();
});

test('an admin can deactivate a registration back to pending', function () {
    $admin = User::factory()->admin()->create();
    $user = adminRegistrationFactory()->adminVerified()->create();

    expect($user->fresh()->admin_verified_at)->not->toBeNull();

    $this->actingAs($admin)
        ->post(route('admin.deactivate', $user))
        ->assertRedirect();

    expect($user->fresh()->admin_verified_at)->toBeNull();
});

test('an admin can delete a registration and its cascaded content', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $listing = Listing::factory()->create(['user_id' => $user->id]);

    $this->actingAs($admin)
        ->delete(route('admin.destroy', $user))
        ->assertRedirect();

    expect(User::find($user->id))->toBeNull()
        ->and(Listing::find($listing->id))->toBeNull();
});

test('a non-admin cannot delete a registration', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.destroy', $user))
        ->assertForbidden();

    expect(User::find($user->id))->not->toBeNull();
});
