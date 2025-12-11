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
                        <table class="table table-hover align-middle mb-0 shadow-sm rounded">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>SL No.</th>
                                    <th>Assembly</th>
                                    <th>Block</th>
                                    <th>GP</th>
                                    <th>Complainer Name</th>
                                    <th>Complainer Phone</th>
                                    <th>Complain Description</th>
                                    <th>Date & Time</th>
                                    <th>Action Taken</th>
                                    <th width="15%">
                                        <i class="bi bi-flag me-1"></i> Status
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($mccList as $key => $item)
                                    <tr class="text-center">
                                        <td>{{ $mccList->firstItem() + $key }}</td>
                                        <td class="text-start">
                                            <div class="fw-semibold">{{ ucwords(optional($item->assembly)->assembly_name_en ?? '_') }}</div>
                                            <div class="text-muted small">District: {{ optional(optional($item->assembly)->district)->name_en }}</div>
                                            <div class="small text-primary">
                                                {{ ucwords(optional(optional(optional($item->assembly)->assemblyPhase)->phase)->name ?? 'N/A') }}
                                            </div>
                                        </td>
                                        <td>{{ ucwords($item->block) }}</td>
                                        <td>{{ ucwords($item->gp) }}</td>
                                        <td>{{ ucwords($item->complainer_name) }}</td>
                                        <td>{{ ucwords($item->complainer_phone) }}</td>
                                        <td>{{ ucwords($item->complainer_description) }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                                        <td class="text-center">
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_action_taken_and_status'))
                                            <div class="btn-group">
                                                @if(empty($item->action_taken))
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        title="Action Taken"
                                                        wire:click="openActionTakenModal({{ $item->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#openActionTakenModal">
                                                        Escalated To:
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-success"
                                                        title="Action Taken">
                                                        Escalated To: {{ ucwords($item->action_taken) }}
                                                    </button>
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm"
                                                wire:change="changeStatus({{ $item->id }}, $event.target.value)"
                                                @if($item->status == 'pending_to_process' || $item->status == 'confirm_resolved') disabled @endif >

                                                <option value="pending_to_process"
                                                    {{ $item->status == 'pending_to_process' ? 'selected' : '' }}>
                                                    Pending to Process
                                                </option>
                                                <option value="processed"
                                                    {{ $item->status == 'processed' ? 'selected' : '' }}
                                                    @if($item->status == 'confirm_resolved') disabled @endif>
                                                    Processed
                                                </option>
                                                <option value="confirm_resolved"
                                                    {{ $item->status == 'confirm_resolved' ? 'selected' : '' }}>
                                                    Resolved
                                                </option>
                                            </select>

                                            <span class="badge 
                                                @if($item->status == 'pending_to_process') bg-warning
                                                @elseif($item->status == 'processed') bg-info
                                                @elseif($item->status == 'confirm_resolved') bg-success
                                                @else bg-secondary
                                                @endif
                                                ">
                                                {{ ucwords(str_replace('_',' ', $item->status)) }}
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted d-block">Remarks: {{ ucwords($item->remarks) ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <!-- Edit -->
                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_update_mcc'))
                                                <button class="btn btn-sm btn-outline-primary"
                                                    title="Edit Campaign"
                                                    wire:click="edit({{ $item->id }})">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                @endif
                                            </div>
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_view_mcc_log'))
                                            <div class="btn group">
                                                <a href="{{ route('admin.mcc_log_details', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Mcc Log">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </a>
                                            </div>
                                            @endif
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
        aria-hidden="true" style="background: rgba(0,0,0,0.5);">
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
                                    <label>Block<span class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="block" placeholder="Enter blocks"></textarea>
                                    @error('block') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>GP<span class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="gp" placeholder="Enter GP"></textarea>
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

        <div wire:ignore class="modal fade" id="importMccModal" tabindex="-1"
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
        <div wire:ignore class="modal fade" id="resolveModal" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Status: Resolved</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Remarks <span class="text-danger"></span></label>
                        <textarea class="form-control" wire:model="remarks" rows="4"
                            placeholder="Enter remarks here..."></textarea>
                        @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success btn-sm" wire:click="saveResolution">Save</button>
                    </div>

                </div>
            </div>
        </div>

    <div class="loader-container" wire:loading wire:target="save,openCampaignModal">
        <div class="loader"></div>
    </div>

    </div>
    @push('scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

            Livewire.on('open-edit-modal', () => {
                $("#mccModal").modal('show');
            });

            Livewire.on('modelHide', () => {
                $("#mccModal").modal('hide');

                // Cleanup leftover backdrop
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = "";
            });
        });

    </script>

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('open-escalation-modal', () => {
                $("#escalationModal").modal('show');
            });

            Livewire.on('close-escalation-modal', () => {
                $("#escalationModal").modal('hide');

                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = "";
                document.querySelector('#resolveModal input[type="text"]').value = '';
            });

        });
    </script>

    <script>
        window.addEventListener('closeModal', event => {
            var modal = bootstrap.Modal.getInstance(document.getElementById(event.detail.id));
            modal.hide();
            location.reload();
           
        });
    </script>

    <script>
        window.addEventListener('clear-search-input', () => {
            const input = document.querySelector('input[wire\\:model="search"]');
            if (input) input.value = '';
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('open-resolve-modal', () => {
                $("#resolveModal").modal('show');
            });

            Livewire.on('close-resolve-modal', () => {

                $("#resolveModal").modal('hide');

                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = "";
                document.querySelector('#resolveModal textarea').value = '';
            });

        });
    </script>

    @endpush
</div>

