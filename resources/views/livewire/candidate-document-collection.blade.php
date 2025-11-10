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
                            <th class="text-nowrap pe-3">Agent Name & Number</th>
                            <td>: {{ $agentName ?? 'N/A' }} || {{ $agentNumber ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap pe-3">Phase</th>
                            <td>: {{ $phase ?? '1' }}</td>
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
                            <th width="14%">Upload History</th>
                            <th width="10%">Uploaded by</th>
                            <th width="16%">Date & Time</th>
                            <th width="8%">Status</th>
                            <th width="20%">Remarks</th>
                            <th width="10%">Upload Now</th>
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

                                    <tr class="text-center">
                                        {{-- Document Name (only once per document type) --}}
                                        @if($index === 0)
                                            <td rowspan="{{ $rowspan }}"><strong>{{ $label }}</strong></td>
                                        @endif

                                        {{-- File Name + Icon --}}
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    @switch(strtolower($extension))
                                                        @case('pdf')
                                                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                            @break
                                                        @case('doc')
                                                        @case('docx')
                                                            <i class="bi bi-file-earmark-word text-primary me-2"></i>
                                                            @break
                                                        @case('jpg')
                                                        @case('jpeg')
                                                        @case('png')
                                                        @case('gif')
                                                        @case('bmp')
                                                        @case('webp')
                                                            <i class="bi bi-file-earmark-image text-success me-2"></i>
                                                            @break
                                                        @default
                                                            <i class="bi bi-file-earmark-text text-secondary me-2"></i>
                                                    @endswitch

                                                    <a href="{{ asset('storage/' . $doc['path']) }}"
                                                    target="_blank"
                                                    class="text-decoration-none text-dark fw-medium"
                                                    title="{{ $fileName }}">
                                                        {{ Str::limit($fileName, 13) }}
                                                    </a>
                                                </div>

                                                @if($doc['status'] == 'Pending')
                                                    <button type="button" 
                                                            wire:click="deleteDocument({{ $doc['id'] }})" 
                                                            class="delete-btn-padding btn btn-sm btn-outline-danger ms-2"
                                                            title="Delete file">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Uploaded By --}}
                                        <td>
                                            <i class="bi bi-person me-1"></i>
                                            {{ $doc['uploaded_by_name'] ?? 'N/A' }}
                                        </td>

                                        {{-- Uploaded At --}}
                                        <td>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $doc['created_at'] ?? '' }}
                                        </td>

                                        {{-- Status --}}
                                        <td>
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
                                                @endif
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
    <div class="loader-container" wire:loading wire:target="saveDocument">
        <div class="loader"></div>
    </div>

    <!-- Success/Error Messages -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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