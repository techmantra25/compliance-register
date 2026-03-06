<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Assembly;
use App\Models\Mcc;
use App\Models\Admin;
use App\Models\ChangeLog;

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
    public $selected_mcc_id;

    public $isEdit = false;
    public $filter_by_assembly = '';
    public $filter_by_status = '';

    public $legalAssociates = [];

    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'assembly_id' => 'required|integer',
        'block' => 'required|string',
        'gp' => 'required|string',
        'complainer_name' => 'required|string',
        'complainer_phone' => 'required|numeric|digits:10',
        'complainer_description' => 'nullable|string',
        'action_taken' => 'nullable|exists:admins,id',
        'category' => 'required',
        'mccFile' => 'required|file|mimes:csv,txt|max:2048'
    ];

    protected $messages = [
        'assembly_id.required' => 'Please select assembly.',
        'block.required' => 'Block is required.',
        'gp.required' => 'GP is required.',
        'complainer_name.required' => 'Complainer name is required.',
        'complainer_phone.required' => 'Phone is required.',
        'complainer_phone.digits' => 'Phone must be 10 digits.',
        'category.required' => 'Category is required.'
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
        $this->dispatch('open-edit-modal'); 
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
            'category'
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
        $this->complainer_phone = $mcc->complainer_phone;
        $this->complainer_description = $mcc->complainer_description;
        $this->action_taken = $mcc->action_taken;

        $this->isEdit = true;

        $this->dispatch('refreshChosen');
        $this->dispatch('open-edit-modal');
    }

    public function save()
    {
        $this->isEdit ? $this->updateMcc() : $this->storeMcc();
    }

    public function storeMcc()
    {
        $this->validate();

        $status = $this->action_taken ? 'processed' : 'pending_to_process';

        try {

            $assembly = Assembly::find($this->assembly_id);
            $assemblyNumber = $assembly->assembly_number;

            $count = Mcc::where('assembly_id', $this->assembly_id)->count();

            $sequence = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

            $mccCode = $assemblyNumber . '-' . $sequence;

            $mcc = Mcc::create([
                'assembly_id' => $this->assembly_id,
                'category' => $this->category,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => $this->complainer_name,
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
                'action_taken' => $this->action_taken,
                'status' => $status,
                'mcc_code' => $mccCode
            ]);

            ChangeLog::create([
                'module_name' => 'mcc',
                'module_id' => $mcc->id,
                'action' => 'inserted',
                'description' => 'MCC created Successfully',
                'old_data' => $mcc->toArray(),
                'new_data' => $mcc->toArray(),
                'changed_by' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            $this->dispatch('toastr:success', message: 'MCC created successfully!');
            $this->dispatch('closeModal', id: 'mccModal');
            $this->resetInputFields();

        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
        }
    }

    public function updateMcc()
    {
        $this->validate();

        $status = $this->action_taken ? 'processed' : 'pending_to_process';

        try {
            $mcc = Mcc::findOrFail($this->mcc_id);

            $old = $mcc->toArray();

            $mcc->update([
                'assembly_id' => $this->assembly_id,
                'category' => $this->category,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => $this->complainer_name,
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
                'action_taken' => $this->action_taken,
                'status' => $status,
            ]);

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
            : 'MCC updated Successfully';

            ChangeLog::create([
                'module_name' => 'mcc',
                'module_id'    => $mcc->id,
                'action' => 'updated',
                'description' => $logDescription,
                'old_data' => $old,
                'new_data' => $new,
                'changed_by' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            $this->dispatch('toastr:success', message: 'MCC updated successfully!');
            $this->dispatch('modelHide');

        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong while updating!');
        }
    }

    public function openActionTakenModal($id)
    {
        $this->selected_mcc_id = $id;

        $mcc = Mcc::find($id);

        $this->action_taken = $mcc->action_taken ?? '';
        $this->status = $mcc->status ?? 'pending_to_process';

        $this->dispatch('open-escalation-modal');
    }

    public function saveActionTaken()
    {
        $this->validate([
            'action_taken' => 'required'
        ]);

        $mcc = Mcc::find($this->selected_mcc_id);

        if (!$mcc) {
            $this->dispatch('toastr:error', message: 'Record not found');
            return;
        }

        $oldData = [
            'action_taken' => $mcc->action_taken,
            'status'       => $mcc->status,
        ];
        $mcc->action_taken = $this->action_taken;

        $mcc->status = $this->action_taken ? 'processed' : 'pending_to_process';

        $mcc->save();

        $newData = [
            'action_taken' => $mcc->action_taken,
            'status'       => $mcc->status,
        ];

        ChangeLog::create([
            'module_name'  => 'mcc',  
            'module_id'    => $mcc->id,  
            'action'       => 'Action Taken Updated',
            'description' => 'Action Taken Updated Successfully',
            'old_data'     => $oldData,
            'new_data'     => $newData,
            'changed_by'   => auth()->id(),
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->header('User-Agent'),
        ]);

        $this->dispatch('toastr:success', message: 'Escalation saved successfully');

        $this->dispatch('close-escalation-modal');
    }

    public function changeStatus($id, $newStatus)
    {
        $mcc = Mcc::find($id);

        if (!$mcc) {
            $this->dispatch('toastr:error', message: 'Record not found');
            return;
        }

        if ($mcc->status == 'pending_to_process') {
            $this->dispatch('toastr:error', message: 'Status cannot be changed from Pending to Process');
            return;
        }

        if ($mcc->status == 'processed' && $newStatus == 'pending_to_process') {
            $this->dispatch('toastr:error', message: 'Cannot move back to Pending to Process');
            return;
        }

        if ($mcc->status == 'confirm_resolved') {
            $this->dispatch('toastr:error', message: 'Resolved status cannot be changed');
            return;
        }

        if ($newStatus == 'confirm_resolved') {
            $this->selectedId = $id;
            $this->reset('remarks');

            $this->dispatch('open-resolve-modal');
            return;
        }

        $oldData = [
            'status' => $mcc->status
        ];

        $mcc->status = $newStatus;
        $mcc->save();

        $newData = [
            'status' => $newStatus
        ];

        ChangeLog::create([
            'module_name'  => 'mcc',
            'module_id'    => $mcc->id,
            'action'       => 'Status Updated',
            'description' => 'Status updated Successfully',
            'old_data'     => $oldData,
            'new_data'     => $newData,
            'changed_by'   => auth()->id(),
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->header('User-Agent'),
        ]);

        $this->dispatch('toastr:success', message: 'Status updated successfully');
    }

    public function saveResolution()
    {
        $mcc = Mcc::find($this->selectedId);

        if (!$mcc) {
            $this->dispatch('toastr:error', message: 'Record not found');
            return;
        }
        $oldData = [
            'status'  => $mcc->status,
            'remarks' => $mcc->remarks,
        ];

        $newStatus = 'confirm_resolved';

        $mcc->status = $newStatus;
        $mcc->remarks = $this->remarks;
        $mcc->save();

        $newData = [
            'status'  => $newStatus,
            'remarks' => $this->remarks,
        ];

        ChangeLog::create([
            'module_name'  => 'mcc',
            'module_id'    => $mcc->id,
            'action'       => 'Status Change',
            'description'  => 'MCC resolved successfully',
            'old_data'     => json_encode($oldData),
            'new_data'     => json_encode($newData),
            'changed_by'   => auth()->id(),
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->header('User-Agent'),
        ]);

        $this->dispatch('close-resolve-modal');
        $this->dispatch('toastr:success', message: 'Resolved successfully');
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


    public function saveMcc()
    {
        $this->validate([
            'mccFile' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        try {

            $path = $this->mccFile->getRealPath();
            $file = fopen($path, 'r');

            $header = fgetcsv($file);

            $required = ['assembly_number', 'block', 'gp', 'complainer_name', 'complainer_phone', 'complainer_description'];

            foreach ($required as $col) {
                if (!in_array($col, $header)) {
                    session()->flash('error', "Missing required column: <b>$col</b>");
                    return;
                }
            }

            $rows = [];
            $line = 1;

            $legalAssociates = Admin::where('role', 'legal_associate')->where('suspended_status', 1)->pluck('id')->toArray();

            if (count($legalAssociates) == 0) {
                throw new \Exception("No Legal Associate found to assign MCC.");
            }

            $associateCount = count($legalAssociates);
            $assignIndex = 0;
            $assemblySequence = [];

            while (($row = fgetcsv($file)) !== false) {

                $line++;

                $data = array_combine($header, $row);

                if (!preg_match('/^[0-9]{10}$/', $data['complainer_phone'])) {
                    throw new \Exception("Row $line : Complainer Phone must be EXACTLY 10 digits.");
                }

                $assembly = Assembly::where('assembly_number', $data['assembly_number'])->first();

                if (!$assembly) {
                    throw new \Exception("Row $line : Assembly number {$data['assembly_number']} NOT found.");
                }

                if (!isset($assemblySequence[$assembly->id])) {

                    $count = Mcc::where('assembly_id', $assembly->id)->count();

                    $assemblySequence[$assembly->id] = $count + 1;
                }

                $sequence = str_pad($assemblySequence[$assembly->id], 4, '0', STR_PAD_LEFT);

                $mccCode = $assembly->assembly_number . '-' . $sequence;

                $assemblySequence[$assembly->id]++;

                $assignedAssociate = $legalAssociates[$assignIndex];

                $rows[] = [
                    'assembly_id'            => $assembly->id,
                    'category'               => $data['category'],
                    'mcc_code'               => $mccCode,
                    'block'                  => $data['block'],
                    'gp'                     => $data['gp'],
                    'complainer_name'        => $data['complainer_name'],
                    'complainer_phone'       => $data['complainer_phone'],
                    'complainer_description' => $data['complainer_description'],
                    'action_taken'           => $assignedAssociate,
                    'status'                 => 'processed',
                    'created_at'             => now(),
                    'updated_at'             => now()
                ];

                $assignIndex++;

                if ($assignIndex >= $associateCount) {
                    $assignIndex = 0;
                }
            }

            fclose($file);


            Mcc::insert($rows);

            session()->flash('success', 'MCC CSV uploaded successfully! ALL rows imported.');

            $this->resetForm();

            $this->dispatch('closeModal', id: 'importMccModal');

        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function exportMcc()
    {
        $user = auth()->user();

        $query = Mcc::with(['assembly']);

        if($user->role == 'legal_associate'){
            $query->where('action_taken', $user->id);
        }

        if($this->search){
            $query->where(function($q){
                $q->where('block', 'like', "%{$this->search}%")
                ->orWhere('gp', 'like', "%{$this->search}%")
                ->orWhere('complainer_name', 'like', "%{$this->search}%")
                ->orWhere('complainer_phone', 'like', "%{$this->search}%");
            });
        }

        if($this->filter_by_assembly){
            $query->where('assembly_id', $this->filter_by_assembly);
        }

        if($this->filter_by_status){
            $query->where('status', $this->filter_by_status);
        }

        $mccList = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="mcc_export.csv"',
        ];

        $columns = ['Assembly', 'Category','Mcc_Code', 'Block', 'GP', 'Complainer Name', 'Complainer Phone', 'Complainer Description', 'Status', 'Remarks'];

        $callback = function() use ($mccList, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($mccList as $item){
                fputcsv($file, [
                    $item->assembly->assembly_name_en ?? 'N/A',
                    ucwords($item->category),
                    $item->mcc_code,
                    $item->block,
                    $item->gp,
                    $item->complainer_name,
                    $item->complainer_phone,
                    $item->complainer_description,
                    $item->status,
                    $item->remarks ?? 'N/A',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $user = auth()->user();

        $campaigns = Mcc::with([
                'districts',
                'assembly',
                'assembly.assemblyPhase',
                'assembly.assemblyPhase.phase',
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
            })
            ->orderBy('id', 'DESC') 
            ->paginate(20);

        return view('livewire.mcc-violation-crud', [
            'mccList' => $campaigns,
        ])->layout('layouts.admin');
    }

}