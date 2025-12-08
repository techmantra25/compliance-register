<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MCC extends Model

{
   protected $table = 'mcc';

   protected $fillable = [
        'assembly_id', 'block', 'gp', 'complainer_name', 'complainer_phone','complainer_description', 'remarks','action_taken','status'
   ];

    public function districts(){
        return $this->belongsTo(District::class, 'district_id');
    }

    public function assembly(){
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }
}
