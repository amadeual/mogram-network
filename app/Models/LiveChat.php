<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChat extends Model
{
    use HasFactory;

    protected $fillable = ['live_id', 'user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function live()
    {
        return $this->belongsTo(Live::class);
    }
}
