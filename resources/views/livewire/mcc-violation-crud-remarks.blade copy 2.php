<div>
    <style>
        .cancelled-remark{
            filter: blur(1px);
            pointer-events: none;
        }
    </style>
    <div class="row g-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-chat-left-text me-2 text-primary"></i>
                    Complaint Remarks
                </h4>

                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted text-decoration-none">Complaint</a>
                    </li>
                    <li class="breadcrumb-item active text-primary">
                        Remarks Trail
                    </li>
                </ol>
            </div>

            <div>
                <a href="{{ route('admin.mcc_violation') }}" 
                class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

        </div>


        <!-- LEFT : REMARKS TRAIL -->
        <div class="col-lg-{{$userRole=='legal_associate'?"12":"12"}}">

            <div class="card shadow-sm border-0 p-3">

                <div class="card-header bg-white">

                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <h5 class="fw-bold mb-4">
                            Complaint Details
                        </h5>
                    </div>
                        
                    <div class="row">
                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">Complaint Code</strong>
                            {{ $mcc->mcc_code }}
                        </div>
                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">Category</strong>
                            {{ $mcc->category }}
                        </div>
                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">Block</strong>
                            {{ $mcc->block }}
                        </div>
                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">GP</strong>
                            {{ $mcc->gp }}
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4 mb-lg-4">
                            <strong class="title-text">Complainer</strong>
                            {{ $mcc->complainer_name }}
                        </div>
                        <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">Phone</strong>
                            {{ $mcc->complainer_phone }}
                        </div>
                            @if($legalAssociate)
                            <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                                <strong class="title-text">Assigned To</strong>
                                    {{ $legalAssociate->name }}
                            </div>
                            @endif
                            <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                            <strong class="title-text">Status</strong>
                            {{ $mcc->status }}
                        </div>
                            @if($mcc->complainer_description)
                        <div class="col-md-6 col-lg-6 mb-4 mb-lg-4">
                            <strong class="title-text">Description</strong>
                            <p>{{ $mcc->complainer_description }}</p>
                        </div>
                        @endif
                    </div>

                    

                    @if($userRole=='legal_associate')

                    <hr class="mb-4">

                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-9">
                            <!-- <div class="d-flex align-items-center flex-wrap g-3 mb-3">
                                <h5 class="fw-bold mb-0">
                                Status
                                </h5>
                            </div> -->
                            <div class="d-flex align-items-center flex-wrap g-3 mb-3">
                                <span class="fw-semibold">Current Status:</span>
                                <span class="badge 
                                    @if($mcc->status == 'pending') bg-warning
                                    @elseif($mcc->status == 'inprogress') bg-info
                                    @elseif($mcc->status == 'resolved') bg-success
                                    @endif
                                    text-white  mx-3">
                                    {{ ucfirst($mcc->status) }}
                                </span>
                            </div>

                            @if($mcc->status == 'resolved')
                                <!-- Already resolved -->
                                <div class="alert alert-success mb-0">
                                    <i class="bi bi-check-circle"></i> This case is resolved. You cannot change status.
                                </div>
                            @else
                                <!-- Status buttons -->
                                <div class="d-flex g-4">
                                    @foreach(['pending', 'inprogress', 'resolved'] as $statusOption)
                                        @php
                                            $activeClass = '';
                                            if($mcc->status == $statusOption) {
                                                $activeClass = match($statusOption) {
                                                    'pending' => 'btn-warning text-white',
                                                    'inprogress' => 'btn-info text-white',
                                                    'resolved' => 'btn-success text-white',
                                                    default => 'btn-secondary text-white',
                                                };
                                            } else {
                                                $activeClass = 'btn-outline-primary';
                                            }
                                        @endphp

                                        <button 
                                            wire:click="preConfirmResolve('{{ $mcc->id }}', '{{ $statusOption }}')" 
                                            class="btn btn-sm {{ $activeClass }} me-1"
                                        >
                                            {{ ucfirst($statusOption) }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Optional info message -->
                                <div id="resolve-warning" class="mt-2 text-danger text-sm fw-semibold" style="display:block;">
                                    <small>Once you set this case as resolved, you <strong>cannot revert it back</strong>!</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-3 text-end">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-remarks">
                                <i class="bi bi-plus-circle me-1"></i> Add Remark
                            </button>
                        </div>
                    </div>

                    @endif

                   {{--@if($supportingDocs->count())
                    <div class="mt-2">
                        <strong>Supporting Documents:</strong>

                        <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">

                            @foreach($supportingDocs as $doc)

                                    @if(Str::endsWith($doc->file_path, ['jpg','jpeg','png','gif','webp','bmp']))

                                        <img src="{{ asset($doc->file_path) }}"
                                            class="rounded border"
                                            style="width:90px; height:90px; object-fit:cover; cursor:pointer;"
                                            onclick="window.open('{{ asset($doc->file_path) }}','_blank')">

                                    @else

                                        <a href="{{ asset($doc->file_path) }}"
                                        target="_blank"
                                        class="btn btn-outline-secondary btn-sm px-2 py-1">
                                            <i class="bi bi-file-earmark"></i> File
                                        </a>

                                    @endif

                            @endforeach

                        </div>
                    </div>
                    @endif --}} 
                        
                </div>
                
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="section-header">Remarks</h6>
                                <div class="chat-box-type">
                                    @if($remarks->count())

                                    @foreach($remarks as $r)

                                    <div class="border rounded p-3 mb-3 position-relative 
                                        {{ $r->is_cancelled == 1 ? 'opacity-50 cancelled-remark' : '' }}" wire:key="item-{{$r->id}}">

                                        @if($r->is_cancelled == 1)
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                                Cancelled
                                            </span>
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center">

                                            <span class="badge bg-success">
                                                {{ $r->created_at->format('d M Y h:i A') }}
                                            </span>

                                            @if($r->is_cancelled == 0 && $userRole=='legal_associate')
                                                <button class="btn btn-sm btn-outline-danger"
                                                        wire:click="addCancel({{ $r->id }})"
                                                        wire:loading.attr="disabled">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            @endif

                                        </div>

                                        <div class="mt-2">
                                            {{ $r->remarks }}
                                        </div>
                                        @if($r->attachment)

                                        <div class="mt-2">

                                            @if(Str::endsWith($r->attachment, ['jpg','jpeg','png']))

                                            <img src="{{ asset($r->attachment) }}"
                                                class="img-fluid rounded"
                                                style="max-width:200px">

                                            @else

                                            <a href="{{ asset($r->attachment) }}"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-file-earmark-pdf"></i> View File
                                            </a>

                                            @endif

                                        </div>

                                        @endif

                                    </div>

                                    @endforeach

                                    @else

                                    <div class="text-muted text-center">
                                        No remarks found
                                    </div>

                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h6 class="section-header">Prewiew</h6>
                                @if($supportingDocs->count())
                                    <div class="preview-option">
                                        @foreach($supportingDocs as $doc)
                                            @if(Str::endsWith($doc->file_path, ['jpg','jpeg','png','gif','webp','bmp']))
                                            <a href="{{ asset($doc->file_path) }}" class="lightbox images-wrapper" data-lcl-thumb="{{ asset($doc->file_path) }}">
                                                <img src="{{ asset($doc->file_path) }}">
                                            </a>
                                            @else
                                                <!-- @php
                                                    $fileExtension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                                    $fileIcon = match(strtolower($fileExtension)) {
                                                        'pdf' => 'assets/img/pdf-icon.gif', // Replace with your PDF icon path
                                                        'doc', 'docx' => 'assets/img/word-icon.gif', // Replace with your Word icon path
                                                        'xls', 'xlsx' => 'assets/img/excel-icon.gif', // Replace with your Excel icon path
                                                        'ppt', 'pptx' => 'assets/img/powerpoint-icon.gif', // Replace with your PowerPoint icon path
                                                        //'txt' => 'assets/img/txt-icon.gif', // Replace with your Text icon path
                                                        //'zip', 'rar' => 'assets/img/archive-icon.gif', // Replace with your Archive icon path
                                                        default => 'assets/img/add-folder.gif' // Default icon
                                                    };
                                                @endphp -->


                                                <a href="{{ asset($doc->file_path) }}"
                                                target="_blank" class="document"
                                                class="btn btn-outline-secondary btn-sm px-2 py-1">
                                                    <img src="{{ asset('assets/img/add-folder.gif') }}" alt="">
                                                    <span>File</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>



                       {{-- 
                            <h5 class="fw-bold mb-1">
                            Remarks History
                            </h5>

                            @if($remarks->count())

                            @foreach($remarks as $r)

                            <div class="border rounded p-3 mb-3 position-relative 
                                {{ $r->is_cancelled == 1 ? 'opacity-50 cancelled-remark' : '' }}" wire:key="item-{{$r->id}}">

                                @if($r->is_cancelled == 1)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                        Cancelled
                                    </span>
                                @endif

                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="badge bg-light text-dark">
                                        {{ $r->created_at->format('d M Y h:i A') }}
                                    </span>

                                    @if($r->is_cancelled == 0 && $userRole=='legal_associate')
                                        <button class="btn btn-sm btn-outline-danger"
                                                wire:click="addCancel({{ $r->id }})"
                                                wire:loading.attr="disabled">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    @endif

                                </div>

                                <div class="mt-2">
                                    {{ $r->remarks }}
                                </div>
                                @if($r->attachment)

                                <div class="mt-2">

                                    @if(Str::endsWith($r->attachment, ['jpg','jpeg','png']))

                                    <img src="{{ asset($r->attachment) }}"
                                        class="img-fluid rounded"
                                        style="max-width:200px">

                                    @else

                                    <a href="{{ asset($r->attachment) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-pdf"></i> View File
                                    </a>

                                    @endif

                                </div>

                                @endif

                            </div>

                            @endforeach

                            @else

                            <div class="text-muted text-center">
                                No remarks found
                            </div>

                            @endif
                        --}}
                    </div>

            </div>

        </div>


        <!-- RIGHT : ADD REMARK -->
        {{--
        @if($userRole=='legal_associate')
            <div class="col-lg-4"> 
                <!-- Status Card -->
                <div class="card shadow-sm border-0 p-3 mb-3 sticky-card">

                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">Status</h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Current Status:</span>
                            <span class="badge 
                                @if($mcc->status == 'pending') bg-warning
                                @elseif($mcc->status == 'inprogress') bg-info
                                @elseif($mcc->status == 'resolved') bg-success
                                @endif
                                text-white">
                                {{ ucfirst($mcc->status) }}
                            </span>
                        </div>

                        <hr>

                        @if($mcc->status == 'resolved')
                            <!-- Already resolved -->
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle"></i> This case is resolved. You cannot change status.
                            </div>
                        @else
                            <!-- Status buttons -->
                            <div class="d-flex justify-content-between">
                                @foreach(['pending', 'inprogress', 'resolved'] as $statusOption)
                                    @php
                                        $activeClass = '';
                                        if($mcc->status == $statusOption) {
                                            $activeClass = match($statusOption) {
                                                'pending' => 'btn-warning text-white',
                                                'inprogress' => 'btn-info text-white',
                                                'resolved' => 'btn-success text-white',
                                                default => 'btn-secondary text-white',
                                            };
                                        } else {
                                            $activeClass = 'btn-outline-primary';
                                        }
                                    @endphp

                                    <button 
                                        wire:click="preConfirmResolve('{{ $mcc->id }}', '{{ $statusOption }}')" 
                                        class="btn btn-sm {{ $activeClass }} me-1"
                                    >
                                        {{ ucfirst($statusOption) }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Optional info message -->
                            <div id="resolve-warning" class="mt-2 text-danger text-sm fw-semibold" style="display:block;">
                                <small>Once you set this case as resolved, you <strong>cannot revert it back</strong>!</small>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="card shadow-sm border-0 p-3">

                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">Add Remark</h5>
                    </div>

                    <div class="card-body">
                        @if($mcc->status == 'resolved')
                            <!-- Show message if resolved -->
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle"></i> This case is resolved. You cannot add remarks.
                            </div>
                        @else
                            <!-- Add Remark Form -->
                            <form wire:submit.prevent="saveRemark">

                                <div class="mb-3">
                                    <label class="form-label">Remark</label>
                                    <textarea wire:model.defer="remark" class="form-control" rows="4"></textarea>
                                    @error('remark')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Attachment</label>
                                    <input type="file" wire:model="attachment" class="form-control">
                                    @error('attachment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary btn-sm"
                                            wire:loading.attr="disabled"
                                            wire:target="attachment,saveRemark">

                                        <span wire:loading.remove wire:target="saveRemark">
                                            <i class="bi bi-send"></i> Add Remark
                                        </span>

                                        <span wire:loading wire:target="saveRemark">
                                            <span class="spinner-border spinner-border-sm"></span>
                                            Saving...
                                        </span>

                                    </button>
                                </div>

                            </form>
                        @endif
                    </div>

                </div>

            </div>
        @endif
            ---}}
    </div>

     @if($userRole=='legal_associate')
    <div wire:ignore.self class="modal fade" id="add-remarks" tabindex="-1" aria-labelledby="add-remarksLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                       Add Remark
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                @if($mcc->status == 'resolved')
                    <div class="modal-body">
                        <!-- Show message if resolved -->
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle"></i> This case is resolved. You cannot add remarks.
                        </div>
                    </div>
                @else
                    <!-- Add Remark Form -->
                    <form wire:submit.prevent="saveRemark">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Remark</label>
                                <textarea wire:model.defer="remark" class="form-control" rows="4"></textarea>
                                @error('remark')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attachment</label>
                                <input type="file" wire:model="attachment" class="form-control">
                                @error('attachment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary"
                                    wire:loading.attr="disabled"
                                    wire:target="attachment,saveRemark">

                                <span wire:loading.remove wire:target="saveRemark">
                                    <i class="bi bi-send"></i> Add Remark
                                </span>

                                <span wire:loading wire:target="saveRemark">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                @endif

                
                
            </div>
        </div>
    </div>
    @endif




    <!-- Loader -->
    <div class="loader-container" wire:loading wire:target="saveRemark">

        <div class="loader"></div>

    </div>


    @push('scripts')
    <!-- ✅ Toastr setup -->
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('showStatusConfirm', event => {
            let itemId = event.detail[0].itemId;
            let newStatus = event.detail[0].newStatus;

            if(newStatus === 'resolved') {
                // Show card body warning message first
                const warning = document.getElementById('resolve-warning');
                warning.style.display = 'block';

                Swal.fire({
                    title: 'Are you sure?',
                    html: 'Once you resolve this case, it cannot be reverted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, resolve it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    warning.style.display = 'none'; // hide after decision
                    if(result.isConfirmed){
                        @this.call('updateStatus', itemId, newStatus);
                    }
                });
            } else {
                @this.call('updateStatus', itemId, newStatus);
            }
        });
        window.addEventListener('showConfirm', function (event) {
            let itemId = event.detail[0].itemId;

            Swal.fire({
                title: "Cancel Remark?",
                text: "Are you sure you want to cancel this remark? This action will mark the remark as cancelled.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, Cancel it",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('CancelRemarks', itemId);
                }
            });
        });

        window.addEventListener('ResetForm', () => {

            // Reset all forms
            document.querySelectorAll('form').forEach(form => form.reset());

            // Clear file inputs manually (sometimes needed)
            document.querySelectorAll('input[type="file"]').forEach(fileInput => {
                fileInput.value = '';
            });

        });
       
    </script>
    
    
    @endpush

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lc-lightbox-lite@1.5.0/css/lc_lightbox.min.css'/>
<script src="https://cdn.jsdelivr.net/npm/lc-lightbox-lite@1.5.0/js/lc_lightbox.lite.min.js"></script>

<script>
    lc_lightbox('.lightbox', {
      wrap_class: 'lcl_fade_oc',
      gallery   : true,
      thumb_attr: 'data-lcl-thumb',
      skin      : 'light',
      radius    : 4,
      padding   : 0,
      border_w  : 0
    });
</script>

</div>