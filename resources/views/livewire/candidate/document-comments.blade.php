<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-chat-dots me-2 text-primary"></i> Document Comments
            </h4>
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none">
                        <i class="bi bi-grid-fill me-1"></i> Admin
                    </a>
                </li>
                <li class="breadcrumb-item">
                    @if($authUser->role =="legal_associate")
                        <a href="{{ route('admin.candidates.documents.vetting', $document->candidate_id) }}" class="text-muted text-decoration-none">
                            Candidate Documents
                        </a>
                    @else
                        <a href="{{ route('admin.candidates.documents', ['candidate'=>$document->candidate_id]) }}" class="text-muted text-decoration-none">
                            Candidate Documents
                        </a>
                    @endif
                </li>
                <li class="breadcrumb-item active text-primary">
                    Comments — <span class="fw-semibold">{{ $document->file_name ?? 'Document #'.$documentId }}</span>
                </li>
            </ol>
        </div>
        <div class="align-self-start">
            @if($authUser->role =="legal_associate")
                <a href="{{ route('admin.candidates.documents.vetting', $document->candidate_id) }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            @else
                <a href="{{ route('admin.candidates.documents', ['candidate'=>$document->candidate_id]) }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            @endif
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            @php
                $extension = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                $fileUrl = asset($document->path);
            @endphp

            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    {{-- 🖼️ If image --}}
                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                        <img src="{{ $fileUrl }}" 
                            alt="Document Image"
                            class="img-fluid rounded shadow-sm border"
                            style="max-height: 600px; object-fit: contain;">

                    {{-- 📄 If PDF --}}
                    @elseif($extension === 'pdf')
                        <iframe src="{{ $fileUrl }}" 
                                style="width:100%; height:600px; border:none;" 
                                frameborder="0"></iframe>

                    {{-- 📊 If CSV or TXT --}}
                    @elseif(in_array($extension, ['csv', 'txt']))
                        <div class="bg-light p-3 rounded border text-start">
                            <strong>Preview:</strong>
                            <pre class="small text-muted" style="max-height: 500px; overflow-y: auto;">
                                {{ Str::limit(file_get_contents(storage_path('app/public/' . $document->path)), 3000, '...') }}
                            </pre>
                        </div>

                    @elseif(in_array($extension, ['xlsx', 'xls']))
                        <div class="text-center p-4 bg-light border rounded">
                            <i class="bi bi-file-earmark-excel text-success fs-1 mb-2"></i>
                            <h6>Excel File</h6>
                            <p class="small text-muted mb-2">You can download and open this file in Microsoft Excel or Google Sheets.</p>
                            <a href="{{ $fileUrl }}" class="btn btn-success btn-sm" target="_blank">
                                <i class="bi bi-download"></i> Download Excel
                            </a>
                        </div>

                    {{-- 📁 Default fallback --}}
                    @else
                        <p class="text-muted">
                            <i class="bi bi-file-earmark-text fs-3 text-secondary"></i><br>
                            <a href="{{ $fileUrl }}" target="_blank">Open file</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if($authUser->role !== "legal_associate")
                <div class="card shadow border-0 mb-4">

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="
                                badge px-3 fs-6
                                @if($document->status == 'Approved') bg-success
                                @elseif($document->status == 'Rejected') bg-danger
                                @else bg-warning text-dark
                                @endif
                            ">
                                Current Status: <strong>{{ $document->status }}</strong>
                            </span>
                        </div>
                        {{-- When Rejected --}}
                        @if($document->status === "Rejected")

                            <div class="d-flex align-items-start mb-2">
                                <i class="bi bi-calendar-x text-danger me-2 fs-5"></i>
                                <div>
                                    <strong>Rejected On:</strong><br>
                                    <span class="text-muted">{{ $document->updated_at }}</span>
                                </div>
                            </div>

                            @if(!empty($document->vettedBy))
                            <div class="d-flex align-items-start mb-2">
                                <i class="bi bi-person-x text-danger me-2 fs-5"></i>
                                <div>
                                    <strong>Rejected By:</strong><br>
                                    <span class="text-muted">{{ $document->vettedBy->name }}</span>
                                </div>
                            </div>
                            @endif

                        {{-- When Approved or Pending --}}
                        @else
                            @if(!empty($document->vetted_on))
                            <div class="d-flex align-items-start mb-2">
                                <i class="bi bi-calendar-check text-success me-2 fs-5"></i>
                                <div>
                                    <strong>Vetted On:</strong><br>
                                    <span class="text-muted">{{ $document->vetted_on }}</span>
                                </div>
                            </div>
                            @endif

                            @if(!empty($document->vettedBy))
                            <div class="d-flex align-items-start">
                                <i class="bi bi-person-badge text-info me-2 fs-5"></i>
                                <div>
                                    <strong>Approved By:</strong><br>
                                    <span class="text-muted">{{ $document->vettedBy->name }}</span>
                                </div>
                            </div>
                            @endif

                        @endif

                    </div>
                </div>
                @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-3">Legal Comments ({{ count($comments) }})</h6>
                </div>
                <div class="card-body chart-body">
                    @forelse($comments as $comment)
                        <div class="border-bottom py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $comment->admin->name ?? 'Unknown Admin' }}</strong>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y, h:i A') }}</small>
                            </div>
                            <div class="mt-1 text-secondary">{{ $comment->comment }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">No comments yet.</div>
                    @endforelse
                </div>
            </div>
            @if($authUser->role =="legal_associate")
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        {{-- Comment Section --}}
                        <h6 class="mb-3 fw-bold">Add a Comment</h6>

                        <textarea wire:model.defer="newComment"
                            class="form-control mb-2"
                            rows="2"
                            placeholder="Type your comment here..."></textarea>

                        @error('newComment')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror

                        <button wire:click="addComment" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-send me-1"></i> Submit Comment
                        </button>

                        {{-- Status Section --}}
                        <h6 class="fw-bold mb-2">Update Document Status</h6>
                        {{-- Current Status Badge --}}
                        <span class="badge 
                            @if($document->status == 'Approved') bg-success 
                            @elseif($document->status == 'Rejected') bg-danger
                            @else bg-warning text-dark
                            @endif
                            mb-2">
                            Current: {{ $document->status }}
                        </span>
                        {{-- Beautiful Button Option UI --}}
                        {{-- @if($document->candidate->document_collection_status!=="verified_submitted_with_copy") --}}
                            <div class="btn-group w-100" role="group">

                                <button 
                                    wire:click="updateStatus('Approved','{{$document->type}}')" 
                                    class="btn btn-outline-success 
                                    {{ $document->status=='Approved' ? 'active' : '' }}">
                                    <i class="bi bi-check-circle"></i> Approved
                                </button>

                                <button 
                                    wire:click="updateStatus('Rejected','{{$document->type}}')" 
                                    class="btn btn-outline-danger 
                                    {{ $document->status=='Rejected' ? 'active' : '' }}">
                                    <i class="bi bi-x-circle"></i> Rejected
                                </button>

                                <button 
                                    wire:click="updateStatus('Pending','{{$document->type}}')" 
                                    class="btn btn-outline-warning 
                                    {{ $document->status=='Pending' ? 'active' : '' }}">
                                    <i class="bi bi-clock"></i> Pending
                                </button>

                            </div>
                        {{-- @endif --}}

                    </div>
                </div>
                @endif

        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        window.addEventListener('ResetForm', event => {
          // Clear all input fields
            document.querySelectorAll('input').forEach(input => input.value = '');
            
            // Clear all textarea fields
            document.querySelectorAll('textarea').forEach(textarea => textarea.value = '');
        });
    </script>
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
                } 
            });
        });
    </script>
    @endpush
</div>
