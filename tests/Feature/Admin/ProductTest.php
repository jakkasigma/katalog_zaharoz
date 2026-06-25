<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access products', function () {
    $this->get(route('admin.products.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access products', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.products.index'))
        ->assertForbidden();
});

test('admin can view products index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.products.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index');
});

test('admin can create product', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    actingAs($admin)
        ->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'description' => 'Test description',
            'price' => 100000,
            'stock' => 10,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('product.jpg'),
        ])
        ->assertRedirect(route('admin.products.index'));

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'slug' => 'test-product',
        'sku' => 'TEST-001',
    ]);

    Storage::disk('public')->assertExists(Product::latest()->first()->image_path);
});

test('admin can update product', function () {
    $admin = User::factory()->admin()->create();
    $product = Product::factory()->create(['name' => 'Old Name']);

    actingAs($admin)
        ->patch(route('admin.products.update', $product), [
            'category_id' => $product->category_id,
            'name' => 'Updated Name',
            'sku' => $product->sku,
            'price' => 150000,
            'stock' => 5,
            'is_active' => false,
        ])
        ->assertRedirect(route('admin.products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Name',
        'is_active' => false,
    ]);
});

test('product name is required', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.products.store'), [
            'name' => '',
            'price' => 100000,
            'stock' => 10,
        ])
        ->assertSessionHasErrors(['name']);
});

test('product price must be numeric', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.products.store'), [
            'name' => 'Test',
            'price' => 'invalid',
            'stock' => 10,
        ])
        ->assertSessionHasErrors(['price']);
});
