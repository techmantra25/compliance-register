<?php

namespace App\Livewire;
use App\Models\Assembly;
use App\Models\Grade;
use App\Models\GradeWiseAssembly;

use Livewire\Component;

class GradeWiseAssemblyCrud extends Component
{
    public $name;
    public $assembly_ids = [];
    public $grade_id;
    public $isEdit = false;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|unique:grades,name,' . $this->grade_id,
            'assembly_ids' => 'required|array'
        ];
    }

    public function save()
    {
        $this->validate();

        $existingAssemblies = GradeWiseAssembly::whereIn('assembly_id', $this->assembly_ids)
            ->when($this->isEdit, function ($query) {
                $query->where('grade_id', '!=', $this->grade_id);
            })
            ->pluck('assembly_id')
            ->toArray();

        if (!empty($existingAssemblies)) {

            $names = Assembly::whereIn('id', $existingAssemblies)
                ->pluck('assembly_name_en')
                ->implode(', ');

            $this->dispatch('toastr:error', message: "These assemblies already belong to another grade: ".$names);

            return;
        }

        if ($this->isEdit) {

            $grade = Grade::find($this->grade_id);
            $grade->update([
                'name' => $this->name
            ]);

        } else {

            $grade = Grade::create([
                'name' => $this->name
            ]);
        }

        $grade->assemblies()->sync($this->assembly_ids);

        $this->dispatch('toastr:success', message: 'Grade Saved Successfully');

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $grade = Grade::with('assemblies')->find($id);

        $this->grade_id = $grade->id;
        $this->name = ucwords($grade->name);

        $this->assembly_ids = $grade->assemblies->pluck('id')->toArray();

        $this->isEdit = true;
    }

    public function resetInputFields()
    {
        $this->reset(['name','assembly_ids','grade_id','isEdit', 'search']);

        $this->dispatch('ResetForm');
    }

    public function filterData($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function render()
    {
        $assemblies = Assembly::orderBy('assembly_name_en')->get();

        $grades = Grade::with('assemblies')
            ->when($this->search, function ($query) {

                $query->where(function ($q) {

                    $q->where('name', 'like', '%'.$this->search.'%')
                    
                    ->orWhereHas('assemblies', function ($assemblyQuery) {
                        $assemblyQuery->where('assembly_name_en', 'like', '%'.$this->search.'%')
                                    ->orWhere('assembly_code', 'like', '%'.$this->search.'%');
                    });

                });

            })
            ->latest()
            ->get();

        return view('livewire.grade-wise-assembly-crud', [
            'assemblies' => $assemblies,
            'grades' => $grades
        ])->layout('layouts.admin');
    }

}
