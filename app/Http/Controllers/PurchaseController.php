<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['post.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('purchases', compact('purchases'));
    }
}
