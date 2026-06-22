<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('user can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Virgi Customer',
        'email' => 'virgi@example.com',
        'phone' => '08123456789',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'virgi@example.com',
        'phone' => '08123456789',
    ]);
});

test('user can login and logout', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);

    $this->post(route('logout'))->assertRedirect(route('login'));

    $this->assertGuest();
});

test('dashboard requires authentication', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});
