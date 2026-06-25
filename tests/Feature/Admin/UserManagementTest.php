<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access users', function () {
    $this->get(route('admin.users.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access users', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

test('admin can view users index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.users.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index');
});

test('admin can toggle user active status', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create(['is_active' => true]);

    actingAs($admin)
        ->patch(route('admin.users.toggle-active', $user))
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'is_active' => false,
    ]);
});

test('admin cannot deactivate themselves', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->patch(route('admin.users.toggle-active', $admin))
        ->assertForbidden();
});

test('admin can view user details', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    actingAs($admin)
        ->get(route('admin.users.show', $user))
        ->assertSuccessful()
        ->assertViewIs('admin.users.show')
        ->assertViewHas('user');
});
