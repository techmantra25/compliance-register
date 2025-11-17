<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateAcknoledgmentCopy extends Model
{
    protected $table = "candidate_acknowledgment_copy";

    protected $fillable = [
        'candidate_id', 'path'
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }
}
