<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $fillable = ['name', 'slug', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'admin_role_id');
    }

    public function hasPermission($permission)
    {
        return is_array($this->permissions) && in_array($permission, $this->permissions);
    }
}
