<?php

use App\Models\Order;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access orders', function () {
    $this->get(route('admin.orders.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access orders', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.orders.index'))
        ->assertForbidden();
});

test('admin can view orders index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.orders.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index');
});

test('admin can update order status', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['status' => 'pending']);

    actingAs($admin)
        ->patch(route('admin.orders.update-status', $order), [
            'status' => 'processing',
        ])
        ->assertRedirect(route('admin.orders.show', $order));

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'processing',
    ]);
});

test('admin can update order to shipped with tracking number', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['status' => 'processing']);

    actingAs($admin)
        ->patch(route('admin.orders.update-status', $order), [
            'status' => 'shipped',
            'tracking_number' => 'JNE123456789',
        ])
        ->assertRedirect(route('admin.orders.show', $order));

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'shipped',
        'tracking_number' => 'JNE123456789',
    ]);

    expect($order->fresh()->shipped_at)->not->toBeNull();
});

test('tracking number is required when status is shipped', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['status' => 'processing']);

    actingAs($admin)
        ->patch(route('admin.orders.update-status', $order), [
            'status' => 'shipped',
        ])
        ->assertSessionHasErrors(['tracking_number']);
});

test('invalid status transition is rejected', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['status' => 'delivered']);

    actingAs($admin)
        ->patch(route('admin.orders.update-status', $order), [
            'status' => 'processing',
        ])
        ->assertSessionHasErrors(['status']);
});
