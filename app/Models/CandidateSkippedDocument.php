<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateSkippedDocument extends Model
{
   protected $table = 'candidate_skipped_documents';

    protected $fillable = [
        'candidate_id',
        'version',
        'type',
        'path',
        'remarks',
        'uploaded_by',
        'vetted_by',
        'vetted_on',
        'status',
        'attached_with',
        'attached_with_slug'
    ];

    protected $casts = [
        'vetted_on' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Candidate Relation
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    // Uploaded By (Admin/User)
    public function uploader()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    // Vetted By (Admin/User)
    public function vetter()
    {
        return $this->belongsTo(Admin::class, 'vetted_by');
    }
}
