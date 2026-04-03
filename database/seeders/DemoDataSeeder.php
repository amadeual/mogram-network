<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Live;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Creator User
        $ana = User::updateOrCreate(
            ['email' => 'ana@mogram.com'],
            [
                'name' => 'Ana Clara',
                'username' => 'ana_clara',
                'password' => Hash::make('password'),
                'avatar' => '/images/ana_clara.png',
                'city' => 'Rio de Janeiro',
                'category' => 'Marketing Creator',
                'bio' => 'Especialista em marketing digital e criação de conteúdo. 🚀',
                'is_verified' => true,
            ]
        );

        $marcos = User::updateOrCreate(
            ['email' => 'marcos@mogram.com'],
            [
                'name' => 'Marcos Silva',
                'username' => 'marcos_silva',
                'password' => Hash::make('password'),
                'avatar' => '/images/marcos_silva.png',
                'city' => 'São Paulo',
                'category' => 'Tech & Gaming',
                'bio' => 'Apaixonado por tecnologia e jogos eletrônicos. 🎮✨',
                'is_verified' => true,
            ]
        );

        // 2. Create some Posts
        Post::create([
            'user_id' => $ana->id,
            'title' => 'Estratégias de Crescimento para 2024',
            'description' => 'Aprenda as técnicas avançadas de tráfego pago e branding. 📈✨',
            'type' => 'video',
            'is_exclusive' => true,
            'price' => 29.90,
            'file_path' => '/images/island_video.png', 
        ]);

        Post::create([
            'user_id' => $marcos->id,
            'title' => 'Review do Novo Gadget X',
            'description' => 'As especificações superaram minhas expectativas! 📸🕹️',
            'type' => 'image',
            'is_exclusive' => false,
            'price' => 0,
            'file_path' => '/images/live_gadget.png', 
        ]);

        // 3. Create a Scheduled Live (using model fields)
        Live::create([
            'user_id' => $ana->id,
            'title' => 'Workshop: Monetizando sua Audiência',
            'description' => 'Sessão ao vivo exclusiva sobre como vender seus primeiros infoprodutos.',
            'thumbnail' => '/images/live_office.png',
            'status' => 'scheduled',
            'started_at' => Carbon::now()->addDays(2),
            'price' => 49.00,
            'is_free' => false,
        ]);
        
        Live::create([
            'user_id' => $marcos->id,
            'title' => 'Gameplay Sábado: Novos Lançamentos',
            'description' => 'Testando os jogos que saíram essa semana com vocês! 🎮',
            'thumbnail' => '/images/live_fitness.png',
            'status' => 'live',
            'started_at' => Carbon::now(),
            'price' => 0,
            'is_free' => true,
        ]);
    }
}
