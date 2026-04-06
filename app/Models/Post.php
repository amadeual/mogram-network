<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'is_exclusive',
        'price',
        'file_path',
        'thumbnail',
        'scheduled_at',
        'allow_comments',
        'category',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_exclusive' => 'boolean',
        'allow_comments' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function isPurchasedBy(User $user)
    {
        return $this->purchases()->where('user_id', $user->id)->exists();
    }
}
