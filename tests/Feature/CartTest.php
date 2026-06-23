<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from cart', function () {
    $this->get(route('cart.index'))->assertRedirect(route('login'));
});

it('lets authenticated users add products to cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['stock' => 5]);

    $this->actingAs($user)
        ->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])
        ->assertRedirect(route('cart.index'));

    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);
});

it('increases quantity when adding the same product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['stock' => 5]);

    $this->actingAs($user)->post(route('cart.store'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)->post(route('cart.store'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 3,
    ]);
});

it('does not add products beyond stock', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['stock' => 1]);

    $this->actingAs($user)
        ->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])
        ->assertSessionHas('status', 'Stok produk tidak mencukupi.');

    $this->assertDatabaseMissing('cart_items', [
        'product_id' => $product->id,
    ]);
});

it('lets users update their cart item quantity', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $product = Product::factory()->create(['stock' => 10]);
    $item = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)
        ->patch(route('cart.update', $item), ['quantity' => 4])
        ->assertRedirect(route('cart.index'));

    $this->assertDatabaseHas('cart_items', [
        'id' => $item->id,
        'quantity' => 4,
    ]);
});

it('lets users remove their cart item', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $this->actingAs($user)
        ->delete(route('cart.destroy', $item))
        ->assertRedirect(route('cart.index'));

    $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
});

it('prevents users from changing another users cart item', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $owner->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $this->actingAs($intruder)
        ->patch(route('cart.update', $item), ['quantity' => 2])
        ->assertForbidden();

    $this->actingAs($intruder)
        ->delete(route('cart.destroy', $item))
        ->assertForbidden();
});
