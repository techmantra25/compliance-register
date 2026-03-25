<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Assembly;
use App\Models\Mcc;
use App\Models\Admin;
use App\Models\ChangeLog;
use App\Models\MccRemarks;
use Illuminate\Support\Facades\Auth;
use App\Models\MccSupportingDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MccViolationCrud extends Component
{
    use WithPagination , WithFileUploads;

    public $mcc_id, $assembly_id, $category, $block, $gp, $complainer_name, $complainer_phone, $complainer_description;
    public $assembly;
    public $search = '';
    public $mccFile;
    public $status;
    public $selectedId;
    public $remarks;
    
    public $action_taken;
    public $associate_id;
    public $selected_mcc_id;

    public $isEdit = false;
    public $filter_by_assembly = '';
    public $filter_by_status = '';

    public $legalAssociates = [];
    public $supporting_documents = [];

    public $keywords = [];
    public $keywordInput = '';
    public $deletedFiles = [];

    // public $viewMcc;
    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'assembly_id' => 'required|integer',
        'block' => 'nullable|string',
        'gp' => 'nullable|string',
        'complainer_name' => 'nullable|string',
        'complainer_phone' => 'nullable|digits:10',
        'complainer_description' => 'required|string',
        'action_taken' => 'required|exists:admins,id',
        'category' => 'required',
        'supporting_documents.*' => 'file',
        'keywords' => 'nullable|array',
    ];

    protected $messages = [

        // Assembly
        'assembly_id.required' => 'Please select assembly.',
        'assembly_id.integer' => 'Invalid assembly selected.',

        // Block (nullable → only validate type)
        'block.string' => 'Block must be valid text.',

        // GP
        'gp.string' => 'GP/Ward must be valid text.',

        // Complainer Name
        'complainer_name.string' => 'Complainer name must be valid.',

        // Phone
        'complainer_phone.digits' => 'Phone number must be exactly 10 digits.',

        // Description
        'complainer_description.required' => 'Complaint description is required.',
        'complainer_description.string' => 'Description must be valid text.',

        // Action Taken
        'action_taken.required' => 'Please select legal associate.',
        'action_taken.exists' => 'Selected legal associate is invalid.',

        // Category
        'category.required' => 'Please select category (For/Against AITC).',

        // Documents
        'supporting_documents.*.file' => 'Each file must be a valid file.',

        // Keywords
        'keywords.array' => 'Keywords must be in valid format.',
    ];

    public function mount()
    {
        $this->assembly = Assembly::where('status', 'active')->orderBy('assembly_name_en')->get();
        $this->legalAssociates = Admin::where('role', 'legal_associate')->where('suspended_status', 1)->get();
    }
    

    public function openMccModal()
    {
        $this->resetInputFields();
        $this->isEdit = false;

        $this->dispatch('refreshChosen');
        $this->dispatch('open-mcc-modal');
    }

    public function resetInputFields()
    {
        $this->reset([
            'mcc_id',
            'assembly_id',
            'block',
            'gp',
            'complainer_name',
            'complainer_phone',
            'complainer_description',
            'category',
            'supporting_documents'
        ]);

        $this->isEdit = false;
        $this->dispatch('refreshChosen');
    }

    public function edit($id)
    {
      
        $this->resetErrorBag();

        $mcc = Mcc::findOrFail($id);

        $this->mcc_id = $mcc->id;
        $this->assembly_id = $mcc->assembly_id;
        $this->category = $mcc->category;
        $this->block = $mcc->block;
        $this->gp = $mcc->gp;
        $this->complainer_name = $mcc->complainer_name;
        $this->complainer_phone = $this->complainer_phone ?: null;
        $this->complainer_description = $mcc->complainer_description;
        $this->action_taken = $mcc->action_taken;
        $this->keywords = $mcc->keywords ? array_map('trim', explode(',', $mcc->keywords)) : [];

        $this->isEdit = true;
        $this->dispatch('refreshChosen');
        $this->dispatch('open-edit-modal');
    }

    public function save()
    {
        $this->isEdit ? $this->updateMcc() : $this->storeMcc();
    }

    private function generateMccCode($assemblyId)
    {
        $assembly = Assembly::findOrFail($assemblyId);
        $assemblyNumber = $assembly->assembly_number;

        $maxCode = Mcc::where('assembly_id', $assemblyId)->max('mcc_code');

        $next = $maxCode ? intval(substr($maxCode, -4)) + 1 : 1;

        do {

            $sequence = str_pad($next, 4, '0', STR_PAD_LEFT);

            $mccCode = $assemblyNumber . $sequence;

            $exists = Mcc::where('mcc_code', $mccCode)->exists();

            $next++;

        } while ($exists);

        return $mccCode;
    }
    public function storeMcc()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $mccCode = $this->generateMccCode($this->assembly_id);

            // Step 1: Create MCC
            $mcc = Mcc::create([
                'assembly_id' => $this->assembly_id,
                'category' => $this->category,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => ucwords($this->complainer_name),
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
                'action_taken' => $this->action_taken,
                'mcc_code' => $mccCode,
                'keywords' => !empty($this->keywords) ? implode(',', $this->keywords) : null,
            ]);

            // Step 2: Create Remarks
            $mcc_remarks = MccRemarks::create([
                'mcc_id' => $mcc->id,
                'admin_id' => $this->action_taken,
                'remarks' => $this->complainer_description,
                'tag_with' => $this->action_taken . ',' . auth()->guard('admin')->id(),
            ]);

            // Step 3: Upload Files
            if ($this->supporting_documents) {
                foreach ($this->supporting_documents as $file) {

                    $timestamp = now()->format('Ymd_His');
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();

                    $filename = "{$originalName}_{$timestamp}.{$extension}";

                    $path = $file->storeAs(
                        "mcc_files/{$this->assembly_id}",
                        $filename,
                        'public'
                    );

                    MccSupportingDocument::create([
                        'mcc_remarks_id' => $mcc_remarks->id,
                        'file_path' => "storage/{$path}"
                    ]);
                }
            }

            // Step 4: Change Log
            ChangeLog::create([
                'module_name' => 'Complaint',
                'module_id' => $mcc->id,
                'action' => 'inserted',
                'description' => 'Complaint created successfully',
                'old_data' => $mcc->toArray(),
                'new_data' => $mcc->toArray(),
                'changed_by' => auth()->guard('admin')->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            //  Commit Transaction
            DB::commit();

            // UI Actions
            $this->dispatch('toastr:success', message: 'Complaint created successfully!');
            $this->dispatch('resetField');
            $this->dispatch('closeModal');

            $this->resetInputFields();

        } catch (\Exception $e) {

            //  Rollback everything if any error occurs
            DB::rollBack();

            \Log::error('MCC Store Error: ' . $e->getMessage());

            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
        }
    }

    public function openAssignModal($id)
    {
        $mcc = Mcc::findOrFail($id);

        $this->selected_mcc_id = $id;
        $this->complainer_name = $mcc->complainer_name;
        $this->associate_id = $mcc->associate_id;

        $this->dispatch('open-assign-modal');
    }

    public function updateAssign()
    {
        $this->validate([
            'associate_id' => 'required|exists:admins,id'
        ]);

        $mcc = Mcc::findOrFail($this->selected_mcc_id);

        $mcc->update([
            'associate_id' => $this->associate_id
        ]);
        $this->reset(['selected_mcc_id','associate_id']);
        $this->dispatch('toastr:success', message: 'Legal associate assigned successfully');

        $this->dispatch('closeModal');
    }

    public function updateMcc()
    {
        $this->validate();

        DB::beginTransaction();

        $uploadedPaths = [];

        try {
            $mccCode = $this->generateMccCode($this->assembly_id);
            $mcc = Mcc::findOrFail($this->mcc_id);

            $old = $mcc->toArray();

            // Step 1: Update MCC
            $mcc->update([
                'assembly_id' => $this->assembly_id,
                'category' => $this->category,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => ucwords($this->complainer_name),
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
                'action_taken' => $this->action_taken,
                'mcc_code' => $mccCode,
                'keywords' => !empty($this->keywords) ? implode(',', $this->keywords) : null,
            ]);

            // Step 2: Update or Create Latest Remark
            $latestRemark = MccRemarks::where('mcc_id', $mcc->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($latestRemark) {

                $latestRemark->update([
                    'admin_id' => $this->action_taken,
                    'remarks' => $this->complainer_description,
                    'tag_with' => $this->action_taken . ',' . auth()->guard('admin')->id(),
                ]);

                $mcc_remarks = $latestRemark;

            } else {

                $mcc_remarks = MccRemarks::create([
                    'mcc_id' => $mcc->id,
                    'admin_id' => $this->action_taken,
                    'remarks' => $this->complainer_description,
                    'tag_with' => $this->action_taken . ',' . auth()->guard('admin')->id(),
                ]);
            }

            // Step 3: Upload New Files
            if ($this->supporting_documents) {
                foreach ($this->supporting_documents as $file) {

                    $timestamp = now()->format('Ymd_His');
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();

                    $filename = "{$originalName}_{$timestamp}.{$extension}";

                    $path = $file->storeAs(
                        "mcc_files/{$this->assembly_id}",
                        $filename,
                        'public'
                    );

                    $uploadedPaths[] = $path;

                    MccSupportingDocument::create([
                        'mcc_remarks_id' => $mcc_remarks->id, //  FIXED RELATION
                        'file_path' => "storage/{$path}"
                    ]);
                }
            }

            // Step 4: Delete Removed Files
            if (!empty($this->deletedFiles)) {

                $files = MccSupportingDocument::whereIn('id', $this->deletedFiles)->get();

                foreach ($files as $file) {

                    $relativePath = str_replace('storage/', '', $file->file_path);

                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }

                    $file->delete();
                }
            }

            // Step 5: Logging
            $new = $mcc->fresh()->toArray();

            $description = [];

            if ($old['action_taken'] != $new['action_taken']) {

                $oldAssociate = Admin::find($old['action_taken']);
                $newAssociate = Admin::find($new['action_taken']);

                $oldName = $oldAssociate->name ?? 'None';
                $newName = $newAssociate->name ?? 'None';

                $description[] = "Action Taken changed from {$oldName} to {$newName}";
            }

            $logDescription = count($description)
                ? implode(', ', $description)
                : 'Complaint updated Successfully';

            ChangeLog::create([
                'module_name' => 'Complaint',
                'module_id' => $mcc->id,
                'action' => 'updated',
                'description' => $logDescription,
                'old_data' => $old,
                'new_data' => $new,
                'changed_by' => auth()->guard('admin')->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            DB::commit();

            $this->dispatch('toastr:success', message: 'Complaint updated successfully!');
            $this->dispatch('closeModal');
            $this->resetInputFields();

        } catch (\Exception $e) {

            DB::rollBack();

            // cleanup uploaded files
            if (!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            \Log::error('MCC Update Error: ' . $e->getMessage());

            $this->dispatch('toastr:error', message: 'Something went wrong while updating!');
        }
    }
    
    public function removeTempFile($index)
    {
        unset($this->supporting_documents[$index]);
        $this->supporting_documents = array_values($this->supporting_documents);
    }

    public function removeExistingFile($id)
    {
        $this->deletedFiles[] = $id;
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

    public function resetForm(){
        $this->reset(['mccFile']);
        session()->forget(['success', 'error']);
    }

    public function addKeyword()
    {
        $value = trim($this->keywordInput);

        if ($value && !in_array($value, $this->keywords)) {
            $this->keywords[] = $value;
        }
        $this->keywordInput = '';
        $this->dispatch('resetField');
    }

    public function removeKeyword($value)
    {
        $this->keywords = array_values(array_filter($this->keywords, function ($k) use ($value) {
            return $k !== $value;
        }));
    }

    private function getMccQuery()
    {
        $user = auth()->user();

        return Mcc::with([
                'districts',
                'assembly',
                'assembly.assemblyPhase',
                'assembly.assemblyPhase.phase',
                'latestRemark',
                'legalAssociate',
            ])

            ->when($user->role == 'legal_associate', function ($query) use ($user) {
                $query->where('action_taken', $user->id);
            })

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('block', "like", "%{$this->search}%")
                        ->orWhere('gp', "like", "%{$this->search}%")
                        ->orWhere('complainer_name', "like", "%{$this->search}%")
                        ->orWhere('complainer_phone', "like", "%{$this->search}%")
                        ->orWhere('keywords', "like", "%{$this->search}%")
                        ->orWhereHas('assembly', function ($asmb) {
                            $asmb->where('assembly_number', "like", "%{$this->search}%")
                                ->orWhere('assembly_name_en', "like", "%{$this->search}%")
                                ->orWhere('assembly_code', "like", "%{$this->search}%");
                        });
                });
            })

            ->when($this->filter_by_assembly, function ($q) {
                $q->where('assembly_id', $this->filter_by_assembly);
            })

            ->when($this->filter_by_status, function ($q) {
                $q->where('status', $this->filter_by_status);
            });
    }
    
    public function render()
    {
        $campaigns = $this->getMccQuery()
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('livewire.mcc-violation-crud', [
            'mccList' => $campaigns,
        ])->layout('layouts.admin');
    }
}