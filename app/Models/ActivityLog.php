<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'type',
        'description',
        'amount',
        'wallet_type',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Helper to log an activity
     */
    public static function log($description, $type = 'info', $amount = null, $userId = null, $walletType = null, $metadata = [])
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'admin_id' => auth()->user() && auth()->user()->isAdmin() ? auth()->id() : null,
            'description' => $description,
            'type' => $type,
            'amount' => $amount,
            'wallet_type' => $walletType,
            'metadata' => $metadata,
        ]);
    }
}
