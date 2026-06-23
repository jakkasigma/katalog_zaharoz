<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows active products and hides inactive products', function () {
    $activeProduct = Product::factory()->create(['name' => 'Crimson Veil Coat', 'is_active' => true]);
    $inactiveProduct = Product::factory()->inactive()->create(['name' => 'Hidden Grave Coat']);

    $this->get(route('products.index'))
        ->assertSuccessful()
        ->assertSee($activeProduct->name)
        ->assertDontSee($inactiveProduct->name);
});

it('searches products by name description and sku', function () {
    Product::factory()->create([
        'name' => 'Blood Rose Shirt',
        'description' => 'A crimson ritual layer.',
        'sku' => 'EOZ-ROSE',
    ]);

    Product::factory()->create(['name' => 'Obsidian Boots']);

    $this->get(route('products.index', ['search' => 'ROSE']))
        ->assertSuccessful()
        ->assertSee('Blood Rose Shirt')
        ->assertDontSee('Obsidian Boots');
});

it('filters products by category slug', function () {
    $outerwear = Category::factory()->create(['name' => 'Outerwear', 'slug' => 'outerwear']);
    $boots = Category::factory()->create(['name' => 'Boots', 'slug' => 'boots']);

    Product::factory()->create(['category_id' => $outerwear->id, 'name' => 'Nocturne Coat']);
    Product::factory()->create(['category_id' => $boots->id, 'name' => 'Grave Boots']);

    $this->get(route('products.index', ['category' => 'outerwear']))
        ->assertSuccessful()
        ->assertSee('Nocturne Coat')
        ->assertDontSee('Grave Boots');
});

it('shows active product detail by slug', function () {
    $product = Product::factory()->create([
        'name' => 'Zaharoz Sigil Belt',
        'slug' => 'zaharoz-sigil-belt',
    ]);

    $this->get(route('products.show', $product))
        ->assertSuccessful()
        ->assertSee('Zaharoz Sigil Belt');
});

it('returns not found for inactive product detail', function () {
    $product = Product::factory()->inactive()->create([
        'slug' => 'hidden-product',
    ]);

    $this->get(route('products.show', $product))->assertNotFound();
});
