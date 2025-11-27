<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Campaigner;
use App\Models\ChangeLog;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StarCampaignerCrud extends Component
{
    use WithFileUploads, WithPagination;
    public $campaigner_id, $name, $mobile, $extra_details;
    public $isEdit = false;
    public $search = '';

    public $campaignerFile;
    protected $campaignerRules = [
        'campaignerFile' => 'required|mimes:csv,txt|max:10240',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'mobile' => 'required|digits:10',
        'extra_details' => 'nullable|string|max:500',
    ];
    public function openAddModal(){
        $this->resetForm();
        $this->isEdit = false;
        $this->dispatch('showModal');
    }

    public function openEditModal($id){
        $campaigner = Campaigner::findOrFail($id);
        $this->campaigner_id = $campaigner->id;
        $this->name = $campaigner->name;
        $this->mobile = $campaigner->mobile;
        $this->extra_details = $campaigner->extra_details;
        $this->isEdit = true;
        $this->dispatch('showModal');
    }

    private function logChange($moduleName, $action, $oldData = null, $newData = null, $description = null)
    {
        ChangeLog::create([
            'module_name' => $moduleName,
            'action'      => $action,
            'description' => $description,
            'old_data'    => $oldData,
            'new_data'    => $newData,
            'changed_by'  => auth()->id(),
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->header('User-Agent'),
        ]);
    }

    public function save(){
        $this->validate();
        $exists = Campaigner::where('mobile', $this->mobile)
            ->when($this->isEdit, fn($q) => $q->where('id', '!=', $this->campaigner_id))
            ->exists();

        if ($exists) {
            $this->dispatch('toastr:error', message: 'Mobile number already exists!');
            return;
        }
        if($this->isEdit){
            $old = Campaigner::find($this->campaigner_id);

            Campaigner::where('id', $this->campaigner_id)->update([
                'name' => $this->name,
                'mobile' => $this->mobile,
                'extra_details' => $this->extra_details,
            ]);
            $new = Campaigner::find($this->campaigner_id);

            $this->logChange(
                moduleName: 'Campaigner',
                action: 'Update',
                oldData: $old->toArray(),
                newData: $new->toArray(),
                description: "Campaigner Updated Successfully"
            );

            $this->dispatch('toastr:success', message: 'Campaigner updated successfully!');
        } else {
            $new = Campaigner::create([
                'name' => $this->name,
                'mobile' => $this->mobile,
                'extra_details' => $this->extra_details,
            ]);
            $this->logChange(
                moduleName: 'Campaigner',
                action: 'Insert',
                oldData: $new->toArray(),
                newData: $new->toArray(),
                description: "Campaigner Added Successfully"
            );
            $this->dispatch('toastr:success', message: 'Campaigner Added successfully!');
        }
        $this->dispatch('hideModal');
        $this->resetForm();
    }

    public function confirmDelete($id){
        $this->dispatch('confirmDelete', ['itemId' => $id]);
    }

    public function delete($id)
    {
        try{
            Campaigner::findOrFail($id)->delete();
            $this->dispatch('toastr:success', message: 'Campaigner deleted successfully!');
        }catch(\Exception $e){
            $this->dispatch('toastr:error', message: 'Error deleting Campaigner. It is linked to campaigns.');
        }
        
    }

    public function resetForm()
    {
        $this->reset(['campaigner_id', 'name', 'mobile', 'extra_details']);
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

    public function filtercampaigner($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function resetFilters()
    {
        $this->reset('search');
    }

    public function render()
    {
        $campaigners = Campaigner::when($this->search, function ($query) {

        $query->where(function ($q) {
            $q->where('name', 'like', "%{$this->search}%")
              ->orWhere('mobile', 'like', "%{$this->search}%")
              ->orWhere('extra_details', 'like', "%{$this->search}%");
        });

        })->orderBy('id', 'desc')->paginate(20);

        return view('livewire.star-campaigner-crud',['campaigners' => $campaigners])->layout('layouts.admin');
    }
}
