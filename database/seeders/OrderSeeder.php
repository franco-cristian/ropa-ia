<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->info('No users or products found, skipping order creation.');
            return;
        }

        // Crearemos 200 órdenes para tener un buen historial
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $orderDate = fake()->dateTimeBetween('-1 year', 'now');
            
            // Creamos la orden primero con un total temporal
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0,
                'status' => 'completed',
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            $totalAmount = 0;
            // Cada orden tendrá entre 1 y 4 productos diferentes
            $productsInOrder = $products->random(rand(1, 4));

            foreach ($productsInOrder as $product) {
                // Solo vendemos si hay stock
                if ($product->stock > 0) {
                    $quantity = rand(1, 3);
                    // Nos aseguramos de no vender más de lo que hay
                    $quantity = min($quantity, $product->stock); 

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);

                    $totalAmount += $product->price * $quantity;
                    
                    // Descontamos el stock (opcional)
                    $product->decrement('stock', $quantity);
                }
            }

            // Si la orden tiene items, actualizamos el total
            if ($totalAmount > 0) {
                $order->update(['total_amount' => $totalAmount]);
            } else {
                // Si no se pudo añadir ningún producto (ej. sin stock), borramos la orden vacía
                $order->delete();
            }
        }
    }
}