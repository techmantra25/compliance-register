<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
   protected $table = "candidates";
    
   protected $fillable = [
        'name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'contact_number_alt_2', 'type', 'assembly_id', 'document_collection_status', 'acknowledgment_file', 'acknowledgment_by', 'acknowledgment_at', 'final_submission_confirmation'
   ];

   public function documents()
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_id');
    }
   public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }
   public function user()
    {
        return $this->belongsTo(Admin::class, 'acknowledgment_by');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'candidate_agents', 'candidate_id', 'agent_id');
    }
}
