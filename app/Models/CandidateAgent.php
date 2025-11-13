<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateAgent extends Model
{
    protected $table = 'candidate_agents';

    protected $fillable = [
        'candidate_id',
        'agent_id',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
