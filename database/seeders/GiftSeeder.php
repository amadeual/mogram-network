<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gift;

class GiftSeeder extends Seeder
{
    public function run()
    {
        $gifts = [
            ['name' => 'Rosa', 'icon' => '🌹', 'price' => 0.50],
            ['name' => 'Café', 'icon' => '☕', 'price' => 1.00],
            ['name' => 'Joinha', 'icon' => '👍', 'price' => 2.00],
            ['name' => 'Fogo', 'icon' => '🔥', 'price' => 5.00],
            ['name' => 'Cerveja', 'icon' => '🍺', 'price' => 10.00],
            ['name' => 'Pizza', 'icon' => '🍕', 'price' => 20.00],
            ['name' => 'Game', 'icon' => '🎮', 'price' => 50.00],
            ['name' => 'Saxofone', 'icon' => '🎷', 'price' => 100.00],
            ['name' => 'Guitarra', 'icon' => '🎸', 'price' => 250.00],
            ['name' => 'Diamante Mogram', 'icon' => '💎', 'price' => 500.00],
        ];

        foreach ($gifts as $gift) {
            Gift::updateOrCreate(['name' => $gift['name']], $gift);
        }
    }
}
