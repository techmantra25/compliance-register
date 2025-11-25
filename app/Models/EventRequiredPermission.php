<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequiredPermission extends Model
{
    protected $table = "event_required_permissions";
    protected $fillable = [
        'category_id',
        'permission_required',
        'issuing_authority',
        'status'
    ];

    
    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }
}
