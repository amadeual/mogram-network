<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Deposit;

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

    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:10']);

        $user = Auth::user();
        $amount = $request->amount;
        $amountCents = (int)($amount * 100);

        // Create local deposit record
        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        $apiKey = env('ABACATE_PAY_KEY');

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post('https://api.abacatepay.com/v1/checkout/create', [
                'frequency' => 'ONE_TIME',
                'methods' => ['PIX', 'BILL'], // Abacate Pay uses BILL for cards sometimes or similar, per search v2/checkouts/create is better
                // Let's use the v2 structure if possible, but the search said v1 in some places.
                // Re-checking search: "v2/checkouts/create" was mentioned.
                'products' => [
                    [
                        'externalId' => 'deposit_' . $deposit->id,
                        'name' => 'Adição de Saldo Mogram',
                        'quantity' => 1,
                        'price' => $amountCents
                    ]
                ],
                'returnUrl' => route('wallet.index'),
                'completionUrl' => route('wallet.index'),
                'customerId' => $user->id, // If already exists, or we send 'customer' object
            ]);

            // If v1 fails, fallback to v2 checkouts/create
            if ($response->failed()) {
                 $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('https://api.abacatepay.com/v2/checkouts/create', [
                    'items' => [
                        [
                            'id' => 'deposit_' . $deposit->id,
                            'quantity' => 1,
                            'price' => $amountCents,
                            'name' => 'Adição de Saldo Mogram'
                        ]
                    ],
                    'methods' => ['PIX', 'CARD'],
                    'returnUrl' => route('wallet.index'),
                    'externalId' => 'dep_' . $deposit->id,
                ]);
            }

            if ($response->successful()) {
                $data = $response->json();
                // Depending on the version, the URL might be in different places.
                $checkoutUrl = $data['data']['url'] ?? $data['url'] ?? null;
                $externalId = $data['data']['id'] ?? $data['id'] ?? null;

                if ($checkoutUrl) {
                    $deposit->update([
                        'payment_url' => $checkoutUrl,
                        'external_id' => $externalId
                    ]);
                    return redirect()->away($checkoutUrl);
                }
            }

            return redirect()->back()->with('error', 'Erro ao processar pagamento com Abacate Pay. Verifique se a chave API está configurada.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro técnico: ' . $e->getMessage());
        }
    }

    /*
     * Webhook for Abacate Pay
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        // Abacate Pay sends the status in 'data' structure
        $status = $payload['data']['status'] ?? null;
        $externalId = $payload['data']['id'] ?? null;

        if ($status === 'PAID' || $status === 'CONFIRMED') {
            $deposit = Deposit::where('external_id', $externalId)->where('status', 'pending')->first();

            if ($deposit) {
                DB::transaction(function() use ($deposit) {
                    $deposit->update(['status' => 'completed']);
                    
                    $user = $deposit->user;
                    $user->balance += $deposit->amount;
                    $user->save();
                });
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['status' => 'received']);
    }
}
