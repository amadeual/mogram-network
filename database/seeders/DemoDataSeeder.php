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
            ['email' => 'ana@mogram.com'],
            [
                'name' => 'Ana Silva',
                'username' => 'anasilva',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'category' => 'Lifestyle & Moda',
                'bio' => 'Conteúdo exclusivo sobre moda e bastidores.'
            ]
        );

        $marcos = User::firstOrCreate(
            ['email' => 'marcos@mogram.com'],
            [
                'name' => 'Marcos Gamer',
                'username' => 'marcosgamer',
                'password' => Hash::make('password'),
                'is_verified' => true,
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
                'file_path' => 'images/posts/travel.png',
                'type' => 'image',
                'price' => 0.00,
                'is_exclusive' => false
            ],
            [
                'user_id' => $ana->id,
                'title' => 'Look Urban Night ✨',
                'description' => 'As luzes da cidade sempre inspiram meus melhores looks. Estilo e conforto em uma só peça.',
                'file_path' => 'images/posts/fashion.png',
                'type' => 'image',
                'price' => 0.00,
                'is_exclusive' => false
            ],
            [
                'user_id' => $marcos->id,
                'title' => 'Segredos da Alta Gastronomia 🍳',
                'description' => 'Confira como preparei este prato exclusivo hoje. Dicas de tempero e apresentação.',
                'file_path' => 'images/posts/chef.png',
                'type' => 'image',
                'price' => 19.90,
                'is_exclusive' => true
            ],
            [
                'user_id' => $ana->id,
                'title' => 'Yoga ao pôr do sol 🧘‍♀️',
                'description' => 'Minha rotina completa de meditação e yoga para começar bem a semana. Conteúdo exclusivo para assinantes.',
                'file_path' => 'images/posts/fitness.png',
                'type' => 'image',
                'price' => 49.90,
                'is_exclusive' => true
            ],
            [
                'user_id' => $marcos->id,
                'title' => 'Mercado Central 🍎',
                'description' => 'Buscando inspirações e novos sabores no mercado local hoje pela manhã.',
                'file_path' => 'images/posts/art.png',
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
