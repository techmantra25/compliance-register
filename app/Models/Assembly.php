<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
   protected $table = "assemblies";

   protected $fillable = [
        'district_id', 'assembly_number', 'assembly_name_en', 'assembly_name_bn', 'assembly_code', 'status'
   ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'assembly_id');
    }
    public function assemblyPhase()
    {
        return $this->hasOne(PhaseWiseAssembly::class, 'assembly_id','id');
    }
}
