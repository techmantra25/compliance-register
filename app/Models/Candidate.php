<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
   protected $table = "candidates";
    
   protected $fillable = [
       'name', 'designation','image', 'email', 'contact_number', 'contact_number_alt_1', 'contact_number_alt_2', 'type', 'assembly_id', 'document_collection_status', 'status', 'parent_candidate_id', 'cloned_by', 'cloned_at', 'clone_remarks', 'is_special_case', 'criminal_case_id', 'special_case_label', 'observation_description', 'last_created_observation_form', 'is_criminal_offence', 'legal_associate_id'
   ];

   public function documents()
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_id');
    }
  public function VedifiedDocuments()
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_id')
                    ->whereIn('status', ['Skipped','Approved','Uploaded','Pending']);
    }
   public function assembly()
    {
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'candidate_agents', 'candidate_id', 'agent_id');
    }
    public function clonedBy()
    {
        return $this->belongsTo(Admin::class, 'cloned_by');
    }
    public function legalAssociate()
    {
        return $this->belongsTo(Admin::class, 'legal_associate_id');
    }
}
