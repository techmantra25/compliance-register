<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assembly;
use App\Models\Campaign;
use App\Models\EventCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Campaigner;
use App\Models\CampaignWisePermission;
use App\Models\ChangeLog;
use App\Models\District;
use App\Models\Phase;
use App\Models\Zone;
use App\Models\CampaignPermissionDocument;
use Illuminate\Support\Facades\DB;

class CampaignCrud extends Component
{ 
    use WithPagination, WithFileUploads;
    public $campaign_id, $assembly_id, $event_category_id, $address, $campaign_date, $remarks, $permission_status;
    public $isEdit = false;
    public $search = '';
    public $new_campaign_date;
    public $selected_campaign_id;
    public $rescheduled_at;
    public $selected_status;
    public $old_selected_status;
    public $cancelled_remarks;

    public $filter_by_status = '';
    public $filter_by_assembly = '';
    public $filter_by_district = '';
    public $filter_by_zone = '';
    public $districts = [];
    public $phases = [];
    public $zones = [];
    public $campaigner_ids = [];
    public $new_campaigners = []; 
    public $statuses = [
        'pending',
        'rescheduled',
        'cancelled',
        'completed',
    ];


    public $campaign;
    public $keywords = [];
    public $keywordInput = '';
    public $deletedFiles = [];

    protected $paginationTheme = "bootstrap";

    public $assembly, $eventCategory, $campaigners;
    public $other_event_category;
    public $show_other_category = false;
    public $campaignerFile;
    public $permission_documents = [];
    public $new_documents = [];
    public $existing_documents = [];

    protected $campaignerRules = [
        'campaignerFile' => 'required|mimes:csv,txt|max:10240',
    ];

    protected function rules()
    {
        return [
            'campaigner_ids'     => 'required|array',
            'assembly_id'        => 'required|integer',
            'event_category_id'  => 'required',
            'address'            => 'required|string|max:255',
            'campaign_date'      => 'required|date',
            'remarks'            => 'nullable|string',
            'other_event_category' => $this->event_category_id === 'others'
                ? 'required|string'
                : 'nullable',
            'keywords' => 'nullable|array',
            'new_documents.*' => 'file',
        ];
    }
    
    protected $messages = [
        'campaigner_ids.required' => 'Please select at least one campaigner.',
        'assembly_id.required'       => 'Please select an assembly.',
        'event_category_id.required' => 'Please select an event category.',
        'address.required'           => 'Address is required.',
        'campaign_date.required'     => 'Campaign date & time is required.',
        'campaign_date.date'         => 'Please enter a valid campaign date.',
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
        $this->reset(['campaigner_ids','assembly_id', 'event_category_id', 'address', 'campaign_date', 'search', 'permission_documents']);
        $this->show_other_category = false;
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

        $this->assembly_id = $campaign->assembly_id;
        $this->event_category_id = $campaign->event_category_id ?? 'others';
        $this->other_event_category = $campaign->event_category_others;
        $this->show_other_category = $campaign->event_category_id ? false : true;
        $this->address = $campaign->address;
        $this->campaign_date = $campaign->campaign_date;
        $this->remarks = $campaign->remarks;
        $this->new_campaigners = [];

        $this->campaigner_ids = $campaign->campaigners->pluck('id')->toArray();
        $this->keywords = $campaign->keywords ? array_map('trim', explode(',', $campaign->keywords)) : [];
        $this->isEdit = true;
        $this->existing_documents = CampaignPermissionDocument::where('campaign_id', $id)->get();
        $this->dispatch('refreshChosen');
        
    }

    public function save(){
        $this->isEdit ? $this->updateCampaign()  : $this->storeCampaign();
    }

    public function removeTempFile($index)
    {
        unset($this->permission_documents[$index]);
        $this->permission_documents = array_values($this->permission_documents);
    }

    public function removeExistingFile($id)
    {
        $this->deletedFiles[] = $id;

        $this->existing_documents = collect($this->existing_documents)
        ->filter(fn($file) => $file->id != $id)
        ->values();
    }

