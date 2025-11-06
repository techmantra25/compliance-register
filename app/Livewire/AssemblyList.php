<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly;
use App\Models\District;

class AssemblyList extends Component
{
    use WithPagination;

    public $district_id;
    public $search;

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
