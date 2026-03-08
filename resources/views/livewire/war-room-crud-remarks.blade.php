<div>
    <style>
        .cancelled-remark {
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
                    War Room Remarks
                </h4>
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">War Room</a></li>
                    <li class="breadcrumb-item active text-primary">Remarks Trail</li>
                </ol>
            </div>
            <div>
                <a href="{{ route('admin.war_room') }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>
        </div>

        <!-- LEFT : REMARKS TRAIL -->
        <div class="col-lg-{{ $userRole=='legal_associate' ? 8 : 12 }}">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h5 class="fw-bold mb-1">Remarks History</h5>
                            <div class="small text-muted">
                                <span class="me-3"><strong>Code:</strong> {{ $war->war_code }}</span>
                                <span class="me-3"><strong>Assembly:</strong> {{ optional($war->assembly)->assembly_name_en }}</span>
                                <span class="me-3"><strong>Severity:</strong> {{ ucfirst($war->severity) }}</span>
                            </div>
                            <div class="small text-muted mt-1">
                                <span class="me-3"><strong>Reported By:</strong> {{ $war->reported_by }}</span>
                                <span><strong>Contact:</strong> {{ $war->contact_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($remarks->count())
                        @foreach($remarks as $r)
                        <div class="border rounded p-3 mb-3 position-relative {{ $r->is_cancelled ? 'opacity-50 cancelled-remark' : '' }}" wire:key="item-{{$r->id}}">
                            @if($r->is_cancelled)
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">Cancelled</span>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">{{ $r->created_at->format('d M Y h:i A') }}</span>
                                @if(!$r->is_cancelled && $userRole=='legal_associate')
                                    <button class="btn btn-sm btn-outline-danger" wire:click="addCancel({{ $r->id }})">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @endif
                            </div>
                            <div class="mt-2">{{ $r->remarks }}</div>
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
                        <div class="text-muted text-center">No remarks found</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT : ADD REMARK -->
        @if($userRole=='legal_associate')
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">Add Remark</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveRemark">
                        <div class="mb-3">
                            <label class="form-label">Remark</label>
                            <textarea wire:model.defer="remark" class="form-control" rows="4"></textarea>
                            @error('remark') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attachment</label>
                            <input type="file" wire:model="attachment" class="form-control">
                            @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveRemark"><i class="bi bi-send"></i> Add Remark</span>
                                <span wire:loading wire:target="saveRemark"><span class="spinner-border spinner-border-sm"></span> Saving...</span>
                            </button>
                        </div>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    </script>
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
        window.addEventListener('showConfirm', function (event) {
            let itemId = event.detail[0].itemId;
            Swal.fire({
                title: "Cancel Remark?",
                text: "This will mark the remark as cancelled.",
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
            document.querySelectorAll('form').forEach(f => f.reset());
            document.querySelectorAll('input[type="file"]').forEach(f => f.value='');
        });
    </script>
    @endpush
</div>