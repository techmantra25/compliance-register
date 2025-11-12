<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateDocumentType extends Model
{
    use HasFactory;

    protected $table = 'candidate_document_types';

    protected $fillable = [
        'key',
        'name',
    ];
}
