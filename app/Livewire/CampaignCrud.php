<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Campaign;
use App\Models\EventCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Campaigner;
use App\Models\ChangeLog;
use App\Models\District;
use App\Models\Phase;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class CampaignCrud extends Component
{ 
    use WithPagination, WithFileUploads;
    public $campaign_id, $campaigner_id, $assembly_id, $event_category_id, $address, $campaign_date, $remarks, $permission_status, $last_date_of_permission;
    public $isEdit = false;
    public $search = '';

    public $new_campaign_date;
    public $selected_campaign_id;
    public $rescheduled_at;
    public $selected_status;
    public $cancelled_remarks;

    public $filter_by_assembly = '';
    public $filter_by_district = '';
    public $filter_by_zone = '';
    public $districts = [];
    public $phases = [];
    public $zones = [];


    public $campaign;

    protected $paginationTheme = "bootstrap";

    public $assembly, $eventCategory, $campaigners;

    public $campaignerFile;
    protected $campaignerRules = [
        'campaignerFile' => 'required|mimes:csv,txt|max:10240',
    ];

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
        $this->districts = District::orderBy('name_en')->get();
        $this->zones = Zone::orderBy('name')->get();
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
            $campaign = Campaign::findOrFail($this->campaign_id);

            $old = $campaign->toArray();
            $campaign->update([
                'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'last_date_of_permission' => $this->last_date_of_permission,
                'remarks' => $this->remarks,
            ]);

            $new = $campaign->fresh()->toArray();

            ChangeLog::create([
                'module_name' => 'campaign',
                'action' => 'updated',
                'description' => 'Campaign updated',
                'old_data' => $old,
                'new_data' => $new,

                'changed_by'   => auth()->id(),
                'ip_address'   => request()->ip(),
                'user_agent'   => request()->header('User-Agent'),
            ]);


            $this->dispatch('toastr:success', message: 'Campaign updated successfully!');
            // $this->dispatch('refreshChosen');
            // $this->dispatch('resetField');
            // $this->dispatch('modelHide');
            return redirect()->route('admin.campaigns');

        } catch (\Exception $e) {
            //dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong while updating!');
            logger()->error('Campaign Update Error: ' . $e->getMessage());
        }
    }



    public function storeCampaign()
    {
        $this->validate();

        try {

            $campaign = Campaign::create([
                'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'last_date_of_permission' => $this->last_date_of_permission,
                'remarks' => $this->remarks,
            ]);

            ChangeLog::create([
                'module_name' => 'campaign',
                'action' => 'inserted',
                'description' => 'New Campaign created',
                'old_data' => $campaign->toArray(),
                'new_data' => $campaign->toArray(),

                'changed_by'   => auth()->id(),
                'ip_address'   => request()->ip(),
                'user_agent'   => request()->header('User-Agent'),
            ]);

            $this->dispatch('toastr:success', message: 'Campaign created successfully!');
            // $this->dispatch('refreshChosen');
            // $this->dispatch('resetField');
            // $this->dispatch('modelHide');
            return redirect()->route('admin.campaigns');

        } catch (\Exception $e) {
            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
            logger()->error('Campaign Create Error: ' . $e->getMessage());
        }
    }

    public function resetForm(){
        $this->reset('campaignerFile');
        $this->dispatch('close-modal', ['modalId' => 'uploadcampaignerModal']);
        $this->dispatch('reset-file-input');
    }

    public function saveCampaigner()
    {
        try {
            $this->validate($this->campaignerRules);
            } catch (\Exception $e) {
                session()->flash('error', "Validation failed: " . $e->getMessage());
                return;
            }

        try {
            $filePath = $this->campaignerFile->getRealPath();
            $file = fopen($filePath, 'r');

            if (!$file) {
                session()->flash('error', "Unable to open CSV file.");
                return;
            }

            $header = fgetcsv($file);
            $errors = [];
            $rowNumber = 1;

            while (($row = fgetcsv($file)) !== false) {
                $rowNumber++;

                try {
                    $name   = $row[0] ?? null;
                    $mobile = $row[1] ?? null;
                    $extra  = $row[2] ?? null;

                    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
                        $errors[] = "Row $rowNumber: Mobile number '$mobile' must be exactly 10 digits.";
                        continue;
                    }

                    // Check duplicate mobile
                    if (Campaigner::where('mobile', $mobile)->exists()) {
                        $errors[] = "Row $rowNumber: Mobile number '$mobile' already exists.";
                        continue;
                    }

                    Campaigner::create([
                        'name'          => $name,
                        'mobile'        => $mobile,
                        'extra_details' => $extra,
                    ]);

                } catch (\Exception $e) {
                    $errors[] = "Row $rowNumber: Database error - " . $e->getMessage();
                    continue;
                }
            }

            fclose($file);

        } catch (\Exception $e) {
            session()->flash('error', "File processing failed: " . $e->getMessage());
            return;
        }

        if (!empty($errors)) {
            session()->flash('error', implode("<br>", $errors));
            return;
        }

        $this->reset('campaignerFile');
        session()->flash('success', 'Campaigners Imported Successfully!');

        $this->dispatch('close-modal', ['modalId' => 'uploadcampaignerModal']);
    }

    public function statusChanged($id, $status)
    {
        $this->selected_campaign_id = $id;
        $this->selected_status = $status;

        $this->rescheduled_at = null;
        $this->cancelled_remark = null;

        if ($status == 'rescheduled' || $status == 'cancelled') {
            $this->dispatch('open-reschedule-modal');
        } else {
           // Campaign::where('id', $id)->update(['status' => $status]);
           $this->saveCampaignStatus();
        }
    }


    public function saveCampaignStatus()
    {
        $campaign = Campaign::find($this->selected_campaign_id);

        $oldData = $campaign->only(['status', 'campaign_date','rescheduled_at', 'cancelled_remarks']);

        if ($this->selected_status == 'rescheduled') {

            $this->validate([
                'new_campaign_date' => 'required|date|after:today',
            ],[
                'new_campaign_date.after' => 'The rescheduled date must be a future date.',
            ]);

            $campaign->update([
                'status' => 'rescheduled',
                'campaign_date' => $this->new_campaign_date, 
                'rescheduled_at' => now(),                    
                'cancelled_remarks' => null,
            ]);
        }

        else if ($this->selected_status == 'cancelled') {

            $this->validate([
                'cancelled_remarks' => 'required|string|max:255',
            ]);

            $campaign->update([
                'status' => 'cancelled',
                'cancelled_remarks' => $this->cancelled_remarks,
                'rescheduled_at' => null,
            ]);
        }    

        else {
            $campaign->update([
                'status' => $this->selected_status,
                'rescheduled_at' => null,
                'cancelled_remarks' => null,
            ]);
        }

        $campaign->refresh();

        $newData = $campaign->only(['status','campaign_date','rescheduled_at','cancelled_remarks']);

        ChangeLog::create([
            'module_name'  => 'campaign',
            'action'       => 'status changed',
            'description'  => "Campaign status changed",
            'old_data'     => $oldData,
            'new_data'     => $newData,
            'changed_by'   => auth()->id(),
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->header('User-Agent'),
        ]);

        $this->dispatch('close-reschedule-modal');
        $this->dispatch('toastr:success', message: "Campaign status updated successfully!");
    }



    public function resetFilters()
    {
        $this->filter_by_assembly = '';
        $this->filter_by_district = '';
        $this->filter_by_zone = '';
        $this->search = '';

        $this->dispatch('refreshChosen'); 
    }

    public function filterCampaign($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function render()
    {
        $campaigns = Campaign::with([
                'assembly.assemblyPhase.phase',
                'campaigner',
                'category'
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('campaign_date', "like", "%{$this->search}%")
                    ->orWhere('address', "like", "%{$this->search}%")
                    ->orWhere('remarks', "like", "%{$this->search}%")
                    ->orWhereHas('assembly', function ($asmb) {
                        $asmb->where('assembly_number', "like", "%{$this->search}%")
                            ->orWhere('assembly_name_en', "like", "%{$this->search}%")
                            ->orWhere('assembly_code', "like", "%{$this->search}%");
                    })
                    ->orWhereHas('category', function ($cat) {
                        $cat->where('name', "like", "%{$this->search}%");
                    })
                    ->orWhereHas('campaigner', function ($camp) {
                        $camp->where('name', "like", "%{$this->search}%");
                    });
                });
            })

            ->when($this->filter_by_assembly, function ($q) {
                $q->where('assembly_id', $this->filter_by_assembly);
            })


            ->when($this->filter_by_district, function ($q) {
                $q->whereHas('assembly', function ($asm) {
                    $asm->where('district_id', $this->filter_by_district);
                });
            })

            ->when($this->filter_by_zone, function ($q) {
                $zone = Zone::find($this->filter_by_zone);

                if (!$zone) return;

                $districtIds = explode(',', $zone->districts);

                $q->whereHas('assembly', function ($asm) use ($districtIds) {
                    $asm->whereIn('district_id', $districtIds);
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
            'campaigns' => $campaigns,
        ])->layout('layouts.admin');
    }

}
