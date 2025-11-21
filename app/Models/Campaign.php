<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = "campaigns";

    protected $fillable = [
        'campaigner_id', 'assembly_id', 'event_category_id', 'address', 'campaign_date', 'remarks', 'permission_status', 'last_date_of_permission',
        'status','rescheduled_at','cancelled_remarks',
    ];


    public function campaigner(){
        return $this->belongsTo(Campaigner::class, 'campaigner_id', 'id');
    }
    public function assembly(){
        return $this->belongsTo(Assembly::class, 'assembly_id', 'id');
    }

    public function category(){
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }
}
