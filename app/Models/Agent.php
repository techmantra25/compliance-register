<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;
    
    protected $table ='agents';

    protected $fillable = [
        'name',
        'assemblies_id', 
        'designation', 
        'email', 
        'contact_number', 
        'contact_number_alt_1', 
        'comments', 
        'phone_number',
        'whatsapp_number',
        'type',
        'area'
    ];

    public function assemblies()
    {
        return $this->belongsToMany(Assembly::class, 'agent_assemblies');
    }

     public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_agents', 'agent_id', 'candidate_id');
    }

    public function assembliesDetails()
    {
        return $this->belongsTo(Assembly::class, 'assemblies_id');
    }
    
}
