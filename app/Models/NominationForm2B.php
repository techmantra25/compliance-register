<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationForm2B extends Model
{
    protected $table = 'nomination_forms_2_b';

    protected $fillable = [
        'assembly_id',
        'candidate_id',
        'assembly_name',
        'candidate_name',
        'relation_name',
        'postal_address',
        'candidate_sl_no',
        'candidate_part_no',
        'candidate_constituency',
        'proposer_name',
        'proposer_sl_no',
        'proposer_part_no',
        'proposer_constituency',
        'nomination_date',
        'candidate_age',
        'party_name',
        'party_type',
        'relation_type',
        'language_name',
        'election_type',
        'state_name'
    ];

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    
}
