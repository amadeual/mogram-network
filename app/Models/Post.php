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
        'views',
        'shares',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_exclusive' => 'boolean',
        'allow_comments' => 'boolean',
        'price' => 'decimal:2',
        'views' => 'integer',
        'shares' => 'integer',
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
        return $this->hasMany(Comment::class);
    }

    public function getEngagement()
    {
        $likesCount = $this->likes()->count();
        $commentsCount = $this->comments()->count();
        return $likesCount + $commentsCount;
    }

    public function incrementViews()
    {
        $this->increment('views');
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

    public function getFormattedDescriptionAttribute()
    {
        $content = e($this->description);
        return preg_replace('/(\B@(\w+))/', '<a href="/profile/$2" style="color: #3390ec; font-weight: 800; text-decoration: none;">$1</a>', $content);
    }

    public function getFormattedShortDescriptionAttribute()
    {
        $plainText = strip_tags($this->description);
        $short = mb_substr($plainText, 0, 500);
        return preg_replace('/(\B@(\w+))/', '<a href="/profile/$2" style="color: #3390ec; font-weight: 800; text-decoration: none;">$1</a>', e($short));
    }
}
