<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
   protected $table = "candidates";
    
   protected $fillable = [
        'name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'contact_number_alt_2', 'type','agent_id', 'assembly_id'
   ];

   public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }
    public function agent(){
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
