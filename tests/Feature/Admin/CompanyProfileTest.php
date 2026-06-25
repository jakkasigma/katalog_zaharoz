<?php

use App\Models\CompanyProfile;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access company profile', function () {
    $this->get(route('admin.company-profile.edit'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access company profile', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.company-profile.edit'))
        ->assertForbidden();
});

test('admin can view company profile edit form', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.company-profile.edit'))
        ->assertSuccessful()
        ->assertViewIs('admin.company-profile.edit');
});

test('admin can update company profile', function () {
    $admin = User::factory()->admin()->create();
    CompanyProfile::factory()->create();

    actingAs($admin)
        ->patch(route('admin.company-profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'phone' => '081234567890',
            'description' => 'Updated description',
        ])
        ->assertRedirect(route('admin.company-profile.edit'));

    $this->assertDatabaseHas('company_profiles', [
        'name' => 'Updated Name',
        'email' => 'updated@test.com',
    ]);
});

test('company profile name is required', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->patch(route('admin.company-profile.update'), [
            'name' => '',
            'email' => 'test@test.com',
            'phone' => '081234567890',
        ])
        ->assertSessionHasErrors(['name']);
});
