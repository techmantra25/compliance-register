<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'admin_id',
        'email',
        'ip_address',
        'user_agent',
        'login_at',
        'is_success'
    ];
}
