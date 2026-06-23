<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50000, 500000);
        $shippingCost = fake()->randomFloat(2, 10000, 50000);

        return [
            'order_number' => 'ORD-'.strtoupper(fake()->bothify('??###??##')),
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'status' => fake()->randomElement(['pending', 'processing', 'packed', 'shipped', 'delivered', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'verified', 'rejected']),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal + $shippingCost,
            'notes' => fake()->optional()->sentence(),
            'tracking_number' => fake()->optional()->bothify('JNE###??########'),
            'shipped_at' => fake()->optional()->dateTimeBetween('-7 days', 'now'),
            'delivered_at' => null,
        ];
    }
}
