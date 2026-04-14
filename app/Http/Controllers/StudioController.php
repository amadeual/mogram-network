<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalRequestedMail;

class StudioController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->take(5)->get();
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        
        $postRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        $giftRevenue = DB::table('live_gifts')->where('receiver_id', Auth::id())->sum(DB::raw('amount - commission'));
        $ticketRevenue = DB::table('live_access')->join('lives', 'live_access.live_id', '=', 'lives.id')->where('lives.user_id', Auth::id())->sum(DB::raw('live_access.amount - (CASE WHEN live_access.commission IS NULL THEN 0 ELSE live_access.commission END)'));
        $communityRevenue = DB::table('community_subscriptions')->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')->where('communities.user_id', Auth::id())->where('community_subscriptions.status', 'active')->sum('community_subscriptions.amount');
        
        $totalRevenue = $postRevenue + $giftRevenue + $ticketRevenue + $communityRevenue;
        
        return view('studio.dashboard', compact('posts', 'totalRevenue'));
    }

    public function content()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->paginate(10);
        $totalPosts = Post::where('user_id', Auth::id())->count();
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        
        $postRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        $giftRevenue = DB::table('live_gifts')->where('receiver_id', Auth::id())->sum(DB::raw('amount - commission'));
        $ticketRevenue = DB::table('live_access')->join('lives', 'live_access.live_id', '=', 'lives.id')->where('lives.user_id', Auth::id())->sum(DB::raw('live_access.amount - (CASE WHEN live_access.commission IS NULL THEN 0 ELSE live_access.commission END)'));
        $communityRevenue = DB::table('community_subscriptions')->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')->where('communities.user_id', Auth::id())->where('community_subscriptions.status', 'active')->sum('community_subscriptions.amount');
            
        $totalRevenue = $postRevenue + $giftRevenue + $ticketRevenue + $communityRevenue;
        
        return view('studio.content', compact('posts', 'totalPosts', 'totalRevenue'));
    }

    public function analytics()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalPosts = count($postIds);
        
        $postRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        $giftRevenue = DB::table('live_gifts')->where('receiver_id', Auth::id())->sum(DB::raw('amount - commission'));
        $ticketRevenue = DB::table('live_access')->join('lives', 'live_access.live_id', '=', 'lives.id')->where('lives.user_id', Auth::id())->sum(DB::raw('live_access.amount - (CASE WHEN live_access.commission IS NULL THEN 0 ELSE live_access.commission END)'));
        $communityRevenue = DB::table('community_subscriptions')->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')->where('communities.user_id', Auth::id())->where('community_subscriptions.status', 'active')->sum('community_subscriptions.amount');
            
        $totalRevenue = $postRevenue + $giftRevenue + $ticketRevenue + $communityRevenue;
        $totalViews = Post::where('user_id', Auth::id())->sum('views');
        
        // Weekly Earnings Evolution (Monday to Sunday)
        $weeklyEarnings = collect();
        $startOfWeek = now()->startOfWeek(); 
        for ($i = 0; $i < 7; $i++) {
            $currentDay = $startOfWeek->copy()->addDays($i);
            $date = $currentDay->format('Y-m-d');
            $amount = DB::table('purchases')
                ->whereIn('post_id', $postIds)
                ->whereDate('created_at', $date)
                ->sum('amount');
            
            $weeklyEarnings->put($currentDay->translatedFormat('D'), (float)$amount);
        }

        $topPosts = Post::where('user_id', Auth::id())
            ->whereHas('purchases')
            ->withCount('purchases')
            ->orderBy('purchases_count', 'desc')
            ->take(3)->get();
            
        return view('studio.analytics', compact('totalPosts', 'totalRevenue', 'totalViews', 'topPosts', 'weeklyEarnings'));
    }

    public function finance()
    {
        $period = request('period', 'all');
        $filterType = request('type', 'all');
        
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        
        // Post Purchases (Conteúdo)
        $postSalesQuery = DB::table('purchases')
            ->join('posts', 'purchases.post_id', '=', 'posts.id')
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->whereIn('purchases.post_id', $postIds)
            ->select('purchases.amount', 'purchases.created_at', 'posts.title as post_title', 'users.name as buyer_name', 'users.username as buyer_username');

        // Live Gifts (Lives & Chat)
        $liveGiftsQuery = DB::table('live_gifts')
            ->join('users', 'live_gifts.user_id', '=', 'users.id')
            ->join('gifts', 'live_gifts.gift_id', '=', 'gifts.id')
            ->where('live_gifts.receiver_id', Auth::id())
            ->select('live_gifts.amount', 'live_gifts.commission', 'live_gifts.live_id', 'live_gifts.created_at', 'gifts.name as gift_name', 'users.name as sender_name', 'users.username as sender_username');

        // Live Tickets
        $liveTicketsQuery = DB::table('live_access')
            ->join('lives', 'live_access.live_id', '=', 'lives.id')
            ->join('users', 'live_access.user_id', '=', 'users.id')
            ->where('lives.user_id', Auth::id())
            ->select('live_access.amount', 'live_access.commission', 'lives.title as live_title', 'users.name as buyer_name', 'users.username as buyer_username', 'live_access.created_at');

        // Community Subscriptions
        $communitySubsQuery = DB::table('community_subscriptions')
            ->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')
            ->join('users', 'community_subscriptions.user_id', '=', 'users.id')
            ->where('communities.user_id', Auth::id())
            ->where('community_subscriptions.status', 'active')
            ->select('community_subscriptions.amount', 'community_subscriptions.created_at', 'communities.name as community_name', 'users.name as buyer_name', 'users.username as buyer_username');

        $withdrawalsQuery = Withdrawal::where('user_id', Auth::id());

        // Apply Global Totals (always showing global balance/overview unless specifically asked otherwise, 
        // but for now let's make the Stats reflect the filters too for better UX)
        
        if ($period != 'all') {
            $days = (int)$period;
            $date = ($days == 1) ? now()->startOfDay() : now()->subDays($days)->startOfDay();
            
            $postSalesQuery->where('purchases.created_at', '>=', $date);
            $liveGiftsQuery->where('live_gifts.created_at', '>=', $date);
            $liveTicketsQuery->where('live_access.created_at', '>=', $date);
            $communitySubsQuery->where('community_subscriptions.created_at', '>=', $date);
            $withdrawalsQuery->where('created_at', '>=', $date);
        }

        $postSales = $postSalesQuery->get();
        $liveGifts = $liveGiftsQuery->get();
        $liveTickets = $liveTicketsQuery->get();
        $communitySubs = $communitySubsQuery->get();
        $withdrawals = $withdrawalsQuery->latest()->get();

        $history = collect();

        if ($filterType == 'all' || $filterType == 'content') {
            foreach ($postSales as $sale) {
                $history->push([
                    'type' => 'Conteúdo',
                    'description' => $sale->post_title,
                    'user' => $sale->buyer_name,
                    'username' => $sale->buyer_username,
                    'amount' => $sale->amount,
                    'direction' => 'in',
                    'date' => $sale->created_at,
                    'status' => 'Aprovado',
                ]);
            }
        }

        if ($filterType == 'all' || $filterType == 'lives' || $filterType == 'gifts') {
            foreach ($liveGifts as $gift) {
                $isLive = !empty($gift->live_id);
                $typeLabel = $isLive ? 'Lives' : 'Mimos';
                
                // If filtering by Lives, skip if not a live gift
                if ($filterType == 'lives' && !$isLive) continue;
                // If filtering by Gifts (Mimos), skip if it is a live gift
                if ($filterType == 'gifts' && $isLive) continue;

                $history->push([
                    'type' => $typeLabel,
                    'description' => $gift->gift_name,
                    'user' => $gift->sender_name,
                    'username' => $gift->sender_username,
                    'amount' => $gift->amount - $gift->commission,
                    'direction' => 'in',
                    'date' => $gift->created_at,
                    'status' => 'Aprovado',
                ]);
            }
        }

        if ($filterType == 'all' || $filterType == 'tickets' || $filterType == 'lives') {
            foreach ($liveTickets as $ticket) {
                $history->push([
                    'type' => 'Lives',
                    'description' => $ticket->live_title,
                    'user' => $ticket->buyer_name,
                    'username' => $ticket->buyer_username,
                    'amount' => $ticket->amount - (float)($ticket->commission ?? 0),
                    'direction' => 'in',
                    'date' => $ticket->created_at,
                    'status' => 'Aprovado',
                ]);
            }
        }

        if ($filterType == 'all' || $filterType == 'communities' || $filterType == 'subscriptions') {
            foreach ($communitySubs as $sub) {
                $history->push([
                    'type' => 'Assinaturas',
                    'description' => $sub->community_name,
                    'user' => $sub->buyer_name,
                    'username' => $sub->buyer_username,
                    'amount' => $sub->amount,
                    'direction' => 'in',
                    'date' => $sub->created_at,
                    'status' => 'Ativo',
                ]);
            }
        }

        if ($filterType == 'all' || $filterType == 'withdrawals') {
            foreach ($withdrawals as $w) {
                $history->push([
                    'type' => 'Saque via ' . strtoupper($w->method),
                    'description' => $w->account_info,
                    'user' => 'Para você',
                    'username' => Auth::user()->username,
                    'amount' => $w->amount,
                    'direction' => 'out',
                    'date' => $w->created_at->toDateTimeString(),
                    'status' => ucfirst($w->status),
                ]);
            }
        }

        $history = $history->sortByDesc('date');

        $postRevenue = (float)$postSales->sum('amount');
        
        $liveGiftRevenue = (float)$liveGifts->filter(function($g) {
            return !empty($g->live_id) && $g->live_id > 0;
        })->sum(function($g) { return $g->amount - $g->commission; });
        
        $liveTicketRevenue = (float)$liveTickets->sum(function($t) { return $t->amount - (float)($t->commission ?? 0); });
        $liveRevenue = $liveGiftRevenue + $liveTicketRevenue;

        $communityRevenue = (float)$communitySubs->sum('amount');
        
        $mimoRevenue = (float)$liveGifts->filter(function($g) {
            return empty($g->live_id) || $g->live_id == 0;
        })->sum(function($g) { return $g->amount - $g->commission; });
        
        $totalRevenue = $postRevenue + $liveRevenue + $communityRevenue + $mimoRevenue;
        
        $totalCompletedWithdrawals = (float)Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');
            
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;
        
        return view('studio.finance', compact(
            'totalRevenue', 
            'postRevenue', 
            'liveRevenue', 
            'communityRevenue',
            'mimoRevenue',
            'availableBalance', 
            'history'
        ));
    }

    public function withdrawPage()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalRevenue = $this->calculateTotalRevenue();
        $totalCompletedWithdrawals = Withdrawal::where('user_id', Auth::id())->whereIn('status', ['approved', 'pending'])->sum('amount');
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;

        return view('studio.withdraw', compact('availableBalance'));
    }

    public function withdraw(Request $request)
    {
        $messages = [
            'amount.required' => 'Por favor, informe o valor que deseja sacar.',
            'amount.numeric' => 'O valor do saque deve ser um número válido.',
            'amount.min' => 'O valor mínimo para saque é de R$ 50,00.',
            'amount.max' => 'O valor máximo permitido por saque é de R$ 5.000,00.',
            'method.required' => 'Selecione um método de pagamento.',
            'account_info.required' => 'Informe os dados da sua conta para recebimento.',
        ];

        $request->validate([
            'amount' => 'required|numeric|min:50|max:5000',
            'method' => 'required|in:pix,redotpay,usdt_bep20',
            'account_info' => 'required|string|max:255',
        ], $messages);

        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalRevenue = $this->calculateTotalRevenue();
        
        $totalCompletedWithdrawals = Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');
            
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;

        $withdrawAmount = (float)str_replace(',', '.', $request->amount);
        
        // Fee Calculation
        $fee = 5.00; // Default for PIX
        if ($request->method === 'redotpay') {
            // Usando uma taxa de R$ 6.00 para representar $1 fixo "acima da taxa de câmbio"
            // ou buscando de configurações se existir
            $usdRate = \App\Models\Setting::where('key', 'USD_RATE')->value('value') ?? 6.00;
            $fee = (float)$usdRate;
        }

        $netAmount = $withdrawAmount - $fee;

        if ($withdrawAmount < 50) {
            return redirect()->back()
                ->with('error', '⚠️ O valor mínimo permitido para saques é de R$ 50,00. Por favor, ajuste o valor e tente novamente.')
                ->withInput();
        }

        if ($withdrawAmount > 5000) {
            return redirect()->back()
                ->with('error', '⚠️ O valor máximo permitido por saque é de R$ 5.000,00. Por favor, ajuste o valor e tente novamente.')
                ->withInput();
        }

        if ($withdrawAmount > $availableBalance) {
            return redirect()->back()
                ->with('error', '❌ Saldo Insuficiente! Você tentou sacar R$ ' . number_format($withdrawAmount, 2, ',', '.') . ', mas seu saldo disponível no momento é de R$ ' . number_format($availableBalance, 2, ',', '.') . '.')
                ->withInput();
        }

        $w = Withdrawal::create([
            'user_id' => Auth::id(),
            'amount' => $withdrawAmount,
            'fee' => $fee,
            'net_amount' => $netAmount,
            'method' => $request->method,
            'account_info' => $request->account_info,
            'status' => 'pending',
        ]);

        try {
            Mail::to(Auth::user()->email)->send(new WithdrawalRequestedMail($withdrawAmount, $request->method, $w->id));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de saque: ' . $e->getMessage());
        }

        $feeFormatted = 'R$ ' . number_format($fee, 2, ',', '.');
        return redirect()->route('studio.finance')->with('success', 'Pedido de saque de R$ ' . number_format($withdrawAmount, 2, ',', '.') . ' enviado com sucesso! (Taxa: ' . $feeFormatted . ')');
    }

    public function postAnalytics(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return redirect()->route('studio.dashboard');
        }
        return view('studio.post-analytics', compact('post'));
    }

    public function create()
    {
        return view('studio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'required|string|max:50000',
            'type' => 'required|in:video,image,pdf,stories',
            'price' => $request->is_paid ? 'required|numeric|min:5' : 'nullable|numeric|min:0',
            'file' => 'required|file|max:51200',
            'thumbnail' => 'nullable|image|max:5120',
            'is_paid' => 'nullable|boolean',
            'scheduled_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
            'category' => 'nullable|string'
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = $request->type;
        $post->price = (float)str_replace(',', '.', $request->price ?? 0);
        $post->is_exclusive = $request->is_paid == "1";
        $post->scheduled_at = $request->scheduled_at;
        $post->allow_comments = $request->has('allow_comments') ? (bool)$request->allow_comments : true;
        $post->category = $request->category;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('posts', $fileName, 'public');
            $post->file_path = $path;
        }

        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_' . uniqid() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumbPath = $thumb->storeAs('posts/thumbnails', $thumbName, 'public');
            $post->thumbnail = $thumbPath;
        }

        $post->save();

        return redirect()->route('studio.dashboard')->with('success', 'Conteúdo criado com sucesso!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return redirect()->route('studio.dashboard');
        }
        return view('studio.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return redirect()->route('studio.dashboard');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:50000',
            'type' => 'required|in:video,image,pdf,stories',
            'price' => 'nullable|numeric|min:0',
            'file' => 'nullable|file|max:51200',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = $request->type;
        $post->price = (float)str_replace(',', '.', $request->price ?? 0);
        $post->is_exclusive = $request->has('is_exclusive');

        if ($request->hasFile('file')) {
            if ($post->file_path) {
                Storage::disk('public')->delete($post->file_path);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('posts', $fileName, 'public');
            $post->file_path = $path;
        }

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_' . uniqid() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumbPath = $thumb->storeAs('posts/thumbnails', $thumbName, 'public');
            $post->thumbnail = $thumbPath;
        }

        $post->save();

        return redirect()->route('studio.dashboard')->with('success', 'Conteúdo atualizado com sucesso!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return redirect()->route('studio.dashboard');
        }

        if ($post->file_path) {
            Storage::disk('public')->delete($post->file_path);
        }
        $post->delete();

        return redirect()->back()->with('success', 'Conteúdo removido!');
    }

    public function incrementView(Post $post)
    {
        $post->increment('views');
        return response()->json(['success' => true, 'views' => $post->views]);
    }

    public function incrementShare(Post $post)
    {
        $post->increment('shares');
        return response()->json(['success' => true, 'shares' => $post->shares]);
    }

    private function calculateTotalRevenue()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $postRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        $giftRevenue = DB::table('live_gifts')->where('receiver_id', Auth::id())->sum(DB::raw('amount - commission'));
        $ticketRevenue = DB::table('live_access')->join('lives', 'live_access.live_id', '=', 'lives.id')->where('lives.user_id', Auth::id())->sum(DB::raw('live_access.amount - (CASE WHEN live_access.commission IS NULL THEN 0 ELSE live_access.commission END)'));
        $communityRevenue = DB::table('community_subscriptions')->join('communities', 'community_subscriptions.community_id', '=', 'communities.id')->where('communities.user_id', Auth::id())->where('community_subscriptions.status', 'active')->sum('community_subscriptions.amount');
        
        return (float)$postRevenue + (float)$giftRevenue + (float)$ticketRevenue + (float)$communityRevenue;
    }
}
