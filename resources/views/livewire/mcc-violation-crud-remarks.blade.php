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
                    MCC Remarks
                </h4>

                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted text-decoration-none">Mcc</a>
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
        <div class="col-lg-{{$userRole=='legal_associate'?"8":"12"}}">

            <div class="card shadow-sm border-0 p-3">

                <div class="card-header bg-white">

                    <div class="d-flex justify-content-between align-items-start flex-wrap">

                        <div>
                            <h5 class="fw-bold mb-1">
                                Remarks History
                            </h5>

                            <div class="small text-muted">

                                <span class="me-3">
                                    <strong>MCC Code:</strong> {{ $mcc->mcc_code }}
                                </span>

                                <span class="me-3">
                                    <strong>Category:</strong> {{ $mcc->category }}
                                </span>

                                <span class="me-3">
                                    <strong>Block:</strong> {{ $mcc->block }}
                                </span>

                                <span class="me-3">
                                    <strong>GP:</strong> {{ $mcc->gp }}
                                </span>

                            </div>

                            <div class="small text-muted mt-1">

                                <span class="me-3">
                                    <strong>Complainer:</strong> {{ $mcc->complainer_name }}
                                </span>

                                <span>
                                    <strong>Phone:</strong> {{ $mcc->complainer_phone }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="card-body">

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

                    </div>

            </div>

        </div>


        <!-- RIGHT : ADD REMARK -->
        @if($userRole=='legal_associate')
            <div class="col-lg-4"> 
                <!-- Status Card -->
                <div class="card shadow-sm border-0 p-3 mb-3">

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
    </div>


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

</div>