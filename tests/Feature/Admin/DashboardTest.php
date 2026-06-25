<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access admin dashboard', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admin can view dashboard', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertViewIs('admin.dashboard')
        ->assertViewHas('stats')
        ->assertViewHas('recentOrders');
});

test('dashboard shows correct stats', function () {
    $admin = User::factory()->admin()->create();

    User::factory()->count(5)->create();

    actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSuccessful();
});
