<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateAcknowledgmentCopy extends Model
{
    protected $table = "candidate_acknowledgment_copy";

    protected $fillable = [
        'candidate_id', 'path', 'acknowledgment_by', 'acknowledgment_at', 'final_submission_confirmation', 'uploaded_by', 'uploaded_at', 'status', 'rejected_reason'
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }
    public function uploader(){
        return $this->belongsTo(Admin::class, 'uploaded_by', 'id');
    }

    public function acknowledger(){
        return $this->belongsTo(Admin::class, 'acknowledgment_by', 'id');
    }
}
