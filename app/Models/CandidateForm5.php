<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateForm5 extends Model
{
    protected $fillable = [
        'candidate_id',

        'election_to',
        'candidate_name',
        'place',
        'candidate_date',

        'office_hour',
        'office_date',
        'delivered_by_name',
        'delivered_by_role',
        'ro_date',

        'candidate_signature',
        'ro_signature',

        'receipt_candidate_name',
        'receipt_election_to',
        'receipt_delivered_by',
        'receipt_office_hour',
        'receipt_office_date',
        'receipt_ro_signature',
        'receipt_place',
        'receipt_date',

        // ✅ FOOTNOTE FIELDS
        'footnote_hp_constituency',
        'footnote_la_constituency',
        'footnote_cs_state',
        'footnote_cs_ut',
        'footnote_lc_constituency',
    ];
}
