<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'slug', 'description', 'category', 'banner', 'avatar', 'price', 'has_free_trial', 'free_trial_days', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(CommunitySubscription::class);
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }
}
