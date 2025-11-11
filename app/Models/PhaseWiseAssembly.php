<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhaseWiseAssembly extends Model
{
   protected $table = "phase_wise_assembly";

   protected $fillable = [
        'phase_id', 'assembly_id'
   ];

   public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id', 'id');
   }
   public function assembly(){
        return $this->belongsTo(Assembly::class, 'assembly_id', 'id');
   }
}
