<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscrepancyReport extends Model
{
   protected $table = 'discrepancy_reports';

   protected $fillable = [
    'unique_id', 'assembly_id', 'social_media', 'report', 'source_url', 'is_verified', 'report_type', 'user_id','screenshot'
   ];

    public function assembly(){
        return $this->belongsTo(Assembly::class, 'assembly_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
