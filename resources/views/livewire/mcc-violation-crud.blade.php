<div>
   <style>
        .status-dropdown {
            background: #f8f9fa;
            border: 1px solid #dee2e6 !important;
            cursor: pointer;
            transition: 0.2s;
        }
        .status-dropdown:hover {
            background: #eef2f6;
        }
        .alert {
            border-left-width: 4px;
            border-left-style: solid;
        }
        .alert-primary { border-left-color: #0d6efd; }
        .alert-danger { border-left-color: #dc3545; }
    </style>

    <div class="row g-4">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-megaphone-fill me-2 text-primary"></i> MCC Violation
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Admin</a>
                    </li>
                    <li class="breadcrumb-item active text-primary">MCC</li>
                </ol>
            </div>
            <div>
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_export_mcc'))
                <button class="btn btn-primary btn-sm" wire:click="exportMcc">
                    <i class="bi bi-download me-1"></i> Export MCC
                </button>
                @endif
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_import_mcc'))
                <button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#importMccModal">
                    <i class="bi bi-upload me-1"></i> Import MCC
                </button>
                @endif
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_add_mcc'))
                <button class="btn btn-primary btn-sm" wire:click="openMccModal">
                    <i class="bi bi-plus-circle me-1"></i> Add MCC
                </button>
                @endif
            </div>
        </div>


        <!-- Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 filter-card">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">MCC</h5>
                    <div class="d-flex align-items-center">
                        <div wire:ignore class="me-2">
                            <select wire:model="filter_by_status" class="form-select chosen-select">
                                <option value="">Filter by Status</option>
                                <option value="pending">Pending</option>
                                <option value="inprogress">Inprogress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                        <div wire:ignore>
                            <select wire:model="filter_by_assembly" class="form-select chosen-select">
                                <option value="">Filter by Assembly</option>
                                @foreach ($assembly as $assemb)
                                <option value="{{ $assemb->id }}">
                                    {{ $assemb->assembly_name_en }} ({{ $assemb->assembly_code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <input type="text" wire:model="search" wire:keyup="filterCampaign($event.target.value)"
                            class="form-control form-control-sm w-auto me-2"
                            placeholder="Search here...">


                        <button class="btn btn-sm btn-danger" wire:click="resetFilters">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Assembly</th>
                                    <th>Block & GP</th>
                                    <th>Complainer Details</th>
                                    <th>Date & Time</th>
                                    <th>Assign To</th>
                                    <th width="15%">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mccList as $key => $item)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $item->mcc_code }}</div>

                                            <div class="text-muted small">
                                                @if($item->category == 'For AITC')
                                                    <span class="badge bg-primary">{{ ucwords($item->category) }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ ucwords($item->category) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="fw-semibold">{{ ucwords(optional($item->assembly)->assembly_name_en ?? '_') }}</div>
                                            <div class="text-muted small">District: {{ optional(optional($item->assembly)->district)->name_en }}</div>
                                            <div class="small text-primary">
                                                {{ ucwords(optional(optional(optional($item->assembly)->assemblyPhase)->phase)->name ?? 'N/A') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ ucwords($item->block) }}</div>
                                            <div class="text-muted small">GP: {{ ucwords($item->gp) }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ ucwords($item->complainer_name) }}</div>
                                            <div class="text-muted small">
                                                <i class="bi bi-telephone me-1"></i> {{ $item->complainer_phone }}
                                            </div>
                                        </td>
                                        <td>{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-lavel-success" title="Action Taken">
                                                {{ ucwords($item->legalAssociate->name ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($item->status == 'pending') bg-warning
                                                @elseif($item->status == 'inprogress') bg-info
                                                @elseif($item->status == 'resolved') bg-success
                                                @else bg-secondary
                                                @endif">

                                                {{ ucwords(str_replace('_',' ', $item->status)) }}

                                            </span>
                                        </td>

                                        <td class="text-center">

                                            <!-- Edit Button -->
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_update_mcc') && $item->status == "pending")
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                            wire:click="edit({{ $item->id }})">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <span class="tooltip-text">Edit MCC</span>
                                                </div>
                                            </div>
                                            @endif
                                            <!-- View MCC Log -->
                                            {{-- @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_view_mcc_log'))
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{ route('admin.mcc_log_details', $item->id) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-clock-history"></i>
                                                    </a>
                                                    <span class="tooltip-text">View MCC Log</span>
                                                </div>
                                            </div>
                                            @endif --}}


                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{route('admin.mcc_violation_remarks', $item->id)}}" class="btn btn-sm btn-outline-warning position-relative">

                                                        <i class="bi bi-chat-left-text"></i>

                                                        @php
                                                            $unreadRemarks = $item->Remarks()->where('is_read', 0)->count();
                                                        @endphp

                                                        @if($unreadRemarks > 0)
                                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                {{ $unreadRemarks }}
                                                            </span>
                                                        @endif

                                                    </a>
                                                    <span class="tooltip-text">View Remarks</span>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-danger fw-bold">
                                            No Records Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-end">
                    {{ $mccList->links('pagination.custom') }}
                </div>
            </div>
        </div>


        <!-- Form -->
        <div wire:ignore.self class="modal fade" id="mccModal" tabindex="-1" aria-labelledby="mccModalLabel"
            ria-hidden="true" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mccModalLabel">{{ $isEdit ? 'Edit MCC' : 'Add MCC' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form wire:submit.prevent="save"
                            wire:key="mcc-form-{{ $mcc_id ?? 'new' }}">
                            <div class="row">
                                <!-- Assembly -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Assembly</label>
                                    <div wire:ignore>
                                        <select class="form-control chosen-select" wire:model="assembly_id">
                                            <option value="">Select Assembly</option>
                                            @foreach($assembly as $a)
                                                <option value="{{ $a->id }}" data-code="{{ $a->assembly_code }}"
                                                    data-number="{{ $a->assembly_number }}">
                                                    {{ $a->assembly_name_en }}({{$a->assembly_code}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('assembly_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category<span class="text-danger">*</span></label>
                                    <select class="form-control" wire:model="category">
                                        <option value="">Select Category</option>
                                        <option value="For AITC">For AITC</option>
                                        <option value="Against AITC">Against AITC</option>
                                    </select>

                                    @error('category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Block/Municipality/Town<span class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="block" placeholder="Enter Block/Municipality/Town"></textarea>
                                    @error('block') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>GP/Word<span class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="gp" placeholder="Enter GP/Word"></textarea>
                                    @error('gp') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Complainer Name<span class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="complainer_name" placeholder="Enter Complainer Name"></textarea>
                                    @error('complainer_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Complainer Phone<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" wire:model="complainer_phone">
                                    @error('complainer_phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Complainer Description</label>
                                    <textarea class="form-control" wire:model="complainer_description" placeholder="Write your complain here"></textarea>
                                    @error('complainer_description') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Assign To</label>
                                    <select class="form-control" wire:model="action_taken">
                                        <option value="">Select Legal Associate</option>

                                        @foreach($legalAssociates as $associate)
                                            <option value="{{ $associate->id }}" data-code="{{ $associate->name }}"
                                                    data-number="{{ $associate->name }}">
                                                {{ ucwords($associate->name) }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('action_taken')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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

        <div wire:ignore class="modal fade" id="escalationModal" tabindex="-1" aria-labelledby="actionTakenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-l"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Escalated To</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Escalated To</label>
                        <input type="text" class="form-control" wire:model="action_taken">
                        @error('action_taken') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-sm" wire:click="saveActionTaken">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="importMccModal" tabindex="-1"
            aria-labelledby="importMccModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-3">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="uploadcampaignerModalLabel">Upload MCC</h5>
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
                                <a href="{{ asset('assets/sample-csv/bulk-mcc.csv') }}" download
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Download Sample CSV
                                </a>
                            </div>

                            <div class="col-12">
                                <label for="mccFile" class="form-label fw-semibold mt-3">Upload MCC CSV</label>
                                <input type="file" class="form-control" id="mccFile" wire:model="mccFile" accept=".csv">
                                    @error('mccFile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror

                                <div wire:loading wire:target="mccFile" class="text-muted mt-2">
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
                            wire:click="saveMcc"
                            wire:loading.remove
                            wire:target="mccFile">
                            <i class="bi bi-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="loader-container" wire:loading wire:target="save,openCampaignModal,edit">
            <div class="loader"></div>
        </div>

    </div>
        @push('scripts')
        <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
        <script>
            window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
            window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        </script>

        <script>
            function initChosen() {
                $('.chosen-select').chosen({
                    width: '100%',
                    no_results_text: "No result found",
                    search_contains: true
                })
                .off('change')
                .on('change', function () {
                    let model = $(this).attr('wire:model');
                    if (model) {
                        @this.set(model, $(this).val());
                    }
                });
            }

            document.addEventListener("DOMContentLoaded", () => {
                initChosen();
            });

            Livewire.hook('morph.updated', () => {
            
                $('.chosen-select').each(function () {
                    const el = $(this);
                    const model = el.attr('wire:model');
                    const liveValue = @this.get(model);
                    
                    if (liveValue !== undefined && liveValue !== null) {
                        el.val(liveValue).trigger('chosen:updated');
                    }
                });
                initChosen();
            });

            document.addEventListener('refreshChosen', () => {
                const chosen = $('.chosen-select');

                if (chosen.length) {
                    chosen.trigger('chosen:updated');
                }
            });

            document.addEventListener('resetField', () => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
            });
            document.addEventListener('modelHide', () => {
                $('#campaignerModal').modal('hide');
            });

        </script>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('refreshChosen', () => {
                    $(".chosen-select").trigger("chosen:updated");
                });


                Livewire.on('modelHide', () => {
                    $("#mccModal").modal('hide');

                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = "";
                });
            });

        </script>

        <script>
            window.addEventListener('closeModal', () => {
                $("#mccModal").modal('hide');
                $("#importMccModal").modal('hide');
            });
            window.addEventListener('open-edit-modal', () => {
                $("#mccModal").modal('show');
            });
            window.addEventListener('open-mcc-modal', () => {
                $("#mccModal").modal('show');
            });
        </script>

        <script>
            window.addEventListener('clear-search-input', () => {
                const input = document.querySelector('input[wire\\:model="search"]');
                if (input) input.value = '';
            });
        </script>

        @endpush
</div>

