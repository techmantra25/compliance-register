<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateDocument extends Model
{
    
    protected $table = "candidate_documents";
    protected $fillable = [
        'candidate_id',
        'type',
        'path',
        'remarks',
        'uploaded_by',
        'status',
    ];

    public function uploadedBy()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by', 'id');
    }
}
