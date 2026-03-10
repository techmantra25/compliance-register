<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WarRoom;
use App\Models\Assembly;
use App\Models\District;
use App\Models\Admin;

class WarRoomCrud extends Component
{
    use WithPagination;

    protected $paginationTheme="bootstrap";

    public $war_id;

    public $assembly_id;
    public $district_id;
    public $booth_area;

    public $gp_word;
    public $block_town;
    public $incident_description;

    public $reported_by;
    public $contact_number;

    public $incident_time;

    public $assigned_to;

    public $search='';
    public $filter_by_assembly = '';
    public $filter_by_status = '';

    public $isEdit=false;

    public $assemblies=[];
    public $districts=[];
    public $legalAssociates=[];

    protected $rules = [
        'assembly_id' => 'required',
        'booth_area' => 'required',
        'gp_word' => 'required',
        'block_town' => 'required',
        'incident_description' => 'required',
        'reported_by' => 'required',
        'contact_number' => 'required|digits:10|numeric',
        'incident_time' => 'nullable',
    ];

    public function mount()
    {
        $this->assemblies = Assembly::where('status','active')->get();
        $this->districts = District::get();

        $this->legalAssociates = Admin::where('role','legal_associate')
            ->where('suspended_status',1)
            ->get();
    }

    public function openWarModal()
    {
        $this->resetFields();
        $this->dispatch('refreshChosen');
        $this->dispatch('resetField');
        $this->dispatch('open-war-modal');
    }

    public function resetFields()
    {
        $this->reset([
            'assembly_id',
            'booth_area',
            'gp_word',
            'block_town',
            'incident_description',
            'reported_by',
            'contact_number',
            'incident_time',
            'assigned_to',
        ]);
        $this->isEdit = false;
    }

    private function generateWarCode($assemblyId)
    {
        $assembly = Assembly::find($assemblyId);

        $assemblyNumber = $assembly->assembly_number;

        $max = WarRoom::where('assembly_id',$assemblyId)->max('war_code');

        $next = $max ? intval(substr($max,-4))+1 : 1;

        $sequence = str_pad($next,4,'0',STR_PAD_LEFT);

        return "WR".$assemblyNumber.$sequence;
    }

    public function save()
    {
        $this->validate();

        if($this->isEdit){
            $this->updateWar();
        }else{
            $this->storeWar();
        }
    }

    public function storeWar()
    {
        $this->validate();

        $warCode = $this->generateWarCode($this->assembly_id);
        $assembly = Assembly::findOrFail($this->assembly_id);

        WarRoom::create([
            'war_code' => $warCode,
            'assembly_id' => $this->assembly_id,
            'district_id' => $assembly->district_id,
            'booth_area' => $this->booth_area,
            'gp_word' => $this->gp_word,
            'block_town' => $this->block_town,
            'incident_description' => $this->incident_description,
            'reported_by' => $this->reported_by,
            'contact_number' => $this->contact_number,
            'incident_time' => $this->incident_time,
            'assigned_to' => $this->assigned_to,
        ]);

        $this->dispatch('toastr:success', message: 'War Room case created');
        $this->resetFields();
        $this->dispatch('closeModal'); // This will close the modal
    }

    public function updateWar()
    {
        $this->validate();

        $data = WarRoom::find($this->war_id);
        $assembly = Assembly::findOrFail($this->assembly_id);

        $data->update([
            'assembly_id' => $this->assembly_id,
            'district_id' => $assembly->district_id,
            'booth_area' => $this->booth_area,
            'gp_word' => $this->gp_word,
            'block_town' => $this->block_town,
            'incident_description' => $this->incident_description,
            'reported_by' => $this->reported_by,
            'contact_number' => $this->contact_number,
            'incident_time' => $this->incident_time,
            'assigned_to' => $this->assigned_to,
        ]);

        $this->dispatch('toastr:success', message: 'Updated successfully');
        $this->resetFields();
        $this->dispatch('closeModal');
    }
    public function edit($id)
    {
        $data = WarRoom::find($id);

        $this->war_id = $data->id;

        $this->assembly_id = $data->assembly_id;
        $this->booth_area = $data->booth_area;

        $this->gp_word = $data->gp_word;
        $this->block_town = $data->block_town;

        $this->incident_description = $data->incident_description;

        $this->reported_by = $data->reported_by;
        $this->contact_number = $data->contact_number;

        $this->incident_time = $data->incident_time;

        $this->assigned_to = $data->assigned_to;

        $this->isEdit = true;

        $this->dispatch('refreshChosen');

        $this->dispatch('open-edit-modal');
    }

    
    public function resetFilters()
    {
        $this->filter_by_assembly = '';
        $this->filter_by_status = '';
        $this->search = '';

        $this->dispatch('refreshChosen'); 

         $this->dispatch('clear-search-input');
    }

     public function filterCampaign($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function render()
    {

        $wars = WarRoom::with(['assembly','district','assignedUser'])

        ->when($this->search,function($q){

            $q->where('booth_area','like','%'.$this->search.'%')
            ->orWhere('incident_from_name','like','%'.$this->search.'%')
            ->orWhere('incident_from_number','like','%'.$this->search.'%')
            ->orWhere('block_town','like','%'.$this->search.'%')
            ->orWhere('incident_description','like','%'.$this->search.'%')
            ->orWhere('contact_number','like','%'.$this->search.'%')
            ->orWhere('status','like','%'.$this->search.'%')
            ->orWhere('war_code','like','%'.$this->search.'%')
            ->orWhere('reported_by','like','%'.$this->search.'%')
            ->orWhere('gp_word','like','%'.$this->search.'%');

        })
        ->when($this->filter_by_assembly, function ($q) {
                $q->where('assembly_id', $this->filter_by_assembly);
            })
        ->when($this->filter_by_status, function ($q) {
            $q->where('status', $this->filter_by_status);
        })

        ->orderBy('id','DESC')
        ->paginate(20);

        return view('livewire.war-room-crud',[

            'warList'=>$wars

        ])->layout('layouts.admin');
    }
}