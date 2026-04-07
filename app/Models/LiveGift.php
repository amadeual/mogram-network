<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveGift extends Model
{
    use HasFactory;

    protected $fillable = ['live_id', 'user_id', 'receiver_id', 'gift_id', 'amount', 'commission'];
}
