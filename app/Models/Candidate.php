<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
   protected $table = "candidates";
    
   protected $fillable = [
        'name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'contact_number_alt_2', 'type', 'assembly_id'
   ];

   public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'candidate_agents', 'candidate_id', 'agent_id');
    }
}
