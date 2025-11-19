<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Campaign;
use App\Models\EventCategory;
use Livewire\WithPagination;
use App\Models\Campaigner;
use Illuminate\Support\Facades\DB;

class CampaignCrud extends Component
{ 
    use WithPagination;
    public $campaign_id, $campaigner_id, $assembly_id, $event_category_id, $address, $campaign_date, $remarks, $permission_status, $last_date_of_permission;
    public $isEdit = false;
    public $search = '';

    protected $paginationTheme = "bootstrap";

    public $assembly, $eventCategory, $campaigners;

    protected $rules = [
        'campaigner_id'      => 'required|integer',
        'assembly_id'        => 'required|integer',
        'event_category_id'  => 'required|integer',
        'address'            => 'required|string|max:255',
        'campaign_date'      => 'required|date',
        'last_date_of_permission'      => 'nullable|date',
        'remarks'            => 'nullable|string',
    ];
    protected $messages = [
        'campaigner_id.required'       => 'Please select a campaigner.',
        'assembly_id.required'       => 'Please select an assembly.',
        'event_category_id.required' => 'Please select an event category.',
        'address.required'           => 'Address is required.',
        'campaign_date.required'     => 'Campaign date & time is required.',
        'campaign_date.date'         => 'Please enter a valid campaign date.',
        'last_date_of_permission.date'         => 'Please enter a valid last permission date.',
        'permission_status.required' => 'Please select permission status.',
    ];


    public function mount(){
        $this->campaigners = Campaigner::orderBy('name', 'ASC')->get();
        $this->assembly  = Assembly::where('status', 'active')->orderBy('assembly_name_en', 'ASC')->get();
        $this->eventCategory = EventCategory::where('status', 1)->orderBy('name', 'ASC')->get();
    }

    public function openCampaignModal(){
        $this->resetInputFields();
        $this->isEdit = false;
        $this->dispatch('resetField');
    }
    public function resetInputFields(){
        $this->reset(['campaigner_id','assembly_id', 'event_category_id', 'address', 'campaign_date', 'search']);
        $this->isEdit = false;
        $this->dispatch('refreshChosen');
    }

    public function filter(){
        $this->search = $term;
    }
    public function edit($id)
    {
        $this->resetErrorBag();

        $campaign = Campaign::findOrFail($id);

        $this->campaign_id = $campaign->id;
        $this->campaigner_id = $campaign->campaigner_id;
        $this->assembly_id = $campaign->assembly_id;
        $this->event_category_id = $campaign->event_category_id;
        $this->address = $campaign->address;
        $this->campaign_date = $campaign->campaign_date;
        $this->last_date_of_permission = $campaign->last_date_of_permission;
        $this->remarks = $campaign->remarks;

        $this->isEdit = true;
        $this->dispatch('refreshChosen');
        
    }

    public function save(){
        $this->isEdit ? $this->updateCampaign()  : $this->storeCampaign();
    }

    public function updateCampaign()
    {
        $this->validate();

        try {

            Campaign::where('id', $this->campaign_id)->update([
                'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'last_date_of_permission' => $this->last_date_of_permission,
                'remarks' => $this->remarks,
            ]);

            $this->dispatch('toastr:success', message: 'Campaign updated successfully!');
            $this->dispatch('refreshChosen');
            $this->dispatch('resetField');
            $this->dispatch('modelHide');

        } catch (\Exception $e) {

            $this->dispatch('toastr:error', message: 'Something went wrong while updating!');
            logger()->error('Campaign Update Error: ' . $e->getMessage());
        }
    }



    public function storeCampaign()
    {
        $this->validate();

        try {

            Campaign::create([
                'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'last_date_of_permission' => $this->last_date_of_permission,
                'remarks' => $this->remarks,
            ]);

            $this->dispatch('toastr:success', message: 'Campaign created successfully!');
            $this->dispatch('refreshChosen');
            $this->dispatch('resetField');
            $this->dispatch('modelHide');

        } catch (\Exception $e) {

            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
            logger()->error('Campaign Create Error: ' . $e->getMessage());
        }
    }


    public function render()
    {

        $campaigns = Campaign::when($this->search, function ($query){
            $query->where('campaign_date', "like", "%{$this->search}%")
            ->orWhere('address', "like", "%{$this->search}%")
            ->orWhere('remarks', "like", "%{$this->search}%")
            ->orWhereHas('assembly', function ($asmb){
                $asmb->where('assembly_number', "like", "%{$this->search}%")
                ->orWhere('assembly_name_en', "like", "%{$this->search}%")
                ->orWhere('assembly_code', "like", "%{$this->search}%");
            })->orWhereHas('category', function ($evnt_category){
                $evnt_category->where('name', "like", "%{$this->search}%");
            });
        })
        ->orderByRaw("
            CASE 
                WHEN campaign_date >= NOW() THEN 0
                ELSE 1
            END
        ")
        ->orderBy('campaign_date', 'ASC')
        ->paginate(20);
        return view('livewire.campaign-crud', [
            'campaigns' =>$campaigns,
        ])->layout('layouts.admin');
    }
}
