<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('user can update profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'Virgi Updated',
            'email' => 'updated@example.com',
            'phone' => '0899999999',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect($user->fresh())
        ->name->toBe('Virgi Updated')
        ->email->toBe('updated@example.com')
        ->phone->toBe('0899999999');
});

test('user can update password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $this->actingAs($user)
        ->patch(route('profile.password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});
