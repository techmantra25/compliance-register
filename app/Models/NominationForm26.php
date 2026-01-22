<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationForm26 extends Model
{
    protected $table = 'form_26';
    
    protected $fillable = [
    'relation_type',
    'relation_name',
    'address',
    'assembly_constituency_no',
    'assembly_constituency_serial_no',
    'assembly_constituency_part_no',
    'phone_no',
    'alternative_phone_no',
    'candidate_epic_no',
    'photograph',
    'caste_tribe_details',
    'proposer_epic',
    'email_id',
    'social_media_accounts',
    'pan_and_itr_details',
    'last_5_yrs_income',
    'movable_and_immovable_assets',
    'loans_govt_dues',
    'occupation',
    'sources_of_incomes',
    'highest_educational_qualification',
];
    
}
