<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'thumbnail', 'is_free', 'price', 'status', 'started_at', 'ended_at', 'is_paused', 'is_muted', 'is_camera_off'];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chats()
    {
        return $this->hasMany(LiveChat::class);
    }

    public function likes()
    {
        return $this->hasMany(LiveLike::class);
    }
}
