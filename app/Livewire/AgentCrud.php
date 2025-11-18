<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Agent;
use App\Models\ContactDesignation;
use App\Models\Assembly;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class AgentCrud extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Common fields
    public $agent_type, $name, $email, $comments;
    
    // Category-specific fields
    public $designation, $area, $mobile_no, $phone_no, $whatsapp_no;
    public $assemblies_id;
    public $sameAsMobile, $designations;

    // Other properties
    public $editId = null, $editMode = false, $search = '';
    public $assemblies;
    public $expandedAgentId = null;
    public $importCategory;
    public $sampleCSV;
    public $csvFile;
    
    public function mount()
    {
        $this->assemblies = Assembly::select('id', 'assembly_code', 'assembly_name_en')
            ->where('status', 1)
            ->orderBy('assembly_code')
            ->get();
        $this->designations = ContactDesignation::where('status', 1)->orderBy('name')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    
    public function view($id){
         if ($this->expandedAgentId === $id) {
           $this->expandedAgentId = null;
        } else {
            $this->expandedAgentId = $id;
        }
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
        $this->dispatch('ResetFormData');
    }

    public function newAgent()
    {
        $this->resetForm();
        $this->editMode = false;
         $this->dispatch('refreshChosen');
    }

    public function saveAgent()
    {
        // dd($this->all());
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
            'mobile_no' => 'required|digits:10',
        ];

        if ($this->agent_type === 'bureaucrat') {
            return array_merge($commonRules, [
                'designation' => 'required|string|max:255',
                'area' => 'required|string|max:255',
                'phone_no' => 'nullable|digits:10',
                'email' => 'nullable|email|max:255',
                'comments' => 'nullable|string',
            ]);
        } elseif ($this->agent_type === 'political') {
            return array_merge($commonRules, [
                'assemblies_id' => 'nullable|exists:assemblies,id',
                'whatsapp_no' => 'nullable|digits:10',
                'email' => 'nullable|email|max:255',
                'designation' => 'nullable|string|max:255',
                'comments' => 'nullable|string',
            ]);
        } elseif ($this->agent_type === 'other') {
            return array_merge($commonRules, [
                'whatsapp_no' => 'nullable|digits:10',
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
                $data['whatsapp_number'] = $this->sameAsMobile ? $this->mobile_no : $this->whatsapp_no;
                $data['designation'] = $this->designation;
                break;

            case 'other':
                $data['contact_number'] = $this->mobile_no;
                $data['whatsapp_number'] = $this->sameAsMobile ? $this->mobile_no : $this->whatsapp_no;
                $data['designation'] = $this->designation;
                $data['area'] = $this->area; // Store area in alt_1 or create new column
                break;
        }

        return $data;
    }

    public function updateCategory($value)
    {
        // When category changes, clear category-specific fields
        if ($value === 'bureaucrat') {
            $this->reset([
                'designation',
                'area',
                'mobile_no',
                'phone_no',
                'whatsapp_no',
            ]);
        } elseif ($value === 'political') {
            $this->reset([
                'designation',
                'area',
                'mobile_no',
                'phone_no',
                'whatsapp_no',
            ]);
        } else {
            // For any other category
            $this->reset([
                'designation',
                'area',
                'mobile_no',
                'phone_no',
                'whatsapp_no',
            ]);
        }

        // Update the category
        $this->agent_type = $value;

        // Tell frontend to toggle visible fields (e.g. show/hide sections)
        $this->dispatch('toggleCategoryFields', type: $value);
        $this->dispatch('ResetFormData');
    }

   public function updateAgent()
{
    // dd($this->all());
    $rules = $this->getValidationRules();
    $this->validate($rules);

    try {
        $agent = Agent::findOrFail($this->editId);

        $data = $this->prepareAgentData();
        $agent->update($data);

        $this->dispatch('toastr:success', message: 'Contact updated successfully!');
        $this->dispatch('close-modal');

        $this->resetForm();

    } catch (\Exception $e) {
        $this->dispatch('toastr:error', message: 'Update failed: ' . $e->getMessage());
    }
}



    public function edit($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->editId = $id;

        $agent = Agent::findOrFail($id);

        $this->agent_type = $agent->type;
        $this->name = $agent->name;
        $this->email = $agent->email;
        $this->comments = $agent->comments;
        
        
        if ($agent->type === 'bureaucrat') {
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->phone_no = $agent->phone_number;
            $this->area = $agent->area;
        } elseif ($agent->type === 'political') {
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->whatsapp_no = $agent->whatsapp_number;
            $this->assemblies_id = $agent->assemblies_id;
        } elseif ($agent->type === 'other') {
            $this->designation = $agent->designation;
            $this->mobile_no = $agent->contact_number;
            $this->whatsapp_no = $agent->whatsapp_number;
            $this->area = $agent->area;
        }
        
         $this->dispatch('agent-edit-loaded', ['type' => $this->agent_type]);
            $this->dispatch('refreshChosen');

    }


    public function confirmDelete($id){
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

     public function delete($id)
    {
        Agent::findOrFail($id)->delete();
        $this->dispatch('toastr:success', message: 'Agent deleted successfully!');
    }

    public function updateSampleCSV()
    {
        switch ($this->importCategory) {
            case 'bureaucrat':
                $this->sampleCSV = asset('assets/sample-csv/bureaucrat-sample.csv');
                break;
            case 'political':
                $this->sampleCSV = asset('assets/sample-csv/political-sample.csv');
                break;
            case 'other':
                $this->sampleCSV = asset('assets/sample-csv/other-sample.csv');
                break;
            default:
                $this->sampleCSV = null;
        }
    }

    public function import()
    {
        $this->dispatch('open-modal', 'importModal');
        $this->reset(['importCategory', 'sampleCSV', 'csvFile']);

    }

    public function importCSV()
    {
        $this->validate([
            'importCategory' => 'required|in:bureaucrat,political,other',
            'csvFile' => 'required|file|mimes:csv,txt',
        ]);

        DB::beginTransaction(); // Start transaction

        try {
            $path = $this->csvFile->getRealPath();
            $file = fopen($path, 'r');

            $headers = fgetcsv($file); // first row headers
            $rowNumber = 1;

            while ($row = fgetcsv($file)) {
                $rowNumber++;
                $data = $this->mapCSVRowToAgent($row, $headers);

                // 🔹 Validation based on category
                if ($this->importCategory === 'bureaucrat') {
                    $requiredFields = ['name', 'area', 'designation', 'contact_number'];
                } elseif ($this->importCategory === 'political' || $this->importCategory === 'other') {
                    $requiredFields = ['name', 'contact_number'];
                }

                foreach ($requiredFields as $field) {
                    if (empty($data[$field])) {
                        throw new \Exception("Row {$rowNumber}: {$field} is required for {$this->importCategory}.");
                    }
                }

                Agent::create($data);
            }

            fclose($file);

            DB::commit(); // Commit transaction if everything is OK
            $this->dispatch('toastr:success', message: 'CSV imported successfully!');
            $this->dispatch('close-modal');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any error occurs
            $this->dispatch('toastr:error', message: 'Import failed: ' . $e->getMessage());
        }
    }
    private function mapCSVRowToAgent($row, $headers)
    {
        $data = ['type' => $this->importCategory];

        foreach ($headers as $index => $header) {
            $value = $row[$index] ?? null;

            switch ($this->importCategory) {
                case 'bureaucrat':
                    // Sample headers: Name,Designation,Area,Mobile No,Phone No,Email,Comments
                    if ($header == 'Name') $data['name'] = $value;
                    elseif ($header == 'Designation') $data['designation'] = $value;
                    elseif ($header == 'Area') $data['area'] = $value;
                    elseif ($header == 'Mobile No') $data['contact_number'] = $value;
                    elseif ($header == 'Phone No') $data['phone_number'] = $value;
                    elseif ($header == 'Email') $data['email'] = $value;
                    elseif ($header == 'Comments') $data['comments'] = $value;
                    break;

                case 'political':
                    // Sample headers: Name,Assembly ID,Mobile No,Whatsapp No,Designation,Email,Comments
                    if ($header == 'Name') $data['name'] = $value;
                   // 🔹 Lookup assembly ID by name
                    elseif ($header == 'Assembly Name') {
                        $assembly = Assembly::where('assembly_name_en', $value)->first();
                        $data['assemblies_id'] = $assembly ? $assembly->id : null;
                    }
                    elseif ($header == 'Mobile No') $data['contact_number'] = $value;
                    elseif ($header == 'Whatsapp No') $data['whatsapp_number'] = $value;
                    elseif ($header == 'Designation') $data['designation'] = $value;
                    elseif ($header == 'Email') $data['email'] = $value;
                    elseif ($header == 'Comments') $data['comments'] = $value;
                    break;

                case 'other':
                    // Sample headers: Name,Mobile No,Whatsapp No,Designation,Area,Email,Comments
                    if ($header == 'Name') $data['name'] = $value;
                    elseif ($header == 'Mobile No') $data['contact_number'] = $value;
                    elseif ($header == 'Whatsapp No') $data['whatsapp_number'] = $value;
                    elseif ($header == 'Designation') $data['designation'] = $value;
                    elseif ($header == 'Area') $data['area'] = $value;
                    elseif ($header == 'Email') $data['email'] = $value;
                    elseif ($header == 'Comments') $data['comments'] = $value;
                    break;
            }
        }

        return $data;
    }

    public function render()
    {
        // $agents = Agent::with('assembliesDetails')->where('name', 'like', "%{$this->search}%")
        //     ->orWhere('email', 'like', "%{$this->search}%")
        //     ->orWhere('contact_number', 'like', "%{$this->search}%")
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);
        
        $agents = Agent::with('assembliesDetails')
            ->when($this->search, function ($query) {
                $search = "%{$this->search}%";

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('designation', 'like', $search)
                        ->orWhere('contact_number', 'like', $search)
                        ->orWhere('phone_number', 'like', $search)
                        ->orWhere('contact_number_alt_1', 'like', $search)
                        ->orWhere('area', 'like', $search)
                        ->orWhere('type', 'like', $search)
                        ->orWhere('whatsapp_number', 'like', $search)

                        //  Important: this is inside the same group
                        ->orWhereHas('assembliesDetails', function ($a) use ($search) {
                            $a->where('assembly_name_en', 'like', $search)
                                ->orWhere('assembly_code', 'like', $search)
                                ->orWhere('assembly_number', 'like', $search);
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.agent-crud', compact('agents'))
            ->layout('layouts.admin');
    }
}