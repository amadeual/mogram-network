<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPostComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'community_post_id', 'content'];

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
}
