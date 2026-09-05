<?php

use App\Models\DiagnosticoResposta;
use App\Models\Municipality;
use App\Models\State;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

function diagnosticoRespostas(): array
{
    $respostas = [];

    foreach (config('diagnosticoQuestions') as $area) {
        foreach ($area['perguntas'] as $pergunta) {
            $alt = last($pergunta['alternativas']);
            $respostas[$pergunta['id']] = [
                'letra' => $alt['letra'],
                'pontos' => $alt['pontos'],
            ];
        }
    }

    return $respostas;
}

function diagnosticoCadastro(): array
{
    $state = State::factory()->create();
    $municipality = Municipality::factory()->create(['state_id' => $state->id]);

    return [
        'renda' => 'De 1.000 a 2.000',
        'nome' => 'João Videomaker',
        'instagram' => '@joaovideo',
        'celular' => '(11) 99999-9999',
        'state_id' => $state->id,
        'municipality_id' => $municipality->id,
        'participa_grupo_whatsapp' => false,
    ];
}

test('guests can visit the diagnostic index with states and regions', function () {
    $this->get(route('diagnostico.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('diagnostico/index')
            ->has('areas', 7)
            ->has('states')
            ->has('regions'));
});

test('diagnostic requires the contact fields before saving', function () {
    $this->post(route('diagnostico.store'), [
        'respostas' => diagnosticoRespostas(),
    ])->assertSessionHasErrors(['renda', 'nome', 'instagram', 'celular', 'state_id', 'municipality_id', 'participa_grupo_whatsapp']);
});

test('diagnostic only accepts a valid income range', function () {
    $this->post(route('diagnostico.store'), [
        ...diagnosticoCadastro(),
        'renda' => 'R$ 999.999',
        'respostas' => diagnosticoRespostas(),
    ])->assertSessionHasErrors('renda');
});

test('diagnostic requires the group name when the user participates in a group', function () {
    $this->post(route('diagnostico.store'), [
        ...diagnosticoCadastro(),
        'participa_grupo_whatsapp' => true,
        'respostas' => diagnosticoRespostas(),
    ])->assertSessionHasErrors('grupo_whatsapp_qual');
});

test('store saves the contact and answers and redirects to the result', function () {
    $payload = [
        ...diagnosticoCadastro(),
        'respostas' => diagnosticoRespostas(),
    ];

    $this->post(route('diagnostico.store'), $payload)
        ->assertRedirect();

    $registro = DiagnosticoResposta::query()->firstOrFail();

    expect($registro->nome)->toBe('João Videomaker');
    expect($registro->instagram)->toBe('@joaovideo');
    expect($registro->renda)->toBe('De 1.000 a 2.000');
    expect($registro->participa_grupo_whatsapp)->toBeFalse();
    expect($registro->grupo_whatsapp_qual)->toBeNull();
    expect($registro->resultado)->not->toBeEmpty();

    $this->get(route('diagnostico.resultado', $registro->uuid))->assertOk();
});

test('store saves the group name when participating', function () {
    $payload = [
        ...diagnosticoCadastro(),
        'participa_grupo_whatsapp' => true,
        'grupo_whatsapp_qual' => 'Videomakers SP',
        'respostas' => diagnosticoRespostas(),
    ];

    $this->post(route('diagnostico.store'), $payload)->assertRedirect();

    $registro = DiagnosticoResposta::query()->firstOrFail();

    expect($registro->participa_grupo_whatsapp)->toBeTrue();
    expect($registro->grupo_whatsapp_qual)->toBe('Videomakers SP');
});

test('a new diagnostic result stays locked until the admin releases it', function () {
    $this->post(route('diagnostico.store'), [
        ...diagnosticoCadastro(),
        'respostas' => diagnosticoRespostas(),
    ])->assertRedirect();

    $registro = DiagnosticoResposta::query()->firstOrFail();

    expect($registro->resultado_liberado_em)->toBeNull();

    $this->get(route('diagnostico.resultado', $registro->uuid))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('diagnostico/resultado')
            ->where('liberado', false)
            ->has('resultado.geral'));
});

test('an admin can release the detailed diagnostic result', function () {
    $registro = DiagnosticoResposta::factory()->create();
    $admin = User::factory()->admin()->adminVerified()->create();

    $this->actingAs($admin)
        ->post(route('admin.diagnosticos.release', $registro->uuid))
        ->assertRedirect();

    expect($registro->fresh()->resultado_liberado_em)->not->toBeNull();

    $this->get(route('diagnostico.resultado', $registro->uuid))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('diagnostico/resultado')
            ->where('liberado', true));
});

test('only admins can release a diagnostic result', function () {
    $registro = DiagnosticoResposta::factory()->create();
    $user = User::factory()->adminVerified()->create();

    $this->post(route('admin.diagnosticos.release', $registro->uuid))
        ->assertRedirect(route('login'));

    $this->actingAs($user)
        ->post(route('admin.diagnosticos.release', $registro->uuid))
        ->assertForbidden();

    expect($registro->fresh()->resultado_liberado_em)->toBeNull();
});

test('the per-area result includes the explanatory text of its band', function () {
    $this->post(route('diagnostico.store'), [
        ...diagnosticoCadastro(),
        'respostas' => diagnosticoRespostas(),
    ])->assertRedirect();

    $registro = DiagnosticoResposta::query()->firstOrFail();

    $this->actingAs(
        User::factory()->admin()->adminVerified()->create(),
    )->get(route('admin.diagnosticos.show', $registro->uuid))
        ->assertInertia(fn (Assert $page) => $page
            ->component('admin/diagnostico-show')
            ->has('resultado.areas.0.texto'));

    $this->get(route('diagnostico.resultado', $registro->uuid))
        ->assertInertia(fn (Assert $page) => $page
            ->component('diagnostico/resultado')
            ->has('resultado.areas.0.texto'));
});

test('an admin can delete a diagnostic submission', function () {
    $registro = DiagnosticoResposta::factory()->create();
    $admin = User::factory()->admin()->adminVerified()->create();

    $this->actingAs($admin)
        ->delete(route('admin.diagnosticos.destroy', $registro->uuid))
        ->assertRedirect(route('admin.diagnosticos'));

    expect(DiagnosticoResposta::query()->find($registro->id))->toBeNull();
});

test('only admins can delete a diagnostic submission', function () {
    $registro = DiagnosticoResposta::factory()->create();

    $this->delete(route('admin.diagnosticos.destroy', $registro->uuid))
        ->assertRedirect(route('login'));

    $this->actingAs(
        User::factory()->adminVerified()->create(),
    )->delete(route('admin.diagnosticos.destroy', $registro->uuid))
        ->assertForbidden();

    expect(DiagnosticoResposta::query()->find($registro->id))->not->toBeNull();
});
