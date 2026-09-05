<?php

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingType;
use App\Models\Listing;
use App\Models\Permuta;
use App\Models\Service;
use App\Models\User;

test('security headers are applied to responses', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

test('a user cannot update another user listing', function () {
    $owner = User::factory()->adminVerified()->create();
    $attacker = User::factory()->adminVerified()->create();

    $listing = Listing::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($attacker)
        ->put(route('listings.update', $listing), [
            'title' => 'Hacked',
            'description' => 'x',
            'category' => EquipmentCategory::Camera->value,
            'intent' => ListingIntent::Ofereco->value,
            'type' => ListingType::Permuta->value,
            'condition' => EquipmentCondition::Novo->value,
        ])
        ->assertForbidden();

    $this->assertDatabaseHas('listings', ['id' => $listing->id, 'title' => $listing->title]);
});

test('a user cannot update another user service', function () {
    $owner = User::factory()->adminVerified()->create();
    $attacker = User::factory()->adminVerified()->create();

    $service = Service::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($attacker)
        ->put(route('services.update', $service), [
            'title' => 'Hacked',
            'description' => 'x',
        ])
        ->assertForbidden();
});

test('a user cannot update another user permuta', function () {
    $owner = User::factory()->adminVerified()->create();
    $attacker = User::factory()->adminVerified()->create();

    $permuta = Permuta::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($attacker)
        ->put(route('permutas.update', $permuta), [
            'titulo' => 'Hacked',
            'descricao' => 'x',
            'valor' => 100,
        ])
        ->assertForbidden();
});

test('sensitive user attributes are hidden from serialization', function () {
    $owner = User::factory()->adminVerified()->create();

    $owner->forceFill([
        'stripe_id' => 'cus_test123',
        'pm_last_four' => '4242',
        'pm_type' => 'card',
    ])->save();

    $payload = $owner->toArray();

    expect($payload['stripe_id'] ?? null)->toBeNull();
    expect($payload['pm_last_four'] ?? null)->toBeNull();
    expect($payload['pm_type'] ?? null)->toBeNull();
});
