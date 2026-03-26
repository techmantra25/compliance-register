<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\NominationForm;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class NominationForm2B extends Component
{
    public $candidateId;
    public $assembly_id;
    public $candidate_id;
    public $candidate;

    public $candidate_name;
    public $assembly_name;
    public $state = 'WEST BENGAL';
    public $relation_type = '';
    public $pronoun = '';
    
    public $relation_name;
    public $age;
    public $postal_address;
    public $candidate_serial_no;
    public $candidate_part_no;
    public $constituency_where_enrolled;
    public $political_party_name = 'AITC';
    public $recognized_political_party = 'National Party';
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

    public $convicted = 'No';
    public $convicted_details = [
        'case_no' => null,
        'police_station' => null,
        'district' => null,
        'state' => null,
        'sections' => null,
        'conviction_date' => null,
        'court' => null,
        'punishment' => null,
        'release_date' => null,
        'appeal_filed' => null,
        'appeal_details' => null,
        'appeal_court' => null,
        'appeal_status' => null,
        'disposal_date' => null,
        'order_nature' => null,
    ];

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

    public $criminal_check = 'No';
    public $formLocked = false;
   

    protected $rules = [
        'age' => 'required|integer|min:18',
        'relation_type' => 'required|in:father,mother,husband',
        'pronoun' => 'required|in:his,her',
        'relation_name' => 'required',
        'postal_address' => 'required',
        'candidate_serial_no' => 'required',
        'candidate_part_no' => 'required',
        'proposer_name' => 'required',
        'proposer_serial_no' => 'required',
        'proposer_part_no' => 'required',
        'convicted' => 'required|in:Yes,No',
    ];

    private function titleCase($value)
    {
        return is_string($value) ? ucwords(strtolower($value)) : $value;
    }

    public function mount($id)
    {
        $this->candidate = Candidate::with('assembly')->findOrFail($id);

        $this->candidateId    = $this->candidate->id;
        $this->candidate_id   = $this->candidate->id;
        $this->assembly_id    = $this->candidate->assembly->id;

        $this->age = $this->candidate->age;
        $this->candidate_serial_no = $this->candidate->serial_no;
        $this->candidate_part_no = $this->candidate->part_no;

        $form = NominationForm::where('candidate_id', $this->candidate_id)->first();

        if ($form) {
            $this->fill($form->toArray());

            $this->candidate_name               = $this->titleCase($this->candidate_name);
            $this->relation_name                = $this->titleCase($this->relation_name);
            $this->pronoun                      = $form->pronoun ?? 'his'; 
            $this->postal_address               = $this->titleCase($this->postal_address);
            $this->constituency_where_enrolled  = $this->titleCase($this->constituency_where_enrolled);
            $this->proposer_name                = $this->titleCase($this->proposer_name);
            $this->proposer_constituency        = $this->titleCase($this->proposer_constituency);
            $this->holding_office_of_profit     = $this->titleCase($this->holding_office_of_profit);
            $this->declared_insolvent           = $this->titleCase($this->declared_insolvent);
            $this->allegiance_to_foreign_country= $this->titleCase($this->allegiance_to_foreign_country);
            $this->managing_agent_role          = $this->titleCase($this->managing_agent_role);

            if (is_array($form->convicted_details)) {
                $this->convicted_details = $form->convicted_details;
            } else {
                $this->convicted_details = [
                    'case_no' => null,
                    'police_station' => null,
                    'district' => null,
                    'state' => null,
                    'sections' => null,
                    'conviction_date' => null,
                    'court' => null,
                    'punishment' => null,
                    'release_date' => null,
                    'appeal_filed' => null,
                    'appeal_details' => null,
                    'appeal_court' => null,
                    'appeal_status' => null,
                    'disposal_date' => null,
                    'order_nature' => null,
                ];
            }

            if (is_array($this->convicted_details)) {
                foreach ($this->convicted_details as $key => $value) {
                    $this->convicted_details[$key] = $this->titleCase($value);
                }
            }

            $this->convicted = $form->convicted;
            $this->office_of_profit = $form->office_of_profit;
            $this->insolvent = $form->insolvent;
            $this->foreign_allegiance = $form->foreign_allegiance;
            $this->disqualified_president = $form->disqualified_president;
            $this->dismissed_for_corruptions = $form->dismissed_for_corruptions;
            $this->govt_contract = $form->govt_contract;
            $this->company_position = $form->company_position;
            $this->commission_disqualified = $form->commission_disqualified;
        } else{
            $this->convicted = "No";
            $this->office_of_profit = 0;
            $this->insolvent = 0;
            $this->foreign_allegiance = 0;
            $this->disqualified_president = 0;
            $this->dismissed_for_corruptions = 0;
            $this->govt_contract = 0;
            $this->company_position = 0;
            $this->commission_disqualified = 0;
        }

         // Office of profit
        // $this->office_of_profit = $form?->holding_office_of_profit ? 'Yes' : 'No';
        $this->holding_office_of_profit = $form?->holding_office_of_profit;

        // Insolvent
        // $this->insolvent = $form?->declared_insolvent ? 'Yes' : 'No';
        $this->declared_insolvent = $form?->declared_insolvent;

        // Foreign allegiance
        // $this->foreign_allegiance = $form?->allegiance_to_foreign_country ? 'Yes' : 'No';
        $this->allegiance_to_foreign_country = $form?->allegiance_to_foreign_country;

        // Disqualified by president
        // $this->disqualified_president = $form?->disqualified_by_president ? 'Yes' : 'No';
        $this->disqualified_by_president = $form?->disqualified_by_president;

        // Dismissed
        // $this->dismissed_for_corruptions = $form?->dismissed_for_corruption ? 'Yes' : 'No';
        $this->dismissed_for_corruption = $form?->dismissed_for_corruption;

        // Govt contract
        // $this->govt_contract = $form?->subsisting_govt_contract ? 'Yes' : 'No';
        $this->subsisting_govt_contract = $form?->subsisting_govt_contract;

        // Company position
        // $this->company_position = $form?->managing_agent_role ? 'Yes' : 'No';
        $this->managing_agent_role = $form?->managing_agent_role;

        // Commission disqualified
        // $this->commission_disqualified = $form?->date_of_disqualification ? 'Yes' : 'No';
        $this->date_of_disqualification = $form?->date_of_disqualification;

        $this->candidate_name = $this->titleCase($this->candidate->name);
        $this->assembly_name  =
            $this->candidate->assembly->assembly_number. '-' .$this->candidate->assembly->assembly_name_en;

        $this->holding_office_of_profit      = $this->titleCase($this->holding_office_of_profit);
        $this->declared_insolvent            = $this->titleCase($this->declared_insolvent);
        $this->allegiance_to_foreign_country = $this->titleCase($this->allegiance_to_foreign_country);
        $this->disqualified_by_president = $this->titleCase($this->disqualified_by_president);
        $this->subsisting_govt_contract = $this->titleCase($this->subsisting_govt_contract);
        $this->managing_agent_role = $this->titleCase($this->managing_agent_role);
        $this->criminal_check = 'No';
        $this->formLocked = false;
    }


    public function FieldToggle($field, $value){
            $this->$field = $value;
    }
    public function updatedCriminalCheck($value)
    {
        if ($value === 'Yes') {
            $this->formLocked = true;
        } else {
            $this->formLocked = false;
        }
    }

    public function updatedConvicted($value)
    {
        if ($value === 'No') {
            $this->resetConvictionFields();
        }
    }

    private function resetConvictionFields()
    {
        if (!is_array($this->convicted_details)) {
            return;
        }
      foreach ($this->convicted_details as $key => $value) {
            $this->convicted_details[$key] = null;
        }
    }


    public function save()
    {
        if ($this->criminal_check === 'Yes') {
            $this->dispatch('toastr:error', message: 'Candidate has criminal offense. Form submission is blocked.');
            return;
        }
        try {
            $this->validate();
            $data = [
                'convicted' => $this->convicted,
            ];

            if ($this->convicted === 'Yes') {
                $data['convicted_details'] = $this->convicted_details;
            } else {
                $data['convicted_details'] = null;
            }

            $holdingOfficeOfProfit = null;

            if ($this->office_of_profit == 1) {

                $this->validate([
                    'holding_office_of_profit' => 'required'
                ],[
                    'holding_office_of_profit.required' => 'Please provide details of the office of profit held by the candidate.'
                ]);

                $holdingOfficeOfProfit = $this->holding_office_of_profit;

            }

            $insolventDetails = null;

            if ($this->insolvent == 1) {
                $this->validate([
                    'declared_insolvent' => 'required'
                ],[
                    'declared_insolvent.required' => 'Please provide details if the candidate has been declared insolvent by any Court.'
                ]);
                $insolventDetails = $this->declared_insolvent;
            }
            
            $foreignDetails = null;
            if ($this->foreign_allegiance == 1) {
                $this->validate([
                    'allegiance_to_foreign_country' => 'required'
                ],[
                    'allegiance_to_foreign_country.required' => 'Please provide details of the candidate\'s allegiance to the foreign country.'
                ]);
                $foreignDetails = $this->allegiance_to_foreign_country;
            }
    
            $disqualifiedPresident = null;
            if ($this->disqualified_president == 1) {
                $this->validate([
                    'disqualified_by_president' => 'required'
                ],[
                    'disqualified_by_president.required' => 'Please provide details if the candidate has been disqualified under Section 8A of the Representation of the People Act by an order of the President.'
                ]);
                $disqualifiedPresident = $this->disqualified_by_president;
            }

            $dismissedForCorruption = null;
            if ($this->dismissed_for_corruptions == 1) {
                $this->validate([
                    'dismissed_for_corruption' => 'required'
                ],[
                    'dismissed_for_corruption.required' => 'Please provide details if the candidate was dismissed for corruption or disloyalty.'
                ]);
                $dismissedForCorruption = $this->dismissed_for_corruption;
            }

            
            $govtContract = null;
            if ($this->govt_contract == 1) {
                $this->validate([
                    'subsisting_govt_contract' => 'required'
                ],[
                    'subsisting_govt_contract.required' => 'Please provide details if the candidate has any subsisting contract(s) with the Government'
                ]);
                $govtContract = $this->subsisting_govt_contract;
            }

            $manageAgentRole = null;
            if ($this->company_position == 1) {
                $this->validate([
                    'managing_agent_role' => 'required'
                ], [
                    'managing_agent_role.required' => 'Please provide details if the candidate is a managing agent, manager or secretary of any company or corporation.'
                ]);
                $manageAgentRole = $this->managing_agent_role;
            }
            

            $commisionDisqualifiedDate = null;
            if ($this->commission_disqualified == 1) {
                $this->validate([
                    'date_of_disqualification' => 'required'
                ], [
                    'date_of_disqualification.required' => 'Please provide the date of disqualification by the Commission under Section 10A.'
                ]);
                $commisionDisqualifiedDate = $this->date_of_disqualification;
            }

            $nomination = NominationForm::updateOrCreate(
                ['candidate_id' => $this->candidate_id],
                array_merge($data, [
                    'assembly_id' => $this->assembly_id,
                    'state' => $this->state,
                    'form_type' => 'form_2b',
                    'age' => $this->age,
                    'relation_type' => $this->relation_type,
                    'pronoun' => $this->pronoun,
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
                    'office_of_profit' =>$this->office_of_profit,
                    'insolvent' =>$this->insolvent,
                    'company_position' =>$this->company_position,
                    'dismissed_for_corruptions' =>$this->dismissed_for_corruptions,
                    'commission_disqualified' =>$this->commission_disqualified,
                    'govt_contract' =>$this->govt_contract,
                    'disqualified_president' =>$this->disqualified_president,
                    'foreign_allegiance' =>$this->foreign_allegiance,
                ])
            );

            return redirect()->route('admin.candidates.form2B.preview', $nomination->id);
        } catch (ValidationException $e) {

            $this->dispatch('scroll-to-error'); 
            throw $e;

        } catch (\Exception $e) {
            //dd($e->getMessage());
            \Log::error('Nomination Save Error: '.$e->getMessage());
            session()->flash('error', 'Something went wrong');
        }
    }

    public function toggleConvicted($value){
        $this->convicted = $value;
    }

    public function render()
    {
       // dd($this->all());
        return view('livewire.nomination-form2-b')->layout('layouts.admin');
    }
}
