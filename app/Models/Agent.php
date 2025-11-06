<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table ='agents';

    protected $fillable = [
        'name', 'designation', 'email', 'contact_number', 'contact_number_alt_1'
    ];

    public function assemblies()
    {
        return $this->belongsToMany(Assembly::class, 'agent_assemblies');
    }
    
}
