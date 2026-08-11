<?php

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Str;

test('the role seeder creates all platform user types', function () {
    $this->seed(RoleSeeder::class);

    expect(Role::query()->count())->toBe(4);
    expect(Role::query()->pluck('slug')->all())
        ->toContain('administrador', 'videomaker', 'cliente', 'empresa');
});

test('new users are assigned the videomaker role by default', function () {
    $user = User::factory()->create();

    expect($user->hasRole(UserRole::Videomaker))->toBeTrue();
});

test('a role can be assigned and checked', function () {
    $user = User::factory()->create();

    $user->assignRole(UserRole::Cliente);

    expect($user->hasRole(UserRole::Cliente))->toBeTrue()
        ->and($user->hasRole(UserRole::Empresa))->toBeFalse();
});

test('an administrator can be promoted via the make-admin command', function () {
    $user = User::factory()->create(['email' => 'admin@example.com']);

    $this->artisan('app:make-admin', ['email' => 'admin@example.com'])
        ->assertExitCode(0);

    expect($user->fresh()->isAdmin())->toBeTrue()
        ->and($user->fresh()->is_admin)->toBeTrue();
});

test('the make-admin command fails for unknown users', function () {
    $this->artisan('app:make-admin', ['email' => 'nobody@example.com'])
        ->assertExitCode(1);
});

test('users without the administrator role are not admins', function () {
    $user = User::factory()->create([
        'email' => Str::random(8).'@example.com',
    ]);

    expect($user->isAdmin())->toBeFalse()
        ->and($user->is_admin)->toBeFalse();
});
