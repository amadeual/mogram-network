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

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function getFormattedContentAttribute()
    {
        $content = str_replace(['<div>', '</div>', '<p>', '</p>', '<br>', '<br/>', '<br />'], ["", "\n", "", "\n", "\n", "\n", "\n"], $this->content);
        $content = strip_tags($content);
        $content = nl2br(e(trim($content)));
        return preg_replace('/(\B@(\w+))/', '<a href="/profile/$2" style="color: #3390ec; font-weight: 800; text-decoration: none;">$1</a>', $content);
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
        try {
            return $this->likes()->where('user_id', $userId)->exists();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCommentsCountAttribute()
    {
        try {
            return $this->comments()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }


}
