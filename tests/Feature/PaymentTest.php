<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

uses()->group('payments');

test('guest cannot access payment upload page', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
    ]);

    $this->get(route('payments.create', $order))
        ->assertRedirect(route('login'));
});

test('user can view payment upload page for their pending order', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
        'payment_status' => 'pending',
    ]);

    actingAs($user)
        ->get(route('payments.create', $order))
        ->assertSuccessful()
        ->assertViewIs('payments.create')
        ->assertViewHas('order');
});

test('user cannot access payment upload page for verified order', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
        'payment_status' => 'verified',
    ]);

    actingAs($user)
        ->get(route('payments.create', $order))
        ->assertForbidden();
});

test('user can upload payment proof', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
        'payment_status' => 'pending',
    ]);

    $file = UploadedFile::fake()->image('payment.jpg');

    actingAs($user)
        ->post(route('payments.store', $order), [
            'payment_proof' => $file,
        ])
        ->assertRedirect(route('orders.show', $order))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('payments', [
        'order_id' => $order->id,
        'status' => 'pending_verification',
    ]);

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'payment_status' => 'pending_verification',
    ]);

    Storage::disk('public')->assertExists('payment-proofs/'.$file->hashName());
});

test('payment proof is required', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
        'payment_status' => 'pending',
    ]);

    actingAs($user)
        ->post(route('payments.store', $order), [])
        ->assertSessionHasErrors(['payment_proof']);
});

test('payment proof must be image', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'address_id' => $address->id,
        'payment_status' => 'pending',
    ]);

    $file = UploadedFile::fake()->create('document.pdf', 1024);

    actingAs($user)
        ->post(route('payments.store', $order), [
            'payment_proof' => $file,
        ])
        ->assertSessionHasErrors(['payment_proof']);
});

test('user cannot upload payment for other users order', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $otherUser->id]);
    $order = Order::factory()->create([
        'user_id' => $otherUser->id,
        'address_id' => $address->id,
        'payment_status' => 'pending',
    ]);

    $file = UploadedFile::fake()->image('payment.jpg');

    actingAs($user)
        ->post(route('payments.store', $order), [
            'payment_proof' => $file,
        ])
        ->assertForbidden();
});
