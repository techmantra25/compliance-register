<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form2bDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form2b_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assembly_id', 'candidate_name', 'age', 'relation_type', 'party_name', 'relation_name', 'pronoun', 'postal_address', 'candidate_serial_no', 'candidate_part_no', 'assembly_name', 'constituency_where_enrolled', 'proposers', 'convicted', 'office_of_profit', 'holding_office_of_profit', 'insolvent', 'declared_insolvent', 'foreign_allegiance', 'allegiance_to_foreign_country', 'disqualified_president', 'disqualified_by_president', 'dismissed_for_corruptions', 'dismissed_for_corruption', 'govt_contract', 'subsisting_govt_contract', 'company_position', 'managing_agent_role', 'commission_disqualified', 'date_of_disqualification', 'party_type', 'symbol_1', 'symbol_2', 'symbol_3', 'has_caste', 'caste', 'caste_state', 'caste_area', 'created_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Automatically handle JSON encoding/decoding for multiple proposers
        'proposers' => 'array',
        
        // Ensure boolean fields are treated as true/false
        'office_of_profit' => 'boolean',
        'insolvent' => 'boolean',
        'foreign_allegiance' => 'boolean',
        'disqualified_president' => 'boolean',
        'dismissed_for_corruptions' => 'boolean',
        'govt_contract' => 'boolean',
        'company_position' => 'boolean',
        'commission_disqualified' => 'boolean',
        
        // Ensure dates are Carbon instances
        'dismissed_for_corruption' => 'date',
        'date_of_disqualification' => 'date',
    ];

    /**
     * Get the assembly that owns this form detail.
     */
    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}