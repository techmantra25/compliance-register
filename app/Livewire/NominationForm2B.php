<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\NominationForm;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class NominationForm2B extends Component
{
    public $candidateId;
    public $assembly_id;
    public $candidate_id;
    public $candidate;

    public $candidate_name;
    public $assembly_name;
    public $state = 'WEST BENGAL';
    public $relation_type = 'father';
    public $pronoun = 'his';
    
    public $relation_name;
    public $age;
    public $postal_address;
    public $candidate_serial_no;
    public $candidate_part_no;
    public $constituency_where_enrolled;
    public $political_party_name = 'AITC';
    public $recognized_political_party = 'AITC';
    public $language_of_name = 'ENGLISH';

    public $proposer_name;
    public $proposer_serial_no;
    public $proposer_part_no;
    public $proposer_constituency;

    public $candidate_age;
    public $party_name = '';
    public $language_name = 'ENGLISH';

    public $election_type = 'general'; 
    public $nomination_date;
    public $assemblies = [];
    public $candidates = [];

    public $convicted = 'no';
    public $convicted_details = [];
    public $case_no;
    public $police_station;
    public $district;
    public $sections;
    public $conviction_date;
    public $court;
    public $punishment;
    public $release_date;

    public $appeal_filed;
    public $appeal_details;
    public $appeal_court;
    public $appeal_status;
    public $disposal_date;
    public $order_nature;



    public $holding_office_of_profit;
    public $declared_insolvent;
    public $allegiance_to_foreign_country;
    public $disqualified_by_president;
    public $dismissed_for_corruption;
    public $subsisting_govt_contract;
    public $managing_agent_role;
    public $disqualified_by_commission;
    public $date_of_disqualification;

    public $office_of_profit; 
    public $office_details; 

    public $insolvent;
    public $insolvent_details;

    public $foreign_allegiance;
    public $foreign_details;

    public $disqualified_president;
    public $disqualified_period;

    public $dismissed_for_corruptions;
    public $dismissed_date;

    public $govt_contract;
    public $govt_contract_details;

    public $company_position;
    public $company_details;

    public $commission_disqualified;
    public $commission_disqualified_date;
   

    protected $rules = [
        'relation_type' => 'required|in:father,mother,husband',
        'relation_name' => 'required',
        'postal_address' => 'required',
        'candidate_serial_no' => 'required',
        'candidate_part_no' => 'required',

        'proposer_name' => 'required',
        'proposer_serial_no' => 'required',
        'proposer_part_no' => 'required',
        'convicted' => 'required|in:yes,no',

        'office_of_profit' => 'required|in:yes,no',
        'office_details' => 'required_if:office_of_profit,yes',

        'insolvent' => 'required|in:yes,no',
        'insolvent_details' => 'required_if:insolvent,yes',
    ];

    public function mount($id)
    {
        $this->candidate = Candidate::with('assembly')->findOrFail($id);

        $this->candidateId    = $this->candidate->id;
        $this->candidate_id   = $this->candidate->id;
        $this->assembly_id    = $this->candidate->assembly->id;

        $form = NominationForm::where('candidate_id', $this->candidate_id)->first();

        if ($form) {
            $this->fill($form->toArray());
        } 

        $this->candidate_name = $this->candidate->name;
        $this->assembly_name  =
            $this->candidate->assembly->assembly_name_en
            . ' (' . $this->candidate->assembly->assembly_code . ')';

    }

    public function updatedConvicted($value)
    {
        if ($value === 'no') {
            $this->case_no = null;
            $this->police_station = null;
            $this->district = null;
            $this->state = null;
            $this->sections = null;
            $this->conviction_date = null;
            $this->court = null;
            $this->punishment = null;
            $this->release_date = null;
            $this->appeal_filed = null;
            $this->appeal_details = null;
            $this->appeal_court = null;
            $this->appeal_status = null;
            $this->disposal_date = null;
            $this->order_nature = null;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'convicted' => $this->convicted,
            ];

            if ($this->convicted === 'yes') {
                $data['convicted_details'] = [
                    'case_no'          => $this->case_no,
                    'police_station'   => $this->police_station,
                    'district'         => $this->district,
                    'state'            => $this->state,
                    'sections'         => $this->sections,
                    'conviction_date'  => $this->conviction_date,
                    'court'            => $this->court,
                    'punishment'       => $this->punishment,
                    'release_date'     => $this->release_date,
                    'appeal_filed'     => $this->appeal_filed,
                    'appeal_details'   => $this->appeal_details,
                    'appeal_court'     => $this->appeal_court,
                    'appeal_status'    => $this->appeal_status,
                    'disposal_date'    => $this->disposal_date,
                    'order_nature'     => $this->order_nature,
                ];
            } else {
                $data['convicted_details'] = null;
            }

            $holdingOfficeOfProfit = null;

            if ($this->office_of_profit === 'yes') {
                $holdingOfficeOfProfit = $this->office_details;
            }

            $insolventDetails = null;

            if ($this->insolvent === 'yes') {
                $insolventDetails = $this->insolvent_details;
            }

            $foreignDetails = null;
            if ($this->foreign_allegiance === 'yes') {
                $foreignDetails = $this->foreign_details;
            }

            $disqualifiedPresident = null;
            if ($this->disqualified_president === 'yes') {
                $disqualifiedPresident = $this->disqualified_period;
            }

            $dismissedForCorruption = null;
            if ($this->dismissed_for_corruptions === 'yes') {
                $dismissedForCorruption = $this->dismissed_date;
            }


            $govtContract = null;
            if ($this->govt_contract === 'yes') {
                $govtContract = $this->govt_contract_details;
            }

            $manageAgentRole = null;
            if ($this->company_position === 'yes') {
                $manageAgentRole = $this->company_details;
            }

            $commisionDisqualifiedDate = null;
            if ($this->commission_disqualified === 'yes') {
                $commisionDisqualifiedDate = $this->commission_disqualified_date;
            }

            $nomination = NominationForm::updateOrCreate(
                ['candidate_id' => $this->candidate_id],
                array_merge($data, [
                    'assembly_id' => $this->assembly_id,
                    'state' => $this->state,
                    'form_type' => 'form_2b',
                    'age' => $this->age,
                    'relation_type' => $this->relation_type,
                    'relation_name' => $this->relation_name,
                    'postal_address' => $this->postal_address,
                    'candidate_serial_no' => $this->candidate_serial_no,
                    'candidate_part_no' => $this->candidate_part_no,
                    'constituency_where_enrolled' => $this->constituency_where_enrolled,
                    'political_party_name' => $this->political_party_name,
                    'recognized_political_party' => $this->recognized_political_party,
                    'language_of_name' => $this->language_of_name,
                    'proposer_name' => $this->proposer_name,
                    'proposer_serial_no' => $this->proposer_serial_no,
                    'proposer_part_no' => $this->proposer_part_no,
                    'proposer_constituency' => $this->proposer_constituency,
                    'declared_insolvent' => $this->declared_insolvent,
                    'allegiance_to_foreign_country' => $this->allegiance_to_foreign_country,
                    'disqualified_by_president' => $this->disqualified_by_president,
                    'dismissed_for_corruption' => $this->dismissed_for_corruption,
                    'subsisting_govt_contract' => $this->subsisting_govt_contract,
                    'managing_agent_role' => $this->managing_agent_role,
                    'disqualified_by_commission' => $this->disqualified_by_commission,
                    'date_of_disqualification' => $this->date_of_disqualification,
                    'holding_office_of_profit' => $holdingOfficeOfProfit,
                    'declared_insolvent' => $insolventDetails,
                    'allegiance_to_foreign_country' => $foreignDetails,
                    'disqualified_by_president' => $disqualifiedPresident,
                    'dismissed_for_corruption' => $dismissedForCorruption,
                    'subsisting_govt_contract' => $govtContract,
                    'managing_agent_role' => $manageAgentRole,
                    'disqualified_by_commission' => $this->commission_disqualified,
                    'date_of_disqualification' => $commisionDisqualifiedDate,
                ])
            );

            return redirect()->route('admin.candidates.form2B.pdf', $nomination->id);

        } catch (\Exception $e) {
            dd($e->getMessage());
            \Log::error('Nomination Save Error: '.$e->getMessage());
            session()->flash('error', 'Something went wrong');
        }
    }

    public function render()
    {
        return view('livewire.nomination-form2-b')->layout('layouts.admin');
    }
}
