<?php

use App\Enums\PermutaStatus;
use App\Enums\UserRole;
use App\Models\Permuta;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page on the permutas index', function () {
    $this->get(route('permutas.index'))
        ->assertRedirect(route('login'));
});

test('the index page renders the financial summary and the list', function () {
    $user = User::factory()->create();
    $contact = User::factory()->create();

    Permuta::factory()->create(['user_id' => $user->id, 'valor' => 1500]);
    Permuta::factory()->withContact($user)->create(['user_id' => $contact->id, 'valor' => 500]);
    Permuta::factory()->withContact($contact)->create(['user_id' => $user->id, 'valor' => 200, 'status' => PermutaStatus::Cancelled]);

    $response = $this->actingAs($user)->get(route('permutas.index'));

    $response->assertOk();

    // Ganhos = permutas criadas (1500 + 200), despesas = permutas vinculadas (500),
    // mas a cancelada não entra no resumo.
    $response->assertInertia(fn (Assert $page) => $page
        ->component('permutas/index')
        ->where('summary.ganhos', 1500)
        ->where('summary.despesas', 500)
        ->where('summary.total', 1000)
        ->has('permutas', 3),
    );
});

test('a user can create a permuta linking a registered user', function () {
    $creator = User::factory()->create();
    $contact = User::factory()->create();

    $response = $this->actingAs($creator)->post(route('permutas.store'), [
        'contato_id' => $contact->id,
        'titulo' => 'Filmagem de casamento',
        'descricao' => 'Troca de serviço',
        'valor' => 250000,
        'data' => '2026-09-01',
        'status' => 'concluida',
    ]);

    $response->assertRedirect(route('permutas.index'));

    $this->assertDatabaseHas('permutas', [
        'user_id' => $creator->id,
        'contato_id' => $contact->id,
        'contato_nome' => $contact->name,
        'valor' => 2500.00,
        'titulo' => 'Filmagem de casamento',
    ]);
});

test('a user can create a permuta with a free-form person, registering them as a client', function () {
    $creator = User::factory()->create();

    $this->actingAs($creator)->post(route('permutas.store'), [
        'contato_nome' => 'Cliente João',
        'contato_email' => 'joao@example.com',
        'valor' => 10000,
        'status' => 'pendente',
    ])->assertRedirect(route('permutas.index'));

    $novoUsuario = User::where('email', 'joao@example.com')->first();

    expect($novoUsuario)->not->toBeNull()
        ->and($novoUsuario->hasRole(UserRole::Cliente))->toBeTrue()
        ->and($novoUsuario->mustChangePassword())->toBeTrue();

    $this->assertDatabaseHas('permutas', [
        'user_id' => $creator->id,
        'contato_id' => $novoUsuario->id,
        'contato_nome' => 'Cliente João',
        'valor' => 100.00,
    ]);
});

test('a free-form person requires a name, an email and cannot reuse the creators email', function () {
    $creator = User::factory()->create();

    // Missing email -> error
    $this->actingAs($creator)
        ->post(route('permutas.store'), [
            'contato_nome' => 'Cliente João',
            'valor' => 500,
            'status' => 'pendente',
        ])
        ->assertSessionHasErrors('contato_email');

    // The creators own email -> error
    $this->actingAs($creator)
        ->post(route('permutas.store'), [
            'contato_nome' => 'Cliente João',
            'contato_email' => $creator->email,
            'valor' => 500,
            'status' => 'pendente',
        ])
        ->assertSessionHasErrors('contato_email');
});

test('validation requires a value and exactly one linked party', function () {
    $creator = User::factory()->create();

    $this->actingAs($creator)
        ->post(route('permutas.store'), [
            'valor' => '',
            'status' => 'concluida',
        ])
        ->assertSessionHasErrors(['valor', 'contato_id']);

    // Both linked parties provided -> error
    $contact = User::factory()->create();
    $this->actingAs($creator)
        ->post(route('permutas.store'), [
            'contato_id' => $contact->id,
            'contato_nome' => 'Cliente João',
            'valor' => 500,
            'status' => 'concluida',
        ])
        ->assertSessionHasErrors('contato_id');

    // Linking yourself -> error
    $this->actingAs($creator)
        ->post(route('permutas.store'), [
            'contato_id' => $creator->id,
            'valor' => 500,
            'status' => 'concluida',
        ])
        ->assertSessionHasErrors('contato_id');
});

test('only the creator can update a permuta', function () {
    $creator = User::factory()->create();
    $other = User::factory()->create();
    $contact = User::factory()->create();

    $permuta = Permuta::factory()->withContact($contact)->create([
        'user_id' => $creator->id,
        'valor' => 1000,
    ]);

    $this->actingAs($other)
        ->put(route('permutas.update', $permuta), [
            'contato_id' => $contact->id,
            'valor' => 900,
            'status' => 'concluida',
        ])
        ->assertForbidden();

    $this->actingAs($creator)
        ->put(route('permutas.update', $permuta), [
            'contato_id' => $contact->id,
            'titulo' => 'Editado',
            'valor' => 90000,
            'status' => 'concluida',
        ])
        ->assertRedirect(route('permutas.index'));

    expect($permuta->fresh()->titulo)->toBe('Editado')
        ->and((float) $permuta->fresh()->valor)->toBe(900.0);
});

test('only the creator can delete a permuta', function () {
    $creator = User::factory()->create();
    $other = User::factory()->create();
    $contact = User::factory()->create();

    $permuta = Permuta::factory()->withContact($contact)->create(['user_id' => $creator->id]);

    $this->actingAs($other)
        ->delete(route('permutas.destroy', $permuta))
        ->assertForbidden();

    $this->actingAs($creator)
        ->delete(route('permutas.destroy', $permuta))
        ->assertRedirect(route('permutas.index'));

    expect(Permuta::find($permuta->id))->toBeNull();
});

test('a linked contact cannot edit a permuta created by someone else', function () {
    $creator = User::factory()->create();
    $contact = User::factory()->create();

    $permuta = Permuta::factory()->withContact($contact)->create([
        'user_id' => $creator->id,
        'valor' => 500,
    ]);

    $this->actingAs($contact)
        ->put(route('permutas.update', $permuta), [
            'contato_id' => $creator->id,
            'valor' => 1,
            'status' => 'concluida',
        ])
        ->assertForbidden();
});

test('the share link is publicly accessible without authentication', function () {
    $creator = User::factory()->create();
    $permuta = Permuta::factory()->create([
        'user_id' => $creator->id,
        'contato_nome' => 'Pessoa Avulsa',
        'titulo' => 'Serviço de drone',
    ]);

    $this->get(route('permutas.share', $permuta->uuid))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('permutas/share')
            ->where('permuta.titulo', 'Serviço de drone'));
});

test('the share link returns 404 for an unknown uuid', function () {
    $this->get(route('permutas.share', Str::uuid()))
        ->assertNotFound();
});

test('permalink uses the creator policy for viewing', function () {
    $creator = User::factory()->create();
    $contact = User::factory()->create();
    $stranger = User::factory()->create();

    $permuta = Permuta::factory()->withContact($contact)->create(['user_id' => $creator->id]);

    expect($creator->can('view', $permuta))->toBeTrue()
        ->and($contact->can('view', $permuta))->toBeTrue()
        ->and($stranger->can('view', $permuta))->toBeFalse()
        ->and($stranger->can('update', $permuta))->toBeFalse()
        ->and($contact->can('update', $permuta))->toBeFalse()
        ->and($creator->can('update', $permuta))->toBeTrue();
});
