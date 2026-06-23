<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();

        foreach ($users as $user) {
            $address = Address::factory()->create(['user_id' => $user->id]);

            $orders = Order::factory(3)->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
            ]);

            foreach ($orders as $order) {
                $itemsCount = rand(1, 4);
                $subtotal = 0;

                for ($i = 0; $i < $itemsCount; $i++) {
                    $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
                    $quantity = rand(1, 3);
                    $unitPrice = $product->price;
                    $itemSubtotal = $unitPrice * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                    ]);

                    $subtotal += $itemSubtotal;
                }

                $order->update([
                    'subtotal' => $subtotal,
                    'total' => $subtotal + $order->shipping_cost,
                ]);

                Payment::factory()->create([
                    'order_id' => $order->id,
                    'amount' => $order->total,
                ]);
            }
        }
    }
}
