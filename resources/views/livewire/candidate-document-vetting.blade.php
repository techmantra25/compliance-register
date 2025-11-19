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

            {{-- Candidate Info Table --}}
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
                        <tr>
                            <th>Final Submission Confirmation (RO office)</th>
                            <td> 
                                @if($candidateData->final_submission_confirmation)
                                    {{ \Carbon\Carbon::parse($candidateData->final_submission_confirmation)->format('d M Y, h:i A') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Acknowledgment Copy Reference</th>
                            <td>
                                @if($candidateData->acknowledgment_file)
                                    <a href="{{ asset($candidateData->acknowledgment_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-earmark-text"></i> View File
                                    </a>
                                @else
                                    <span class="text-muted">Not Uploaded</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Logged By</th>
                            <td>
                                @if($candidateData->acknowledgment_by)
                                    {{optional($candidateData->user)->name}}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Date & Time</th>
                            <td>
                                @if($candidateData->acknowledgment_at)
                                    {{ \Carbon\Carbon::parse($candidateData->acknowledgment_at)->format('d M Y, h:i A') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
          </div>
        </div>

        {{-- Right Section: Back Button --}}
        <div class="align-self-start">
            <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>
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
                                                                    <i class="bi bi-file-earmark-image text-success me-2 fs-5"></i>
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
                                <td colspan="6" class="text-center text-danger">
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