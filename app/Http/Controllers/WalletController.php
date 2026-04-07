<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Deposit;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositConfirmedMail;

class WalletController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Sync pending deposits with Abacate Pay (Sync/Poll fallback for local testing)
        $pendingDeposits = Deposit::where('user_id', $user->id)->where('status', 'pending')->get();
        $apiKey = env('ABACATE_PAY_KEY');

        foreach ($pendingDeposits as $deposit) {
            try {
                if (!$deposit->external_id) continue;
                
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json'
                ])->get('https://api.abacatepay.com/v1/billing/list', [ // or specific list with filter
                    'id' => $deposit->external_id
                ]);

                if ($response->successful()) {
                    $billings = $response->json()['data'] ?? [];
                    // Check if our specific billing is PAID
                    foreach($billings as $bill) {
                        if ($bill['id'] === $deposit->external_id && ($bill['status'] === 'PAID' || $bill['status'] === 'CONFIRMED')) {
                            DB::transaction(function() use ($deposit, $user) {
                                $deposit->update(['status' => 'completed']);
                                $user->balance = (float)$user->balance + (float)$deposit->amount;
                                $user->save();
                                
                                try {
                                    Mail::to($user->email)->send(new DepositConfirmedMail($deposit->amount, $deposit->id));
                                } catch (\Exception $e) {
                                    \Illuminate\Support\Facades\Log::error("Email Error (Auto-Sync): " . $e->getMessage());
                                }

                                \Illuminate\Support\Facades\Log::info("Auto-Sync: Deposit confirmed for User {$user->id}: +{$deposit->amount}");
                                
                                // Notify user
                                try {
                                    $user->notify(new \App\Notifications\NewDeposit($deposit->amount));
                                } catch (\Exception $e) {
                                    \Illuminate\Support\Facades\Log::error("Notification Error (Auto-Sync): " . $e->getMessage());
                                }
                            });
                            break;
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Sync Error: " . $e->getMessage());
            }
        }

        $user->refresh();
        
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

        // History of my deposits (in)
        $deposits = Deposit::where('user_id', $user->id)
            ->where('status', 'completed')
            ->get()
            ->map(function($d) {
                return [
                    'type' => 'Depósito PIX/Cartão',
                    'description' => 'Via Abacate Pay',
                    'user' => 'Saldo Adicionado',
                    'username' => Auth::user()->username,
                    'amount' => $d->amount,
                    'direction' => 'in',
                    'date' => $d->created_at,
                    'status' => 'Concluído'
                ];
            });

        // History of Live Access (out)
        $liveAccess = DB::table('live_access')
            ->join('lives', 'live_access.live_id', '=', 'lives.id')
            ->join('users', 'lives.user_id', '=', 'users.id')
            ->where('live_access.user_id', $user->id)
            ->select('live_access.*', 'lives.title as live_title', 'users.name as creator_name', 'users.username as creator_username')
            ->get()
            ->map(function($la) {
                return [
                    'type' => 'Ticket de Live',
                    'description' => $la->live_title,
                    'user' => $la->creator_name,
                    'username' => $la->creator_username,
                    'amount' => $la->amount,
                    'direction' => 'out',
                    'date' => $la->created_at,
                    'status' => 'Liberado'
                ];
            });

        // History of Gifts Sent (out)
        $giftsSent = DB::table('live_gifts')
            ->leftJoin('lives', 'live_gifts.live_id', '=', 'lives.id')
            ->join('users', 'live_gifts.receiver_id', '=', 'users.id')
            ->join('gifts', 'live_gifts.gift_id', '=', 'gifts.id')
            ->where('live_gifts.user_id', $user->id)
            ->select('live_gifts.*', 'lives.title as live_title', 'users.name as creator_name', 'users.username as creator_username', 'gifts.name as gift_name')
            ->get()
            ->map(function($gs) {
                return [
                    'type' => $gs->live_id ? 'Presente em Live' : 'Presente (Mimos)',
                    'description' => $gs->live_id ? ($gs->gift_name . ' (' . $gs->live_title . ')') : $gs->gift_name,
                    'user' => $gs->creator_name,
                    'username' => $gs->creator_username,
                    'amount' => $gs->amount,
                    'direction' => 'out',
                    'date' => $gs->created_at,
                    'status' => 'Enviado'
                ];
            });

        $history = $purchases->concat($deposits)
            ->concat($liveAccess)
            ->concat($giftsSent);

        // Earnings from Tickets (in)
        $ticketEarnings = DB::table('live_access')
            ->join('lives', 'live_access.live_id', '=', 'lives.id')
            ->join('users', 'live_access.user_id', '=', 'users.id')
            ->where('lives.user_id', $user->id)
            ->select('live_access.*', 'lives.title as live_title', 'users.name as buyer_name', 'users.username as buyer_username')
            ->get()
            ->map(function($te) {
                return [
                    'type' => 'Ganho: Ticket de Live',
                    'description' => $te->live_title,
                    'user' => $te->buyer_name,
                    'username' => $te->buyer_username,
                    'amount' => $te->amount * 0.80, // Show what they actually received
                    'direction' => 'in',
                    'date' => $te->created_at,
                    'status' => 'Concluído'
                ];
            });

        // Earnings from Gifts (in)
        $giftEarnings = DB::table('live_gifts')
            ->leftJoin('lives', 'live_gifts.live_id', '=', 'lives.id')
            ->join('users', 'live_gifts.user_id', '=', 'users.id') // sender
            ->join('gifts', 'live_gifts.gift_id', '=', 'gifts.id')
            ->where('live_gifts.receiver_id', $user->id)
            ->select('live_gifts.*', 'lives.title as live_title', 'users.name as sender_name', 'users.username as sender_username', 'gifts.name as gift_name')
            ->get()
            ->map(function($ge) {
                return [
                    'type' => $ge->live_id ? 'Ganho: Presente' : 'Ganho: Mimo',
                    'description' => $ge->live_id ? ($ge->gift_name . ' (' . $ge->live_title . ')') : $ge->gift_name,
                    'user' => $ge->sender_name,
                    'username' => $ge->sender_username,
                    'amount' => $ge->amount - $ge->commission,
                    'direction' => 'in',
                    'date' => $ge->created_at,
                    'status' => 'Recebido'
                ];
            });

        // Earnings from Content Sales (in)
        $contentEarnings = DB::table('purchases')
            ->join('posts', 'purchases.post_id', '=', 'posts.id')
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->where('posts.user_id', $user->id)
            ->select('purchases.*', 'posts.title as post_title', 'users.name as buyer_name', 'users.username as buyer_username')
            ->get()
            ->map(function($ce) {
                return [
                    'type' => 'Ganho: Venda de Conteúdo',
                    'description' => $ce->post_title,
                    'user' => $ce->buyer_name,
                    'username' => $ce->buyer_username,
                    'amount' => $ce->amount, // Usually full amount in this platform? Let's assume as recorded
                    'direction' => 'in',
                    'date' => $ce->created_at,
                    'status' => 'Concluído'
                ];
            });

        $history = $history->concat($ticketEarnings)
            ->concat($giftEarnings)
            ->concat($contentEarnings)
            ->sortByDesc('date');
        $availableBalance = $user->balance;

        return view('wallet', compact('availableBalance', 'history'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:5000',
            'taxId' => 'required|string|min:11|max:14',
            'cellphone' => 'required|string',
        ], [
            'taxId.size' => 'O CPF deve ter exatamente 11 números.',
            'taxId.required' => 'O CPF é obrigatório.',
            'cellphone.min' => 'O celular deve ter pelo menos 10 números (DDD + número).',
            'cellphone.max' => 'O celular não pode ter mais de 11 números.',
            'amount.min' => 'O valor mínimo para depósito é R$ 10,00.',
            'amount.max' => 'O valor máximo para depósito é R$ 5.000,00.',
        ]);

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
            // Using v1 billing structure as per most dynamic integrations
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post('https://api.abacatepay.com/v1/billing/create', [
                'frequency' => 'ONE_TIME',
                'methods' => ['PIX', 'CARD'],
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
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'taxId' => preg_replace('/[^0-9]/', '', $request->taxId),
                    'cellphone' => preg_replace('/[^0-9]/', '', $request->cellphone),
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
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

            // Fallback to simpler structure if products fails
            $errorBody = $response->body();
            
            return redirect()->back()->with('error', 'Erro do Abacate Pay: ' . $errorBody);

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
        \Illuminate\Support\Facades\Log::info('AbacatePay Webhook Received:', $payload);

        // Abacate Pay sends the status in 'data' structure
        // Different versions might have status directly or inside data
        $status = $payload['data']['status'] ?? $payload['status'] ?? null;
        $externalId = $payload['data']['id'] ?? $payload['id'] ?? null;
        
        // Also check for the event type if available
        $event = $payload['event'] ?? null;

        if ($status === 'PAID' || $status === 'CONFIRMED' || $event === 'billing.paid' || $event === 'checkout.completed') {
            // Find by external_id (checkout id) or look in metadata if we sent it
            $deposit = Deposit::where('external_id', $externalId)->where('status', 'pending')->first();

            if (!$deposit) {
                // Try to find by metadata externalId if available
                $metaId = $payload['data']['metadata']['externalId'] ?? null;
                if ($metaId) {
                    $deposit = Deposit::where('id', str_replace('deposit_', '', $metaId))->where('status', 'pending')->first();
                }
            }

            if ($deposit) {
                DB::transaction(function() use ($deposit) {
                    $deposit->update(['status' => 'completed']);
                    
                    $user = $deposit->user;
                    $user->balance = (float)$user->balance + (float)$deposit->amount;
                    $user->save();

                    try {
                        Mail::to($user->email)->send(new DepositConfirmedMail($deposit->amount, $deposit->id));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Email Error (Webhook): " . $e->getMessage());
                    }
                    
                    \Illuminate\Support\Facades\Log::info("Deposit confirmed for User {$user->id}: +{$deposit->amount}");
                    
                    // Notify user
                    try {
                        $user->notify(new \App\Notifications\NewDeposit($deposit->amount));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Notification Error (Webhook): " . $e->getMessage());
                    }
                });
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['status' => 'received']);
    }
}
