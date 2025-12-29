<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\NominationForm2B as NominationForm2BModel;

class NominationForm2B extends Component
{
    public $candidateId;
    public $assembly_id;
    public $candidate_id;
    public $candidate;

    // read-only fields
    public $assembly_name;
    public $candidate_name;

    public $relation_name;
    public $postal_address;
    public $candidate_sl_no;
    public $candidate_part_no;

    public $proposer_name;
    public $proposer_sl_no;
    public $proposer_part_no;
    public $proposer_constituency;

    public $candidate_age;
    public $party_name;
    public $party_type = 'national';
    public $language_name = 'ENGLISH';

    public $election_type = 'general'; 
    public $state_name = 'WEST BENGAL';
    

    public $nomination_date;

    public $assemblies = [];
    public $candidates = [];

    public $convicted = 'no';
    public $conviction_details = [
        'fir_no' => null,
        'police_station' => null,
        'district' => null,
        'state' => null,
        'sections' => null,
        'conviction_dates' => null,
        'courts' => null,
        'punishment' => null,
        'release_date' => null,
        'appeal_filed' => 'no',
        'appeal_details' => null,
        'appeal_court' => null,
        'appeal_status' => null,
    ];

    public $office_of_profit = 'no';
    public $office_details;

    public $insolvent = 'no';
    public $insolvent_details;

    public $foreign_allegiance = 'no';
    public $foreign_details;

    public $disqualified_president = 'no';
    public $disqualified_period;

    public $dismissed_for_corruption = 'no';
    public $dismissed_date;

    public $govt_contract = 'no';
    public $govt_contract_details;

    public $company_position = 'no';
    public $company_details;

    public $commission_disqualified = 'no';
    public $commission_disqualified_date;

    public $place;
    public $declaration_date;


    protected $rules = [
        'relation_name' => 'required',
        'postal_address' => 'required',
        'candidate_sl_no' => 'required',
        'candidate_part_no' => 'required',

        'proposer_name' => 'required',
        'proposer_sl_no' => 'required',
        'proposer_part_no' => 'required',
        'candidate_age' => 'required|integer|min:25',
        'party_name' => 'required',
        'party_type' => 'required|in:national,state',
        'language_name' => 'required',
        'election_type' => 'required|in:general,bye',
        'state_name' => 'required',
        
    ];

    
    public function mount($id)
    {
        $candidate = Candidate::with('assembly')->findOrFail($id);

        $this->candidateId      = $candidate->id;
        $this->candidate_id     = $candidate->id;
        $this->assembly_id      = $candidate->assembly->id;

        $this->candidate_name   = $candidate->name;
        $this->assembly_name    = $candidate->assembly->assembly_name_en . ' (' . $candidate->assembly->assembly_code . ')';
    }

    public function save()
    {
        dd($this->validate());
        $this->validate();

        NominationForm2BModel::create([
            'assembly_id' => $this->assembly_id,
            'candidate_id' => $this->candidate_id,

            'relation_name' => $this->relation_name,
            'postal_address' => $this->postal_address,
            'candidate_sl_no' => $this->candidate_sl_no,
            'candidate_part_no' => $this->candidate_part_no,

            'proposer_name' => $this->proposer_name,
            'proposer_sl_no' => $this->proposer_sl_no,
            'proposer_part_no' => $this->proposer_part_no,
            'proposer_constituency' => $this->proposer_constituency,
            'candidate_age' => $this->candidate_age,
            'party_name' => $this->party_name,
            'party_type' => $this->party_type,
            'language_name' => $this->language_name,
            'election_type' => $this->election_type,
            'state_name' => $this->state_name,
            'part_3a' => [
                'convicted' => $this->convicted,
                'conviction_details' => $this->conviction_details,

                'office_of_profit' => $this->office_of_profit,
                'office_details' => $this->office_details,

                'insolvent' => $this->insolvent,
                'insolvent_details' => $this->insolvent_details,

                'foreign_allegiance' => $this->foreign_allegiance,
                'foreign_details' => $this->foreign_details,

                'disqualified_president' => $this->disqualified_president,
                'disqualified_period' => $this->disqualified_period,

                'dismissed_for_corruption' => $this->dismissed_for_corruption,
                'dismissed_date' => $this->dismissed_date,

                'govt_contract' => $this->govt_contract,
                'govt_contract_details' => $this->govt_contract_details,

                'company_position' => $this->company_position,
                'company_details' => $this->company_details,

                'commission_disqualified' => $this->commission_disqualified,
                'commission_disqualified_date' => $this->commission_disqualified_date,
            ],

        ]);

        session()->flash('success', 'Nomination form submitted successfully');
        $this->reset();
    }


    public function render()
    {
        return view('livewire.nomination-form2-b')->layout('layouts.admin');
    }
}
