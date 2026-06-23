<?php

use App\Models\Address;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('checkout');

test('guest cannot access checkout page', function () {
    $this->get(route('checkout.index'))
        ->assertRedirect(route('login'));
});

test('user without address is redirected to create address', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('checkout.index'))
        ->assertRedirect(route('addresses.create'))
        ->assertSessionHas('status');
});

test('user can view checkout page with addresses', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('checkout.index'))
        ->assertSuccessful()
        ->assertViewIs('checkout.index')
        ->assertViewHas('addresses')
        ->assertViewHas('defaultAddress');
});

test('user can create order', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->post(route('checkout.store'), [
            'address_id' => $address->id,
            'notes' => 'Test notes',
        ])
        ->assertRedirect()
        ->assertSessionHas('status');

    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'address_id' => $address->id,
        'notes' => 'Test notes',
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);
});

test('checkout requires address_id', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('checkout.store'), [
            'notes' => 'Test notes',
        ])
        ->assertSessionHasErrors(['address_id']);
});

test('checkout validates address_id exists', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('checkout.store'), [
            'address_id' => 99999,
        ])
        ->assertSessionHasErrors(['address_id']);
});

test('checkout notes is optional', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->post(route('checkout.store'), [
            'address_id' => $address->id,
        ])
        ->assertRedirect()
        ->assertSessionHas('status');

    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'address_id' => $address->id,
        'notes' => null,
    ]);
});
