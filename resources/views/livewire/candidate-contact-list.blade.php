<div>
    <div class=" g-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Candidate Nomination List
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Candidates
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
         
        <div class="d-flex flex-wrap justify-content-md-center justify-content-lg-end align-items-center mb-4">
            <div class="btn-group flex-wrap gap-1">
                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_export_candidate'))
                    @if($filter_by_document=='partial')
                        <button class="btn btn-sm btn-outline-danger"
                                wire:click="exportPendingDocument">
                            <i class="bi bi-cloud-arrow-down me-1"></i> Export Candidate Wise Pending Documents
                        </button>
                    @endif
                    <a wire:click='exportCsv' class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-cloud-arrow-down me-1"></i>Export Candidate
                    </a>
                @endif

                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_import_candidate'))
                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadcandidateModal">
                    <i class="bi bi-upload me-1"></i>Upload Candidate
                </button>
                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#uploadExtraModal">
                    <i class="bi bi-file-earmark-excel me-1"></i>Upload Extra Details
                </button>
                @endif

                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_add_candidate'))
                <button class="btn btn-outline-primary btn-sm" wire:click="newCandidate" data-bs-toggle="modal"
                    data-bs-target="#candidateModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Candidate
                </button>
                @endif
            </div>
        </div>

        

        <!--  Main Content -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 ">
                <div class="bg-white">

                    <div class="row g-2 mb-4 justify-content-center align-items-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="canditate-search">
                                <input type="text"
                                wire:model="search" wire:keyup="filterCandidates($event.target.value)"
                                class="form-control form-control-sm"
                                placeholder="Search candidate...">

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </span>
                            </div>
                        </div>
                        @if(in_array($authUser->role, ['legal_associate', 'admin']))
                            <div class="col-md-2">
                                <div class="tooltip-wrapper position-relative">
                                    <button class="btn btn-sm btn-success d-flex align-items-center gap-1"
                                            onclick="SendMail()">
                                        <i class="bi bi-envelope-fill text-light"></i>
                                        Daily Report
                                    </button>

                                    <!-- Tooltip Message -->
                                    <span class="tooltip-text">
                                        Send Daily Report via email
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- 🔹 Row 1 -->
                    <div class="row g-2 mb-4">

                        <div class="col-md-4 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_assembly" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by Assembly</option>
                                @foreach ($assemblies as $assembly)
                                <option value="{{ $assembly->id }}">
                                    {{ $assembly->assembly_name_en }} -{{ $assembly->assembly_number }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_district" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ $district->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_phase" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by Phase</option>
                                @foreach ($phases as $phase)
                                    <option value="{{ $phase->id }}">
                                        {{ ucwords($phase->name) }}
                                        ({{ \Carbon\Carbon::parse($phase->last_date_of_nomination)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-lg-2">
                            <select wire:model="filter_by_status" class="form-select form-select-sm select-style" wire:change="filterByStatus($event.target.value)">
                                <option value="">Filter by Final Status</option>
                                @foreach (getFinalDocStatus() as $key => $status)
                                    <option value="{{ $key }}">
                                        {{ $status['icon'] }} {{ $status['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-lg-2">
                            <select wire:model="filter_by_document" class="form-select form-select-sm select-style" wire:change="filterByDocument($event.target.value)">
                                <option value="">Filter by Document Status</option>
                                <option value="all">All Documents Uploaded</option>
                                <option value="personal_doc">Missing Personal Informations</option>
                                <option value="missing">Missing Required Documents</option>
                                <option value="partial">Partially Uploaded Documents</option>
                            </select>
                        </div>

                        <div class="col-md-2 text-start text-md-end">

                            <!-- Reset Button -->
                            <button class="btn btn-sm btn-danger"
                                    wire:click="resetForm">
                                Reset Filters
                            </button>

                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-2">
                            {{ $candidates->total() }} Nominations
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Candidate</th>
                                    {{-- <th>Agent</th> --}}
                                    <th>Assembly</th>
                                    <th>Documents</th>
                                    <th >Final Status</th>
                                    <th style="width:91px;">Last Date of Nomination</th>
                                    <th>Form</th>
                                    <th style="max-width: 250px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidates as $candidate)
                                <tr wire:key="candidate-{{ $candidate->id }}">
                                    <td>
                                        {{ $candidates->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <div class="fw-semibold text-primary">
                                            {{ ucwords($candidate->name) }}
                                        </div>

                                        <div class="text-muted small">

                                            @if($candidate->email)
                                                <span>
                                                    <i class="bi bi-envelope-fill text-primary me-1"></i>
                                                    {{ $candidate->email }}
                                                </span>
                                                <br>
                                            @endif

                                            @if($candidate->contact_number)
                                                <span>
                                                    <i class="bi bi-telephone-fill text-success me-1"></i>
                                                    {{ $candidate->contact_number ?? '-' }}
                                                    @if($candidate->contact_number_alt_1)
                                                        , {{ $candidate->contact_number_alt_1 }}
                                                    @endif
                                                </span>
                                                <br>
                                            @endif

                                            <span>
                                                District: 
                                                {{ $candidate->assembly->district->name_en ?? 'N/A' }}
                                            </span>

                                        </div>
                                    </td>

                                    <td>
                                        <span>
                                            @if(!empty($candidate->assembly->assembly_number))
                                                {{ $candidate->assembly->assembly_number }} 
                                            @endif
                                            {{ $candidate->assembly->assembly_name_en ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                       @php
                                            $uploaded = $candidate->VedifiedDocuments->groupBy('type')->count();
                                        @endphp

                                        <span>
                                            <span
                                                class="{{ $uploaded == $required_document ? 'text-success' : 'text-danger' }}">{{
                                                $uploaded }}</span>/<span>{{ $required_document }}</span>
                                        </span>
                                    </td>
                                    
                                    <td>

                                        {{ getFinalDocStatus($candidate->document_collection_status, 'icon') }}
                                        {{ getFinalDocStatus($candidate->document_collection_status, 'label') }}
                                        <br>
                                        @if($candidate->is_criminal_offence == 1)
                                            <span class="badge bg-warning text-dark ms-1">
                                                Criminal Offence Case
                                            </span>

                                                @if($candidate->legalAssociate)
                                                    <div class="small text-muted mt-1">
                                                        Handled by: <strong>{{ $candidate->legalAssociate->name }}</strong>
                                                    </div>
                                                @else
                                                    <div class="small text-danger mt-1">
                                                        Legal Associate not assigned
                                                    </div>
                                                @endif
                                        @endif
                                    </td>

                                    <td>
                                        {{
                                            optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                                            ? \Carbon\Carbon::parse(
                                                optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                                            )->format('d M Y')
                                            : 'N/A'
                                        }}
                                    </td>

                                    <td class="">

                                    <div class="btn-group flex-wrap gap-1">
                                        {{-- Default when status is NULL --}}
                                        @if(is_null($candidate->status))
                                            <div class="tooltip-wrapper">
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                Upload
                                                </a>
                                                <span class="tooltip-text">Upload Candidate Documents</span>
                                            </div>

                                        {{-- Re-upload condition --}}
                                        @elseif($candidate->status == "without_criminal_rejected_observation_only")
                                            <div class="tooltip-wrapper">
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                Re-upload
                                                </a>
                                                <span class="tooltip-text">Upload Candidate Documents</span>
                                            </div>

                                        {{-- Preview condition --}}
                                        @elseif($candidate->status == "without_criminal_full_generation")
                                            <div class="tooltip-wrapper">
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                Preview
                                                </a>
                                                <span class="tooltip-text">Preview Candidate Documents</span>
                                            </div>
                                            <div class="tooltip-wrapper">
                                                <button wire:click="downloadAcknowledgement({{ $candidate->id }})"
                                                        class="btn btn-sm btn-outline-primary">
                                                         Acknowledgement
                                                </button>
                                                <span class="tooltip-text">Download Acknowledgement</span>
                                            </div>

                                        {{-- Fallback --}}
                                        @else
                                            <div class="tooltip-wrapper">
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                Upload
                                                </a>
                                                <span class="tooltip-text">Upload Candidate Documents</span>
                                                <span class="tooltip-text">Upload Candidate Documents</span>
                                            </div>
                                        @endif
                                            @if($candidate->nominationForm && $candidate->nominationForm->logs->count())
                                                <div class="tooltip-wrapper">
                                                    <button 
                                                            class="btn btn-sm btn-outline-primary"
                                                            wire:click="openFormModal({{ $candidate->id }})"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#formModal"
                                                        >
                                                        <i class="bi bi-download me-1"></i> Form 2B
                                                    </button>
                                                </div>
                                            @else
                                                <div class="tooltip-wrapper">
                                                    <a href="{{ route('admin.candidates.form2B', $candidate->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    Generate Form 2B
                                                    </a>
                                                    <span class="tooltip-text">Generate Form 2B PDF</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-group flex-wrap gap-1">
                                            @if($candidate->document_collection_status !== 'rejected')
                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_assign_agents'))
                                                <div class="tooltip-wrapper">
                                                    <button 
                                                        class="btn btn-sm btn-outline-{{ count($candidate->agents) > 0 ? 'primary' : 'danger' }}"
                                                        wire:click="openAgentModal({{ $candidate->id }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#assignAgentModal">
                                                        <i class="bi bi-people"></i>
                                                    </button>

                                                    <span class="tooltip-text">
                                                    {{ count($candidate->agents) > 0 ? 'View or Change Assigned Agent' : 'Assign Agent to Candidate' }}
                                                    </span>
                                                </div>
                                                @endif

                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_update_candidate'))
                                                <div class="tooltip-wrapper">
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="edit({{ $candidate->id }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#candidateModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <span class="tooltip-text">Edit Candidate</span>
                                                </div>
                                                @endif

                                            @endif

                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_candidate_journey_timeline'))
                                                <div class="tooltip-wrapper">
                                                    <a href="{{ route('admin.candidates.journey', $candidate->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-clock-history"></i>
                                                    </a>
                                                    <span class="tooltip-text">Candidate Journey Timeline</span>
                                                </div>
                                            @endif
                                            @if($candidate->nominationForm && $candidate->nominationForm->logs->count() && $candidate->status == "without_criminal_full_generation")
                                                <div class="tooltip-wrapper"> 
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="openEmailModal({{ $candidate->id }})">
                                                        <i class="bi bi-envelope"></i>
                                                    </button>
                                                    <span class="tooltip-text">Send Mail</span>
                                                </div>

                                                <div class="tooltip-wrapper">
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="openWhatsappModal({{ $candidate->id }})">
                                                        <i class="bi bi-whatsapp"></i>
                                                    </button>
                                                    <span class="tooltip-text">Send Whatsapp</span>
                                                </div>
                                            @endif
                                            </div>
                                        </td>

                                    <!-- modal -->
                                    <div class="modal fade" id="formModal-{{ $candidate->id }}" tabindex="-1"
                                        aria-labelledby="formModalLabel-{{ $candidate->id }}" aria-hidden="true" wire:ignore.self>
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">

                                                <!-- Modal Header -->
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="formModalLabel-{{ $candidate->id }}">
                                                        <i class="bi bi-file-earmark-text me-1"></i> Candidate Forms
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <a href="{{ route('admin.candidates.form2B', $candidate->id) }}"
                                                    class="btn btn-outline-primary w-100 mb-3">
                                                        <i class="bi bi-file-earmark"></i> FORM 2B
                                                    </a>

                                                    <div class="text-start">
                                                        <h6 class="fw-bold mb-2">Generated Form 2B PDF</h6>
                                                        @forelse($form2bLogs as $log)
                                                            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                                                                <div>
                                                                    <i class="bi bi-file-pdf text-danger me-1"></i>
                                                                    <small class="text-muted">
                                                                        {{ $log->created_at->format('d M Y, h:i A') }}
                                                                    </small>
                                                                </div>

                                                                <a href="{{ route('admin.candidates.log.pdf', $log->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                    Download
                                                                </a>
                                                            </div>
                                                        @empty
                                                            <p class="text-muted small">No Form 2B generated yet.</p>
                                                        @endforelse
                                                    </div>

                                                    <a href="{{ route('admin.candidates.form26', $candidate->id) }}"
                                                    class="btn btn-outline-primary w-100 mt-3">
                                                        <i class="bi bi-file-earmark"></i> FORM 26
                                                    </a>
                                                    <div class="text-start">
                                                        <h6 class="fw-bold mb-2">Generated Form 26 PDF</h6>
                                                        @forelse($form26Logs as $log)
                                                            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                                                                <div>
                                                                    <i class="bi bi-file-pdf text-danger me-1"></i>
                                                                    <small class="text-muted">
                                                                        {{ $log->created_at->format('d M Y, h:i A') }}
                                                                    </small>
                                                                </div>

                                                                <a href="{{ route('admin.candidates.log.pdf', $log->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                    Download
                                                                </a>
                                                            </div>
                                                        @empty
                                                            <p class="text-muted small">No Form 26 generated yet.</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        No candidates found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 d-flex flex-wrap  justify-content-between align-items-center">

                        <!-- Total Count -->
                        <div class="text-center text-md-start mb-4 mb-md-0">
                            Showing {{ $candidates->firstItem() }} to {{ $candidates->lastItem() }}
                            of {{ $candidates->total() }} entries
                        </div>

                        <!-- Pagination -->
                        <div>
                            {{ $candidates->links('pagination.custom') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- upload candidate modal --}}
    <div wire:ignore.self class="modal fade" id="uploadcandidateModal" tabindex="-1"
        aria-labelledby="uploadcandidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="uploadcandidateModalLabel">Upload Candidate</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Download Sample CSV -->
                        <div class="col-12">
                            <a href="{{ asset('assets/sample-csv/bulk-candidate.csv') }}" download
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download me-1"></i>Download Sample CSV
                            </a>
                        </div>

                        <!-- Upload Field -->
                        <div class="col-12">
                            <label for="candidateFile" class="form-label fw-semibold mt-3">Upload Candidate CSV</label>
                            <input type="file" class="form-control form-control-sm" id="candidateFile" wire:model="candidateFile" accept=".csv">

                            @error('candidateFile')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            @if($csvError)
                                <small class="text-danger d-block mt-1">{{ $csvError }}</small>
                            @endif

                            <!-- Uploading Loader -->
                            <div wire:loading wire:target="candidateFile" class="text-muted mt-2">
                                <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                        wire:click="resetForm">Close</button>

                    <!-- Upload button should appear only when NOT uploading -->
                    <button type="button" class="btn btn-primary btn-sm"
                        wire:click="saveCandidate"
                        wire:loading.remove
                        wire:target="candidateFile">
                        <i class="bi bi-upload me-1"></i>Upload
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload extra details of candidate--}}
    <div wire:ignore.self class="modal fade" id="uploadExtraModal" tabindex="-1"
    aria-labelledby="uploadExtraModalLabel" aria-hidden="true">
        
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Header -->
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="uploadExtraModalLabel">
                        Upload Extra Candidate Details
                    </h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        wire:click="resetForm"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12">
                            <a href="{{ asset('assets/sample-excel/candidate_more_details_sample.xlsx') }}" download
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download me-1"></i>Download Sample
                            </a>
                        </div>

                        <!-- File Input -->
                        <div class="col-12">
                            <label class="form-label fw-semibold mt-3">
                                Upload Excel File
                            </label>

                            <input type="file"
                                class="form-control form-control-sm"
                                wire:model="candidateFile"
                                accept=".xlsx,.xls">

                            @error('candidateFile')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Loader -->
                            <div wire:loading wire:target="candidateFile" class="text-muted mt-2">
                                <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal"
                            wire:click="resetForm">
                        Close
                    </button>

                    <button class="btn btn-sm btn-warning"
                            wire:click="importAdditionalDetails"
                            wire:loading.remove
                            wire:target="candidateFile">
                        <i class="bi bi-upload me-1"></i>Upload Extra Data
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!--  Candidate Modal -->
    <div wire:ignore.self class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="candidateModalLabel">
                        {{ $editMode ? 'Update Candidate' : 'Add Candidate' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>
                <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}"
                    wire:key="agent-form-{{ $editId ?? 'new' }}">
                    <div class="modal-body">
                        <div class="row">
                            {{-- ðŸ”¹ Agent Name --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" class="form-control">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ðŸ”¹ Designation --}}
                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" wire:model="designation" class="form-control">
                                @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div> --}}

                            {{-- ðŸ”¹ Email --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" wire:model="email" class="form-control">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ðŸ”¹ Contact Number --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" wire:model="contact_number" class="form-control">
                                @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- ðŸ”¹ Alt Contact Number --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alt Contact Number</label>
                                <input type="text" wire:model="contact_number_alt_1" class="form-control">
                                @error('contact_number_alt_1') <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label">Assemblies <span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select wire:model="assembly_id" id="assembly_id" class="form-select chosen-select">
                                        <option value="">Select one</option>
                                        @foreach ($assemblies as $assembly)
                                        <option value="{{ $assembly->id }}"  data-code="{{ $assembly->assembly_code }}"
                                           data-name="{{ $assembly->assembly_name_en }}"
                                           data-number="{{ $assembly->assembly_number }}">
                                            {{ $assembly->assembly_name_en }} -{{ $assembly->assembly_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assembly_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            wire:click="resetForm">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ $editMode ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignAgentModal" tabindex="-1" aria-labelledby="assignAgentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <!-- extra-large modal -->
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="assignAgentModalLabel">
                        <i class="bi bi-person-plus text-primary me-2"></i> Assign Agents
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @foreach ($agentsList as $index => $agent)
                     @php $key = $agent['id'] ?? $index; @endphp
                    <div class="row align-items-end mb-3" wire:key="agent-row-{{ $key }}">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="agentsList.{{ $index }}.name"
                                placeholder="Agent Name">
                            @error('agentsList.' . $index . '.name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Contact Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control"
                                wire:model.defer="agentsList.{{ $index }}.contact_number" placeholder="Primary Contact">
                            @error('agentsList.' . $index . '.contact_number')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Alternate Contact</label>
                            <input type="text" class="form-control"
                                wire:model.defer="agentsList.{{ $index }}.contact_number_alt_1"
                                placeholder="Alt Contact">
                            @error('agentsList.' . $index . '.contact_number_alt_1')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" wire:model.defer="agentsList.{{ $index }}.email"
                                placeholder="Email">
                            @error('agentsList.' . $index . '.email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 text-end mt-2">
                            @if($index > 0)
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="removeAgentRow({{ $index }})">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                            @endif
                        </div>
                        <hr class="my-2">
                    </div>
                    @endforeach

                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-success mt-2" wire:click="addAgentRow">
                            <i class="bi bi-plus-circle me-1"></i> Add More Agent
                        </button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button wire:click="saveAgents" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Save All
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- log modal --}}
    <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Form 2B</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if($candidateId)
                    <div class="mb-3">
                        <a href="{{ route('admin.candidates.form2B', $candidateId) }}"
                        class="btn btn-success w-100" onclick="$('#formModal').modal('hide')">
                            Generate New Form 2B
                        </a>
                    </div>
                    @endif
                    @if(count($form2bLogs) > 0)

                        <h6 class="mb-2">Previous Generated Forms</h6>

                        <table class="table table-bordered">
                            
                            <tbody>
                                @foreach($form2bLogs as $log)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-success"
                                                wire:click="openPrintPreview({{ $log->id }})"
                                            >
                                                <i class="bi bi-download me-1"></i> Form
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                        <div class="alert alert-warning text-center">
                            No Form 2B generated yet.
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

    <!-- EMAIL MODAL -->
    <div  class="modal fade {{ $is_active_email ? 'show d-block' : '' }}" 
        id="send_email_modal" 
        tabindex="-1"
        style="{{ $is_active_email ? 'background: rgba(0,0,0,0.5);' : '' }}">
        <div class="modal-dialog modal-{{count($emailLogs) > 0 ? "xl":"lg"}}">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">New mail</h5>
                            @if($selectedCandidate)
                                <small class="text-muted">
                                    {{ $selectedCandidate->name ?? 'N/A' }}
                                    | {{ $selectedCandidate->contact_number ?? 'N/A' }}
                                    | {{ $selectedCandidate->email ?? 'N/A' }}
                                    | {{ $selectedCandidate->assembly->assembly_name_en ?? 'N/A' }}
                                </small>
                            @endif
                    </div>
                    <button type="button" class="btn-close" wire:click="closeEmailWhatsappModal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <!-- LEFT: New Mail (col-8) -->
                        <div class="col-md-{{count($emailLogs) > 0 ? 8:"12"}} border-end">

                            <!-- Selected Emails -->
                            <div class="mb-2">
                                @foreach($emails as $index => $email)
                                    <span class="badge bg-primary me-1">
                                        {{ $email }}
                                        <span style="cursor:pointer;" wire:click="removeEmail({{ $index }})">
                                            &times;
                                        </span>
                                    </span>
                                @endforeach
                            </div>

                            <!-- Input -->
                            <div class="d-flex gap-2 mb-2">
                                <input type="text"
                                    class="form-control"
                                    placeholder="Enter email & press Enter"
                                    wire:model="emailInput"
                                    wire:keydown.enter.prevent="addEmail">

                                <button class="btn btn-secondary" wire:click="addEmail">Add</button>
                            </div>

                            {{-- <!-- Subject -->
                            <input type="text" class="form-control mb-2"
                                placeholder="Subject"
                                wire:model="subject">

                            <!-- Message -->
                            <textarea class="form-control mb-2"
                                rows="4"
                                placeholder="Write message..."
                                wire:model="message"></textarea> --}}

                            <!-- Send -->
                            @if(count($emails) > 0)
                                <button class="btn btn-success w-100" wire:click="sendEmail">
                                    Send Mail
                                </button>
                            @endif

                        </div>

                        <!-- RIGHT: Logs (col-4) -->
                        @if(count($emailLogs)>0)
                            <div class="col-md-4">

                                <h6>Email Logs</h6>

                                <div style="max-height:300px; overflow-y:auto;">
                                    @forelse($emailLogs as $log)
                                        <div class="border p-2 mb-2 rounded small">
                                            
                                            <strong>{{ $log->subject ?? 'No Subject' }}</strong><br>

                                            <span class="text-muted">
                                                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
                                            </span>

                                            <div>
                                                <b>To:</b>
                                                {{ implode(', ', json_decode($log->recipients, true)) }}
                                            </div>

                                        </div>
                                    @empty
                                        <p class="text-muted">No logs found</p>
                                    @endforelse
                                </div>

                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div  class="modal fade {{ $is_active_whatsapp ? 'show d-block' : '' }}" 
        id="send_whatsapp_modal" 
        tabindex="-1"
        style="{{ $is_active_email ? 'background: rgba(0,0,0,0.5);' : '' }}">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title">Email</h5>
                    <button type="button" class="btn-close" wire:click="closeEmailWhatsappModal"></button>
                </div>

                <div class="modal-body">
                    <p>hello email</p>

                    <button class="btn btn-success" wire:click="closeEmailWhatsappModal">
                        Send Email
                    </button>
                </div>

            </div>
        </div>
    </div>


    <div class="loader-container" wire:loading wire:target="saveCandidate,changeStatus,downloadAcknowledgement,openEmailModal,openWhatsappModal,closeEmailWhatsappModal,addEmail,removeEmail,sendEmail">
        <div class="loader"></div>
    </div>
    @push('scripts')
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
            window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
    </script>
    <script>
       window.addEventListener('ResetFormData', event => {

            document.querySelectorAll('input, textarea, select').forEach(el => {

                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                } 
                else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } 
                else {
                    el.value = '';
                }

            });

        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function initChosen() {
            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found",
                search_contains: true
            })
            .off('change')
            .on('change', function () {
                let model = $(this).attr('wire:model');
                if (model) {
                    @this.set(model, $(this).val());
                }
            });
        }
        Livewire.hook('morph.updated', ({ el, component }) => {
            initChosen();
            $('.chosen-select').each(function () {
                const el = $(this);
                const model = el.attr('wire:model');
                if (model && @this.get(model)) {
                    el.val(@this.get(model)).trigger('chosen:updated');
                }
            });
        });

        document.addEventListener('livewire:load', function () {
            initChosen();
        });

        Livewire.hook('message.processed', (message, component) => {
            initChosen();
        });

        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });

        $('#candidateModal').on('shown.bs.modal', function () {
            setTimeout(() => initChosen(), 150);
        });
    </script>

    <script>
        window.addEventListener('close-upload-modal', () => {
            $('#uploadcandidateModal').modal('hide');
        });
        window.addEventListener('close-extra-upload-modal', () => {
            $('#uploadExtraModal').modal('hide');
        });
        Livewire.on('refreshChosen', (value) => {

            setTimeout(() => {
                $('#assembly_id')
                    .val(value)
                    .trigger('chosen:updated');
            }, 100);

        });

        window.addEventListener('refreshChosen', () => {
            $('.chosen-select').trigger('chosen:updated');
        });

        window.addEventListener('clearSearch', () => {
            $('input[wire\\:model]').val('');
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('resetAllFilters', () => {
                $('.chosen-select').val('').trigger('chosen:updated');
                $('input[wire\\:model="search"]').val('');
            });
        });

        // function copyToClipboard(id) {
        //     let text = document.getElementById(id).innerText;
        //     navigator.clipboard.writeText(text);

        //     alert("Phone number copied!");
        // }

        function SendMail() {
            Swal.fire({
                title: "Send Mail?",
                text: "Are you sure you want to send the email?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Send Mail"
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: "Sending Mail...",
                        text: "Please wait while the email is being sent.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    @this.call('ConfirmSendMail');
                }

            });
        }
        function SendNotifyCandidateMail(id) {
            Swal.fire({
                title: "Send Mail?",
                text: "Are you sure you want to send the email to the Candidate?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Send Mail"
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: "Sending Mail...",
                        text: "Please wait while the email is being sent.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    @this.call('ConfirmSendNotifyMailMail', id);
                }

            });
        }


        document.addEventListener('livewire:init', () => {

            window.addEventListener('mail-sent-success', () => {

                Swal.fire({
                    icon: "success",
                    title: "Mail Sent!",
                    text: "Email successfully sent.",
                    confirmButtonColor: "#198754"
                });

            });

            window.addEventListener('mail-sent-failed', () => {
                Swal.fire({
                    icon: "error",
                    title: "Mail Failed",
                    text: event.message ?? "Something went wrong while sending mail.",
                    confirmButtonColor: "#d33"
                });

            });

        });
    </script>

    <script>
    document.addEventListener('livewire:init', () => {

        Livewire.on('openNewTab', ({ url }) => {
            window.open(url, '_blank');
        });

    });
    </script>

    @endpush
</div>