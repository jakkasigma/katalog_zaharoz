<?php

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

uses()->group('admin');

test('guest cannot access payments', function () {
    $this->get(route('admin.payments.index'))
        ->assertRedirect(route('admin.login'));
});

test('non-admin cannot access payments', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.payments.index'))
        ->assertForbidden();
});

test('admin can view payments index', function () {
    actingAs(User::factory()->admin()->create())
        ->get(route('admin.payments.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.payments.index');
});

test('admin can approve payment', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['payment_status' => 'pending_verification']);
    $payment = Payment::factory()->create([
        'order_id' => $order->id,
        'status' => 'pending_verification',
        'proof_path' => UploadedFile::fake()->image('proof.jpg')->store('payment-proofs', 'public'),
    ]);

    actingAs($admin)
        ->post(route('admin.payments.approve', $payment))
        ->assertRedirect(route('admin.payments.show', $payment));

    $this->assertDatabaseHas('payments', [
        'id' => $payment->id,
        'status' => 'verified',
        'verified_by' => $admin->id,
    ]);

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'payment_status' => 'verified',
    ]);
});

test('admin can reject payment', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create(['payment_status' => 'pending_verification']);
    $payment = Payment::factory()->create([
        'order_id' => $order->id,
        'status' => 'pending_verification',
    ]);

    actingAs($admin)
        ->post(route('admin.payments.reject', $payment), [
            'rejection_reason' => 'Bukti transfer tidak valid.',
        ])
        ->assertRedirect(route('admin.payments.show', $payment));

    $this->assertDatabaseHas('payments', [
        'id' => $payment->id,
        'status' => 'rejected',
        'rejection_reason' => 'Bukti transfer tidak valid.',
    ]);
});

test('rejection reason is required when rejecting payment', function () {
    $admin = User::factory()->admin()->create();
    $payment = Payment::factory()->create(['status' => 'pending_verification']);

    actingAs($admin)
        ->post(route('admin.payments.reject', $payment), [
            'rejection_reason' => '',
        ])
        ->assertSessionHasErrors(['rejection_reason']);
});
