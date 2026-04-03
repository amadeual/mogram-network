<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gift;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gifts = [
            ['name' => 'Rosa', 'icon' => '🌹', 'price' => 1.00],
            ['name' => 'Café', 'icon' => '☕', 'price' => 10.00],
            ['name' => 'Coração', 'icon' => '❤️', 'price' => 50.00],
            ['name' => 'Estrela', 'icon' => '✨', 'price' => 100.00],
            ['name' => 'Diamante', 'icon' => '💎', 'price' => 500.00],
            ['name' => 'Foguete', 'icon' => '🚀', 'price' => 1000.00],
            ['name' => 'Super Carro', 'icon' => '🏎️', 'price' => 5000.00],
            ['name' => 'Mansão', 'icon' => '🏰', 'price' => 10000.00],
            ['name' => 'Jato Particular', 'icon' => '🛩️', 'price' => 20000.00],
            ['name' => 'Planeta', 'icon' => '🪐', 'price' => 50000.00],
            ['name' => 'Galáxia', 'icon' => '🌌', 'price' => 100000.00],
            ['name' => 'Universo', 'icon' => '⚛️', 'price' => 200000.00],
        ];

        foreach ($gifts as $gift) {
            Gift::create($gift);
        }
    }
}
