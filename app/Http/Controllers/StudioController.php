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
        $totalRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        
        return view('studio.dashboard', compact('posts', 'totalRevenue'));
    }

    public function content()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->paginate(10);
        $totalPosts = Post::where('user_id', Auth::id())->count();
        
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        
        return view('studio.content', compact('posts', 'totalPosts', 'totalRevenue'));
    }

    public function analytics()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalPosts = count($postIds);
        $totalRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        
        $topPosts = Post::where('user_id', Auth::id())
            ->whereHas('purchases')
            ->withCount('purchases')
            ->orderBy('purchases_count', 'desc')
            ->take(3)->get();
            
        return view('studio.analytics', compact('totalPosts', 'totalRevenue', 'topPosts'));
    }

    public function finance()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        
        $incomes = DB::table('purchases')
            ->join('posts', 'purchases.post_id', '=', 'posts.id')
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->whereIn('purchases.post_id', $postIds)
            ->select('purchases.*', 'posts.title as post_title', 'users.name as buyer_name', 'users.username as buyer_username')
            ->get();

        $withdrawals = Withdrawal::where('user_id', Auth::id())->latest()->get();

        $history = collect();

        foreach ($incomes as $income) {
            $history->push([
                'type' => 'Post Pago',
                'description' => $income->post_title,
                'user' => $income->buyer_name,
                'username' => $income->buyer_username,
                'amount' => $income->amount,
                'direction' => 'in',
                'date' => $income->created_at,
                'status' => 'Aprovado',
            ]);
        }

        foreach ($withdrawals as $w) {
            $history->push([
                'type' => 'Saque via ' . strtoupper($w->method),
                'description' => $w->account_info,
                'user' => 'Para você',
                'username' => Auth::user()->username,
                'amount' => $w->amount,
                'direction' => 'out',
                'date' => $w->created_at,
                'status' => ucfirst($w->status),
            ]);
        }

        $history = $history->sortByDesc('date');

        $totalRevenue = $incomes->sum('amount');
        $totalCompletedWithdrawals = $withdrawals->whereIn('status', ['completed', 'pending'])->sum('amount');
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;
        
        return view('studio.finance', compact('totalRevenue', 'availableBalance', 'history'));
    }

    public function withdrawPage()
    {
        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        $totalCompletedWithdrawals = Withdrawal::where('user_id', Auth::id())->whereIn('status', ['completed', 'pending'])->sum('amount');
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;

        return view('studio.withdraw', compact('availableBalance'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'method' => 'required|in:pix,redotpay,usdt_bep20',
            'account_info' => 'required|string|max:255',
        ]);

        $postIds = Post::where('user_id', Auth::id())->pluck('id');
        $totalRevenue = DB::table('purchases')->whereIn('post_id', $postIds)->sum('amount');
        
        $totalCompletedWithdrawals = Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'completed'])
            ->sum('amount');
            
        $availableBalance = $totalRevenue - $totalCompletedWithdrawals;

        if ($request->amount > $availableBalance) {
            return redirect()->back()
                ->with('error', 'Saldo insuficiente para realizar este saque. Seu saldo disponível é R$ ' . number_format($availableBalance, 2, ',', '.'))
                ->withInput();
        }

        $w = Withdrawal::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'account_info' => $request->account_info,
            'status' => 'pending',
        ]);

        try {
            Mail::to(Auth::user()->email)->send(new WithdrawalRequestedMail($request->amount, $request->method, $w->id));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de saque: ' . $e->getMessage());
        }

        return redirect()->route('studio.finance')->with('success', 'Pedido de saque enviado com sucesso!');
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
            'description' => 'required|string|max:2200',
            'type' => 'required|in:video,image,pdf,stories',
            'price' => $request->is_paid ? 'required|numeric|min:5' : 'nullable|numeric|min:0',
            'file' => 'required|file|max:51200',
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
        $post->price = $request->price ?? 0;
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
            'description' => 'nullable|string|max:2200',
            'type' => 'required|in:video,image,pdf,stories',
            'price' => 'nullable|numeric|min:0',
            'file' => 'nullable|file|max:51200',
        ]);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = $request->type;
        $post->price = $request->price ?? 0;
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
}
