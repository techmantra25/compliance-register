<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
   protected $table = 'phases';

   protected $fillable = [
        'name', 'last_date_of_nomination', 'date_of_election','last_date_of_mcc'
   ];

  // Relationship to PhaseWiseAssembly
    public function phaseAssemblies()
    {
        return $this->hasMany(PhaseWiseAssembly::class, 'phase_id', 'id');
    }

    //  Direct relationship to Assembly through the pivot
    public function assemblies()
    {
        return $this->belongsToMany(Assembly::class, 'phase_wise_assembly', 'phase_id', 'assembly_id');
    }

}