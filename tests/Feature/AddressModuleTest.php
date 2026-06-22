<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function addressPayload(array $overrides = []): array
{
    return array_merge([
        'recipient_name' => 'Virgi',
        'phone' => '08123456789',
        'province' => 'Jawa Barat',
        'city' => 'Bandung',
        'district' => 'Coblong',
        'postal_code' => '40135',
        'full_address' => 'Jl. Pengiriman No. 2',
        'latitude' => '-6.8915000',
        'longitude' => '107.6107000',
    ], $overrides);
}

test('user can manage addresses', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('addresses.store'), addressPayload())
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('addresses.index'));

    $address = $user->addresses()->first();

    expect($address)
        ->not->toBeNull()
        ->is_default->toBeFalse();

    $this->actingAs($user)
        ->patch(route('addresses.update', $address), addressPayload(['city' => 'Cimahi']))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('addresses.index'));

    expect($address->fresh()->city)->toBe('Cimahi');

    $this->actingAs($user)
        ->delete(route('addresses.destroy', $address))
        ->assertRedirect(route('addresses.index'));

    $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
});

test('user cannot edit another users address', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $address = $owner->addresses()->create(addressPayload());

    $this->actingAs($other)
        ->get(route('addresses.edit', $address))
        ->assertForbidden();
});
