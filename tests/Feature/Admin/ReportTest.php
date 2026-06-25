<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access reports', function () {
    $this->get(route('admin.reports.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access reports', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.reports.index'))
        ->assertForbidden();
});

test('admin can view reports index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.reports.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.reports.index')
        ->assertViewHas('summary')
        ->assertViewHas('topProducts')
        ->assertViewHas('dailySales');
});

test('admin can filter reports by period', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->get(route('admin.reports.index', ['period' => 'daily', 'date' => '2026-06-24']))
        ->assertSuccessful();

    actingAs($admin)
        ->get(route('admin.reports.index', ['period' => 'monthly', 'month' => '2026-06']))
        ->assertSuccessful();

    actingAs($admin)
        ->get(route('admin.reports.index', ['period' => 'yearly', 'year' => '2026']))
        ->assertSuccessful();
});
