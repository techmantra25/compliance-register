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

        {{-- Right Section: Back Button --}}
        <div class="align-self-start">
            <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 p-3">
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
                                    <ul class="mb-0 ps-1">
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
                            <td>: {{ $nomination_date ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap pe-3">Final Status</th>
                            <td>
                                : {{ getFinalDocStatus($candidateData->document_collection_status, 'icon') }}
                                {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
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
        @if($candidateData->document_collection_status=="verified_pending_submission" || $candidateData->document_collection_status=="verified_submitted_with_copy")
            <div class="col-md-5">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">

                        @if($acknowledgmentCopies)

                            <div class="border rounded p-3 mb-2 shadow-sm bg-light">

                                <!-- Header -->
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="bi bi-file-earmark-text me-2"></i>
                                        <strong>Acknowledgement Copy (Latest)</strong>
                                    </div>

                                    <div>
                                        @if($acknowledgmentCopies->status == 'approved')
                                            <span class="badge bg-success px-2">Approved</span>
                                        @elseif($acknowledgmentCopies->status == 'rejected')
                                            <span class="badge bg-danger px-2">Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2">Pending</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Uploaded details -->
                                <div class="text-muted small mt-2">

                                    <div>
                                        <i class="bi bi-clock me-1"></i>
                                        Uploaded At:
                                        {{ \Carbon\Carbon::parse($acknowledgmentCopies->uploaded_at)->format('d M Y, h:i A') }}
                                    </div>

                                    <div>
                                        <i class="bi bi-person me-1"></i>
                                        Uploaded By:
                                        {{ $acknowledgmentCopies->uploader->name ?? 'N/A' }}
                                    </div>

                                    @if($acknowledgmentCopies->final_submission_confirmation)
                                    <div>
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Final Submission Confirmation:
                                        {{ \Carbon\Carbon::parse($acknowledgmentCopies->final_submission_confirmation)->format('d M Y') }}
                                    </div>
                                    @endif

                                </div>

                                <!-- Approved / Rejected Info -->
                                @if($acknowledgmentCopies->status != 'pending')
                                <div class="text-muted small mt-3">

                                    <div>
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ $acknowledgmentCopies->status == 'approved' ? 'Acknowledged At:' : 'Rejected At:' }}
                                        {{ \Carbon\Carbon::parse($acknowledgmentCopies->acknowledgment_at)->format('d M Y, h:i A') }}
                                    </div>

                                    <div>
                                        <i class="bi bi-person-check me-1"></i>
                                        {{ $acknowledgmentCopies->status == 'approved' ? 'Acknowledged By:' : 'Rejected By:' }}
                                        {{ $acknowledgmentCopies->acknowledger->name ?? 'N/A' }}
                                    </div>

                                    @if($acknowledgmentCopies->status == 'rejected' && $acknowledgmentCopies->rejected_reason)
                                    <div>
                                        <i class="bi bi-x-circle me-1"></i>
                                        Rejection Reason: {{ $acknowledgmentCopies->rejected_reason }}
                                    </div>
                                    @endif

                                </div>
                                @endif

                                <!-- View Button -->
                               <div class="mt-3 d-flex flex-column flex-md-row justify-content-between align-items-start gap-2">

                                    <!-- VIEW BUTTON (Left side) -->
                                    <a href="{{ asset($acknowledgmentCopies->path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    <!-- Approve & Reject Buttons (Vertical / Up-Down) -->
                                    @if($acknowledgmentCopies->status == 'pending')
                                        <div class="d-flex flex-column gap-2">

                                            <button class="btn btn-sm btn-success rounded-pill px-3"
                                                    onclick="confirmApprove({{ $acknowledgmentCopies->id }})">
                                                <i class="bi bi-check2-circle"></i> Document is consistent with the vetted version
                                            </button>
                                            <button class="btn btn-sm btn-danger rounded-pill px-3"
                                                    onclick="confirmReject({{ $acknowledgmentCopies->id }},{{$acknowledgmentCopies->candidate_id}})">
                                                <i class="bi bi-x-circle"></i> Inconsistent and needs to be revetted
                                            </button>

                                        </div>
                                    @endif

                                </div>



                            </div>

                        @else
                            <div class="text-center text-muted py-4">
                                No acknowledgement copy uploaded yet.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="card shadow-sm border-0 p-3 mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-bordered">
                   <thead class="table-light">
                        <tr class="text-center">
                            <th width="18%">Document Name</th>
                            <th width="8%">Documents</th>
                            <th width="20%">Remarks</th>
                            <th width="15%">Initial (first) receipt for Vetting</th>
                            <th width="12%">Vetted On</th>
                            <th width="8%">Status</th>
                            <th width="10%">Document Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(count($availableDocuments) == count($documents))
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
                                            @if($doc['status'] !== 'Skipped')
                                                {{-- File Name + Icon --}}
                                                <td style="cursor: pointer;" title="Click to view document comments"
                                                    onclick="window.location='{{ route('admin.candidates.documents.comments', $doc['id']) }}'">
                                                    
                                                    <div class="d-flex align-items-center justify-content-between">

                                                        {{-- File Icon and Version --}}
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

                                                        {{-- View Button --}}
                                                        
                                                    </div>
                                                </td>
                                                {{-- Remarks --}}
                                                <td>
                                                    <span class="text-muted">
                                                        {{ $doc['remarks'] ?: '-' }}
                                                    </span>
                                                </td>
                                                @if($index === 0)
                                                    <td rowspan="{{ $rowspan }}" class="text-center">
                                                        @php
                                                            $firstDocument = App\Models\CandidateDocument::where('type', $doc['type'])->where('candidate_id', $candidateId)->orderBy('id', 'Asc')->first();
                                                        @endphp
                                                        {{ $firstDocument?$firstDocument->created_at->format('d/m/Y h:i A'):"N/A" }}
                                                    </td>
                                                    <td rowspan="{{ $rowspan }}" class="text-center">
                                                        {{ $doc['vetted_on'] }}
                                                    </td>
                                                @endif

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
                                                @if($index === 0)
                                                    <td rowspan="{{ $rowspan }}" class="text-center">
                                                        <div class="mx-2">
                                                            <a href="{{ route('admin.candidates.documents.comments', $doc['id']) }}"
                                                            class="btn btn-secondary btn-sm"
                                                            title="View Comments"
                                                            onclick="event.stopPropagation();">
                                                                <i class="bi bi-chat-dots"></i>
                                                                <span>View</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                @endif
                                            @else
                                                <td colspan="4" class="text-center">
                                                    <span class="cursor-pointer badge
                                                        @if($doc['status'] == 'Approved') bg-lavel-success
                                                        @elseif($doc['status'] == 'Rejected') bg-lavel-danger
                                                        @elseif($doc['status'] == 'Pending') bg-lavel-warning
                                                        @else bg-secondary @endif">
                                                        {{ $doc['status'] ?? 'Uploaded' }}
                                                    </span>
                                                </td>
                                                <td colspan="2">
                                                    <div class="p-2 bg-light rounded border small">

                                                        {{-- Skipped By --}}
                                                        <div class="mb-1">
                                                            <i class="bi bi-person-check me-1 text-primary"></i>
                                                            <strong>Skipped By:</strong>
                                                            <span class="text-dark">{{ $doc['uploaded_by_name'] ?? 'N/A' }}</span>
                                                        </div>

                                                        {{-- Attached With --}}
                                                        <div>
                                                            <i class="bi bi-link-45deg me-1 text-danger"></i>
                                                            <strong>Attached With:</strong>
                                                            <span class="text-dark">{{ $doc['attached_with'] ?? 'N/A' }}</span>
                                                        </div>

                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    {{-- No Documents Yet --}}
                                    <tr>
                                        <td><strong>{{ $label }}</strong></td>
                                        <td colspan="5" class="text-center text-muted">
                                            <i class="bi bi-inbox"></i> No documents uploaded yet
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-danger">
                                    Document not uploaded yet
                                </td>
                            </tr>     
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
        
    </div>
    <div class="loader-container" wire:loading wire:target="saveDocument">
        <div class="loader"></div>
    </div>

    <!-- Success/Error Messages -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('special-case-created', event => {
            Swal.fire({
                icon: "success",
                title: "Special Case Clone Created",
                text: event.detail.message
            });
        });
        // Approve Confirmation
        function confirmApprove(id) {
            Swal.fire({
                title: "Approve Acknowledgement?",
                text: "Are you sure you want to approve this?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('approveAcknowledgment', id);
                }
            });
        }

        // Reject Confirmation With Reason
        function confirmReject(id, candidateId) {
            Swal.fire({
                title: "Select Rejection Type",
                html: `
                    <div class="text-start">

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="revetted">
                            <label class="form-check-label" for="revetted">
                                Acknowledgement Copy needs to be revetted.
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="specialCase">
                            <label class="form-check-label" for="specialCase">
                            Inconsistent and needs to be revetted & Special Case
                            </label>
                        </div>

                        <div id="reasonBox" style="display:none;">
                            <textarea id="rejectReason" class="form-control mt-2"
                                placeholder="Enter reason..."></textarea>
                        </div>

                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Continue",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",

                didOpen: () => {
                    const revetted = Swal.getPopup().querySelector("#revetted");
                    const reasonBox = Swal.getPopup().querySelector("#reasonBox");

                    revetted.addEventListener("change", () => {
                        reasonBox.style.display = revetted.checked ? "block" : "none";
                    });
                },

                preConfirm: () => {
                    const revetted = Swal.getPopup().querySelector("#revetted").checked;
                    const specialCase = Swal.getPopup().querySelector("#specialCase").checked;
                    const reason = Swal.getPopup().querySelector("#rejectReason").value.trim();

                    if (!revetted && !specialCase) {
                        Swal.showValidationMessage("Select at least one option!");
                        return false;
                    }

                    if (revetted && reason === "") {
                        Swal.showValidationMessage("Reason is required for Special Case!");
                        return false;
                    }

                    return { revetted, specialCase, reason };
                }
            }).then(result => {
                if (!result.isConfirmed) return;

                const data = result.value;

                // SPECIAL CASE → open clone modal
                if (data.specialCase) {
                    openSpecialCaseModalWithReason(candidateId, data.reason);
                } 
                else {
                    // NORMAL REJECTION (reason optional)
                    @this.call('rejectAcknowledgment', id, data.reason || "Needs revetting.");
                }
            });
        }


        function openSpecialCaseModalWithReason(candidateId, remarks) {
            Swal.fire({
                title: "Create Special Case Clone?",
                input: "textarea",
                inputLabel: "Remarks (Required)",
                inputValue: remarks,
                inputAttributes: {
                    "aria-label": "Type your remarks here"
                },
                showCancelButton: true,
                confirmButtonText: "Create Clone",
                confirmButtonColor: "#000",
                preConfirm: (value) => {
                    if (!value.trim()) {
                        Swal.showValidationMessage("Remarks are required!");
                        return false;
                    }
                    return value;
                }
            }).then(result => {
                if (result.isConfirmed) {
                    @this.call('createSpecialCaseClone', candidateId, result.value);
                }
            });
        }


    </script>
    <script>
        window.addEventListener('showConfirm', function (event) {
            let value = event.detail[0].value;
            let document = event.detail[0].document;
            let selectElement = event.detail[0].selectElement;
            Swal.fire({
                text: `You are changing status to this document?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('UpdateDocStatus', value, document);
                } else {
                    if (selectElement) {
                        selectElement.value = selectElement.getAttribute('data-prev');
                    }
                    @this.call('reloadData');
                }
            });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
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