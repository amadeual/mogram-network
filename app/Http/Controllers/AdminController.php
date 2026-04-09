<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Live;
use App\Models\LiveGift;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_revenue' => LiveGift::sum('amount'),
            'total_posts' => Post::count(),
            'total_lives' => Live::count(),
        ];

        $recentActivity = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function categories()
    {
        // For categories, we might use a separate model but currently they are strings in posts/lives
        // I will use a mock list for now based on the image provided
        $categories = [
            ['id' => 1, 'name' => 'Premium', 'slug' => 'premium', 'posts' => 1204, 'status' => 'active', 'icon' => '⭐'],
            ['id' => 2, 'name' => 'Bastidores', 'slug' => 'bastidores', 'posts' => 450, 'status' => 'active', 'icon' => '🎥'],
            ['id' => 3, 'name' => 'Promoções', 'slug' => 'promocoes', 'posts' => 120, 'status' => 'inactive', 'icon' => '📢'],
            ['id' => 4, 'name' => 'Tutoriais', 'slug' => 'tutoriais', 'posts' => 85, 'status' => 'active', 'icon' => '🎓'],
        ];

        return view('admin.categories', compact('categories'));
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Logic to update system settings (possibly in a 'configs' table)
        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}
