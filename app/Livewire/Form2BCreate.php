<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use Illuminate\Support\Facades\DB;
use App\Models\Form2bDetail;
use App\Models\Form2bChangeLog;
use Illuminate\Support\Facades\Request;

class Form2BCreate extends Component
{
    public $assembly_id;
    public $assembly_data;
    public $form_id; //  NEW

    public $candidate_name, $age, $relation_type, $party_name, $relation_name, $pronoun;
    public $postal_address, $candidate_serial_no, $candidate_part_no, $assembly_name = '', $constituency_where_enrolled;

    public $proposers = [];

    public $convicted = 'No';
    public $office_of_profit = 0, $holding_office_of_profit;
    public $insolvent = 0, $declared_insolvent;
    public $foreign_allegiance = 0, $allegiance_to_foreign_country;
    public $disqualified_president = 0, $disqualified_by_president;
    public $dismissed_for_corruptions = 0, $dismissed_for_corruption;
    public $govt_contract = 0, $subsisting_govt_contract;
    public $company_position = 0, $managing_agent_role;
    public $commission_disqualified = 0, $date_of_disqualification;

    public $party_type = "state", $symbol_1, $symbol_2, $symbol_3, $name_language = "English", $caste, $caste_area;
    public $caste_state = 'West Bengal';
    public $has_caste = 0;

    public function mount($id)
    {
        //  GET form_id FROM REQUEST
        $this->form_id = request()->get('form_id');

        $this->assembly_id = $id;
        $this->assembly_data = Assembly::findOrFail($id);
        $this->assembly_name = $this->assembly_data->assembly_number.' '. $this->assembly_data->assembly_name_en;
        //  CONDITION: EDIT MODE OR CREATE MODE
        if ($this->form_id) {
            //  EDIT MODE (specific record)
            $existing = DB::table('form2b_details')
                ->where('id', $this->form_id)
                ->first();
        } else {
            //  DEFAULT (latest by assembly)
            $existing = DB::table('form2b_details')
                ->where('assembly_id', $id)
                ->latest()
                ->first();
        }

        if ($existing) {
            foreach ($existing as $key => $value) {
                if ($key == 'proposers') {
                    $this->proposers = json_decode($value, true);
                } else {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }
            }

            //  ensure form_id is set for update
            $this->form_id = $existing->id;

        } else {
            $this->proposers = [
                ['name' => '', 'sl_no' => '', 'part_no' => '', 'constituency' => '']
            ];
        }


    }

    public function addProposer() {
        $this->proposers[] = ['name' => '', 'sl_no' => '', 'part_no' => '', 'constituency' => ''];
    }

    public function removeProposer($index) {
        unset($this->proposers[$index]);
        $this->proposers = array_values($this->proposers);
    }

    public function FieldToggle($field, $value)
    {
        $this->$field = $value;

        if ($value == 0) {
            match($field) {
                'office_of_profit' => $this->holding_office_of_profit = null,
                'insolvent' => $this->declared_insolvent = null,
                'foreign_allegiance' => $this->allegiance_to_foreign_country = null,
                'disqualified_president' => $this->disqualified_by_president = null,
                'dismissed_for_corruptions' => $this->dismissed_for_corruption = null,
                'govt_contract' => $this->subsisting_govt_contract = null,
                'company_position' => $this->managing_agent_role = null,
                'commission_disqualified' => $this->date_of_disqualification = null,
            };
        }
    }

