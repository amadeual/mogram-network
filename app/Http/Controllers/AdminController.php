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
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        $commission = (float)($settings['commission_percentage'] ?? 15);
        $creatorShare = (100 - $commission) / 100;
        $platformShare = $commission / 100;

        // Sum of all money spent on the platform
        $totalSpent = \App\Models\LiveGift::sum('amount') + 
                      \App\Models\Purchase::sum('amount') + 
                      DB::table('live_access')->sum('amount');

        $stats = [
            'total_users' => User::count(),
            'total_deposits' => \App\Models\Deposit::whereIn('status', ['completed', 'approved'])->sum('amount'),
            'total_revenue' => $totalSpent * $creatorShare, // What creators actually earned
            'total_posts' => Post::count(),
            'total_lives' => Live::count(),
            'net_profit' => $totalSpent * $platformShare, // Platform revenue (commission)
            'commission' => $commission
        ];

        // Daily Revenue for Chart (Last 30 days)
        $revenueData = DB::table(function ($query) {
            $query->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
                ->from('deposits')
                ->where('status', 'approved')
                ->groupBy('date')
                ->unionAll(
                    DB::table('live_gifts')
                        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
                        ->groupBy('date')
                )
                ->unionAll(
                    DB::table('purchases')
                        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
                        ->groupBy('date')
                );
        }, 'combined')
        ->select('date', DB::raw('SUM(total) as daily_total'))
        ->where('date', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $recentActivity = User::latest()->take(5)->get();
        $recentTransactions = \App\Models\Deposit::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentActivity', 'recentTransactions', 'revenueData'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%")
                  ->orWhere('username', 'LIKE', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        // Logic for city, country, IP etc. IP usually stored in a logs table or session.
        // For now using the column added in migration.
        return view('admin.user-details', compact('user'));
    }

    public function toggleUserStatus($id, $action)
    {
        $user = User::findOrFail($id);
        
        switch($action) {
            case 'suspend': $user->status = 'suspended'; break;
            case 'activate': $user->status = 'active'; break;
            case 'freeze_withdrawals': $user->withdrawals_frozen = true; break;
            case 'unfreeze_withdrawals': $user->withdrawals_frozen = false; break;
            case 'freeze_deposits': $user->deposits_frozen = true; break;
            case 'unfreeze_deposits': $user->deposits_frozen = false; break;
            case 'reset_2fa': $user->two_factor_secret = null; break;
        }

        $user->save();
        return back()->with('success', 'Ação executada com sucesso!');
    }

    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);
        $tempPassword = \Illuminate\Support\Str::random(10);
        $user->password = \Illuminate\Support\Facades\Hash::make($tempPassword);
        $user->save();
        
        // In a real app, send email. For now return with success message
        return back()->with('success', "Senha resetada! Nova senha temporária: {$tempPassword}");
    }

    public function gifts()
    {
        $gifts = \App\Models\Gift::all();
        return view('admin.gifts', compact('gifts'));
    }

    public function updateGift(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'icon' => 'required|string',
        ]);

        $gift = \App\Models\Gift::findOrFail($id);
        $data = $request->only(['name', 'icon']);
        
        // Fix for 2.50 rounding to 3 or validation failing on 2,50
        $rawPrice = str_replace(',', '.', $request->price);
        $data['price'] = (float)$rawPrice;
        $gift->update($data);

        return back()->with('success', 'Presente atualizado com sucesso!');
    }

    public function categories()
    {
        // For categories, we might use a separate model but currently they are strings in posts/lives
        // I will use a mock list for now based on the image provided
        $categories = [
            ['id' => 1, 'name' => 'Premium', 'slug' => 'premium', 'posts' => Post::count(), 'status' => 'active', 'icon' => '⭐'],
            ['id' => 2, 'name' => 'Bastidores', 'slug' => 'bastidores', 'posts' => Post::count() / 2, 'status' => 'active', 'icon' => '🎥'],
            ['id' => 3, 'name' => 'Geral', 'slug' => 'geral', 'posts' => Post::count(), 'status' => 'active', 'icon' => '🌍'],
        ];

        return view('admin.categories', compact('categories'));
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\Withdrawal::with('user')->orderBy('created_at', 'desc')->paginate(15);
        $pendingAmount = \App\Models\Withdrawal::where('status', 'pending')->sum('amount');
        return view('admin.withdrawals', compact('withdrawals', 'pendingAmount'));
    }

    public function deposits()
    {
        $deposits = \App\Models\Deposit::with('user')->orderBy('created_at', 'desc')->paginate(15);
        $todayAmount = \App\Models\Deposit::whereDate('created_at', \Carbon\Carbon::today())->sum('amount');
        return view('admin.deposits', compact('deposits', 'todayAmount'));
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            // Sync specifically with .env if requested
            if ($key === 'ABACATE_PAY_KEY') {
                $this->updateEnvFile('ABACATE_PAY_KEY', $value);
            }
        }

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = \App\Models\Withdrawal::findOrFail($id);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Este saque já foi processado.');
        }

        $withdrawal->status = 'approved';
        $withdrawal->save();

        // Optional: Send notification to user
        
        return back()->with('success', 'Saque aprovado e marcado como pago!');
    }

    public function rejectWithdrawal(Request $request, $id)
    {
        $withdrawal = \App\Models\Withdrawal::findOrFail($id);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Este saque já foi processado.');
        }

        $withdrawal->status = 'rejected';
        $withdrawal->rejection_reason = $request->reason ?? 'Solicitação recusada pela administração.';
        $withdrawal->save();

        // Optional: Send notification to user

        return back()->with('success', 'Saque recusado com sucesso.');
    }

    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $oldValue = env($key);

            if (str_contains($content, "{$key}=")) {
                $content = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $content
                );
            } else {
                $content .= "\n{$key}={$value}";
            }

            file_put_contents($path, $content);
        }
    }
}
