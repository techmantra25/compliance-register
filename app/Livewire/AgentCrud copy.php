<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Agent;
use App\Models\Assembly;

class AgentCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $designation, $email, $contact_number, $contact_number_alt_1;
    public $editId = null, $editMode = false, $search = '';
     public $assembly_ids = []; // for multi-select chosen

    // protected $rules = [
    //     'name' => 'required|string|max:255',
    //     'designation' => 'nullable|string|max:255',
    //     'email' => 'required|email|unique:agents,email,max:255',
    //     'contact_number' => 'required|string|max:20',
    //     'contact_number_alt_1' => 'nullable|string|max:20',
    // ];

  

    public function filterAgents($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function resetForm()
    {
        $this->reset(['name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'editId', 'editMode','search']);
        $this->resetValidation();
        $this->dispatch('ResetForm');
    }

    public function newAgent()
    {
        $this->resetForm();
        $this->editMode = false;
    }

    public function save()
    {
        // $this->validate();

        $this->validate([
            'name' => 'required|string',
            'designation' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'contact_number' => 'required',
            'contact_number_alt_1' => 'nullable|string|max:20',
        ]);

        Agent::create([
            'name' => $this->name,
            'designation' => $this->designation,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'contact_number_alt_1' => $this->contact_number_alt_1,
        ]);

        // $this->dispatch('toastr:success', message: 'Agent added successfully.');
        // $this->resetForm();
        session()->flash('success', 'Agent added successfully!');
        return redirect()->route('admin.agents');
    }

    public function edit($id)
    {
        $this->editMode = true;
        $this->editId = $id;

        $agent = Agent::findOrFail($id);
        $this->fill($agent->toArray());
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:agents,email,' . $this->editId,
            'contact_number' => 'required',
            'designation' => 'nullable|string|max:255',
            'contact_number_alt_1' => 'nullable|string|max:20',
        ]);

        $agent = Agent::findOrFail($this->editId);
        $agent->update([
            'name' => $this->name,
            'designation' => $this->designation,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'contact_number_alt_1' => $this->contact_number_alt_1,
        ]);

        // $this->dispatch('toastr:success', message: 'Agent updated successfully.');
        // $this->resetForm();
        session()->flash('success', 'Agent updated successfully!');
        return redirect()->route('admin.agents');
    }

      public function render()
    {
        $agents = Agent::where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orWhere('contact_number', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.agent-crud', compact('agents'))
            ->layout('layouts.admin');
    }
}
