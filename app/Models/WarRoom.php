<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'war_code',
        'assembly_id',
        'district_id',
        'booth_area',
        'incident_type',
        'severity',
        'incident_description',
        'reported_by',
        'contact_number',
        'incident_time',
        'assigned_to'
    ];

    // Relations
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function remarks()
    {
        return $this->hasMany(WarRoomRemarks::class, 'war_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}