   public function save()
    {
        try {

            $this->validate([
                'candidate_name' => 'required',
                'party_name' => 'required',
                'age' => 'required|numeric',

                'holding_office_of_profit' => $this->office_of_profit ? 'required' : 'nullable',
                'declared_insolvent' => $this->insolvent ? 'required' : 'nullable',
                'allegiance_to_foreign_country' => $this->foreign_allegiance ? 'required' : 'nullable',
                'disqualified_by_president' => $this->disqualified_president ? 'required' : 'nullable',
                'dismissed_for_corruption' => $this->dismissed_for_corruptions ? 'required' : 'nullable',
                'subsisting_govt_contract' => $this->govt_contract ? 'required' : 'nullable',
                'managing_agent_role' => $this->company_position ? 'required' : 'nullable',
                'date_of_disqualification' => $this->commission_disqualified ? 'required' : 'nullable',

                'caste' => $this->has_caste == 1 ? 'required|string|max:255' : 'nullable',
                'caste_state' => $this->has_caste == 1 ? 'required|string|max:255' : 'nullable',
                'caste_area' => $this->has_caste == 1 ? 'required|string|max:255' : 'nullable',
            ],[
                'candidate_name.required' => 'Candidate name is required',
                'age.required' => 'Age is required',

                'holding_office_of_profit.required' => 'This field is required',
                'declared_insolvent.required' => 'This field is required',
                'allegiance_to_foreign_country.required' => 'This field is required',
                'disqualified_by_president.required' => 'This field is required',
                'dismissed_for_corruption.required' => 'This field is required',
                'subsisting_govt_contract.required' => 'This field is required',
                'managing_agent_role.required' => 'This field is required',
                'date_of_disqualification.required' => 'This field is required',

                 // caste messages
                'caste.required' => 'Caste/Tribe is required',
                'caste_state.required' => 'State is required',
                'caste_area.required' => 'Area is required',
            ]);

            DB::beginTransaction(); //  START TRANSACTION

            //  Prepare clean data (ONLY fillable fields)
            $data = [
                'assembly_id' => $this->assembly_id,
                'candidate_name' => ucwords($this->candidate_name),
                'age' => $this->age,
                'relation_type' => $this->relation_type,
                'party_name' => ucwords($this->party_name),
                'relation_name' => ucwords($this->relation_name),
                'pronoun' => $this->pronoun,
                'postal_address' => $this->postal_address,
                'candidate_serial_no' => $this->candidate_serial_no,
                'candidate_part_no' => $this->candidate_part_no,
                'assembly_name' => $this->assembly_name,
                'constituency_where_enrolled' => $this->constituency_where_enrolled,
                'proposers' => $this->proposers, //  auto JSON (cast in model)
                'convicted' => $this->convicted,
                'office_of_profit' => $this->office_of_profit,
                'holding_office_of_profit' => $this->holding_office_of_profit,
                'insolvent' => $this->insolvent,
                'declared_insolvent' => $this->declared_insolvent,
                'foreign_allegiance' => $this->foreign_allegiance,
                'allegiance_to_foreign_country' => $this->allegiance_to_foreign_country,
                'disqualified_president' => $this->disqualified_president,
                'disqualified_by_president' => $this->disqualified_by_president,
                'dismissed_for_corruptions' => $this->dismissed_for_corruptions,
                'dismissed_for_corruption' => $this->dismissed_for_corruption,
                'govt_contract' => $this->govt_contract,
                'subsisting_govt_contract' => $this->subsisting_govt_contract,
                'company_position' => $this->company_position,
                'managing_agent_role' => $this->managing_agent_role,
                'commission_disqualified' => $this->commission_disqualified,
                'date_of_disqualification' => $this->date_of_disqualification,

                'party_type' => $this->party_type,
                'symbol_1' => $this->symbol_1,
                'symbol_2' => $this->symbol_2,
                'symbol_3' => $this->symbol_3,

                'has_caste' => $this->has_caste,
                'caste' => $this->has_caste==1?$this->caste:null,
                'caste_state' => $this->has_caste==1?$this->caste_state:null,
                'caste_area' => $this->has_caste==1?$this->caste_area:null,
                'created_by' => auth()->id(), // or admin guard
            ];

            //  CREATE OR UPDATE (ELOQUENT)
            if ($this->form_id) {

                $form = Form2bDetail::findOrFail($this->form_id);
                $oldData = $form->toArray(); // BEFORE update

                $form->update($data);

                $newData = $form->fresh()->toArray(); // AFTER update

                Form2bChangeLog::create([
                    'form2b_id' => $form->id,
                    'assembly_id' => $this->assembly_id,
                    'old_data' => $oldData,
                    'new_data' => $newData,
                    'changed_by' => auth()->id(),
                ]);

            } else {

                $form = Form2bDetail::create($data);
                $this->form_id = $form->id;

                Form2bChangeLog::create([
                    'form2b_id' => $form->id,
                    'assembly_id' => $this->assembly_id,
                    'old_data' => null,
                    'new_data' => $form->toArray(),
                    'changed_by' => auth()->id(),
                ]);
                $this->form_id = $form->id;
            }

            DB::commit(); //  SUCCESS
            $this->dispatch('toastr:success', message: 'Data stored successfully');
            return redirect()->route('admin.form-2b-preview', $this->form_id);

        } catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack(); //  rollback validation (safe)
            $this->dispatch('scrollTop');
            throw $e;

        } catch (\Exception $e) {

            DB::rollBack(); //  rollback on error

            $this->dispatch('toastr:error', message: 'Something went wrong: ' . $e->getMessage());
            // session()->flash('error', 'Something went wrong. Please try again.');

            throw $e; // (optional for debugging)
        }
    }
    public function toggleCaste($value)
    {
        $this->has_caste = $value;

        if ($value == 0) {
            $this->caste = null;
            $this->caste_state = null;
            $this->caste_area = null;
        }
    }

    public function render()
    {
        $this->assembly_name = $this->assembly_data->assembly_number.' '. $this->assembly_data->assembly_name_en;
        return view('livewire.form2-b-create')->layout('layouts.admin');
    }
}