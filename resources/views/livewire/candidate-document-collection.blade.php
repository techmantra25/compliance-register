<div>
    <style>
        .delete-btn-padding{
            padding: 0px 2px;
        }
        .file-format-size{
            font-size: 9px;
        }
          .upload-history {
        max-height: 200px;
        overflow-y: auto;
    }
    
    .upload-item {
        padding: 8px;
        border-radius: 4px;
        background: #f8f9fa;
    }
    
    .upload-item:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .upload-details {
        font-size: 0.75rem;
    }
    .badge {
        font-size: 0.65rem;
    }
    body.modal-open {
    overflow: hidden;
    padding-right: 17px;
    }
    </style>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
        {{-- Left Section: Title + Candidate Info --}}
        <div class="mb-2">
            <h4 class="fw-bold mb-2 text-dark">Document Collections</h4>
        </div>
        
        {{-- Right Section: Upload Acknowledgement Copy + Back Button --}}
        <div class="d-flex flex-column align-items-end gap-2">
            {{-- Back Button --}}
            <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-3 mb-3 mx-1">
                <div class="card-body">
                    <table class="table table-sm table-borderless w-auto mb-0">
                        <tbody>
                            <tr>
                                <th class="text-nowrap pe-3">Candidate Name</th>
                                <td>: {{ $candidateName ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap pe-3">Assembly Name & No</th>
                                <td>: {{ $assemblyName ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap pe-3 align-top">Agent Details</th>
                                <td>
                                    @if($candidateData->agents && $candidateData->agents->count() > 0)
                                    <ul class="mb-0 ps-3">
                                        @foreach($candidateData->agents as $agent)
                                        <li>
                                            <strong>{{ ucwords($agent->name) }}</strong>
                                            — {{ $agent->contact_number ?? 'N/A' }}
                                            @if(!empty($agent->contact_number_alt_1))
                                            , {{ $agent->contact_number_alt_1 }}
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    : N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap pe-3">Phase</th>
                                <td>: {{ $phase ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap pe-3">Last Date of Submission of Nomination Form</th>
                                <td>: {{ \Carbon\Carbon::parse($nomination_date)->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap pe-3">Final Status</th>
                                <td>
                                    : {{ getFinalDocStatus($candidateData->document_collection_status, 'icon') }}
                                    {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Documents Approved By</th>
                                <td>
                                    : {{$documents_approved_by}}
                                </td>
                            </tr>
                            @if($candidateData->is_special_case == 1)
                            <tr>
                                <th class="text-nowrap pe-3 align-top">Special Case Details</th>

                                <td>
                                    <div class="border border-danger rounded p-3 bg-light shadow-sm">

                                        <!-- Label -->
                                        <div class="mb-1">
                                            <span class="badge bg-danger px-3 py-2 fs-6">
                                                <i class="bi bi-exclamation-diamond me-1"></i>
                                                {{ $candidateData->special_case_label ?? 'Special Case' }}
                                            </span>
                                        </div>

                                        <!-- Remarks -->
                                        @if($candidateData->clone_remarks)
                                        <div class="mt-2 text-muted small">
                                            <i class="bi bi-chat-left-quote me-1"></i>
                                            <strong>Remarks:</strong>
                                            <span class="ms-1">{{ $candidateData->clone_remarks }}</span>
                                        </div>
                                        @endif

                                        <!-- Clone Meta Info -->
                                        <div class="mt-2 text-muted small">

                                            @if($candidateData->clonedBy)
                                            <div>
                                                <i class="bi bi-person-check me-1"></i>
                                                <strong>Created By:</strong>
                                                {{ $candidateData->clonedBy->name }}
                                            </div>
                                            @endif

                                            @if($candidateData->cloned_at)
                                            <div>
                                                <i class="bi bi-clock-history me-1"></i>
                                                <strong>Created At:</strong>
                                                {{ \Carbon\Carbon::parse($candidateData->cloned_at)->format('d M Y, h:i A') }}
                                            </div>
                                            @endif

                                        </div>

                                    </div>
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($candidateData->document_collection_status=="verified_pending_submission" || $candidateData->document_collection_status=="verified_submitted_with_copy")
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        @if(count($acknowledgmentCopies) == 0 || (count($acknowledgmentCopies) > 0 &&
                        $acknowledgmentCopies['0']->status == 'rejected'))
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-cloud-arrow-up text-primary me-2"></i>
                                Upload Acknowledgement Copy
                            </h6>

                            <form wire:submit.prevent="saveAcknowledgment">

                                <!-- Upload Box -->
                                <div
                                    class="custom-upload-box mb-1 @error('acknowledgment_file') border border-danger @enderror">
                                    <input type="file" wire:model="acknowledgment_file" class="form-control file-input"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.bmp,.webp">

                                    <div class="upload-label">
                                        <i class="bi bi-cloud-upload fs-3"></i>
                                        <p class="mb-0 small">Click to choose a file or drag & drop</p>
                                    </div>
                                </div>

                                @error('acknowledgment_file')
                                <div class="text-danger small">
                                    <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                </div>
                                @enderror

                                <!-- Loader -->
                                <div wire:loading wire:target="acknowledgment_file" class="text-center my-2">
                                    <div class="spinner-border spinner-border-sm text-primary"></div>
                                    <span class="ms-2 small">Uploading...</span>
                                </div>

                                <!-- Final Submission Date -->
                                @if($acknowledgment_file)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">
                                        Final Submission Confirmation (RO Office)
                                    </label>
                                    <input type="datetime-local" wire:model="final_submission_confirmation"
                                        class="form-control form-control-sm">
                                    @error('final_submission_confirmation')
                                        <div class="text-danger small">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @endif

                                <!-- Save Button -->
                                @if($acknowledgment_file)
                                <button type="button" class="btn btn-primary w-100 mt-3 rounded-pill"
                                    onclick="confirmAckUpload()">
                                    <i class="bi bi-upload me-1"></i> Save Acknowledgment Copy
                                </button>
                                @endif

                            </form>

                            @if(count($acknowledgmentCopies) > 0 && $acknowledgmentCopies[0]->status == 'rejected')

                                <div class="card border-danger shadow-sm mt-3">
                                    <div class="card-body">

                                        <!-- Header -->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold text-danger mb-0">
                                                <i class="bi bi-x-circle me-1"></i> Acknowledgement Copy (Rejected)
                                            </h6>

                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="bi bi-exclamation-octagon me-1"></i> Rejected
                                            </span>
                                        </div>

                                        <!-- Details -->
                                        <div class="text-muted small">

                                            <div class="mb-1">
                                                <i class="bi bi-clock-history me-1 text-danger"></i>
                                                <strong>Rejected At:</strong>
                                                {{ \Carbon\Carbon::parse($acknowledgmentCopies[0]->acknowledgment_at)->format('d M Y, h:i A') }}
                                            </div>

                                            <div class="mb-1">
                                                <i class="bi bi-person-x me-1 text-danger"></i>
                                                <strong>Rejected By:</strong>
                                                {{ $acknowledgmentCopies[0]->acknowledger->name ?? 'N/A' }}
                                            </div>

                                            @if($acknowledgmentCopies[0]->rejected_reason)
                                            <div class="mb-1">
                                                <i class="bi bi-chat-left-quote me-1 text-danger"></i>
                                                <strong>Reason:</strong> 
                                                {{ $acknowledgmentCopies[0]->rejected_reason }}
                                            </div>
                                            @endif

                                            <div class="mb-1">
                                                <i class="bi bi-upload me-1 text-secondary"></i>
                                                <strong>Uploaded By:</strong>
                                                {{ $acknowledgmentCopies[0]->uploader->name ?? 'N/A' }}
                                            </div>

                                            <div>
                                                <i class="bi bi-calendar2-check me-1 text-secondary"></i>
                                                <strong>Uploaded At:</strong>
                                                {{ \Carbon\Carbon::parse($acknowledgmentCopies[0]->uploaded_at)->format('d M Y, h:i A') }}
                                            </div>

                                        </div>

                                        <!-- View Button -->
                                        <div class="mt-3 text-end">
                                            <a href="{{ asset($acknowledgmentCopies[0]->path) }}" 
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="bi bi-eye"></i> View Document
                                            </a>
                                        </div>

                                    </div>
                                </div>

                            @endif


                        @else
                            <ul class="nav nav-tabs" id="ackTabs" role="tablist">

                                <!-- TAB 1 – Latest Acknowledgement Copy -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="ack-copy-tab" data-bs-toggle="tab"
                                        data-bs-target="#ack-copy" type="button" role="tab">
                                        <i class="bi bi-file-earmark-text me-1"></i>
                                        Latest Copy
                                    </button>
                                </li>

                                <!-- TAB 2 – HISTORY -->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                                        type="button" role="tab">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Upload History
                                    </button>
                                </li>

                            </ul>

                            <div class="tab-content" id="ackTabsContent">

                                <!-- ==================== TAB 1 : LATEST COPY ==================== -->
                                <div class="tab-pane fade show active" id="ack-copy" role="tabpanel">

                                    @php
                                    $latest = $acknowledgmentCopies->first();
                                    @endphp

                                    @if($latest)
                                        <div class="border rounded p-3 mb-2 shadow-sm bg-light">

                                            <!-- Header -->
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    <strong>Acknowledgement Copy</strong>
                                                </div>

                                                <div>
                                                    @if($latest->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($latest->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Uploaded Details -->
                                            <div class="text-muted small mt-2">
                                                <div>
                                                    <i class="bi bi-cloud-arrow-up me-1"></i>
                                                    Uploaded At:  
                                                    {{ \Carbon\Carbon::parse($latest->uploaded_at)->format('d M Y, h:i A') }}
                                                </div>

                                                <div>
                                                    <i class="bi bi-person me-1"></i>
                                                    Uploaded By: {{ $latest->uploader->name ?? 'N/A' }}
                                                </div>

                                                @if($latest->final_submission_confirmation)
                                                <div>
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    Final Submission Confirmation (RO office):
                                                    {{ \Carbon\Carbon::parse($latest->final_submission_confirmation)->format('d M Y, h:i A') }}
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Approve / Reject Info -->
                                            <div class="text-muted small mt-3">
                                                @if($latest->status != 'pending')
                                                    <div>
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $latest->status == 'approved' ? 'Acknowledged At:' : 'Rejected At:' }}
                                                        {{ \Carbon\Carbon::parse($latest->acknowledgment_at)->format('d M Y, h:i A') }}
                                                    </div>

                                                    <div>
                                                        <i class="bi bi-person-check me-1"></i>
                                                        {{ $latest->status == 'approved' ? 'Acknowledged By:' : 'Rejected By:' }}
                                                        {{ $latest->acknowledger->name ?? 'N/A' }}
                                                    </div>
                                                @endif

                                                @if($latest->status == 'rejected' && $latest->rejected_reason)
                                                    <div>
                                                        <i class="bi bi-x-circle me-1"></i>
                                                        Rejection Reason: {{ $latest->rejected_reason }}
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Button -->
                                            <div class="mt-3">
                                                <a href="{{ asset($latest->path) }}" target="_blank"
                                                    class="btn btn-sm btn-primary rounded-pill px-3">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </div>

                                        </div>

                                        @else
                                        <div class="text-center text-muted py-4">
                                            No acknowledgement copy uploaded yet.
                                        </div>
                                        @endif


                                </div>

                                <!-- ==================== TAB 2 : HISTORY ==================== -->
                                <div class="tab-pane fade" id="history" role="tabpanel">


                                    @php
                                    $history = $acknowledgmentCopies->slice(1); // all except latest
                                    @endphp

                                    @if($history->count() > 0)

                                    @foreach($history as $copy)
                                    <div class="border rounded p-3 mb-2 shadow-sm bg-light">

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="bi bi-file-earmark-text me-2"></i>
                                                <strong>Acknowledgement Copy</strong>
                                            </div>

                                            <div>
                                                @if($copy->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                                @elseif($copy->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                                @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-muted small mt-2">
                                            <div><i class="bi bi-clock me-1"></i>
                                                {{$copy->status== 'approved' ? 'Acknowledged At' : 'Rejected At'}}:
                                                {{ \Carbon\Carbon::parse($copy->acknowledgment_at)->format('d M Y, h:i A') }}
                                            </div>

                                            <div><i class="bi bi-person me-1"></i>
                                                {{$copy->status== 'approved' ? 'Acknowledged' : 'Rejected'}} By:
                                                {{ $copy->acknowledger->name ?? 'N/A' }}
                                            </div>

                                            @if($copy->status == 'rejected' && $copy->rejected_reason)
                                            <div><i class="bi bi-x-circle me-1"></i>
                                                Reason: {{ $copy->rejected_reason }}
                                            </div>
                                            @endif
                                        </div>

                                        <div class="mt-2">
                                            <a href="{{ asset($copy->path) }}" target="_blank"
                                                class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </div>

                                    </div>
                                    @endforeach

                                    @else
                                    <div class="text-center text-muted py-4">
                                        No previous uploads found.
                                    </div>
                                    @endif

                                </div>

                            </div>

                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="card shadow-sm border-0 p-3 mt-4">
        <div class="card-body">
            {{-- File Upload --}}
            
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-bordered">
                   <thead class="table-light">
                        <tr class="text-center">
                            <th width="18%">Document Name</th>
                            <th width="10%">Upload History</th>
                            <th width="14%">Date & Time</th>
                            <th width="8%">Status</th>
                            <th width="18%">Remarks by Data uploader</th>
                            <th width="18%">Action</th>
                            <th width="8%">Upload Now</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($availableDocuments as $key => $label)
                            @if(isset($documents[$key]) && count($documents[$key]) > 0)
                                @foreach($documents[$key] as $index => $doc)
                                    @php
                                        $extension = pathinfo($doc['path'], PATHINFO_EXTENSION);
                                        $fileName  = pathinfo($doc['path'], PATHINFO_FILENAME);
                                        $rowspan = count($documents[$key]);
                                    @endphp

                                    <tr class="">
                                        {{-- Document Name (only once per document type) --}}
                                        @if($index === 0)
                                            <td rowspan="{{ $rowspan }}"><strong>{{ $label }}</strong></td>
                                        @endif

                                        {{-- File Name + Icon --}}
                                    <td onclick="window.location='{{ route('admin.candidates.documents.comments', $doc['id']) }}'"
                                        style="cursor: pointer;"
                                        title="Click to view document comments">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <div class="d-flex align-items-center">
                                                    @switch(strtolower($extension))
                                                        @case('pdf')
                                                            <i class="bi bi-file-earmark-pdf text-danger me-2 fs-5"></i>
                                                            @break
                                                        @case('doc')
                                                        @case('docx')
                                                            <i class="bi bi-file-earmark-word text-primary me-2 fs-5"></i>
                                                            @break
                                                        @case('jpg')
                                                        @case('jpeg')
                                                        @case('png')
                                                        @case('gif')
                                                        @case('bmp')
                                                        @case('webp')
                                                            <i class="bi bi-file-earmark-image text-secondary me-2 fs-5"></i>
                                                            @break
                                                        @default
                                                            <i class="bi bi-file-earmark-text text-secondary me-2 fs-5"></i>
                                                    @endswitch

                                                    <strong class="text-dark fw-medium">V{{ count($documents[$key]) - $index }}</strong>
                                                </div>

                                                <div class="mx-2">
                                                    @if($doc['comments_count']>0)
                                                    <a href="javascript:void(0)"
                                                    class="text-decoration-none position-relative text-secondary"
                                                    title="View Comments">
                                                        <i class="bi bi-chat-dots fs-5"></i>
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                           {{$doc['comments_count']}}
                                                        </span>
                                                    </a>
                                                    @endif
                                                </div>

                                            </div>
                                        </td>
                                        {{-- Uploaded At --}}
                                        <td>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $doc['created_at'] ?? '' }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="text-center">
                                            <span class="cursor-pointer badge
                                                @if($doc['status'] == 'Approved') bg-lavel-success
                                                @elseif($doc['status'] == 'Rejected') bg-lavel-danger
                                                @elseif($doc['status'] == 'Pending') bg-lavel-warning
                                                @else bg-secondary @endif">
                                                {{ $doc['status'] ?? 'Uploaded' }}
                                            </span>
                                        </td>

                                        {{-- Remarks --}}
                                        <td>
                                            <span class="text-muted">
                                                {{ $doc['remarks'] ?: '-' }}
                                            </span>
                                        </td>
                                          {{-- Uploaded By --}}
                                        <td class="align-middle" style="font-size:12px;">
                                            <div class="d-flex flex-column text-start">
                                                <div>
                                                    <i class="bi bi-person me-1 text-primary"></i>
                                                    <strong>Uploaded By:</strong> {{ $doc['uploaded_by_name'] ?? 'N/A' }}
                                                </div>
                                                @if($doc['status'] === "Rejected")

                                                    {{-- Rejected At --}}
                                                    <div>
                                                        <i class="bi bi-calendar-x me-1 text-danger"></i>
                                                        <strong>Rejected At:</strong> 
                                                        {{ $doc['updated_at'] }}
                                                    </div>

                                                    {{-- Rejected By --}}
                                                    @if(!empty($doc['vetted_by_name']))
                                                        <div>
                                                            <i class="bi bi-person-x me-1 text-danger"></i>
                                                            <strong>Rejected By:</strong> {{ $doc['vetted_by_name'] }}
                                                        </div>
                                                    @endif

                                                @else

                                                    {{-- Vetted On --}}
                                                    @if(!empty($doc['vetted_on']))
                                                        <div>
                                                            <i class="bi bi-calendar-check me-1 text-success"></i>
                                                            <strong>Vetted On:</strong> 
                                                            {{ $doc['vetted_on'] }}
                                                        </div>
                                                    @endif

                                                    {{-- Vetted By --}}
                                                    @if(!empty($doc['vetted_by_name']))
                                                        <div>
                                                            <i class="bi bi-person-badge me-1 text-info"></i>
                                                            <strong>Approved By:</strong> {{ $doc['vetted_by_name'] }}
                                                        </div>
                                                    @endif

                                                @endif

                                            </div>
                                        </td>


                                        {{-- Upload Button or Status --}}
                                        @if($index === 0)
                                            <td class="text-center" rowspan="{{ $rowspan }}">
                                                @php
                                                    $lastDocument = $documents[$key][0];
                                                @endphp

                                                @if($lastDocument['status'] == 'Rejected')
                                                    <button class="btn btn-primary btn-sm" 
                                                            wire:click="SetDocType('{{ $key }}')" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#DocumentModal">
                                                        <i class="bi bi-upload me-1"></i> Upload
                                                    </button>
                                                   
                                                @elseif($lastDocument['status'] == 'Approved')
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <a href="{{ route('admin.candidates.documents.comments', $doc['id']) }}" class="btn btn-secondary btn-sm"> 
                                                        View <i class="bi bi-eye-slash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                {{-- No Documents Yet --}}
                                <tr>
                                    <td><strong>{{ $label }}</strong></td>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="bi bi-inbox"></i> No documents uploaded yet
                                    </td>
                                    <td colspan="1" class="text-center">

                                        <!-- Step 1: Radio toggle -->
                                        <div class="d-flex justify-content-center gap-3">

                                            <label class="d-flex justify-content-center align-items-center">
                                                <input type="checkbox"
                                                    wire:model="skipOption.{{ $key }}"
                                                    wire:change="toggleSkip('{{ $key }}', $event.target.value)"
                                                    value="yes"
                                                    class="me-2">
                                                Skip this document?
                                            </label>
                                        </div>

                                        <!-- Step 2: Show dropdown ONLY when 'Included in Another' is selected -->
                                        @if(isset($skipOption[$key]) && $skipOption[$key] === 'yes')
                                            <select class="form-select form-select-sm w-auto d-inline-block mt-2"
                                                    style="min-width: 180px;"
                                                    wire:model="attachedTo.{{ $key }}"
                                                    wire:change="updateAttachment('{{ $key }}')">

                                                <option value="">🔗 Select parent document</option>

                                                @foreach($availableDocuments as $parent_key => $parent)
                                                    @if($parent_key !== $key)
                                                        <option value="{{ $parent }}">
                                                            📄 {{ $parent }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif


                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm" 
                                                wire:click="SetDocType('{{ $key }}')" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#DocumentModal">
                                            <i class="bi bi-upload me-1"></i> Upload
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="DocumentModal" tabindex="-1" aria-labelledby="DocumentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-3">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="DocumentModalLabel">
                                Upload Document
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="resetForm"></button>
                        </div>

                        <form wire:submit.prevent="save" wire:key="document-form-new" enctype="multipart/form-data">
                            <div class="modal-body">
                                {{-- File Upload --}}
                                <div class="mb-3">
                                    <label class="form-label">File <span class="text-danger">*</span></label>
                                    <input type="file" wire:model="newFile" class="form-control">
                                    @error('newFile')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    {{-- Preview or Upload Progress --}}
                                    <div wire:loading wire:target="newFile" class="text-danger small mt-1">
                                        <i class="bi bi-cloud-upload me-1"></i> Uploading...
                                    </div>
                                </div>

                                {{-- Remarks --}}
                                <div class="mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea wire:model="remarks" class="form-control form-control-sm" placeholder="Enter remarks for new upload" rows="2"></textarea>
                                    @error('remarks')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal"
                                        wire:click="resetForm">
                                    <i class="bi bi-x"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-upload me-1"></i> Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
        </div>
    </div>
    <div class="loader-container" wire:loading wire:target="saveDocument,saveAcknowledgment">
        <div class="loader"></div>
    </div>

    <!-- Success/Error Messages -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAckUpload() {
            Swal.fire({
                title: "Upload Acknowledgement Copy?",
                text: "Are you sure you want to upload this file?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Upload"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('saveAcknowledgment');
                }
            });
        }
        window.addEventListener('showConfirm', function (event) {
            let itemId = event.detail[0].itemId;
            Swal.fire({
                title: "Delete Document?",
                text: "Are you sure you want to delete this document?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', itemId);
                }
            });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //  window.addEventListener('ResetFormData', () => {
            //     const modalEl = document.getElementById('DocumentModal');

            //     // 1️⃣ Clear all form fields in modal
            //     modalEl.querySelectorAll('input, textarea, select').forEach(el => el.value = '');

            //     // 2️⃣ Close modal (try Bootstrap API first)
            //     if (typeof bootstrap !== 'undefined' && modalEl) {
            //         let modalInstance = bootstrap.Modal.getInstance(modalEl);
            //         if (!modalInstance) {
            //             modalInstance = new bootstrap.Modal(modalEl);
            //         }
            //         modalInstance.hide();
            //     }

            //     // 3️⃣ Fallback: ensure modal & backdrop are fully removed
            //     setTimeout(() => {
            //         modalEl.classList.remove('show');
            //         modalEl.style.display = 'none';
            //         modalEl.removeAttribute('aria-modal');
            //         modalEl.setAttribute('aria-hidden', 'true');

            //         // Remove all modal backdrops
            //         document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

            //         // ✅ Re-enable page scrolling
            //         document.body.classList.remove('modal-open');
            //         document.body.style.removeProperty('overflow');
            //         document.body.style.removeProperty('padding-right');
            //     }, 300); // small delay to let Bootstrap finish animation
            // });
            document.addEventListener('livewire:init', () => {
                Livewire.on('toastr:success', (event) => {
                    toastr.success(event.message);
                });
                
                Livewire.on('toastr:error', (event) => {
                    toastr.error(event.message);
                });
            });
        </script>
    @endpush

    <style>
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</div>