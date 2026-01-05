<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\NominationForm2B as NominationForm2BModel;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class NominationForm2B extends Component
{
    use WithFileUploads;
    public $candidateId;
    public $assembly_id;
    public $candidate_id;
    public $candidate;

    public $assembly_name;
    public $candidate_name;

    public $relation_type = 'father';
    public $pronoun = 'his';
    
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

    public $convicted = 'yes';
    public $case_no;
    public $police_station;
    public $district;
    public $state;
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
    public $office_of_profit;
    public $office_details;    
    public $insolvent;    
    public $insolvent_details;    
    public $foreign_allegiance;    
    public $foreign_details;     
    public $disqualified_president;     
    public $disqualified_period;     
    public $dismissed_for_corruption;   
    public $dismissed_date;   
    public $govt_contract;   
    public $govt_contract_details;   
    public $company_position;   
    public $company_details;   
    public $commission_disqualified;   
    public $commission_disqualified_date; 
    public $candidate_photo;  

    protected $rules = [
        'candidate_photo' => 'nullable|image|max:2048',
        'relation_type' => 'required|in:father,mother,husband',
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
        'convicted' => 'required|in:yes,no',
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

    public function updatedConvicted()
    {
        if ($this->convicted === 'no') {
            $this->reset([
                'case_no',
                'police_station',
                'district',
                'state',
                'sections',
                'conviction_date',
                'court',
                'punishment',
                'release_date',
                'appeal_filed',
                'appeal_details',
                'appeal_court',
                'appeal_status',
                'disposal_date',
                'order_nature',
            ]);
        }
    }

    // public function upload_candidate_photo()
    // {   
    //         //dd($this->candidate_photo);

    //     try {
    //         $extension = $this->candidate_photo->getClientOriginalExtension();
    //         $fileName  = time() . '_' . uniqid() . '.' . $extension;
            
    //         $destinationPath = public_path('candidate_photos');

    //         // Create folder if not exists
    //         if (!file_exists($destinationPath)) {
    //             mkdir($destinationPath, 0755, true);
    //         }

    //         // Move file to public folder
    //         $this->candidate_photo->move($destinationPath, $fileName);

    //         // Save relative path (for DB later)
    //         $this->uploaded_photo_path = 'candidate_photos/' . $fileName;

    //         session()->flash('success', 'Photo uploaded successfully');

    //     } catch (\Throwable $e) {

    //         logger()->error('Candidate photo upload failed', [
    //             'error' => $e->getMessage()
    //         ]);

    //         session()->flash('error', 'Photo upload failed');
    //     }
    // }

    public function save()
    {
        $this->validate();

        if ($this->office_of_profit !== 'yes') {
            $this->office_details = null;
        }

        if ($this->insolvent !== 'yes') {
            $this->insolvent_details = null;
        }

        if ($this->foreign_allegiance !== 'yes') {
            $this->foreign_details = null;
        }

        if ($this->disqualified_president !== 'yes') {
            $this->disqualified_period = null;
        }

        if ($this->dismissed_for_corruption !== 'yes') {
            $this->dismissed_date = null;
        }

        if ($this->govt_contract !== 'yes') {
            $this->govt_contract_details = null;
        }

        if ($this->company_position !== 'yes') {
            $this->company_details = null;
        }

        if ($this->commission_disqualified !== 'yes') {
            $this->commission_disqualified_date = null;
        }

       $nomination =  NominationForm2BModel::create([
            'assembly_id' => $this->assembly_id,
            'candidate_id' => $this->candidate_id,

            'relation_type' => $this->relation_type,
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
            'convicted' => $this->convicted,

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
            'office_of_profit' => $this->office_of_profit,
            'office_details'   => $this->office_details,
            'insolvent'        => $this->insolvent,
            'insolvent_details'=> $this->insolvent_details,
            'foreign_allegiance'=> $this->foreign_allegiance,
            'foreign_details'  => $this->foreign_details,
            'disqualified_president'=> $this->disqualified_president,   
            'disqualified_period'=> $this->disqualified_period,
            'dismissed_for_corruption'=> $this->dismissed_for_corruption,
            'dismissed_date'   => $this->dismissed_date,
            'govt_contract'    => $this->govt_contract,
            'govt_contract_details'=> $this->govt_contract_details,
            'company_position' => $this->company_position,
            'company_details'  => $this->company_details,
            'commission_disqualified'=> $this->commission_disqualified,
            'commission_disqualified_date'=> $this->commission_disqualified_date,      
        ]);

        return redirect()->route('admin.candidates.form2B.pdf', $nomination->id);
    }

    public function render()
    {
        return view('livewire.nomination-form2-b')->layout('layouts.admin');
    }
}
