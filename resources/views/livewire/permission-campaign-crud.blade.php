<div>
    <style>
    
    
    body.modal-open {
    overflow: hidden;
    padding-right: 17px;
    }
    </style>

    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
    {{-- Left Section: Title + Candidate Info --}}
    <div class="mb-2">
        <h4 class="fw-bold mb-2 text-dark">Campaign Permission</h4>
    </div>
    
    {{-- Right Section: Upload Acknowledgment Copy + Back Button --}}
    <div class="d-flex flex-column align-items-end gap-2">
        {{-- Back Button --}}
        <a href="{{ route('admin.campaigns') }}" class="btn btn-sm btn-danger shadow-sm">
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
                            <th class="text-nowrap pe-3 align-top">Campaigner Details</th>
                            <td>
                                <div><i class="bi bi-person me-1 text-primary"></i>
                                    <strong>Name: </strong>{{ ucwords($camp->campaigner->name) }}</div>
                                <div><i class="bi bi-person-circle me-1 text-primary"></i>
                                    <strong>Mobile: </strong> {{ $camp->campaigner->mobile ?? 'N/A' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Assembly</th>
                            <td>
                                : {{ ucwords($camp->assembly->assembly_name_en ?? 'N/A') }}
                                ({{ $camp->assembly->assembly_code ?? 'N/A' }})
                            </td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Phase</th>
                            <td>
                                : {{ optional(optional($camp->assembly->assemblyPhase)->phase)->name ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Event Type</th>
                            <td>: {{ ucwords($camp->category->name ?? 'N/A') }}</td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Place</th>
                            <td>: {{ ucwords($camp->address) }}</td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Date & Time</th>
                            <td>
                                <div class="mb-1">
                                    <i class="bi bi-calendar-event me-1 text-primary"></i>
                                    <strong>Campaign Date:</strong>
                                    {{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}
                                </div>
                                    <div>
                                        <i class="bi bi-calendar-check me-1 text-danger"></i>
                                        <strong>Last Date of Permission:</strong>
                                        {{ date('d M Y, h:i A', strtotime($camp->last_date_of_permission)) }}
                                    </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-nowrap pe-3">Remarks</th>
                            <td>: {{ $camp->remarks ?? 'N/A' }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 p-3 mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0 align-middle table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th width="5%">SL</th>
                        <th width="20%">Permission</th>
                        <th width="20%">Issuing Authority</th>
                        <th width="40%">Upload History</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($requiredPermissions as $index => $permission)
                        @php
                            $records = App\Models\CampaignWisePermission::where('campaign_id', $camp->id)
                                ->where('event_required_permission_id', $permission->id)
                                ->orderBy('id', 'desc')
                                ->get();

                            $latest = $records->first();  // latest entry
                        @endphp

                        <tr>

                            <td class="text-center">{{ $index + 1 }}</td>

                            <td>{{ $permission->permission_required }}</td>

                            <td>{{ $permission->issuing_authority }}</td>


                            <!-- UPLOAD HISTORY -->
                            <td>
                                @forelse($records as $verIndex => $row)

                                    <div class="p-2 mb-2 border rounded bg-light">
                                        
                                        {{-- HEADER --}}
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="fw-bold text-uppercase">
                                                    {{ str_replace('_', ' ', $row->doc_type) }}
                                                </span>

                                                <span class="mx-2">|</span>

                                                {{-- STATUS BADGE --}}
                                                @if($row->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($row->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </div>

                                            <div>
                                                <a href="{{ asset($row->file) }}" target="_blank" 
                                                class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </div>
                                        </div>


                                        {{-- META INFORMATION --}}
                                        <div class="small text-muted mt-2">
                                            {{-- Approved Info (only approved rows) --}}
                                            @if($row->status == 'approved')
                                                <div>
                                                    <i class="bi bi-check2-circle me-1"></i>
                                                    Approved By: <strong>{{ $row->approvedBy ? $row->approvedBy->name : 'N/A' }}</strong>
                                                    @if($row->approved_at)
                                                        — {{ \Carbon\Carbon::parse($row->approved_at)->format('d M Y h:i A') }}
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- Rejected Reason --}}
                                            @if($row->status == 'rejected' || $row->rejected_reason)
                                                <div class="text-danger mt-1">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Rejected By: <strong>{{ $row->approvedBy ? $row->approvedBy->name : 'N/A' }}</strong> 
                                                     @if($row->approved_at)
                                                        — {{ \Carbon\Carbon::parse($row->approved_at)->format('d M Y h:i A') }}
                                                    @endif <br>
                                                    @if($row->rejected_reason)
                                                    <strong>Reason:</strong> {{ $row->rejected_reason }}
                                                    @endif
                                                </div>
                                                 <br>
                                            @endif

                                            {{-- Uploaded Info --}}
                                            <div>
                                                <i class="bi bi-upload me-1"></i>
                                                Uploaded By: <strong>{{ $row->uploadedBy ? $row->uploadedBy->name : 'N/A' }}</strong>
                                                @if($row->uploaded_at)
                                                    — {{ \Carbon\Carbon::parse($row->uploaded_at)->format('d M Y h:i A') }}
                                                @endif
                                            </div>
                                            {{-- Remarks --}}
                                            @if($row->remarks)
                                                <div class="mt-1">
                                                    <i class="bi bi-chat-left-text me-1"></i>
                                                    {{ $row->remarks }}
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                @empty
                                    <span class="text-muted text-center">No uploads yet</span>
                                @endforelse
                            </td>


                           <td class="text-center">

                            {{-- For Legal Associate Role --}}
                            @if(Auth::user()->role === 'legal_associate')

                                {{-- No uploads yet --}}
                                @if(!$latest)
                                    <span class="badge bg-secondary">No document uploaded</span>

                                {{-- LATEST = pending / awaiting action --}}
                                @elseif($latest->status === 'pending')
                                    <button class="btn btn-sm btn-success"
                                        onclick="confirmApprove({{ $latest->id }})">
                                        <i class="bi bi-check2-circle me-1"></i> Approve
                                    </button>

                                    <button class="btn btn-sm btn-danger"
                                        wire:click="openRejectModal({{ $latest->id }})">
                                        <i class="bi bi-x-circle me-1"></i> Reject
                                    </button>

                                {{-- If already approved --}}
                                @elseif($latest->status === 'approved')
                                    <span class="badge bg-success">Approved</span>

                                {{-- If rejected --}}
                                @elseif($latest->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif

                            @else
                            {{-- Normal USER upload flow (your existing logic) --}}

                                {{-- No uploads yet --}}
                                @if(!$latest)
                                    <button class="btn btn-sm btn-primary"
                                        wire:click="uploadApplied({{ $permission->id }}, {{$camp->id}})">
                                        <i class="bi bi-upload me-1"></i> Upload Applied Copy
                                    </button>

                                {{-- Latest = applied --}}
                                @elseif($latest->doc_type == 'applied_copy')

                                    @if($latest->status == 'rejected')
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="uploadApplied({{ $permission->id }}, {{ $camp->id }})">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Upload Applied
                                        </button>

                                    @elseif($latest->status == 'approved')
                                        <button class="btn btn-sm btn-warning"
                                            wire:click="uploadApproved({{ $permission->id }}, {{$camp->id}})">
                                            <i class="bi bi-upload me-1"></i> Upload Approved Copy
                                        </button>

                                    @else
                                        <span class="badge bg-warning text-dark">Awaiting Verification</span>
                                    @endif

                                {{-- Latest = approved copy --}}
                                @elseif($latest->doc_type == 'approved_copy')

                                    @if($latest->status == 'rejected')
                                        <button class="btn btn-sm btn-warning"
                                            wire:click="uploadApproved({{ $permission->id }}, {{ $camp->id }})">
                                            <i class="bi bi-arrow-repeat me-1"></i> Re-Upload Approved
                                        </button>

                                    @elseif($latest->status == 'approved')
                                        <span class="badge bg-success">Completed</span>

                                    @else
                                        <span class="badge bg-warning text-dark">Awaiting Approval</span>
                                    @endif

                                @endif

                            @endif

                        </td>


                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="rejectModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Reject Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Rejection Remarks</label>
                    <textarea class="form-control" wire:model="rejectRemarks" required></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>

                    <button class="btn btn-primary btn-sm" wire:click="submitRejection">
                        <i class="bi bi-x-circle me-1"></i> Confirm Reject
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="DocumentModal" tabindex="-1" aria-labelledby="DocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="DocumentModalLabel">Upload {{$doc_type=="applied_copy" ? 'Applied Copy' : 'Approved Copy'}}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" wire:click="resetForm"></button>
                </div>

                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <div class="modal-body">

                        <input type="hidden" wire:model="campaign_id">
                        <input type="hidden" wire:model="event_required_permission_id">

                        {{-- File Upload --}}
                        <div class="mb-3">
                            <label class="form-label">File <span class="text-danger">*</span></label>
                            <input type="file" wire:model="file" class="form-control">

                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div wire:loading wire:target="file" class="text-danger small mt-1">
                                <i class="bi bi-cloud-upload"></i> Uploading...
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea wire:model="remarks" class="form-control form-control-sm"
                                    placeholder="Enter remarks..." rows="2"></textarea>

                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal" wire:click="resetForm">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-upload"></i> Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</div>
    {{-- <div class="loader-container" wire:loading wire:target="saveDocument,uploadAcknowledgmentCopy">
        <div class="loader"></div>
    </div> --}}

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
            window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        </script>
        <script>
            window.addEventListener('open-document-modal', () => {
                const modalEl = document.getElementById('DocumentModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            window.addEventListener('close-document-modal', () => {
                const modalEl = document.getElementById('DocumentModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            });
            // Rejected Modal
            window.addEventListener('open_reject_modal', () => {
                const modalEl = document.getElementById('rejectModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            window.addEventListener('close_reject_modal', () => {
                const modalEl = document.getElementById('rejectModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            });
        </script>
        <script>
            function confirmApprove(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to approve this document.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Approve"
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('approveDocument', id);
                    }
                });
            }
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
