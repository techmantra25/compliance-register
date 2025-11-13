<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateDocumentComment extends Model
{
    protected $table = 'candidate_document_comments';

    protected $fillable = [
        'candidate_document_id',
        'comment',
       'created_by',
    ];

    /**
     * Relationship: Each comment belongs to a candidate document
     */
    public function document()
    {
        return $this->belongsTo(CandidateDocument::class, 'candidate_document_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
