<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_nama',
        'user_username',
        'user_password',
        'user_role'
    ];

    protected $hidden = [
        'user_password'
    ];

    // 🔥 penting: override password field
    public function getAuthPassword()
    {
        return $this->user_password;
    }
}