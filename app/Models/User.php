<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'city',
        'country',
        'category',
        'bio',
        'is_verified',
        'role',
        'status',
        'withdrawals_frozen',
        'deposits_frozen',
        'last_ip',
        'two_factor_secret',
        'google_id',
        'google_token',
        'google_refresh_token',
        'studio_balance',
        'admin_role_id',
    ];

    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    public function canAccess($permission)
    {
        if (!$this->isAdmin()) return false;
        
        // Superadmins can access everything
        $superAdmins = ['bomboadmar@gmail.com', 'criptovida@gmail.com'];
        if (in_array($this->email, $superAdmins)) return true;

        if (!$this->adminRole) return false;

        return $this->adminRole->hasPermission($permission);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
        'studio_balance' => 'decimal:2',
    ];
    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function myCommunities()
    {
        return $this->hasMany(Community::class);
    }

    public function communitySubscriptions()
    {
        return $this->hasMany(CommunitySubscription::class);
    }

    public function isAdmin()
    {
        $superAdmins = ['bomboadmar@gmail.com', 'criptovida@gmail.com'];
        return $this->role === 'admin' || in_array($this->email, $superAdmins);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailPortuguese);
    }
}

