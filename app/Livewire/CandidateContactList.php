<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Assembly;
use App\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CandidateContactList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $name, $designation, $email, $contact_number, $contact_number_alt_1, $contact_number_alt_2, $assembly_id,$agent_id, $type = 'Candidate';
    public $assemblies,$agents;
    public $editMode = false;
    public $editId;

    public $candidateFile, $csvError = null;
    protected $rules = [
        'candidateFile' => 'required|file|mimes:csv,txt', 
    ];

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
                'assembly_code', 'agent_name', 'agent_email',
                'candidate_name', 'candidate_email', 'candidate_mobile', 'candidate_alternative_mobile'
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

                $assembly = DB::table('assemblies')
                    ->where('assembly_code', $data['assembly_code'])
                    ->first();

                if (!$assembly) {
                    throw new \Exception("Row " . ($index + 2) . ": Invalid assembly code.");
                }

                $assembly_id = $assembly->id;
                $agent_id = null;

                if (!empty($data['agent_email'])) {
                    if (empty($data['agent_name'])) {
                        throw new \Exception("Row " . ($index + 2) . ": Agent name required when agent email is provided.");
                    }

                    $agent = DB::table('agents')
                        ->where('email', $data['agent_email'])
                        ->first();

                    if ($agent) {
                        $agent_id = $agent->id;
                    } else {
                        $agent_id = DB::table('agents')->insertGetId([
                            'name' => $data['agent_name'],
                            'email' => $data['agent_email'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                DB::table('candidates')->updateOrInsert(
                    [
                        'assembly_id' => $assembly_id,
                    ],
                    [
                        'name' => $data['candidate_name'],
                        'email' => $data['candidate_email'],
                        'contact_number' => $data['candidate_mobile'],
                        'contact_number_alt_1' => $data['candidate_alternative_mobile'] ?? null,
                        'type' => 'Candidate',
                        'agent_id' => $agent_id,
                        'updated_at' => now(),
                        'created_at' => now(), 
                    ]
                );

            }

            DB::commit();

            unlink($file);
            $this->reset(['candidateFile']);
            
            $this->dispatch('close-upload-modal');
            $this->dispatch('toastr:success', message: 'CSV uploaded successfully.');

            // session()->flash('success', 'CSV uploaded successfully.');

        }  catch (\Exception $e) {
            //dd($e->getMessage());
            DB::rollBack();

            $errorMessage = $e->getMessage();

            if (str_contains($errorMessage, 'Invalid CSV header')) {
                $this->csvError = 'Your CSV file format is incorrect. Please use the sample format.';
            } elseif (str_contains($errorMessage, 'Invalid assembly code')) {
                $this->csvError = 'One or more Assembly Codes are invalid. Please verify and re-upload.';
            } elseif (str_contains($errorMessage, 'required')) {
                $this->csvError = 'Please make sure all mandatory fields are filled in.';
            } elseif (str_contains(strtolower($errorMessage), 'duplicate') || str_contains(strtolower($errorMessage), 'unique')) {
                $this->csvError = 'Some emails already exist in the system. Please ensure all agent or candidate emails are unique.';
            } else {
                $this->csvError = 'Something went wrong while processing your CSV. Please try again.';
            }
        }

    }

    // public function saveCandidate()
    // {
    //     $this->validate([
    //         'candidateFile' => 'required|file|mimes:csv,txt|max:10240',
    //     ]);

    //     $this->csvError = null;

    //     try {
    //         $path = $this->candidateFile->store('temp', 'public');
    //         $file = Storage::disk('public')->path($path);

    //         $rows = array_map('str_getcsv', file($file));
    //         $header = array_map('trim', array_shift($rows));

    //         $expectedHeaders = [
    //             'assembly_code', 'agent_name', 'agent_email',
    //             'candidate_name', 'candidate_email', 'candidate_mobile', 'candidate_alternative_mobile'
    //         ];

    //         if ($header !== $expectedHeaders) {
    //             throw new \Exception("Invalid CSV header format. Please use the provided sample CSV.");
    //         }

    //         DB::beginTransaction();

    //         foreach ($rows as $index => $row) {
    //             $data = array_combine($header, array_map('trim', $row));

    //             if (empty($data['assembly_code'])) {
    //                 throw new \Exception("Row " . ($index + 2) . ": Assembly code is required.");
    //             }

    //             if (empty($data['candidate_name']) || empty($data['candidate_mobile'])) {
    //                 throw new \Exception("Row " . ($index + 2) . ": Candidate name and mobile are required.");
    //             }

    //             $assembly = Assembly::where('assembly_code', $data['assembly_code'])->first();

    //             if (!$assembly) {
    //                 throw new \Exception("Row " . ($index + 2) . ": Invalid assembly code.");
    //             }

    //             $assembly_id = $assembly->id;
    //             $agent_id = null;

    //             if (!empty($data['agent_email'])) {
    //                 if (empty($data['agent_name'])) {
    //                     throw new \Exception("Row " . ($index + 2) . ": Agent name required when agent email is provided.");
    //                 }

    //                 $agent = Agent::where('email', $data['agent_email'])->first();

    //                 if ($agent) {
    //                     $agent_id = $agent->id;
    //                 } else {
    //                     $agent = Agent::create([
    //                         'name' => $data['agent_name'],
    //                         'email' => $data['agent_email'],
    //                     ]);
    //                     $agent_id = $agent->id;
    //                 }
    //             }

    //             Candidate::updateOrCreate(
    //                 [
    //                     'assembly_id' => $assembly_id
    //                 ],
    //                 [
    //                     'name' => $data['candidate_name'],
    //                     'email' => $data['candidate_email'],
    //                     'contact_number' => $data['candidate_mobile'],
    //                     'contact_number_alt_1' => $data['candidate_alternative_mobile'] ?? null,
    //                     'type' => 'Candidate',
    //                     'agent_id' => $agent_id,
    //                 ]
    //             );

    //         }

    //         DB::commit();

    //         unlink($file);
    //         $this->reset(['candidateFile']);

    //         $this->dispatch('close-upload-modal');
    //         $this->dispatch('toastr:success', message: 'CSV uploaded successfully.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         $errorMessage = $e->getMessage();

    //         if (str_contains($errorMessage, 'Invalid CSV header')) {
    //             $this->csvError = 'Your CSV file format is incorrect. Please use the sample format.';
    //         } elseif (str_contains($errorMessage, 'Invalid assembly code')) {
    //             $this->csvError = 'One or more Assembly Codes are invalid. Please verify and re-upload.';
    //         } elseif (str_contains($errorMessage, 'required')) {
    //             $this->csvError = 'Please make sure all mandatory fields are filled in.';
    //         } elseif (str_contains(strtolower($errorMessage), 'duplicate') || str_contains(strtolower($errorMessage), 'unique')) {
    //             $this->csvError = 'Some emails already exist in the system. Please ensure all agent or candidate emails are unique.';
    //         } else {
    //             $this->csvError = 'Something went wrong while processing your CSV. Please try again.';
    //         }
    //     }
    // }



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
