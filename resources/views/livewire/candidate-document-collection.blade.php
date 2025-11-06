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
    </style>

    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                 Document Collections
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-decoration-none text-muted">
                            <i class="bi bi-grid-fill me-1"></i> Admin
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">
                        {{ $candidateName }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-3 mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="25%">Document Name</th>
                            <th width="25%">Upload History</th>
                            <th width="20%">Remarks</th>
                            <th width="10%">Upload Now</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availableDocuments as $key => $label)
                            <tr>
                                <td>
                                    <strong>{{ $label }}</strong>
                                    <br>
                                    <small class="text-muted file-format-size">PDF, DOCX, All image format</small>
                                </td>
                                
                                
                                <td>
                                    {{-- Show existing documents with details --}}
                                    @if(isset($documents[$key]) && count($documents[$key]) > 0)
                                        <div class="upload-history">
                                            @foreach($documents[$key] as $doc)
                                                @php
                                                    $extension = pathinfo($doc['path'], PATHINFO_EXTENSION);
                                                    $fileName = pathinfo($doc['path'], PATHINFO_FILENAME);
                                                @endphp
                                                
                                                <div class="upload-item border-bottom pb-2 mb-2">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <div class="d-flex align-items-center">
                                                            <!-- File icon based on type -->
                                                            @if(in_array(strtolower($extension), ['pdf']))
                                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                            @elseif(in_array(strtolower($extension), ['doc', 'docx']))
                                                                <i class="bi bi-file-earmark-word text-primary me-2"></i>
                                                            @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                                <i class="bi bi-file-earmark-image text-success me-2"></i>
                                                            @else
                                                                <i class="bi bi-file-earmark-text text-secondary me-2"></i>
                                                            @endif
                                                            
                                                            <!-- File name and link -->
                                                            <a href="{{ asset('storage/' . $doc['path']) }}" 
                                                            target="_blank" 
                                                            class="text-decoration-none text-dark fw-medium"
                                                            title="{{ $fileName }}">
                                                                {{ Str::limit($fileName, 20) }}
                                                            </a>
                                                        </div>
                                                        
                                                        <!-- Delete button -->
                                                        @if($doc['status'] == 'Pending')
                                                            <button type="button" 
                                                                    wire:click="deleteDocument({{ $doc['id'] }})" 
                                                                    class="btn btn-sm btn-outline-danger delete-btn-padding"
                                                                    onclick="return confirm('Are you sure you want to delete this document?')"
                                                                    title="Delete file">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Upload details -->
                                                    <div class="upload-details small text-muted">
                                                        <div class="d-flex justify-content-between">
                                                            <span>
                                                                <i class="bi bi-person me-1"></i>
                                                                {{ $doc['uploaded_by_name'] }}
                                                            </span>
                                                            <span>
                                                                <i class="bi bi-clock me-1"></i>
                                                                {{ $doc['created_at'] }}
                                                            </span>
                                                        </div>
                                                        <div class="mt-1 text-end">
                                                            <span class="badge 
                                                                @if($doc['status'] == 'Approved') bg-success
                                                                @elseif($doc['status'] == 'Rejected') bg-danger
                                                                @elseif($doc['status'] == 'Pending') bg-warning
                                                                @else bg-secondary @endif">
                                                                {{ $doc['status'] ?? 'uploaded' }}
                                                            </span>
                                                        </div>
                                                       <div class="d-flex justify-content-between align-items-start">
                                                            <span class="text-muted">
                                                                {{ $doc['remarks'] ?: '' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-muted small text-center py-3">
                                            <i class="bi bi-inbox"></i><br>
                                            No documents uploaded yet
                                        </div>
                                    @endif
                                </td>
                                
                                <td>
                                    {{-- Show existing remarks for all documents --}}
                                    {{-- @if(isset($documents[$key]) && count($documents[$key]) > 0)
                                        <ul class="list-unstyled small mb-2">
                                            @foreach($documents[$key] as $doc)
                                                <li class="border-bottom pb-1 mb-1">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <span class="text-muted">
                                                            {{ $doc['remarks'] ?: 'No remarks' }}
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $doc['created_at'])->format('M j') }}
                                                        </small>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="small text-muted mb-2">No remarks yet</div>
                                    @endif --}}
                                    
                                    {{-- Textarea for new remarks --}}
                                    <textarea 
                                        wire:model="remarks.{{ $key }}" 
                                        class="form-control form-control-sm" 
                                        placeholder="Enter remarks for new upload"
                                        rows="2"
                                    ></textarea>
                                    @error("remarks.$key") 
                                        <small class="text-danger">{{ $message }}</small> 
                                    @enderror
                                </td>
                                
                                <td class="text-center">
                                    
                                    @if(isset($documents[$key]) && count($documents[$key]) > 0)
                                        @php
                                            $lastDocument = $documents[$key][0];
                                        @endphp
                                        @if($lastDocument['status'] =="Rejected")
                                            <input type="file" 
                                                wire:model="newFiles.{{ $key }}" 
                                                class="form-control form-control-sm"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                            
                                            <!-- Loader overlay for this specific file input -->
                                            <div class="loader-overlay" wire:loading wire:target="newFiles.{{ $key }}">
                                                <div class="loader-small"></div>
                                                <span class="text-danger" style="font-size: 10px;">Uploading...</span>
                                            </div>
                                            
                                            @error("newFiles.$key") 
                                                <small class="text-danger">{{ $message }}</small> 
                                            @enderror
                                        @endif
                                        @if($lastDocument['status'] =="Approved")
                                            <span class="badge bg-success">Verified</span>
                                        @endif

                                    @else
                                        <input type="file" 
                                                wire:model="newFiles.{{ $key }}" 
                                                class="form-control form-control-sm"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                            
                                            <!-- Loader overlay for this specific file input -->
                                            <div class="loader-overlay" wire:loading wire:target="newFiles.{{ $key }}">
                                                <div class="loader-small"></div>
                                                <span class="text-danger" style="font-size: 10px;">Uploading...</span>
                                            </div>
                                            
                                            @error("newFiles.$key") 
                                                <small class="text-danger">{{ $message }}</small> 
                                            @enderror
                                    @endif

                                    <!-- Show save button only when a file is selected -->
                                    @if(isset($newFiles[$key]) && $newFiles[$key])
                                        <div class="mt-2">
                                            <button type="button" 
                                                wire:click="saveDocument('{{ $key }}')"
                                                wire:loading.attr="disabled"
                                                class="btn btn-primary btn-sm">
                                                <span wire:loading.remove wire:target="saveDocument('{{ $key }}')">
                                                    <i class="bi bi-upload"></i> Save
                                                </span>
                                                <span wire:loading wire:target="saveDocument('{{ $key }}')">
                                                    <i class="bi bi-arrow-clockwise spinner"></i> Saving...
                                                </span>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
        <script>
             window.addEventListener('ResetFormData', event => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
             });
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