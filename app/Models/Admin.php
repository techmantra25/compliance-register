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
        'assemblies',
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

    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'legal_associate' => 'Legal Associate (L1/TL)',
            'employee' => 'Employee (L2)',
            'admin' => 'Super Admin',
            default => ucwords(str_replace('_',' ',$this->role)),
        };
    }

    public function getRoleBadgeAttribute()
    {
        return match($this->role) {
            'legal_associate' => 'bg-primary',
            'employee' => 'bg-success',
            'admin' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
