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
        'vetted_by',
        'vetted_on',
        'status',
    ];

    protected $casts = [
        'vetted_on' => 'datetime',
    ];
    public function uploadedBy()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by', 'id');
    }
    public function vettedBy()
    {
        return $this->belongsTo(Admin::class, 'vetted_by', 'id');
    }
    public function comments()
    {
        return $this->hasMany(CandidateDocumentComment::class, 'candidate_document_id');
    }
}
