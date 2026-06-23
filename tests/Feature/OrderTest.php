<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('orders');

test('guest cannot access orders page', function () {
    $this->get(route('orders.index'))
        ->assertRedirect(route('login'));
});

test('user can view their orders', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    Order::factory()->count(3)->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
    ]);

    actingAs($user)
        ->get(route('orders.index'))
        ->assertSuccessful()
        ->assertViewIs('orders.index')
        ->assertViewHas('orders');
});

test('user can view their order detail', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
    ]);

    actingAs($user)
        ->get(route('orders.show', $order))
        ->assertSuccessful()
        ->assertViewIs('orders.show')
        ->assertViewHas('order');
});

test('user cannot view other users order', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $otherUser->id]);
    $order = Order::factory()->create([
        'user_id' => $otherUser->id,
        'address_id' => $address->id,
    ]);

    actingAs($user)
        ->get(route('orders.show', $order))
        ->assertForbidden();
});
