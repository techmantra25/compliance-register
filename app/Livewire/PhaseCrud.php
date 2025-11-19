<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Phase;
use App\Models\Assembly;
use App\Models\PhaseWiseAssembly;
use Illuminate\Support\Facades\DB;

class PhaseCrud extends Component
{
    public $phase_id, $name, $last_date_of_nomination, $date_of_election, $last_date_of_mcc;
    public $assembly_ids = [];
    public $isEdit = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'last_date_of_nomination' => 'required|date',
        'date_of_election' => 'required|date|after_or_equal:last_date_of_nomination',
        'last_date_of_mcc' => 'required|date',
        'assembly_ids' => 'required|array|min:1',
    ];

    public function resetInputFields()
    {
        $this->reset(['name', 'last_date_of_nomination', 'date_of_election', 'last_date_of_mcc', 'assembly_ids','search']);
        $this->phase_id = null;
        $this->isEdit = false;
        $this->dispatch('ResetForm');
    }

    public function assemblyUpdate($assemblyIds)
    {
        // Convert to array if single value
        $assemblyIds = is_array($assemblyIds) ? $assemblyIds : [$assemblyIds];

        // Find conflicts: assemblies that already belong to other phases
        $query = PhaseWiseAssembly::whereIn('assembly_id', $assemblyIds);

        // If editing, exclude the current phase
        if ($this->isEdit && $this->phase_id) {
            $query->where('phase_id', '!=', $this->phase_id);
        }

        $conflicts = $query->pluck('assembly_id')->toArray();

        if (!empty($conflicts)) {
            // Get the assembly names that conflict
            $conflictNames = Assembly::whereIn('id', $conflicts)->pluck('assembly_name_en')->implode(', ');

            // Dispatch a toastr or alert message
            $this->dispatch('toastr:error', message: "⚠️ These assemblies are already assigned to another phase: {$conflictNames}");

            // Remove conflicting assemblies from the selected list
            $this->assembly_ids = array_diff($assemblyIds, $conflicts);
        } else {
            // No conflicts — update the selected assemblies
            $this->assembly_ids = $assemblyIds;
        }
    }

    public function save()
    { 
        $this->rules['name'] = 'required|string|max:255|unique:phases,name,' . ($this->phase_id ?? 'NULL') . ',id';
        $this->validate();

        DB::beginTransaction();
        try {
            if ($this->isEdit) {
                $phase = Phase::findOrFail($this->phase_id);
                $phase->update([
                    'name' => $this->name,
                    'last_date_of_nomination' => $this->last_date_of_nomination,
                    'date_of_election' => $this->date_of_election,
                    'last_date_of_mcc' => $this->last_date_of_mcc,
                ]);

                // delete old mappings
                PhaseWiseAssembly::where('phase_id', $phase->id)->delete();
            } else {
                $phase = Phase::create([
                    'name' => $this->name,
                    'last_date_of_nomination' => $this->last_date_of_nomination,
                    'date_of_election' => $this->date_of_election,
                    'last_date_of_mcc' => $this->last_date_of_mcc,
                ]);
            }

            foreach ($this->assembly_ids as $assemblyId) {
                PhaseWiseAssembly::create([
                    'phase_id' => $phase->id,
                    'assembly_id' => $assemblyId,
                ]);
            }

            DB::commit();

              $message = $this->isEdit
            ? 'Phase updated successfully!'
            : 'Phase added successfully!';

        $this->dispatch('toastr:success', message: $message);
            $this->resetInputFields();
        } catch (\Exception $e) {
            DB::rollBack();
            $message= 'Something went wrong: ' . $e->getMessage();

            $this->dispatch('toastr:error', message: $message);
        }
    }

    public function edit($id)
    {
        $phase = Phase::findOrFail($id);
        $this->phase_id = $phase->id;
        $this->name = $phase->name;
        $this->last_date_of_nomination = $phase->last_date_of_nomination;
        $this->date_of_election = $phase->date_of_election;
        $this->last_date_of_mcc = $phase->last_date_of_mcc;
        $this->assembly_ids = PhaseWiseAssembly::where('phase_id', $id)->pluck('assembly_id')->toArray();
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            PhaseWiseAssembly::where('phase_id', $id)->delete();
            Phase::findOrFail($id)->delete();
        });
        $this->dispatch('toastr:show', [
            'type' => 'success',
            'message' => 'Phase deleted successfully!',
        ]);
    }

    public function filterData($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function render()
    {
        $assemblies = Assembly::orderBy('assembly_name_en')->get();

        $phases = Phase::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('assemblies', function ($q) {
                        $q->where('assembly_name_en', 'like', '%' . $this->search . '%')
                        ->orWhere('assembly_code', 'like', '%' . $this->search . '%')
                        ->orWhere('assembly_number', 'like', '%' . $this->search . '%');
                    });
            })
            ->with(['assemblies'])
            ->orderBy('last_date_of_nomination', 'asc')
            ->orderBy('date_of_election', 'asc')
            ->get();

        foreach ($phases as $phase) {
            $assemblyIds = PhaseWiseAssembly::where('phase_id', $phase->id)->pluck('assembly_id');
            $phase->assemblies = Assembly::whereIn('id', $assemblyIds)->pluck('assembly_name_en','assembly_code')->toArray();
        }

        return view('livewire.phase-crud', compact('phases', 'assemblies'))->layout('layouts.admin');
    }
}
