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
use App\Models\NominationLog;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Mail;
use App\Mail\NominationVettingMail;
use Carbon\Carbon;
use App\Models\Admin;
use App\Mail\NominationVettingCompletedMail;

class CandidateContactList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter_by_status,$name,$filter_by_document, $designation, $email, $contact_number, $contact_number_alt_1, $contact_number_alt_2, $assembly_id, $type = 'Candidate';
    public $assemblies,$districts,$phases;
    public $editMode = false;
    public $editId,$candidateId,$required_document;
    public $authUser;
    public $agentsList = [];
    public $filter_by_document_array = [];
    public $filter_by_personal_document;
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

    public function openAgentModal($candidateId)
    {
        $this->candidateId = $candidateId;

        // Reset previous data
        $this->reset('agentsList');

        $agents = CandidateAgent::where('candidate_id', $candidateId)
            ->with('agent')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->agent_id,
                    'name' => optional($item->agent)->name,
                    'contact_number' => optional($item->agent)->contact_number,
                    'contact_number_alt_1' => optional($item->agent)->contact_number_alt_1,
                    'email' => optional($item->agent)->email,
                ];
            })
            ->values() // important for Livewire indexing
            ->toArray();

        // If no agents exist, create one empty row
        $this->agentsList = count($agents) > 0 ? $agents : [[
            'id' => null,
            'name' => '',
            'contact_number' => '',
            'contact_number_alt_1' => '',
            'email' => ''
        ]];
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

            $agentsPayload = []; 

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
                        'designation' => 'Election Agent',
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
             dd($e->getMessage());
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
    public function filterByStatus($filter_by_status)
    {
        $this->filter_by_status = $filter_by_status;
    }
    public function filterByDocument($filter_by_document)
    {
        if($filter_by_document=='all'){
            $this->filter_by_document_array = [
                'verified_pending_submission',
                'ready_for_vetting',
            ];
        }elseif($filter_by_document=='missing'){
            $this->filter_by_document_array = [
                'not_received_form',
                'rejected'
            ];
        }elseif($filter_by_document=='partial'){
            $this->filter_by_document_array = [
                'incomplete_additional_required',
                'vetting_in_progress'
            ];
        }elseif($filter_by_document=='personal_doc'){
            $this->filter_by_document_array = [];
            $this->filter_by_personal_document = 'personal_doc';
        }else{
            $this->filter_by_document_array = [];
        }
    }
    public function edit($id)
    {
        // $this->resetForm(); 
        $this->editMode = true;

        $candidate = Candidate::findOrFail($id);

        $this->editId = $id;
        $this->name = $candidate->name;
        $this->designation = $candidate->designation;
        $this->email = $candidate->email;
        $this->contact_number = $candidate->contact_number;
        $this->contact_number_alt_1 = $candidate->contact_number_alt_1;
        $this->assembly_id = $candidate->assembly_id;


        $assignedIds = $this->getInvalidAssembly($candidate->assembly_id);

  
        $this->assemblies = Assembly::orderBy('assembly_name_en')
            ->whereNotIn('id', $assignedIds)
            ->get();

        $this->dispatch('refreshChosen', $this->assembly_id);
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

        // Trigger chosen refresh
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
        $this->reset(['name', 'designation', 'email', 'contact_number', 'contact_number_alt_1', 
        'assembly_id', 'editMode', 'editId',  'search',
        'filter_by_assembly','filter_by_document', 'filter_by_personal_document', 'filter_by_document_array', 'filter_by_status',
        'filter_by_district',
        'filter_by_phase',]);
        $this->search = '';
        $this->dispatch('ResetFormData');
        $this->dispatch('refreshChosen');
        $this->dispatch('clearSearch');
        $this->dispatch('resetAllFilters');
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

                // Candidate Name is required
                if (empty($data['candidate_name'])) {
                    throw new \Exception("Row " . ($index + 2) . ": Candidate name is required.");
                }

                // Candidate Mobile is optional, but if given must be exactly 10 digits
                if (!empty($data['candidate_mobile']) && 
                    !preg_match('/^[0-9]{10}$/', $data['candidate_mobile'])) {
                    
                    throw new \Exception("Row " . ($index + 2) . ": Candidate mobile must be exactly 10 digits.");
                }

                // Candidate Email validation
                if (isset($data['candidate_email']) && 
                    $data['candidate_email'] !== '' && 
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
            // dd($e->getMessage());
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

    private function getFilteredQuery()
    {
        return Candidate::query()
            // ->where('id',7)
            ->where('type', 'Candidate')
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

            ->when($this->filter_by_personal_document, function ($q) {

                $q->where(function ($query) {

                    // Case 1
                    $query->where(function ($sub) {
                        $sub->whereNull('contact_number')
                            ->orWhere('contact_number', '')
                            ->whereDoesntHave('agents');
                    })

                    // Case 2
                    ->orWhere(function ($sub) {
                        $sub->whereNotNull('contact_number')
                            ->where('contact_number', '!=', '')
                            ->whereDoesntHave('agents');
                    })

                    // Case 3
                    ->orWhere(function ($sub) {
                        $sub->where(function ($c) {
                            $c->whereNull('contact_number')
                            ->orWhere('contact_number', '');
                        })->whereHas('agents');
                    });

                });

            })
            ->when($this->filter_by_assembly, fn($q) => $q->where('assembly_id', $this->filter_by_assembly))
            ->when($this->filter_by_district, fn($q) => $q->whereHas('assembly.district', fn($d) => $d->where('id', $this->filter_by_district)))
            ->when($this->filter_by_phase, fn($q) => $q->whereHas('assembly.assemblyPhase', fn($p) => $p->where('phase_id', $this->filter_by_phase)))
        ->with([
            'assembly.district',
            'assembly.assemblyPhase.phase',
            'documents',
            'agents'
        ]);
    }

    public function exportCsv()
    {
        $data = $this->getFilteredQuery()
            ->join('assemblies', 'candidates.assembly_id', '=', 'assemblies.id')
            ->orderBy('assemblies.assembly_number', 'asc')
            ->select('candidates.*') 
            ->get();

        return $this->downloadCsv($data, 'candidates_export.csv');
    }

    public function downloadCsv($data, $filename)
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Candidate Name',
            'Candidate Phone',
            'Assembly Code',
            'District',
            'Phase',
            'Last Date of Nomination',
            'Election Date',
            'Last Date of MCC',
            'Document Pending',
            'Final Status',
            'Agent Name',
            'Agent Phone'
        ];

        $callback = function () use ($data, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

                foreach ($data as $item) {

                    $assembly = $item->assembly;
                    $district = optional($assembly)->district;
                    $phase = optional(optional($assembly)->assemblyPhase)->phase;

                    $required = $this->required_document ?? 5;
                    $uploaded = $item->documents->groupBy('type')->count();
                    $pending = max(0, $required - $uploaded);

                    $agents = $item->agents;

                    // Candidate row
                    fputcsv($file, [
                        $item->name,
                        $item->contact_number,
                        $assembly ? $assembly->assembly_code . ' - ' . $assembly->assembly_name_en : '',
                        $district->name_en ?? '',
                        $phase->name ?? '',
                        $phase->last_date_of_nomination ?? '',
                        $phase->date_of_election ?? '',
                        $phase->last_date_of_mcc ?? '',
                        $pending,
                        $item->document_collection_status ?? '',
                        '', ''
                    ]);

                    // Agent rows
                    foreach ($agents as $agent) {

                        fputcsv($file, [
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $agent->name,
                            $agent->contact_number,
                        ]);
                    }
                }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function openFormModal($candidateId)
    {
        $this->candidateId = $candidateId;

        $this->form2bLogs = NominationLog::whereHas('nomination', function ($q) use ($candidateId) {
            $q->where('candidate_id', $candidateId)
            ->where('form_type', 'form_2b');
        })
        ->latest()
        ->get();

        $this->form26Logs = NominationLog::whereHas('nomination', function ($q) use ($candidateId) {
            $q->where('candidate_id', $candidateId)
            ->where('form_type', 'form_26');
        })
        ->latest()
        ->get();
    }

    public function exportPendingDocument()
    {
        $data = $this->getFilteredQuery()->orderByDesc('id')->get();

        $required_doc = CandidateDocumentType::pluck('name', 'key')->toArray();

        $rows = [];

        // Header
        $rows[] = ['Assembly Code', 'Candidate Name', 'Document', 'Status', 'Time'];

        foreach ($data as $item) {

            $assemblyCode = optional($item->assembly)->assembly_code ?? 'N/A';
            $candidateName = $item->name ?? 'N/A';

            $documents = $item->documents
                ->groupBy('type')
                ->map(function ($docs) {
                    return $docs->sortByDesc('created_at')->first(); // latest per type
                });

            foreach ($required_doc as $docKey => $docName) {

                if (isset($documents[$docKey])) {

                    $latest = $documents[$docKey];

                    // Only latest Rejected
                    if ($latest->status === 'Rejected') {

                        $rows[] = [
                            $assemblyCode,
                            $candidateName,
                            $docName,
                            'Rejected',
                            $latest->created_at->format('d M Y, h:i A')
                        ];
                    }

                } else {

                    // Not uploaded
                    $rows[] = [
                        $assemblyCode,
                        $candidateName,
                        $docName,
                        'Not Uploaded',
                        ''
                    ];
                }
            }
        }

        return Excel::download(
            new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray {

                protected $rows;

                public function __construct($rows)
                {
                    $this->rows = $rows;
                }

                public function array(): array
                {
                    return $this->rows;
                }

            },
            'candidate_pending_documents.xlsx'
        );
    }

    public function ConfirmSendMail($id)
    {
        $legal_associate = Admin::where('role','legal_associate')->pluck('email')->toArray();

        DB::beginTransaction();

        try {

            $candidate = Candidate::findOrFail($id);
            $data = [
                'candidate' => $candidate,

                'ac' => optional($candidate->assembly)->assembly_code . ' | ' .
                    optional($candidate->assembly)->assembly_name_en .
                    ' (' . optional($candidate->assembly)->assembly_name_bn . ')',

                'nominationDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination)->format('d M Y')
                    : 'N/A',

                'electionDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election)->format('d M Y')
                    : 'N/A',

                'link' => route('admin.candidates.documents.vetting',$candidate->id),
            ];

            foreach ($legal_associate as $email) {

                Mail::to($email)->send(
                    new NominationVettingMail($data)
                );
            }

            DB::commit();

            $this->dispatch('mail-sent-success');

        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();

            $this->dispatch('mail-sent-failed', message: $e->getMessage());
        }
    }
    public function ConfirmSendNotifyMailMail($id)
    {
        DB::beginTransaction();

        try {

            $candidate = Candidate::findOrFail($id);

            $data = [
                'candidate' => $candidate,

                'ac' => optional($candidate->assembly)->assembly_code . ' | ' .
                    optional($candidate->assembly)->assembly_name_en .
                    ' (' . optional($candidate->assembly)->assembly_name_bn . ')',

                'nominationDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination)->format('d M Y')
                    : 'N/A',

                'electionDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election)->format('d M Y')
                    : 'N/A',

            ];
            // send mail to candidate
            if (!empty($candidate->email)) {
                Mail::to($candidate->email)->send(
                    new NominationVettingCompletedMail($data)
                );
            }
            

            DB::commit();
            $this->dispatch('mail-sent-success');

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatch('mail-sent-failed', message: $e->getMessage());
        }
    }
    public function render()
    {
        $candidates = $this->getFilteredQuery()
        ->orderByDesc('id')
        ->paginate(20);

        // if ($this->authUser->role === "legal_associate") {
        //     $collection = $candidates->getCollection();

        //     $filtered = $collection->filter(function ($candidate) {
        //         if (!$candidate) return false;

        //         $uploaded_documents = $candidate->documents->groupBy('type')->count();
        //         return $uploaded_documents == $this->required_document;
        //     })->values();

        //     $candidates->setCollection($filtered);
        // }

        $this->dispatch('resetTooltip');
        return view('livewire.candidate-contact-list', [
            'candidates' => $candidates,
            'assemblies' => $this->assemblies,
        ])->layout('layouts.admin');
    }
}
