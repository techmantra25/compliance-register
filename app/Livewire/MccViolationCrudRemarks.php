<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mcc;
use App\Models\MccRemarks;
use App\Models\MccSupportingDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class MccViolationCrudRemarks extends Component
{
    use WithFileUploads;

    public $mcc;
    public $remark;
    public $attachment = [];
    public $selectedFile;
    public $userRole;
    public $allUsers;
    public $tag_with = [];

    protected $rules = [
        'remark' => 'required|min:3',
        'attachment.*' => 'nullable|file|max:4096',
        'tag_with' => 'nullable|array'
    ];

    public function mount($id)
    {
        $this->allUsers = Admin::where('suspended_status', 1)->orderBy('name', 'ASC')->orderBy('role', 'ASC')->get();
        $this->mcc = Mcc::findOrFail($id);
    }

    public function saveRemark()
    {
      

        DB::beginTransaction();

        $uploadedPaths = [];

        try {
              $this->validate();
            // Step 1: Create Remark
            $remark = MccRemarks::create([
                'mcc_id' => $this->mcc->id,
                'admin_id' => auth()->guard('admin')->id(),
                'remarks' => $this->remark,
                'tag_with' => !empty($this->tag_with) ? implode(',', $this->tag_with) : null,
                'is_read' => 0
            ]);

            // Step 2: Upload Files
            if (!empty($this->attachment)) {
                foreach ($this->attachment as $file) {

                    $filename = time().'_'.$file->getClientOriginalName();

                    $path = $file->storeAs(
                        "mcc_docs/{$this->mcc->id}",
                        $filename,
                        'public'
                    );

                    $uploadedPaths[] = $path; // track for rollback

                    MccSupportingDocument::create([
                        'mcc_remarks_id' => $remark->id,
                        'file_path' => 'storage/'.$path
                    ]);
                }
            }

            //  Commit
            DB::commit();

            // Reset form
            $this->reset(['remark', 'attachment', 'tag_with']);
            $this->dispatch('ResetFormData');
            $this->dispatch('toastr:success', message: 'Remark added successfully!');

        } catch (\Exception $e) {

            //  Rollback DB
            DB::rollBack();
            // dd($e->getMessage());
            //  Delete uploaded files if any error occurs
            if (!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            // Log error
            // \Log::error('Save Remark Error: '.$e->getMessage());

            // Show error to UI
            $this->dispatch('toastr:error', message: $e->getMessage());
        }
    }
    public function saveRemarks($value){
        $this->remark = $value;
    }
    public function selectFile($path)
    {
        $this->selectedFile = $path;
    }

   public function render()
    {
        $this->userRole = strtolower(Auth::guard('admin')->user()->role);

        $remarks = MccRemarks::with('supportingDocuments')
            ->where('mcc_id', $this->mcc->id)
            ->orderBy('id', 'ASC')
            ->get();

        // 🔥 Collect all tag IDs from all remarks
        $allTagIds = collect($remarks)
            ->pluck('tag_with') // get all tag_with strings
            ->filter() // remove null
            ->flatMap(function ($tags) {
                return explode(',', $tags);
            })
            ->unique()
            ->values();

        // 🔥 Fetch all users in one query
        $groupMembers = Admin::whereIn('id', $allTagIds)
            ->pluck('name', 'id'); // [id => name]

        return view('livewire.mcc-violation-crud-remarks', compact('remarks', 'groupMembers'))
            ->layout('layouts.admin');
    }
}