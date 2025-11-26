<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'zone_id',
        'role',
        'suspended_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function zones(){
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function getPermissionAttribute(){
        $permissions = \DB::table('admin_permissions')
                ->where('admin_id', $this->id)
                ->pluck('permission_id')
                ->toArray();
        return $permissions;
    }
}
