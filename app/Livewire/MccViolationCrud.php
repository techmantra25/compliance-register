<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Assembly;
use App\Models\Mcc;
use App\Models\ChangeLog;

class MccViolationCrud extends Component
{
    use WithPagination , WithFileUploads;

    public $mcc_id, $assembly_id, $block, $gp, $complainer_name, $complainer_phone, $complainer_description;
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

    protected $paginationTheme = "bootstrap";

    protected $rules = [
        'assembly_id' => 'required|integer',
        'block' => 'required|string',
        'gp' => 'required|string',
        'complainer_name' => 'required|string',
        'complainer_phone' => 'required|numeric|digits:10',
        'complainer_description' => 'nullable|string',
    ];

    protected $messages = [
        'assembly_id.required' => 'Please select assembly.',
        'block.required' => 'Block is required.',
        'gp.required' => 'GP is required.',
        'complainer_name.required' => 'Complainer name is required.',
        'complainer_phone.required' => 'Phone is required.',
        'complainer_phone.digits' => 'Phone must be 10 digits.',
    ];

    public function mount()
    {
        $this->assembly = Assembly::where('status', 'active')->orderBy('assembly_name_en')->get();
    }

    public function openMccModal()
    {
        $this->resetInputFields();
        $this->isEdit = false;

        $this->dispatch('refreshChosen');
        $this->dispatch('open-edit-modal'); 
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
            'complainer_description'
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
        $this->block = $mcc->block;
        $this->gp = $mcc->gp;
        $this->complainer_name = $mcc->complainer_name;
        $this->complainer_phone = $mcc->complainer_phone;
        $this->complainer_description = $mcc->complainer_description;

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

        try {
            $mcc = Mcc::create([
                'assembly_id' => $this->assembly_id,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => $this->complainer_name,
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
            ]);

            ChangeLog::create([
                'module_name' => 'mcc',
                'module_id'    => $mcc->id,
                'action' => 'inserted',
                'description' => 'MCC created Successfully',
                'old_data' => $mcc->toArray(),
                'new_data' => $mcc->toArray(),
                'changed_by' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            $this->dispatch('toastr:success', message: 'MCC created successfully!');
            $this->dispatch('modelHide');
            // $this->resetInputFields();

        } catch (\Exception $e) {
            $this->dispatch('toastr:error', message: 'Something went wrong while creating!');
        }
    }

    public function updateMcc()
    {
        $this->validate();

        try {
            $mcc = Mcc::findOrFail($this->mcc_id);

            $old = $mcc->toArray();

            $mcc->update([
                'assembly_id' => $this->assembly_id,
                'block' => $this->block,
                'gp' => $this->gp,
                'complainer_name' => $this->complainer_name,
                'complainer_phone' => $this->complainer_phone,
                'complainer_description' => $this->complainer_description,
            ]);

            $new = $mcc->fresh()->toArray();

            ChangeLog::create([
                'module_name' => 'mcc',
                'module_id'    => $mcc->id,
                'action' => 'updated',
                'description' => 'MCC updated Successfully',
                'old_data' => $old,
                'new_data' => $new,
                'changed_by' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            $this->dispatch('toastr:success', message: 'MCC updated successfully!');
            $this->dispatch('modelHide');

        } catch (\Exception $e) {
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

        if ($this->status == 'confirm_resolved') {
            $mcc->status = 'confirm_resolved';
        }
        else{
            if (!empty($mcc->action_taken)) {
                $mcc->status = 'processed';
            } else {
                $mcc->status = 'pending_to_process';
            }
        }

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

            while (($row = fgetcsv($file)) !== false) {
                $line++;

                $data = array_combine($header, $row);

                if (!preg_match('/^[0-9]{10}$/', $data['complainer_phone'])) {
                    throw new \Exception("Row $line : Complainer Phone must be EXACTLY 10 digits.");
                }

            
                $assembly = Assembly::where('assembly_number', $data['assembly_number'])->first();

                if (!$assembly) {
                    throw new \Exception("Row $line : Assembly number <b>{$data['assembly_number']}</b> NOT found.");
                }

                $rows[] = [
                    'assembly_id'            => $assembly->id,
                    'block'                  => $data['block'],
                    'gp'                     => $data['gp'],
                    'complainer_name'        => $data['complainer_name'],
                    'complainer_phone'       => $data['complainer_phone'],
                    'complainer_description' => $data['complainer_description'],
                    'created_at'             => now(),
                    'updated_at'             => now()
                ];
            }

            fclose($file);


            Mcc::insert($rows);

            session()->flash('success', 'MCC CSV uploaded successfully! ALL rows imported.');

            $this->resetForm();

            $this->dispatch('closeModal', id: 'importMccModal');

        } catch (\Exception $e) {

            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }
    // public function render()
    // {
    //     return view('livewire.mcc-violation-crud', [
    //         'mccList' => MCC::with(['districts','assembly', 'assembly.assemblyPhase', 'assembly.assemblyPhase.phase'])->latest()->paginate(20),
    //     ])->layout('layouts.admin');
    // }
    public function render()
    {
        $campaigns = Mcc::with([
                'districts',
                'assembly',
                'assembly.assemblyPhase',
                'assembly.assemblyPhase.phase',
            ])

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
            ->orderBy('id', 'DESC') 
            ->paginate(20);

        return view('livewire.mcc-violation-crud', [
            'mccList' => $campaigns,
        ])->layout('layouts.admin');
    }

}
