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

    // Common fields
    public $agent_type, $name, $email, $comments;
    
    // Category-specific fields
    public $designation, $area, $mobile_no, $phone_no, $whatsapp_no;
    public $assemblies_id;
    
    // Other properties
    public $editId = null, $editMode = false, $search = '';
    public $assemblies;

    public function mount()
    {
        $this->assemblies = Assembly::select('id', 'assembly_code', 'assembly_name_en')
            ->where('status', 1)
            ->orderBy('assembly_code')
            ->get();
    }

    public function filterAgents($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function resetForm()
    {
        $this->reset([
            'agent_type', 'name', 'designation', 'email', 'area',
            'mobile_no', 'phone_no', 'whatsapp_no', 'assemblies_id',
            'comments', 'editId', 'editMode', 'search'
        ]);
        $this->resetValidation();
    }

    public function newAgent()
    {
        $this->resetForm();
        $this->editMode = false;
    }

    public function saveAgent()
    {
        // Validate based on category type
        $rules = $this->getValidationRules();
        $this->validate($rules);

        try {
            // Prepare data based on category
            $data = $this->prepareAgentData();

            if ($this->editMode) {
                // Update existing agent
                $agent = Agent::findOrFail($this->editId);
                $agent->update($data);
                $message = 'Agent updated successfully!';
            } else {
                // Create new agent
                Agent::create($data);
                $message = 'Agent added successfully!';
            }

            $this->dispatch('toastr:success', message: $message);
            $this->dispatch('close-modal');
            $this->resetForm();
            
        } catch (\Exception $e) {
            $this->dispatch('toastr:error', message: 'Error: ' . $e->getMessage());
        }
    }

    private function getValidationRules()
    {
        $commonRules = [
            'agent_type' => 'required|in:bureaucrat,political,other',
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:10',
        ];

        if ($this->agent_type === 'bureaucrat') {
            return array_merge($commonRules, [
                'designation' => 'required|string|max:255',
                'area' => 'required|string|max:255',
                'phone_no' => 'nullable|string|max:10',
                'email' => 'nullable|email|max:255',
                'comments' => 'nullable|string',
            ]);
        } elseif ($this->agent_type === 'political') {
            return array_merge($commonRules, [
                'assemblies_id' => 'nullable|exists:assemblies,id',
                'whatsapp_no' => 'nullable|string|max:10',
                'email' => 'nullable|email|max:255',
                'designation' => 'nullable|string|max:255',
                'comments' => 'nullable|string',
            ]);
        } elseif ($this->agent_type === 'other') {
            return array_merge($commonRules, [
                'whatsapp_no' => 'nullable|string|max:10',
                'email' => 'nullable|email|max:255',
                'designation' => 'nullable|string|max:255',
                'area' => 'nullable|string|max:255',
                'comments' => 'nullable|string',
            ]);
        } else {
            return $commonRules;
        }
    }

    private function prepareAgentData()
    {
        $data = [
            'type' => $this->agent_type,
            'name' => $this->name,
            'email' => $this->email,
            'comments' => $this->comments,
        ];

        switch ($this->agent_type) {
            case 'bureaucrat':
                $data['designation'] = $this->designation;
                $data['contact_number'] = $this->mobile_no;
                $data['phone_number'] = $this->phone_no;
                $data['area'] = $this->area; // Store area in alt_1 or create new column
                break;

            case 'political':
                $data['assemblies_id'] = $this->assemblies_id;
                $data['contact_number'] = $this->mobile_no;
                $data['whatsapp_number'] = $this->whatsapp_no;
                $data['designation'] = $this->designation;
                break;

            case 'other':
                $data['contact_number'] = $this->mobile_no;
                $data['whatsapp_number'] = $this->whatsapp_no;
                $data['designation'] = $this->designation;
                $data['area'] = $this->area; // Store area in alt_1 or create new column
                break;
        }

        return $data;
    }

    public function edit($id)
{
    $this->editMode = true;
    $this->editId = $id;

    $agent = Agent::findOrFail($id);
    
    $this->agent_type = $agent->type;
    $this->name = $agent->name;
    $this->email = $agent->email;
    $this->comments = $agent->comments;
    $this->assemblies_id = $agent->assemblies_id;
    
    switch ($agent->type) {
        case 'bureaucrat':
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->phone_no = $agent->phone_number;
            $this->area = $agent->area;
            break;

        case 'political':
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->whatsapp_no = $agent->whatsapp_number;
            break;

        case 'other':
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->whatsapp_no = $agent->whatsapp_number;
            $this->area = $agent->area;
            break;
    }

    //  Dispatch event to JS so modal fields show correctly
    $this->dispatch('agent-edit-loaded', type: $this->agent_type);
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