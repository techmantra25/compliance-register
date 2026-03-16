<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly;
use App\Models\District;

class AssemblyList extends Component
{
    use WithPagination;

    public $district_id, $selected_id;
    public $assembly_name_en;
    public $assembly_name_bn;

    protected $rules = [
        'assembly_name_en' => 'required|string|max:255',
        'assembly_name_bn' => 'required|string|max:255',
    ];
    public $search, $selectedAssembly;

    protected $paginationTheme = 'bootstrap';

    public function DistrictUpdate($value)
    {
        $this->district_id = $value;
        $this->resetPage();
    }

    public function filterData($value)
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['district_id', 'search']);
        $this->dispatch('ResetForm');
    }
     public function editItem($assembly_id)
    {
        $assembly = Assembly::findOrFail($assembly_id);

        $this->selected_id = $assembly->id;
        $this->assembly_name_en = $assembly->assembly_name_en;
        $this->assembly_name_bn = $assembly->assembly_name_bn;

        $this->dispatch('openUpdateModel', [
            'assembly_name_en' => $this->assembly_name_en,
            'assembly_name_bn' => $this->assembly_name_bn
        ]);
    }

    public function updateStatus()
    {
        $this->validate();

        $assembly = Assembly::findOrFail($this->selected_id);

        $assembly->update([
            'assembly_name_en' => $this->assembly_name_en,
            'assembly_name_bn' => $this->assembly_name_bn,
        ]);

        $this->dispatch('closeUpdateModel');
        $this->dispatch('toastr:success', message: 'Assembly Updated Successfully');

        $this->resetFormData();
    }

    public function resetFormData()
    {
        $this->selected_id = null;
        $this->assembly_name_en = '';
        $this->assembly_name_bn = '';
    }

    public function render()
    {
        $assemblies = Assembly::with('district')
            ->when($this->search, fn($q) =>
                $q->where('assembly_name_en', 'like', "%{$this->search}%")
                  ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                  ->orWhere('assembly_code', 'like', "%{$this->search}%"))
            ->when($this->district_id, fn($q) =>
                $q->where('district_id', $this->district_id))
            ->orderBy('assembly_number')
            ->paginate(20);

        $districts = District::orderBy('name_en')->get();

        return view('livewire.assembly-list', [
            'assemblies' => $assemblies,
            'districts'  => $districts,
        ])->layout('layouts.admin');
    }
}
