<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'live_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function live()
    {
        return $this->belongsTo(Live::class);
    }
}
