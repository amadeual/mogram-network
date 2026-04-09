<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 Creators
        $ana = User::firstOrCreate(
            ['email' => 'leticia@mogram.com'],
            [
                'name' => 'Leticia Silva',
                'username' => 'leticiasilva',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'category' => 'Lifestyle & Moda',
                'avatar' => 'images/avatars/ana.png',
                'bio' => 'Conteúdo exclusivo sobre moda e bastidores.'
            ]
        );

        $marcos = User::firstOrCreate(
            ['email' => 'gabriel@mogram.com'],
            [
                'name' => 'Gabriel Games',
                'username' => 'gabrielgames',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'avatar' => 'images/avatars/marcos.png',
                'category' => 'Games & Tech',
                'bio' => 'Lives diárias e reviews de jogos.'
            ]
        );

        // Create 5 Posts
        $posts = [
            [
                'user_id' => $ana->id,
                'title' => 'Um dia de trabalho no paraíso 🌴',
                'description' => 'Aproveitando o sol para adiantar as edições da nova coleção. O que acharam desse setup?',
                'file_path' => 'posts/travel.png',
                'type' => 'image',
                'price' => 0.00,
                'is_exclusive' => false
            ],
            [
                'user_id' => $ana->id,
                'title' => 'Look Urban Night ✨',
                'description' => 'As luzes da cidade sempre inspiram meus melhores looks. Estilo e conforto em uma só peça.',
                'file_path' => 'posts/fashion.png',
                'type' => 'image',
                'price' => 0.00,
                'is_exclusive' => false
            ],
            [
                'user_id' => $marcos->id,
                'title' => 'Segredos da Alta Gastronomia 🍳',
                'description' => 'Confira como preparei este prato exclusivo hoje. Dicas de tempero e apresentação.',
                'file_path' => 'posts/chef.png',
                'type' => 'image',
                'price' => 19.90,
                'is_exclusive' => true
            ],
            [
                'user_id' => $ana->id,
                'title' => 'Yoga ao pôr do sol 🧘‍♀️',
                'description' => 'Minha rotina completa de meditação e yoga para começar bem a semana. Conteúdo exclusivo para assinantes.',
                'file_path' => 'posts/fitness.png',
                'type' => 'image',
                'price' => 49.90,
                'is_exclusive' => true
            ],
            [
                'user_id' => $marcos->id,
                'title' => 'Mercado Central 🍎',
                'description' => 'Buscando inspirações e novos sabores no mercado local hoje pela manhã.',
                'file_path' => 'posts/art.png',
                'type' => 'image',
                'price' => 0.00,
                'is_exclusive' => false
            ]
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }
    }
}
