<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // History of my purchases (out)
        $purchases = DB::table('purchases')
            ->join('posts', 'purchases.post_id', '=', 'posts.id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('purchases.user_id', $user->id)
            ->select('purchases.*', 'posts.title as post_title', 'users.name as creator_name', 'users.username as creator_username')
            ->get()
            ->map(function($p) {
                return [
                    'type' => 'Desbloqueio de Post',
                    'description' => $p->post_title,
                    'user' => $p->creator_name,
                    'username' => $p->creator_username,
                    'amount' => $p->amount,
                    'direction' => 'out',
                    'date' => $p->created_at,
                    'status' => 'Aprovado'
                ];
            });

        $history = $purchases->sortByDesc('date');
        $availableBalance = $user->balance;

        return view('wallet', compact('availableBalance', 'history'));
    }
}
