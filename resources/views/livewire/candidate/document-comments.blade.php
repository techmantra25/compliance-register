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
                    {{-- @if($authUser->role =="legal_associate")
                        <a href="{{ route('admin.candidates.documents.vetting', $document->candidate_id) }}" class="text-muted text-decoration-none">
                            Candidate Documents
                        </a>
                    @else --}}
                        <a href="{{ route('admin.candidates.documents', ['candidate'=>$document->candidate_id]) }}" class="text-muted text-decoration-none">
                            Candidate Documents
                        </a>
                    {{-- @endif --}}
                </li>
                <li class="breadcrumb-item active text-primary">
                    Comments — <span class="fw-semibold">{{ $document->file_name ?? 'Document #'.$documentId }}</span>
                </li>
            </ol>
        </div>
        <div class="align-self-start">
            {{-- @if($authUser->role =="legal_associate")
                <a href="{{ route('admin.candidates.documents.vetting', $document->candidate_id) }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            @else --}}
                <a href="{{ route('admin.candidates.documents', ['candidate'=>$document->candidate_id]) }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            {{-- @endif --}}
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            @php
                $extension = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                $fileUrl = asset($document->path);
                $docTypes = ['doc','docx','xls','xlsx','ppt','pptx','txt','csv','odt','ods','odp'];
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
                    @elseif(in_array($extension, $docTypes))

                            <iframe 
                                src="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true"
                                width="100%" style="border:none; height:600px">
                            </iframe>
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
       
    </div>

    @push('scripts')
    @endpush
</div>
