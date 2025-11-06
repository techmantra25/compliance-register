<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Assembly;
use App\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;

class CandidateContactList extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $designation, $email, $contact_number, $contact_number_alt_1, $contact_number_alt_2, $assembly_id,$agent_id, $type = 'Candidate';
    public $assemblies,$agents;
    public $editMode = false;
    public $editId;

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        // Fetch assemblies that don't yet have a candidate
        $this->agents = Agent::orderBy('name')
            ->get();
        $this->assemblies = Assembly::orderBy('assembly_name_en')
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterCandidates($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function edit($id)
    {
        $this->resetForm(); // always reset before editing
        $this->editMode = true;

        $candidate = Candidate::findOrFail($id);

        $this->editId = $id;
        $this->name = $candidate->name;
        $this->designation = $candidate->designation;
        $this->email = $candidate->email;
        $this->contact_number = $candidate->contact_number;
        $this->contact_number_alt_1 = $candidate->contact_number_alt_1;
        $this->agent_id = $candidate->agent_id;
        $this->assembly_id = $candidate->assembly_id;

        // 🔹 Get assemblies already assigned to other candidates (excluding this one)
        $assignedIds = $this->getInvalidAssembly($candidate->assembly_id);

        // 🔹 Load assemblies excluding already-assigned ones
        $this->assemblies = Assembly::orderBy('assembly_name_en')
            ->whereNotIn('id', $assignedIds)
            ->get();

        // 🔹 Reinitialize chosen on frontend
    }

    protected function getInvalidAssembly($excludeId)
    {
        return Candidate::where('type', 'Candidate')->whereNot('assembly_id', $excludeId)->pluck('assembly_id')->toArray();
    }

    public function newCandidate()
    {
        $invalidId = Candidate::where('type', 'Candidate')
            ->pluck('assembly_id')
            ->toArray();
         
        $this->resetForm();
        $this->editMode = false;
        $this->reset(['editId', 'assembly_id']);

        $this->assemblies = Assembly::orderBy('assembly_name_en')
            ->whereNotIn('id', $invalidId)
            ->get();

        // 🔹 Trigger chosen refresh
    }
    

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:candidates,email,' . $this->editId,
            'contact_number' => 'required',
            'agent_id' => 'required|exists:agents,id',
            'assembly_id' => 'required|exists:assemblies,id',
        ]);

        $candidate = Candidate::findOrFail($this->editId);
        $candidate->update([
            'name' => $this->name,
            'designation' => $this->designation,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'contact_number_alt_1' => $this->contact_number_alt_1,
            'agent_id' => $this->agent_id,
            'assembly_id' => $this->assembly_id,
        ]);

        session()->flash('success', 'Candidate updated successfully!');
        return redirect()->route('admin.candidates.contacts');
    }
    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:candidates,email',
            'contact_number' => 'required',
            'agent_id' => 'required|exists:agents,id',
            'assembly_id' => 'required|exists:assemblies,id',
        ]);

        Candidate::insert([
            'name' => $this->name,
            'designation' => $this->designation,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'contact_number_alt_1' => $this->contact_number_alt_1,
            'assembly_id' => $this->assembly_id,
            'agent_id' => $this->agent_id,
            'type' => "Candidate",
        ]);

        session()->flash('success', 'Candidate updated successfully!');
        return redirect()->route('admin.candidates.contacts');
    }

    public function resetForm()
    {
        $this->reset(['name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'assembly_id', 'editMode', 'editId']);
        $this->search = '';
        $this->dispatch('ResetForm');
        $this->resetPage();
    }

    public function render()
    {
        $candidates = Candidate::where('type', 'Candidate')
        ->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('contact_number', 'like', "%{$this->search}%")
                    // 🔹 Search inside related Assembly table
                    ->orWhereHas('assembly', function ($assembly) {
                        $assembly->where('assembly_number', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_en', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                                ->orWhere('assembly_code', 'like', "%{$this->search}%")
                                // 🔹 Nested relation: District inside Assembly
                                ->orWhereHas('district', function ($district) {
                                    $district->where('name_en', 'like', "%{$this->search}%")
                                            ->orWhere('name_bn', 'like', "%{$this->search}%")
                                            ->orWhere('code', 'like', "%{$this->search}%");
                                });
                    })->orWhereHas('agent', function ($agent){
                        $agent->where('name', 'like', "%{$this->search}%")
                            ->orWhere('designation', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%")
                            ->orWhere('contact_number', 'like', "%{$this->search}%")
                            ->orWhere('contact_number_alt_1', 'like', "%{$this->search}%");
                    });
            });
        })
        ->with(['assembly.district'])
        ->paginate(20);

        return view('livewire.candidate-contact-list', [
            'candidates' => $candidates,
            'assemblies' => $this->assemblies,
            'agents' => $this->agents,
        ])->layout('layouts.admin');
    }
}
