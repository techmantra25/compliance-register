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
                        <th width="5%">SL No.</th>
                        <th width="10%">Permission</th>
                        <th width="20%">Issuing Authority / Department</th>
                        <th width="8%">Current Status</th>
                        <th width="20%">Remarks</th>
                        <th width="16%">Applied Copy</th>
                        <th width="10%">Approval Document </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requiredPermissions as $index => $permission)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>

                            <td>{{ $permission->permission_required ?? 'N/A' }}</td>

                            <td>{{ $permission->issuing_authority ?? 'N/A' }}</td>

                            <td>
                                <span class="badge bg-secondary">Pending</span>
                            </td>

                            <td></td> 
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary"
                                    wire:click= "openModal({{$permission->id}}, {{$camp->id}})">
                                    <i class="bi bi-upload me-1"></i>
                                    Upload
                                </button>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye me-1"></i>
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No permissions defined for this event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="DocumentModal" tabindex="-1" aria-labelledby="DocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="DocumentModalLabel">Upload Document</h5>
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
