<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunitySubscription extends Model
{
    use HasFactory;

    protected $fillable = ['community_id', 'user_id', 'amount', 'expires_at', 'status'];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
