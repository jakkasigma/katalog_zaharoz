<?php

use App\Models\Category;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access categories', function () {
    $this->get(route('admin.categories.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access categories', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertForbidden();
});

test('admin can view categories index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.categories.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index');
});

test('admin can create category', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.categories.store'), [
            'name' => 'New Category',
            'description' => 'Test description',
            'sort_order' => 1,
            'is_active' => true,
        ])
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('categories', [
        'name' => 'New Category',
        'slug' => 'new-category',
    ]);
});

test('admin can update category', function () {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create(['name' => 'Old Name']);

    actingAs($admin)
        ->patch(route('admin.categories.update', $category), [
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'sort_order' => 2,
            'is_active' => false,
        ])
        ->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Name',
        'slug' => 'updated-name',
    ]);
});

test('admin can delete category without products', function () {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    actingAs($admin)
        ->delete(route('admin.categories.destroy', $category))
        ->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('category name is required', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.categories.store'), [
            'name' => '',
        ])
        ->assertSessionHasErrors(['name']);
});
