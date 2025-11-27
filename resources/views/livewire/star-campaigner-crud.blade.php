<div>
    <div class="row g-4">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-megaphone-fill me-2 text-primary"></i> Campaigners
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Admin</a>
                    </li>
                    <li class="breadcrumb-item active text-primary">Campaigners</li>
                </ol>
            </div>
            <div>
                @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_import_campaigner'))
                <button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#uploadcampaignerModal">
                    <i class="bi bi-upload me-1"></i> Import Campaigner
                </button>
                @endif
                <button class="btn btn-primary btn-sm" wire:click="openAddModal" data-bs-toggle="modal"
                    data-bs-target="#campaignerModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Campaigner
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 filter-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Campaigners</h5>
                    <div class="d-flex align-items-center">
                        <input type="text" wire:model="search" wire:keyup="filtercampaigner($event.target.value)"
                            class="form-control form-control-sm w-auto me-2"
                            placeholder="Search here...">


                        <button class="btn btn-sm btn-danger" wire:click="resetFilters">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 shadow-sm rounded">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Extra Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($campaigners as $index => $camp)
                                <tr class="text-center">

                                    <td class="fw-bold text-dark">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="text-start">
                                        <div class="fw-semibold">{{ ucwords($camp->name) }}</div>
                                    </td>

                                    <td class="text-start">
                                        <div class="fw-semibold">{{ $camp->mobile }}</div>
                                    </td>

                                    <td class="fw-semibold">
                                        {{ ucwords($camp->extra_details) ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <!-- Edit -->
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_update_campaigner'))
                                            <button class="btn btn-sm btn-outline-primary"
                                                title="Edit Campaigner"
                                                wire:click="openEditModal({{ $camp->id }})"
                                                data-bs-toggle="modal" data-bs-target="#campaignerModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            @endif
                                             @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_delete_campaigner'))
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="confirmDelete({{ $camp->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle"></i> No campaigns found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-end">
                    {{ $campaigners->links('pagination.custom') }}
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="campaignerModal" tabindex="-1" aria-labelledby="campaignerModalLabel"
            aria-hidden="true" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="campaignerModalLabel">{{ $isEdit ? 'Edit Campaigner' : 'Add Campaigner' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form wire:submit.prevent="save"
                            wire:key="campaign-form-{{ $campaigner_id ?? 'new' }}">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" wire:model="name">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile</label>
                                    <input type="number" class="form-control" wire:model="mobile">
                                    @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Extra Details</label>
                                    <input type="text" class="form-control" wire:model="extra_details">
                                    @error('extra_details') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-primary" wire:click="save">
                            {{ $isEdit ? 'Update' : 'Save' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="uploadcampaignerModal" tabindex="-1"
            aria-labelledby="uploadcampaignerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-3">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="uploadcampaignerModalLabel">Upload Campaigner</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row g-3">
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {!! session('error') !!}
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="col-12">
                                <a href="{{ asset('assets/sample-csv/bulk-campaigner.csv') }}" download
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Download Sample CSV
                                </a>
                            </div>

                            <div class="col-12">
                                <label for="campaignerFile" class="form-label fw-semibold mt-3">Upload Campaigner CSV</label>
                                <input type="file" class="form-control" id="campaignerFile" wire:model="campaignerFile" accept=".csv">
                                
                                <div wire:loading wire:target="campaignerFile" class="text-muted mt-2">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="resetForm">Close</button>

                        <button type="button" class="btn btn-primary"
                            wire:click="saveCampaigner"
                            wire:loading.remove
                            wire:target="campaignerFile">
                            <i class="bi bi-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));

        window.addEventListener('confirmDelete', function (event) {
            let itemId = event.detail[0].itemId;
            Swal.fire({
                title: "Delete Campaigner?",
                text: "Are you sure you want to delete this campaigner?",
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
    <script>
        window.addEventListener('showModal', () => {
            var myModal = new bootstrap.Modal(document.getElementById('campaignerModal'));
            myModal.show();
        });

        window.addEventListener('hideModal', () => {
            var myModalEl = document.getElementById('campaignerModal');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
    </script>
@endpush

