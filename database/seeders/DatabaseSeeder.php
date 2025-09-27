<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductSeeder::class, // Primero los productos
            UserSeeder::class,    // Luego los clientes
            OrderSeeder::class,   // Finalmente las órdenes que los conectan
        ]);
    }
}