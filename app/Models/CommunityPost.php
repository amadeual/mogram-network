<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = ['community_id', 'user_id', 'content', 'media', 'media_type', 'views_count', 'likes_count', 'scheduled_at'];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(CommunityPostLike::class, 'community_post_id');
    }

    public function comments()
    {
        return $this->hasMany(CommunityPostComment::class, 'community_post_id');
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
