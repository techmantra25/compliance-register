<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Agent;
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

class CandidateContactList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $name, $designation, $email, $contact_number, $contact_number_alt_1, $contact_number_alt_2, $assembly_id, $type = 'Candidate';
    public $assemblies,$districts,$phases;
    public $editMode = false;
    public $editId,$candidateId,$required_document;
    public $authUser;
    public $agentsList = [];
    public $filter_by_assembly, $filter_by_district, $filter_by_phase;

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

    public function openAgentModal($candidateId)
    {
        $this->candidateId = $candidateId;

        // Load existing agents if updating
        $this->agentsList = CandidateAgent::where('candidate_id', $candidateId)
            ->with('agent')
            ->get()
            ->map(function($item){
                return [
                    'id' => $item->agent_id,
                    'name' => $item->agent ? $item->agent->name : null,
                    'contact_number' => $item->agent ? $item->agent->contact_number : null,
                    'contact_number_alt_1' => $item->agent ? $item->agent->contact_number_alt_1 : null,
                    'email' => $item->agent ? $item->agent->email : null
                ];
            })
            ->toArray();
    }

    public function addAgentRow()
    {
        $this->agentsList[] = ['name' => '', 'contact_number' => '', 'contact_number_alt_1' => '', 'email' => ''];
    }

    public function removeAgentRow($index)
    {
        unset($this->agentsList[$index]);
        $this->agentsList = array_values($this->agentsList);
    }

    public function saveAgents()
    {
        $this->validate(
            [
                'agentsList.*.name' => 'required|string|max:255',
                'agentsList.*.contact_number' => 'required|digits:10',
                'agentsList.*.contact_number_alt_1' => 'nullable|digits:10',
                'agentsList.*.email' => 'nullable|email|max:255',
            ],
            [
                'agentsList.*.name.required' => 'This field is required',
                'agentsList.*.contact_number.required' => 'This field is required',
                'agentsList.*.contact_number.digits' => 'Must be a 10-digit numeric number',
                'agentsList.*.contact_number_alt_1.digits' => 'Must be a 10-digit numeric number',
                'agentsList.*.email.email' => 'Invalid email format',
            ]
        );


        DB::beginTransaction();

        try {

            $candidate = Candidate::find($this->candidateId);

            $agentsPayload = []; // collect agents data for logging

            foreach ($this->agentsList as $agentData) {

                // create or update agent
                $agent = Agent::updateOrCreate(
                    ['id' => $agentData['id'] ?? null],
                    [
                        'assemblies_id' => $candidate->assembly_id,
                        'name' => $agentData['name'],
                        'contact_number' => $agentData['contact_number'],
                        'contact_number_alt_1' => $agentData['contact_number_alt_1'] ?? null,
                        'email' => $agentData['email'] ?? null,
                        'comments' => "Added as agent of {$candidate->name}",
                    ]
                );

                // Attach agent to candidate
                CandidateAgent::updateOrCreate(
                    [
                        'candidate_id' => $this->candidateId,
                        'agent_id' => $agent->id
                    ]
                );

                // Collect only required fields for log
                $agentsPayload[] = [
                    'assembly' => optional($candidate->assembly)->assembly_name_en,
                    'name' => $agentData['name'],
                    'contact_number' => $agentData['contact_number'],
                    'contact_number_alt_1' => $agentData['contact_number_alt_1'] ?? null,
                    'email' => $agentData['email'] ?? null,
                ];
            }

            $logData = [
                'module_name'   => 'Candidate',
                'module_id'     => $candidate->id,
                'action'        => 'Assign Agents',
                'description'   => "Agents assigned to candidate {$candidate->name}",
                'old_data'      => null, // you can fetch old agents if needed
                'new_data'      => json_encode($agentsPayload),
            ];

            logChange($logData);
            DB::commit();

            session()->flash('success', 'Agents saved successfully!');
            return redirect()->route('admin.candidates.contacts');;

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Something went wrong: ' . $e->getMessage());
        }
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
        $this->assembly_id = $candidate->assembly_id;

        //  Get assemblies already assigned to other candidates (excluding this one)
        $assignedIds = $this->getInvalidAssembly($candidate->assembly_id);

        //  Load assemblies excluding already-assigned ones
        $this->assemblies = Assembly::orderBy('assembly_name_en')
            ->whereNotIn('id', $assignedIds)
            ->get();

        //  Reinitialize chosen on frontend
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
            'contact_number' => 'required|digits:10',
            'contact_number_alt_1' =>'nullable|digits:10',
            'assembly_id' => 'required|exists:assemblies,id',
        ]);

        // Check if another candidate already has this assembly
        $exists = Candidate::where('assembly_id', $this->assembly_id)
                    ->where('id', '!=', $this->editId)
                    ->exists();

        if ($exists) {
            $this->addError('assembly_id', 'Candidate already exists for this assembly.');
            return;
        }
        $candidate = Candidate::findOrFail($this->editId);

        // Store old record BEFORE update
        $oldData = $candidate->replicate()->toArray();
        DB::beginTransaction();

        try {
            // Perform update
            $candidate->update([
                'name' => $this->name,
                'designation' => $this->designation,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'contact_number_alt_1' => $this->contact_number_alt_1,
                'assembly_id' => $this->assembly_id,
            ]);

            // Store new record AFTER update
            $newData = $candidate->fresh()->toArray();

            // Prepare log data
            $logData = [
                'module_name'   => 'Candidate',
                'module_id'     => $candidate->id,
                'action'        => 'Update',
                'description'   => 'Candidate updated successfully.',
                'old_data'      => json_encode($oldData),
                'new_data'      => json_encode($newData),
            ];

            // Save log
            logChange($logData);

            DB::commit();
            session()->flash('success', 'Candidate updated successfully!');
            return redirect()->route('admin.candidates.contacts');
            } catch (\Exception $e) {
        DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
            return;
        }
    }
    public function save()
    {
        // Validation
        $this->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:candidates,email',
            'contact_number' => 'required|digits:10',
            'contact_number_alt_1' => 'nullable|digits:10',
            'assembly_id' => 'required|exists:assemblies,id',
        ]);

        // Check if candidate already exists for that assembly
        $existingCandidate = Candidate::where('assembly_id', $this->assembly_id)->first();

        if ($existingCandidate) {
            // Return validation-style error
            $this->addError('assembly_id', 'Candidate already exists for this assembly.');
            return; // Stop execution
        }

        DB::beginTransaction();

        try {
            // Create Candidate (use create(), NOT insert())
            $candidate = Candidate::create([
                'name' => $this->name,
                'designation' => $this->designation,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'contact_number_alt_1' => $this->contact_number_alt_1,
                'assembly_id' => $this->assembly_id,
                'type' => "Candidate",
            ]);

            // Prepare log data
            $logData = [
                'module_name'   => 'Candidate',
                'module_id'     => $candidate->id,
                'action'        => 'Insert',
                'description'   => 'New candidate record created successfully.',
                'old_data'      => null,
                'new_data'      => json_encode($candidate),
            ];

            logChange($logData);

            DB::commit();

            session()->flash('success', 'Candidate created successfully!');
            return redirect()->route('admin.candidates.contacts');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Error: ' . $e->getMessage());
            return;
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 'assembly_id', 'editMode', 'editId']);
        $this->search = '';
        $this->dispatch('ResetFormData');
        $this->resetPage();
    }

    public function saveCandidate()
    {
        $this->validate([
            'candidateFile' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $this->csvError = null;

        try {
            $path = $this->candidateFile->store('temp', 'public');
            $file = Storage::disk('public')->path($path);

            $rows = array_map('str_getcsv', file($file));
            $header = array_map('trim', array_shift($rows));
            
            $expectedHeaders = [
                'assembly_code', 'candidate_name', 'candidate_email', 'candidate_mobile', 'candidate_alternative_mobile'
            ];

            if ($header !== $expectedHeaders) {
                throw new \Exception("Invalid CSV header format. Please use the provided sample CSV.");
            }

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                $data = array_combine($header, array_map('trim', $row));
                if (empty($data['assembly_code'])) {
                    throw new \Exception("Row " . ($index + 2) . ": Assembly code is required.");
                }

                if (empty($data['candidate_name']) || empty($data['candidate_mobile'])) {
                    throw new \Exception("Row " . ($index + 2) . ": Candidate name and mobile are required.");
                }

                 // Candidate Mobile must be 10 digits
                if (!preg_match('/^[0-9]{10}$/', $data['candidate_mobile'])) {
                    throw new \Exception("Row " . ($index + 2) . ": Candidate mobile must be exactly 10 digits.");
                }

                // Candidate Email validation
                if (!empty($data['candidate_email']) && 
                    !filter_var($data['candidate_email'], FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Row " . ($index + 2) . ": Candidate email is invalid.");
                }

                $assembly = DB::table('assemblies')
                    ->where('assembly_code', $data['assembly_code'])
                    ->orWhere('assembly_number', $data['assembly_code'])
                    ->first();

                if (!$assembly) {
                    throw new \Exception("Row " . ($index + 2) . ": Invalid assembly code.");
                }

                $assembly_id = $assembly->id;

                // Check existing candidate by assembly
                $existingCandidate = DB::table('candidates')
                    ->where('assembly_id', $assembly_id)
                    ->first();

                $oldData = $existingCandidate ? (array) $existingCandidate : null;

                // Insert or Update
                DB::table('candidates')->updateOrInsert(
                    ['assembly_id' => $assembly_id],
                    [
                        'name'                  => $data['candidate_name'],
                        'email'                 => $data['candidate_email'],
                        'contact_number'        => $data['candidate_mobile'],
                        'contact_number_alt_1'  => $data['candidate_alternative_mobile'] ?? null,
                        'type'                  => 'Candidate',
                    ]
                );

                // Fetch updated data
                $newData = DB::table('candidates')
                    ->where('assembly_id', $assembly_id)
                    ->first();

                // Determine action type
                $action = $existingCandidate ? 'Update' : 'Insert';

                // Prepare log data
                $logData = [
                    'module_name'   => 'Candidate',
                    'module_id'     => $newData->id,
                    'action'        => $action,
                    'description'   => $action === 'Update'
                                        ? 'Candidate updated successfully.'
                                        : 'New candidate created successfully.',
                    'old_data'      => $oldData ? json_encode($oldData) : null,
                    'new_data'      => json_encode($newData),
                ];

                // Save log
                logChange($logData);

            }

            DB::commit();

            unlink($file);
            $this->reset(['candidateFile']);
            
            $this->dispatch('close-upload-modal');
            $this->dispatch('toastr:success', message: 'CSV uploaded successfully.');


        }  catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();

            $this->csvError = $e->getMessage();
            $errorMessage = '';
            if (str_contains($errorMessage, 'Invalid CSV header')) {
                $this->csvError = 'Your CSV file format is incorrect. Please use the sample format.';
            } elseif (str_contains($errorMessage, 'Invalid assembly code')) {
                $this->csvError = 'One or more Assembly Codes are invalid. Please verify and re-upload.';
            }elseif (str_contains($errorMessage, 'Candidate mobile must be')) {
                $this->csvError = 'Candidate mobile number must be exactly 10 digits. Please correct your CSV and upload again.';

            } elseif (str_contains($errorMessage, 'Candidate email is invalid')) {
                $this->csvError = 'One or more candidate emails are invalid. Please enter valid email addresses.';
            } elseif (str_contains($errorMessage, 'required')) {
                $this->csvError = 'Please make sure all mandatory fields are filled in.';
            } elseif (str_contains(strtolower($errorMessage), 'duplicate') || str_contains(strtolower($errorMessage), 'unique')) {
                $this->csvError = 'Some emails already exist in the system. Please ensure all agent or candidate emails are unique.';
            } else {
                $this->csvError = 'Something went wrong while processing your CSV. Please try again.';
            }
        }

    }

   



    public function render()
    {
        $candidates = Candidate::query()
            ->where('type', 'Candidate')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('contact_number', 'like', "%{$this->search}%")

                        //  Search inside related Assembly table
                        ->orWhereHas('assembly', function ($assembly) {
                            $assembly->where('assembly_number', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_en', 'like', "%{$this->search}%")
                                ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                                ->orWhere('assembly_code', 'like', "%{$this->search}%")
                                
                                //  Nested relation: District inside Assembly
                                ->orWhereHas('district', function ($district) {
                                    $district->where('name_en', 'like', "%{$this->search}%")
                                        ->orWhere('name_bn', 'like', "%{$this->search}%")
                                        ->orWhere('code', 'like', "%{$this->search}%");
                                });
                        })

                        //  Search inside related Agents (Many-to-Many)
                        ->orWhereHas('agents', function ($agent) {
                            $agent->where('name', 'like', "%{$this->search}%")
                                ->orWhere('designation', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%")
                                ->orWhere('contact_number', 'like', "%{$this->search}%")
                                ->orWhere('contact_number_alt_1', 'like', "%{$this->search}%");
                        });
                });
            })
            ->with([
                'assembly.district',
                'agents' => function ($q) {
                    $q->select('agents.id', 'name', 'email', 'contact_number', 'contact_number_alt_1'); // only required fields
                },'documents'
            ])
            ->orderByDesc('id')
            ->paginate(20);

        return view('livewire.candidate-contact-list', [
            'candidates' => $candidates,
            'assemblies' => $this->assemblies,
        ])->layout('layouts.admin');
    }

}
