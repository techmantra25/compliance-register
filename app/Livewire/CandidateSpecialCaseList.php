<?php

namespace App\Livewire;


use App\Models\Candidate;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Agent;
use App\Models\CandidateObservationStep;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateAgent;
use App\Models\CandidateDocumentType;
use App\Models\NominationLog;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyNominationReport;
use Carbon\Carbon;
use App\Models\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\NominationVettingCompletedMail;

class CandidateSpecialCaseList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $candidate_status;
    public $selectedCandidate;
    public $filter_by_status,$name, $designation, $email, $contact_number, $contact_number_alt_1, $contact_number_alt_2, $assembly_id, $type = 'Candidate';
    public $assemblies,$districts,$phases;
    public $editMode = false;
    public $editId,$candidateId,$required_document;
    public $authUser;
    public $agentsList = [];
    public $filter_by_document_array = [];
    public $filter_by_assembly, $filter_by_district, $filter_by_phase;
    public $form2bLogs = [];
    public $form26Logs = [];

    public $candidateFile, $csvError = null;
    
    protected $rules = [
        'candidateFile' => 'required|file|mimes:csv,txt', 
    ];

    protected $paginationTheme = 'bootstrap';
    
    public function mount()
    {
        $this->authUser = Auth::guard('admin')->user();
        $this->assemblies = Assembly::orderBy('assembly_name_en', 'ASC')
            ->get();
        $this->districts = District::orderBy('name_en', 'ASC')
            ->get();
        $this->phases = Phase::orderBy('name', 'ASC')
            ->get();
        $this->required_document = CandidateDocumentType::count();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterCandidates($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function filterByStatus($filter_by_status)
    {
        $this->filter_by_status = $filter_by_status;
    }

    protected function getInvalidAssembly($excludeId)
    {
        return Candidate::where('type', 'Candidate')->whereNot('assembly_id', $excludeId)->pluck('assembly_id')->toArray();
    }


    public function resetForm()
    {
        $this->reset(['name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 
        'assembly_id', 'editMode', 'editId',  'search',
        'filter_by_assembly', 'filter_by_document_array', 'filter_by_status',
        'filter_by_district',
        'filter_by_phase',]);
        $this->search = '';
        $this->dispatch('ResetFormData');
        $this->dispatch('refreshChosen');
        $this->dispatch('clearSearch');
        $this->dispatch('resetAllFilters');
        $this->resetPage();
    }

    private function getFilteredQuery()
    {
        $query = Candidate::query()
            ->where('type', 'Candidate')
            ->where('legal_associate_id', $this->authUser->id);
        if ($this->authUser->role === 'legal_associate') {
            $query->where('legal_associate_id', $this->authUser->id);
        }
        return $query
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('contact_number', 'like', "%{$this->search}%")
                        ->orWhereHas('assembly', function ($assembly) {
                            $assembly->where('assembly_number', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_en', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                                ->orWhere('assembly_code', 'like', "%{$this->search}%")
                                ->orWhereHas('district', function ($district) {
                                    $district->where('name_en', 'like', "%{$this->search}%")
                                        ->orWhere('name_bn', 'like', "%{$this->search}%")
                                        ->orWhere('code', 'like', "%{$this->search}%");
                                });
                        })
                        ->orWhereHas('agents', function ($agent) {
                            $agent->where('name', 'like', "%{$this->search}%")
                                ->orWhere('designation', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%")
                                ->orWhere('contact_number', 'like', "%{$this->search}%")
                                ->orWhere('contact_number_alt_1', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filter_by_status, fn($q) => $q->where('document_collection_status', $this->filter_by_status))
            ->when(!empty($this->filter_by_document_array), fn($q) =>
                $q->whereIn('document_collection_status', $this->filter_by_document_array)
            )
            ->when($this->filter_by_assembly, fn($q) => $q->where('assembly_id', $this->filter_by_assembly))
            ->when($this->filter_by_district, fn($q) => $q->whereHas('assembly.district', fn($d) => $d->where('id', $this->filter_by_district)))
            ->when($this->filter_by_phase, fn($q) => $q->whereHas('assembly.assemblyPhase', fn($p) => $p->where('phase_id', $this->filter_by_phase)))

            // ADD THIS PART ONLY
            ->join('assemblies', 'candidates.assembly_id', '=', 'assemblies.id')
            ->orderBy('assemblies.assembly_number', 'asc')
            ->select('candidates.*')

            ->with([
                'assembly.district',
                'assembly.assemblyPhase.phase',
                'documents',
                'agents'
            ]);
    }



   public function render()
    {
        $query = $this->getFilteredQuery();

        $candidates = $query
            ->paginate(20);

        $this->dispatch('resetTooltip');

        return view('livewire.candidate-special-case-list', [
            'candidates' => $candidates,
            'assemblies' => $this->assemblies,
        ])->layout('layouts.admin');
    }
}
