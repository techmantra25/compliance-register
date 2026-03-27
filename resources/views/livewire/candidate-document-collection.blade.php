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
    .bg-light-success {
        background-color: #e6f9f0;
    }   
    </style>

        <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
            {{-- Left Section: Title + Candidate Info --}}
            <div class="mb-2">
                <h4 class="fw-bold mb-2 text-dark">Document Repository</h4>
            </div>
            
            {{-- Right Section: Upload Acknowledgement Copy + Back Button --}}
            <div class="d-flex flex-column align-items-end gap-2">
                {{-- Back Button --}}
                <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>
        </div>
   
        <div class="card shadow-sm border-0 p-3 mt-4">
            <div class="row">
                <div class="col-md-4 col-lg-3 mb-4">
                    <strong class="title-text">Candidate Name</strong>
                    {{ $candidateName ?? 'N/A' }}
                </div>
                <div class="col-md-4 col-lg-2 mb-4">
                    <strong class="title-text">Assembly Name & No</strong>
                    {{ $assemblyName ?? 'N/A' }}
                </div>
                <div class="col-md-2 col-lg-1 mb-4">
                    <strong class="title-text">Phase</strong>
                    {{ $phase ?? 'N/A' }}
                </div>
                   <div class="col-md-2 col-lg-1 mb-4">
                    <strong class="title-text">Age</strong>
                    {{ $candidateData->age ?? 'N/A' }}
                </div>

                <div class="col-md-2 col-lg-1 mb-4">
                    <strong class="title-text">Serial No</strong>
                    {{ $candidateData->serial_no ?? 'N/A' }}
                </div>

                <div class="col-md-2 col-lg-1 mb-4">
                    <strong class="title-text">Part No</strong>
                    {{ $candidateData->part_no ?? 'N/A' }}
                </div>
                <div class="col-md-4 col-lg-3 mb-4">
                    <strong class="title-text">Last Date of Nomination</strong>
                    {{ $nomination_date
                        ? \Carbon\Carbon::parse($nomination_date)->format('d M Y')
                    : 'N/A' }}
                </div>
                <div class="col-md-4 col-lg-3 mb-4">
                    <strong class="title-text">Final Status</strong>
                    {!! getFinalDocStatus($candidateData->document_collection_status, 'icon') !!}
                    {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
                </div>
                <div class="col-md-4 col-lg-8 mb-4">
                    <div class="row ">
                    @if(
                        ($candidateData->document_collection_status !== "verified_pending_submission" || 
                        $candidateData->status !== "without_criminal_full_generation")
                        && in_array($authUser->role, ['admin','employee'])
                    )

                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                wire:model="withCriminal"
                                id="criminalCheck"
                                onclick="confirmPendingCases(this)">

                            <label class="form-check-label title-text text-danger cursor-pointer" for="criminalCheck">
                                Pending Criminal Cases
                            </label>
                        </div>
                    </div>

                    @if($withCriminal && in_array($authUser->role, ['admin']))

                    <div class="col-md-4">
                        <label class="form-label small mb-1">Assign Legal Associate</label>

                        <select class="form-select form-select-sm"
                                wire:model="assignedLegalAssociate"
                                onchange="confirmLegalAssign(this.value)">

                            <option value="">Select Legal Associate</option>

                            @foreach($legalAssociate as $associate)
                                <option value="{{ $associate->id }}">
                                    {{ $associate->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    @endif


                    @else

                        @if($candidateData->legalAssociate)
                            <div class="col-md-4">
                                <label class="form-label small mb-1">Criminal Offence Case</label>
                                <span class="text-danger fw-semibold">
                                    Special case for Legal Associate (Criminal Offence)
                                </span>
                                <br>
                                <small class="text-muted">
                                    Assigned Legal Associate:
                                    <strong>{{ $candidateData->legalAssociate->name }}</strong>
                                </small>
                            </div>
                        @endif

                    @endif
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3 justify-content-end">
                @if(count($versions)>1)
                    @foreach($versions as $version_item)
                        <a href="{{ route('admin.candidates.documents.preview', ['candidate' => $candidateId, 'version' => $version_item->version]) }}"
                        class="btn btn-outline-primary btn-sm"
                        title="Generated by: {{ $version_item->generatedBy->name ?? 'N/A' }} on {{ $version_item->created_at->format('d M Y, H:i') }}">
                            V{{ $version_item->version }} Preview
                        </a>
                    @endforeach
                @elseif(count($versions)==1)
                    @foreach($versions as $version_item)
                        <a href="{{ route('admin.candidates.documents.preview', ['candidate' => $candidateId, 'version' => $version_item->version]) }}"
                        class="btn btn-outline-primary btn-sm"
                        title="Generated by: {{ $version_item->generatedBy->name ?? 'N/A' }} on {{ $version_item->created_at->format('d M Y, H:i') }}">
                            V{{ $version_item->version }} Preview
                        </a>
                    @endforeach
                @endif
                
                @if($showPreviewButton)
                    <a href="{{ route('admin.candidates.documents.preview', ['candidate'=>$candidateId]) }}"
                    class="btn btn-success btn-sm">
                        Latest Preview
                    </a>
                @endif
            </div>

            {{--<div class="">

                <div class="mt-3">

                     <table class="table table-sm table-borderless mb-0">

                        <tr>
                            <th class="text-nowrap pe-3">Candidate Name</th>
                            <td>: {{ $candidateName ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Assembly Name & No</th>
                            <td>: {{ $assemblyName ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Phase</th>
                            <td>: {{ $phase ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Last Date of Nomination form Submission</th>
                            <td>
                                : {{ $nomination_date
                                    ? \Carbon\Carbon::parse($nomination_date)->format('d M Y')
                                    : 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Final Status</th>
                            <td>
                                :
                                {!! getFinalDocStatus($candidateData->document_collection_status, 'icon') !!}
                                {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}

                            </td>
                        </tr>
                        @if(
                            ($candidateData->document_collection_status !== "verified_pending_submission" || 
                            $candidateData->status !== "without_criminal_full_generation")
                            && in_array($authUser->role, ['admin','employee'])
                        )

                        <tr>

                            
                            <th width="40%" class="text-nowrap pe-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        wire:model="withCriminal"
                                        wire:change="toggleCriminalStatus"
                                        id="criminalCheck">

                                    <label class="form-check-label" for="criminalCheck">
                                        With Criminal Offence
                                    </label>
                                </div>
                            </th>

                            
                            <td>
                                @if($withCriminal)

                                    <label class="form-label small mb-1">Assign Legal Associate</label>

                                    <select class="form-select form-select-sm"
                                            wire:model="assignedLegalAssociate"
                                            onchange="confirmLegalAssign(this.value)">

                                        <option value="">Select Legal Associate</option>

                                        @foreach($legalAssociate as $associate)
                                            <option value="{{ $associate->id }}">
                                                {{ $associate->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                @endif
                            </td>

                        </tr>

                        @else

                            @if($candidateData->legalAssociate)
                            <tr>
                                <th class="text-nowrap pe-3">Criminal Offence Case</th>
                                <td>
                                    <span class="text-danger fw-semibold">
                                        Special case for Legal Associate (Criminal Offence)
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        Assigned Legal Associate:
                                        <strong>{{ $candidateData->legalAssociate->name }}</strong>
                                    </small>
                                </td>
                            </tr>

                            @endif
                        @endif

                    </table> -->

                </div>

            </div> --}}
        
            <div class="card-body p-0">
                {{-- File Upload --}}
                
                <div class="table-responsive">
                    <table class="table mb-0 align-middle table-bordered">
                    <thead class="table-light">
                            <tr>
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

                                            @if($doc['status'] !== 'Skipped')
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

                                                        {{-- <div class="mx-2">
                                                            @if($doc['comments_count']>0)
                                                            <a href="javascript:void(0)"
                                                            class="text-decoration-none position-relative text-secondary"
                                                            title="View Comments">
                                                                <i class="bi bi-chat-dots fs-5"></i>
                                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                {{$doc['comments_count']}}
                                                                </span>
                                                            </a>
                                                            @else
                                                            <a href="javascript:void(0)"
                                                            class="text-decoration-none position-relative text-secondary"
                                                            title="View Comments">
                                                                <i class="bi bi-chat-dots fs-5"></i>
                                                            </a>
                                                            @endif
                                                        </div> --}}

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
                                                        @if($doc['status'] == 'Uploaded') bg-lavel-success
                                                        @elseif($doc['status'] == 'Rejected') bg-lavel-danger text-danger
                                                        @elseif($doc['status'] == 'Pending') bg-lavel-warning
                                                        @else bg-secondary @endif">

                                                        @if($doc['status'] == 'Rejected')
                                                            Inadequate Documents
                                                        @else
                                                            {{ $doc['status'] ?? 'Uploaded' }}
                                                        @endif
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
                                                            <div class="tooltip-wrapper d-inline-block">
                                                                <button class="btn btn-outline-success btn-sm"
                                                                    wire:click="SetDocType('{{ $key }}')" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#DocumentModal">
                                                                    <i class="bi bi-upload"></i>
                                                                </button>
                                                                <span class="tooltip-text">Please upload {{ $label }}</span>
                                                            </div>
                                                        
                                                        @elseif($lastDocument['status'] == 'Uploaded')
                                                            <span class="badge bg-success">Uploaded</span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                @endif
                                            @else
                                                <td colspan="4" class="text-center">
                                                <span class="cursor-pointer badge
                                                        @if($doc['status'] == 'Uploaded') bg-lavel-success
                                                        @elseif($doc['status'] == 'Rejected') bg-lavel-danger text-danger
                                                        @elseif($doc['status'] == 'Pending') bg-lavel-warning
                                                        @else bg-secondary @endif">

                                                        @if($doc['status'] == 'Rejected')
                                                            Inadequate Documents
                                                        @else
                                                            {{ $doc['status'] ?? 'Uploaded' }}
                                                        @endif

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
                                                            @if($doc['attached_with_slug']=="documents_not_required" || $doc['attached_with_slug']=='documents_required' || $doc['attached_with_slug']=='documents_not_received')
                                                                <strong>Remarks:</strong>
                                                            @else
                                                            <strong>Attached With:</strong>
                                                            @endif
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
                                        <td colspan="4" class="text-center text-muted">
                                            <i class="bi bi-inbox"></i> No documents uploaded yet
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <!-- Step 1: Radio toggle -->
                                            @if(!in_array($key, ['nomination_paper_form_2b','affidavit_form_26']))
                                                <div class="d-flex gap-3">
                                                    <label class="d-flex justify-content-center align-items-center cursor-pointer">
                                                        <input type="checkbox"
                                                            wire:model="skipOption.{{ $key }}"
                                                            wire:change="toggleSkip('{{ $key }}', $event.target.checked ? 'yes' : null)"
                                                            value="yes"
                                                            class="me-2">
                                                        Skip this document?
                                                    </label>
                                                </div>
                                            @endif

                                            <!-- Step 2: Show dropdown ONLY when 'Included in Another' is selected -->
                                            @if(isset($skipOption[$key]) && $skipOption[$key] === 'yes')
                                                <select class="form-select form-select-sm w-100 d-inline-block mt-2"
                                                        
                                                        wire:model="attachedTo.{{ $key }}"
                                                        onchange="confirmUpdateAttachment('{{ $key }}', this)">
                                                    <option value="" > Document already included in</option>
                                                    @foreach($remainRequiredDocuments as $parent_key => $parent)
                                                        @if($parent_key !== $key)
                                                            <option value="{{ $parent }}" data-key="{{ $parent_key }}">
                                                                {{ $parent }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif


                                        </td>

                                        <td class="text-center">
                                            <div class="tooltip-wrapper d-inline-block">
                                                <button class="btn btn-outline-success btn-sm"
                                                    wire:click="SetDocType('{{ $key }}')" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#DocumentModal">
                                                    <i class="bi bi-upload"></i> Upload
                                                </button>
                                                <span class="tooltip-text">Please upload {{ $label }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>

        
            </div>
        
            <div class="d-flex flex-wrap gap-2 mt-3 justify-content-end">
                @if(count($versions)>1)
                    @foreach($versions as $version_item)
                        <a href="{{ route('admin.candidates.documents.preview', ['candidate' => $candidateId, 'version' => $version_item->version]) }}"
                        class="btn btn-outline-primary btn-sm"
                        title="Generated by: {{ $version_item->generatedBy->name ?? 'N/A' }} on {{ $version_item->created_at->format('d M Y, H:i') }}">
                            V{{ $version_item->version }} Preview
                        </a>
                    @endforeach
                @elseif(count($versions)==1)
                    @foreach($versions as $version_item)
                        <a href="{{ route('admin.candidates.documents.preview', ['candidate' => $candidateId, 'version' => $version_item->version]) }}"
                        class="btn btn-outline-primary btn-sm"
                        title="Generated by: {{ $version_item->generatedBy->name ?? 'N/A' }} on {{ $version_item->created_at->format('d M Y, H:i') }}">
                            V{{ $version_item->version }} Preview
                        </a>
                    @endforeach
                @endif
                
                @if($showPreviewButton)
                    <a href="{{ route('admin.candidates.documents.preview', ['candidate'=>$candidateId]) }}"
                    class="btn btn-success btn-sm">
                        Latest Preview
                    </a>
                @endif
            </div>
        
            <div wire:ignore.self class="modal fade" id="DocumentModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-4">

                        <!-- Header -->
                        <div class="modal-header bg-primary text-white rounded-top-4">
                            <h5 class="modal-title">
                                <i class="bi bi-upload me-2"></i> Upload Document
                            </h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal" wire:click="resetForm"></button>
                        </div>

                        <form wire:submit.prevent="save" enctype="multipart/form-data">
                            <div class="modal-body p-4">

                                {{-- SAME AS BEFORE (HIGHLIGHTED CARD) --}}
                                @if($candidateData->status == "without_criminal_rejected_observation_only")
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">Quick Option</label>

                                        <div class="p-3 border rounded-3 cursor-pointer
                                            {{ $sameAsBefore ? 'border-success bg-light-success' : 'border-light' }}"
                                            style="cursor:pointer;"
                                            onclick="document.getElementById('sameAsBefore').click();">

                                            <div class="form-check d-flex align-items-center">
                                                <input type="checkbox"
                                                    class="form-check-input me-2"
                                                    id="sameAsBefore"
                                                    wire:model="sameAsBefore"
                                                    wire:change="toggleSameAsBefore">

                                                <label class="form-check-label fw-semibold mb-0">
                                                    Same As Before
                                                </label>
                                            </div>

                                            <small class="text-muted">
                                                Reuse previously uploaded document
                                            </small>
                                        </div>
                                    </div>
                                @endif


                                {{-- FILE UPLOAD --}}
                                @if(!$sameAsBefore)
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">
                                            Upload File <span class="text-danger">*</span>
                                        </label>

                                       <input type="file"
                                            wire:model="newFile"
                                            multiple
                                            class="form-control form-control-sm">
                                           <small class="text-muted">
                                                You can upload <strong>maximum 20 images</strong> at once or <strong>1 PDF file</strong>. 
                                                Mixing PDF and images is not allowed.
                                            </small>
                                        @error('newFile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <div wire:loading wire:target="newFile"
                                            class="text-primary small mt-2">
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                            Uploading file...
                                        </div>
                                    </div>
                                @endif


                                {{-- REMARKS --}}
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Remarks</label>

                                    <textarea wire:model="remarks"
                                        class="form-control form-control-sm"
                                        placeholder="Add remarks (optional)"
                                        rows="3"></textarea>

                                    @error('remarks')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="modal-footer bg-light rounded-bottom-4">
                                <button type="button"
                                    class="btn btn-outline-secondary btn-md"
                                    data-bs-dismiss="modal"
                                    wire:click="resetForm">
                                    Cancel
                                </button>

                                <button type="submit"
                                    class="btn btn-success btn-md px-4"
                                    wire:loading.attr="disabled"
                                    wire:target="newFile">

                                    <span wire:loading.remove wire:target="newFile">
                                        <i class="bi bi-check-circle me-1"></i> Submit
                                    </span>

                                    <span wire:loading wire:target="newFile">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Please wait...
                                    </span>

                                </button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="loader-container" wire:loading wire:target="saveDocument,saveAcknowledgement">
            <div class="loader"></div>
        </div>

    <!-- Success/Error Messages -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         window.addEventListener('mail-sent-failed', () => {
            Swal.fire({
                icon: "error",
                title: "Mail Failed",
                text: event.message ?? "Something went wrong while sending mail.",
                confirmButtonColor: "#d33"
            });

        });
        function confirmUpdateAttachment(key, selectElement) {
            let parentValue = selectElement.value;
            let parentKey = selectElement.selectedOptions[0].dataset.key;
            if(parentValue === "") {
                toastr.success("Attachment reset.");
                return;
            }
            Swal.fire({
                title: "Update Attachment?",
                text: "Are you sure you want to attach this document?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Update"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Livewire call to updateAttachment
                    @this.call('updateAttachment', key, parentValue, parentKey);
                } else {
                    // If cancelled, revert the dropdown
                    @this.set('attachedTo.' + key, '');
                }
            });
        }
        function confirmPendingCases(el) {
            let checked = el.checked;

            Swal.fire({
                title: checked 
                    ? "Confirm Criminal Case Declaration" 
                    : "Remove Criminal Case Declaration",
                text: checked 
                    ? "Are you sure you want to declare that you have pending criminal cases?"
                    : "Are you sure you want to remove the declaration of pending criminal cases?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: checked ? "#d33" : "#3085d6",
                cancelButtonColor: "#6c757d",
                confirmButtonText: checked ? "Yes, Confirm" : "Yes, Remove",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.set('withCriminal', checked);
                    @this.call('toggleCriminalStatus');
                } else {
                    // revert checkbox state
                    el.checked = !checked;
                }
            });
        }
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
                    @this.call('saveAcknowledgement');
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

        // assigned legal associate
        function confirmLegalAssign(associateId) {

            let isRemove = !associateId;

            Swal.fire({
                title: isRemove ? "Remove Legal Associate?" : "Assign Legal Associate?",
                html: isRemove 
                    ? "Are you sure you want to remove the legal associate from this candidate?"
                    : `
                        Are you sure you want to assign this candidate to the selected legal associate?<br><br>
                        <strong>📧 A notification email will be sent to the legal associate after confirmation.</strong>
                    `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: isRemove ? "#d33" : "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: isRemove ? "Yes, Remove" : "Yes, Assign",
                cancelButtonText: "Cancel"
            }).then((result) => {

                if (result.isConfirmed) {


                    @this.call('assignLegalAssociate', associateId);

                } else {
                    // revert selection
                    @this.set('assignedLegalAssociate', '{{ $candidateData->legal_associate_id }}');
                }
            });
        }

        </script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
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