<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\PhaseWiseAssembly;
use App\Models\District;
use App\Models\Admin;
use App\Models\Candidate;
use App\Mail\AssignmentNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GenerateForm2bIndex extends Component
{
     use WithPagination;

    public $district_id;
    public $filter_by_assembly;
    public $search;

    protected $paginationTheme = 'bootstrap';

     public function filterData($value)
    {
        $this->search = $value;
        $this->resetPage();
    }
    public function resetFilters()
    {
        $this->reset(['district_id', 'search', 'filter_by_assembly']);
        $this->dispatch('ResetForm');
    }
    public function render()
    {
       $assemblies = Assembly::with(['district'])
        ->when($this->search, function ($q) {
            $q->where(function ($query) {
                $query->where('assembly_name_en', 'like', "%{$this->search}%")
                    ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                    ->orWhere('assembly_code', 'like', "%{$this->search}%")
                    ->orWhere('assembly_number', 'like', "%{$this->search}%")
                    
                    // Search by District Name
                    ->orWhereHas('district', function ($districtQuery) {
                        $districtQuery->where('name_en', 'like', "%{$this->search}%")
                                        ->orWhere('name_bn', 'like', "%{$this->search}%");
                    });
            });
        })
        ->when($this->district_id, fn($q) =>
            $q->where('district_id', $this->district_id))
        ->when($this->filter_by_assembly, fn($q) =>
            $q->where('id', $this->filter_by_assembly))
        ->orderBy('assembly_number')
        ->paginate(20);

        $districts = District::orderBy('name_en')->get();
        $assemblyList = Assembly::orderBy('assembly_number', 'ASC')->get();

        return view('livewire.generate-form2b-index', [
            'assemblies' => $assemblies,
            'districts'  => $districts,
            'assemblyList'  => $assemblyList,
        ])->layout('layouts.admin');
    }
}
