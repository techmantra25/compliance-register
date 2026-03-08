<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarRoomRemarks extends Model
{
    use HasFactory;

    protected $fillable = [
        'war_id',
        'remarks',
        'attachment',
        'legal_associate_id',
        'is_read',
        'is_cancelled'
    ];

    public function warRoom()
    {
        return $this->belongsTo(WarRoom::class, 'war_id');
    }

    public function legalAssociate()
    {
        return $this->belongsTo(User::class, 'legal_associate_id');
    }
}