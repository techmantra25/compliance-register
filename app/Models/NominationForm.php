<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationForm extends Model
{
    protected $table = 'nomination_forms';

        protected $fillable = [
            'candidate_id',
            'form_type',
            'assembly_id',
            'state',
            'candidate_serial_no',
            'candidate_part_no',
            'relation_type',
            'relation_name',
            'age',
            'postal_address',
            'constituency_where_enrolled',
            'political_party_name',
            'recognized_political_party',
            'language_of_name',
            'caste_tribe_details',
            'state_of_caste_and_tribe',
            'relation_to_state',
            'proposer_name',
            'proposer_part_no',
            'proposer_serial_no',
            'proposer_constituency',
            'more_proposer_details',
            'convicted',
            'convicted_details',
            'holding_office_of_profit',
            'declared_insolvent',
            'allegiance_to_foreign_country',
            'disqualified_by_president',
            'dismissed_for_corruption',
            'subsisting_govt_contract',
            'managing_agent_role',
            'disqualified_by_commission',
            'date_of_disqualification',
            'contact_phone_nos',
            'email_id',
            'social_media_accounts',
            'pan_details',
            'last_five_year_incomes',
            'movable_assets',
            'immovable_assets',
            'loans_and_govt_dues',
            'candidate_occupation',
            'spouse_occupation',
            'source_of_incomes',
            'highest_educational_qualification',
        ];

        protected $casts = [
            'convicted_details' => 'array',
            'contact_phone_nos' => 'array',
            'social_media_accounts' => 'array',
        ];

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function logs()
    {
        return $this->hasMany(NominationLog::class, 'nomination_id');
    }
}
