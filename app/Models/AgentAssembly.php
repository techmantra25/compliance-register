<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAssembly extends Model
{
   protected $table = 'agent_assemblies';

   protected $fillable = [
    'agent_id', 'assembly_id'
   ];

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_assemblies');
    }
}