    public function updateCampaign()
    {
        $this->validate();

        try {
            $campaign = Campaign::findOrFail($this->campaign_id);

            $old = $campaign->toArray();
            $campaign->update([
                // 'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id === 'others' ? null : $this->event_category_id,
                'event_category_others' => $this->event_category_id === 'others' ? $this->other_event_category : null,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'remarks' => $this->remarks,
                'keywords' => !empty($this->keywords) ? implode(',', $this->keywords) : null,
            ]);

            $new = $campaign->fresh()->toArray();

            if (!empty($this->new_campaigners)) {

                foreach ($this->new_campaigners as $name) {

                    $name = ucfirst(strtolower(trim($name)));

                    $campaigner = Campaigner::firstOrCreate(
                        ['name' => $name],
                        ['mobile' => null]
                    );

                    if (!in_array($campaigner->id, $this->campaigner_ids)) {
                        $this->campaigner_ids[] = $campaigner->id;
                    }
                }
            }

            // Remove fake IDs
            $this->campaigner_ids = array_filter($this->campaigner_ids, function ($id) {
                return is_numeric($id);
            });

            // Sync
            $campaign->campaigners()->sync($this->campaigner_ids);

            // Reset
            $this->new_campaigners = [];

            if ($this->permission_documents) {

                foreach ($this->permission_documents as $file) {

                    $timestamp = now()->format('Ymd_His');
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();

                    $filename = "{$originalName}_{$timestamp}.{$extension}";

                    $path = $file->storeAs(
                        "campaign_files/{$this->assembly_id}",
                        $filename,
                        'public'
                    );

                    CampaignPermissionDocument::create([
                        'campaign_id' => $campaign->id,
                        'file_path' => "storage/{$path}"
                    ]);
                }
            }

             // Delete removed files
            if (!empty($this->deletedFiles)) {
                $files = CampaignPermissionDocument::whereIn('id', $this->deletedFiles)->get();

                foreach ($files as $file) {

                    $filePath = public_path($file->file_path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $file->delete();
                }
            }

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
            $this->dispatch('refreshChosen');
            $this->dispatch('resetField');
            $this->dispatch('modelHide');
            // return redirect()->route('admin.campaigns');

        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong while updating!');
            logger()->error('Campaign Update Error: ' . $e->getMessage());
        }
    }

    public function handleCategoryChange($value)
    {
        if ($value == 'others') {
            $this->show_other_category = true;
        } else {
            $this->show_other_category = false;
            $this->other_event_category = null;
        }
    }

    public function updatedNewDocuments()
    {
        foreach ($this->new_documents as $file) {
            $this->permission_documents[] = $file;
        }

        $this->new_documents = [];
    }

    public function storeCampaign()
    {
        $this->validate();

        try {

            $campaign = Campaign::create([
                // 'campaigner_id' => $this->campaigner_id,
                'assembly_id' => $this->assembly_id,
                'event_category_id' => $this->event_category_id === 'others' ? null : $this->event_category_id,
                'event_category_others' => $this->event_category_id === 'others' ? $this->other_event_category : null,
                'address' => $this->address,
                'campaign_date' => $this->campaign_date,
                'remarks' => $this->remarks,
                'keywords' => !empty($this->keywords) ? implode(',', $this->keywords) : null,
            ]);

            if (!empty($this->new_campaigners)) {

                foreach ($this->new_campaigners as $name) {

                    $name = ucfirst(strtolower(trim($name)));

                    $campaigner = Campaigner::firstOrCreate(
                        ['name' => $name],
                        ['mobile' => null]
                    );

                    if (!in_array($campaigner->id, $this->campaigner_ids)) {
                        $this->campaigner_ids[] = $campaigner->id;
                    }
                }
            }

            // Remove fake IDs
            $this->campaigner_ids = array_filter($this->campaigner_ids, function ($id) {
                return is_numeric($id);
            });

            // Sync
            $campaign->campaigners()->sync($this->campaigner_ids);

            // Reset
            $this->new_campaigners = [];

            if ($this->permission_documents) {

                foreach ($this->permission_documents as $file) {

                    $timestamp = now()->format('Ymd_His');
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();

                    $filename = "{$originalName}_{$timestamp}.{$extension}";

                    $path = $file->storeAs(
                        "campaign_files/{$this->assembly_id}",
                        $filename,
                        'public'
                    );

                    CampaignPermissionDocument::create([
                        'campaign_id' => $campaign->id,
                        'file_path' => "storage/{$path}"
                    ]);
                }
            }

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
            $this->dispatch('refreshChosen');
            $this->dispatch('resetField');
            $this->dispatch('modelHide');
            // return redirect()->route('admin.campaigns');

        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
            logger()->error('Campaign Create Error: ' . $e->getMessage());
        }
    }

    public function resetForm(){
        $this->reset('campaignerFile');
        $this->dispatch('close-modal', ['modalId' => 'uploadcampaignerModal']);
        $this->dispatch('reset-file-input');
    }

     private function isValidStatusChange($current, $new)
    {
        $rules = [
            'pending' => ['rescheduled', 'cancelled', 'completed'],
            'rescheduled' => ['cancelled', 'completed'], // FIXED
            'cancelled' => ['completed'],
            'completed' => [],
        ];

        return in_array($new, $rules[$current] ?? []);
    }

    public function statusChanged($id, $status)
    {
        $campaign = Campaign::findOrFail($id);

        $currentStatus = $campaign->status;

        if (!$this->isValidStatusChange($currentStatus, $status)) {

            $this->dispatch('toastr:error', message: "Status change from '$currentStatus' to '$status' is not allowed.");

            $this->dispatch('reload-page');
            return;
        }

       if ($status == "completed") {

            $required = $campaign->category->permissions->count();

            $appliedCount = CampaignWisePermission::where('campaign_id', $id)
                ->where('doc_type', 'applied_copy')
                ->count();

            $approvedCount = CampaignWisePermission::where('campaign_id', $id)
                ->where('doc_type', 'approved_copy')
                ->count();

            if ($appliedCount < $required || $approvedCount < $required) {

                $this->dispatch('toastr:error',
                    message: "The campaign cannot be marked as Completed until all applied and approved copies are uploaded."
                );

                $this->dispatch('reload-page');
                return;
            }
        }

        $this->selected_campaign_id = $id;
        $this->selected_status = $status;
        $this->old_selected_status = $campaign->status;

        if ($status == 'rescheduled' || $status == 'cancelled') {
            $this->dispatch('open-reschedule-modal');
        } else {
            $this->saveCampaignStatus();
        }
    }

    public function resetSelectField(){
        return redirect()->route('admin.campaigns');
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

                    // if (!preg_match('/^[0-9]{10}$/', $mobile)) {
                    //     $errors[] = "Row $rowNumber: Mobile number '$mobile' must be exactly 10 digits.";
                    //     continue;
                    // }

                    // Check duplicate mobile
                    // if (Campaigner::where('mobile', $mobile)->exists()) {
                    //     $errors[] = "Row $rowNumber: Mobile number '$mobile' already exists.";
                    //     continue;
                    // }

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

        $this->dispatch('toastr:success', message: 'Campaigners Imported Successfully!');
        return redirect()->route('admin.campaigns');
        
    }



    public function resetFilters()
    {
        $this->filter_by_assembly = '';
        $this->filter_by_district = '';
        $this->filter_by_zone = '';
        $this->search = '';
        $this->filter_by_status = '';

        $this->dispatch('refreshChosen'); 
        $this->dispatch('resetField'); 
    }

    public function filterCampaign($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function filterStatus($filter_by_status)
    {
        $this->filter_by_status = $filter_by_status;
    }

    public function addKeyword()
    {
        $value = trim($this->keywordInput);

        if ($value && !in_array($value, $this->keywords)) {
            $this->keywords[] = $value;
        }

        $this->keywordInput = '';
    }
    
    public function removeKeyword($word)
    {
        $this->keywords = array_filter($this->keywords, function ($k) use ($word) {
            return $k !== $word;
        });
    }
    public function render()
    {
        $campaigns = Campaign::with([
                'assembly.assemblyPhase.phase',
                'campaigners',
                'category',
                'permissions'
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('campaign_date', "like", "%{$this->search}%")
                    ->orWhere('address', "like", "%{$this->search}%")
                    ->orWhere('remarks', "like", "%{$this->search}%")
                    ->orWhere('keywords', "like", "%{$this->search}%")
                    ->orWhereHas('assembly', function ($asmb) {
                        $asmb->where('assembly_number', "like", "%{$this->search}%")
                            ->orWhere('assembly_name_en', "like", "%{$this->search}%")
                            ->orWhere('assembly_code', "like", "%{$this->search}%");
                    })
                    ->orWhereHas('category', function ($cat) {
                        $cat->where('name', "like", "%{$this->search}%");
                    })
                    ->orWhereHas('campaigners', function ($camp) {
                        $camp->where('name', "like", "%{$this->search}%");
                    });
                });
            })

            ->when($this->filter_by_assembly, function ($q) {
                $q->where('assembly_id', $this->filter_by_assembly);
            })
            ->when($this->filter_by_status, function ($q) {
                $q->where('status', $this->filter_by_status);
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
