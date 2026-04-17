<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Live;
use App\Models\LiveGift;
use App\Models\Ticket;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        // Sum of all money spent on the platform
        $totalSpent = \App\Models\LiveGift::sum('amount') + 
                      \App\Models\Purchase::sum('amount') + 
                      DB::table('live_access')->sum('amount') +
                      \App\Models\CommunitySubscription::where('status', 'active')->sum('amount');

        $totalCommission = \App\Models\LiveGift::sum('commission') + 
                           \App\Models\Purchase::sum('commission') + 
                           DB::table('live_access')->sum('commission') +
                           \App\Models\CommunitySubscription::where('status', 'active')->sum('commission');

        $stats = [
            'total_users' => User::count(),
            'total_deposits' => \App\Models\Deposit::whereIn('status', ['completed', 'approved'])->sum('amount'),
            'total_revenue' => $totalSpent - $totalCommission, // What creators actually earned
            'total_posts' => Post::count(),
            'total_lives' => Live::count(),
            'net_profit' => $totalCommission, // Platform revenue (commission)
            'commission' => (float)($settings['commission_content'] ?? 15),
            'open_tickets' => Ticket::where('status', 'Aberto')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count()
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

    public function adjustBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'type' => 'required|in:credit,debit',
            'wallet' => 'required|in:balance,studio_balance',
        ]);

        $user = User::findOrFail($id);
        
        // Handle comma or dot for decimal input
        $amountRaw = str_replace(',', '.', $request->amount);
        $amount = (float)$amountRaw;
        
        $wallet = $request->wallet;

        if ($request->type === 'credit') {
            $user->$wallet += $amount;
        } else {
            $user->$wallet -= $amount;
        }

        $user->save();
        
        $walletName = $wallet === 'balance' ? 'Carteira (Gasto)' : 'Financeiro (Ganhos)';
        $actionName = $request->type === 'credit' ? 'Creditado' : 'Debitado';

        return back()->with('success', "R$ " . number_format($amount, 2, ',', '.') . " foi {$actionName} da {$walletName} com sucesso!");
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

    public function contents()
    {
        $posts = Post::with('user')->latest()->paginate(15);
        $livesCount = Live::count();
        return view('admin.content', compact('posts', 'livesCount'));
    }


    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return back()->with('success', 'Post removido com sucesso!');
    }

    public function lives()
    {
        $lives = Live::with('user')->latest()->paginate(15);
        return view('admin.lives', compact('lives'));
    }

    public function finishLive(Request $request, $id)
    {
        $live = Live::findOrFail($id);
        $live->update([
            'status' => 'finished',
            'ended_at' => now(),
            'termination_reason' => $request->reason ?? 'Finalizada pelo administrador'
        ]);
        return back()->with('success', 'Live finalizada pelo administrador.');
    }


    public function deleteLive($id)
    {
        $live = Live::findOrFail($id);
        $live->delete();
        return back()->with('success', 'Live removida do sistema.');
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

    public function reports(Request $request)
    {
        $creatorId = $request->creator_id;
        $creators = User::where('role', '!=', 'admin')->orderBy('name')->get();

        // 1. Core Metrics
        $revenueQuery = DB::table('purchases')
            ->join('posts', 'purchases.post_id', '=', 'posts.id');
        
        $subQuery = DB::table('community_subscriptions');
        $liveQuery = Live::query();
        $postQuery = Post::query();

        if ($creatorId) {
            $revenueQuery->where('posts.user_id', $creatorId);
            $subQuery->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')
                     ->where('communities.user_id', $creatorId);
            $liveQuery->where('user_id', $creatorId);
            $postQuery->where('user_id', $creatorId);
        }

        $totalRevenue = $revenueQuery->sum('purchases.amount');
        $totalGifts = DB::table('live_gifts')->when($creatorId, fn($q) => $q->where('receiver_id', $creatorId))->sum('amount');
        $totalTicketRevenue = DB::table('live_access')->join('lives', 'live_access.live_id', '=', 'lives.id')->when($creatorId, fn($q) => $q->where('lives.user_id', $creatorId))->sum('live_access.amount');
        
        $grossRevenue = $totalRevenue + $totalGifts + $totalTicketRevenue;
        
        $totalCommission = DB::table('live_gifts')->when($creatorId, fn($q) => $q->where('receiver_id', $creatorId))->sum('commission') +
                           DB::table('purchases')
                                ->join('posts', 'purchases.post_id', '=', 'posts.id')
                                ->when($creatorId, fn($q) => $q->where('posts.user_id', $creatorId))
                                ->sum('purchases.commission') +
                           DB::table('live_access')
                                ->join('lives', 'live_access.live_id', '=', 'lives.id')
                                ->when($creatorId, fn($q) => $q->where('lives.user_id', $creatorId))
                                ->sum('live_access.commission') +
                           DB::table('community_subscriptions')
                                ->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')
                                ->when($creatorId, fn($q) => $q->where('communities.user_id', $creatorId))
                                ->where('community_subscriptions.status', 'active')
                                ->sum('community_subscriptions.commission');

        $netProfit = $totalCommission;
        $activeSubQuery = DB::table('community_subscriptions')
            ->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')
            ->when($creatorId, fn($q) => $q->where('communities.user_id', $creatorId))
            ->where('community_subscriptions.status', 'active');
            
        $newSubscribers = $activeSubQuery->count();
        $completedLives = $liveQuery->where('status', 'finished')->count();
        $totalContents = $postQuery->count();

        // 2. Chart Data (Last 30 days)
        $chartData = DB::table('purchases')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports', compact(
            'creators', 
            'grossRevenue', 
            'netProfit',
            'newSubscribers', 
            'completedLives', 
            'totalContents',
            'chartData',
            'creatorId'
        ));
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
