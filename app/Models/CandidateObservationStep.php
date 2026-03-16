<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateObservationStep extends Model
{
    use HasFactory;

    protected $table = 'candidate_observation_steps';

    protected $fillable = [
        'candidate_id',
        'version',
        'observations',
        'generated_by'
    ];

    protected $casts = [
        'candidate_id' => 'integer',
        'version' => 'integer',
        'generated_by' => 'integer',
    ];

    /**
     * Candidate Relationship
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * Admin who generated observation
     */
    public function generatedBy()
    {
        return $this->belongsTo(Admin::class, 'generated_by');
    }
}