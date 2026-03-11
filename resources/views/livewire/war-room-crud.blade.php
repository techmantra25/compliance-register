<div>
    <div class="row g-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i> War Room
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Admin</a>
                    </li>
                    <li class="breadcrumb-item active text-danger">War Room</li>
                </ol>
            </div>
            <div>
                <button class="btn btn-primary btn-sm" wire:click="openWarModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Incident
                </button>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 filter-card">
                <div class="card-header bg-white d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center">
                        <div wire:ignore class="me-2">
                            <select wire:model="filter_by_status" class="form-select chosen-select">
                                <option value="">Filter by Status</option>
                                <option value="pending">Pending</option>
                                <option value="inprogress">Inprogress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                        <div wire:ignore class="me-2">
                            <select wire:model="filter_by_assembly" class="form-select chosen-select">
                                <option value="">Filter by Assembly</option>
                                @foreach ($assemblies as $assemb)
                                <option value="{{ $assemb->id }}">
                                    ({{ $assemb->assembly_code }}) {{ $assemb->assembly_name_en }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <input type="text" wire:model="search" wire:keyup="filterCampaign($event.target.value)"
                            class="form-control form-control-sm me-2"
                            placeholder="Search here..." style="width: 420px;">


                        <button class="btn btn-sm btn-danger" wire:click="resetFilters">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Incident</th>
                                    <th width="25%">Location</th>
                                    <th width="25%">Reporter</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Assigned</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($warList as $item)

                                <tr>

                                    <!-- Incident -->
                                    <td>

                                        <div class="fw-bold text-danger">
                                            {{ $item->war_code }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $item->created_at->format('d M Y h:i:A') }}
                                        </div>

                                    </td>


                                    <!-- Location -->
                                    <td class="small">

                                        <div>
                                            <strong>Assembly:</strong>
                                            {{ optional($item->assembly)->assembly_name_en ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>District:</strong>
                                            {{ optional($item->district)->name_en ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>Block:</strong> {{ $item->block_town ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>GP/Ward:</strong> {{ $item->gp_word ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>Booth:</strong> {{ $item->booth_area ?? '-' }}
                                        </div>

                                    </td>


                                    <!-- Reporter -->
                                    <td class="small">

                                        <div>
                                            <strong>Complainant:</strong>
                                            {{ $item->reported_by ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>Phone:</strong>
                                            {{ $item->contact_number ?? '-' }}
                                        </div>

                                        <div>
                                            <strong>WhatsApp:</strong>
                                            {{ $item->incident_from_name ?? '-' }}
                                        </div>

                                        <div class="text-muted">
                                            {{ $item->incident_from_number ?? '-' }}
                                        </div>

                                    </td>


                                    <!-- Status -->
                                    <td>

                                        <span class="badge
                                            @if($item->status == 'pending') bg-warning
                                            @elseif($item->status == 'inprogress') bg-info
                                            @elseif($item->status == 'resolved') bg-success
                                            @else bg-secondary
                                            @endif">

                                            {{ ucfirst($item->status) }}

                                        </span>

                                    </td>


                                    <!-- Assigned -->
                                    <td>
                                        @if($item->assigned_to)

                                            <span class="badge bg-success">
                                                {{ ucwords(optional($item->assignedUser)->name) }}
                                            </span>

                                        @else

                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="openAssignModal({{ $item->id }})">
                                                 Assign To
                                            </button>

                                        @endif

                                        </td>

                                    <!-- Action -->
                                    <td>

                                        <div class="d-flex gap-1">

                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'war_room_update'))
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="edit({{ $item->id }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            @endif


                                            <a href="{{ route('admin.war_room_remarks',$item->id) }}"
                                                class="btn btn-sm btn-outline-warning position-relative">

                                                <i class="bi bi-chat-left-text"></i>

                                                @php
                                                $unreadRemarks = $item->remarks()->where('is_read',0)->count();
                                                @endphp

                                                @if($unreadRemarks > 0)

                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{ $unreadRemarks }}
                                                </span>

                                                @endif

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                                @empty

                                <tr>
                                    <td colspan="6" class="text-center text-danger fw-bold">
                                        No Records Found
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                        <!-- Pagination -->
                        <div class="mt-2 d-flex justify-content-end">
                            {{ $warList->links('pagination.custom') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

        <div wire:ignore.self class="modal fade" id="assignModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Assign Legal Associate</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Select Associate</label>

                            <select class="form-control" wire:model="assigned_to">
                                <option value="">Select</option>

                                @foreach($legalAssociates as $user)
                                <option value="{{ $user->id }}">
                                    {{ ucwords($user->name) }}
                                </option>
                                @endforeach

                            </select>

                            @error('assigned_to')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button class="btn btn-success" wire:click="updateAssign">
                            Assign
                        </button>
                    </div>

                </div>
            </div>
        </div>


    <div wire:ignore.self class="modal fade" id="warModal" tabindex="-1" aria-labelledby="warModalLabel" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="warModalLabel">
                        {{ $isEdit ? 'Edit War Room Incident' : 'Add War Room Incident' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="save" wire:key="war-form-{{ $war_id ?? 'new' }}">
                        <div class="row g-3">

                            <!-- Assembly -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Assembly<span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select class="form-control chosen-select" wire:model="assembly_id">
                                        <option value="">Select Assembly</option>
                                        @foreach($assemblies as $a)
                                            <option value="{{ $a->id }}">({{ $a->assembly_number }}) {{ $a->assembly_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assembly_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Block / Town -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Block / Town<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="block_town" placeholder="Enter Block or Town">
                                @error('block_town') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- GP / Word -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">GP / Word<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="gp_word" placeholder="Enter GP or Word">
                                @error('gp_word') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- Booth / Area -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Booth / Area<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="booth_area" placeholder="Enter Booth or Area">
                                @error('booth_area') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Time of Incident -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Time of Incident</label>
                                <input type="text" class="form-control" wire:model="incident_time" placeholder="Eg: 12:30 PM">
                                @error('incident_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Reported By -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Reported By<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="reported_by" placeholder="Enter Reporter Name">
                                @error('reported_by') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Contact Number<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" wire:model="contact_number" placeholder="Enter 10-digit number">
                                @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Assign To -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Assign Legal Associate</label>
                                <select class="form-control" wire:model="assigned_to">
                                    <option value="">Select Associate</option>
                                    @foreach($legalAssociates as $user)
                                        <option value="{{ $user->id }}">{{ ucwords($user->name) }}</option>
                                    @endforeach
                                </select>
                                @error('assigned_to') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Incident Description -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Incident Description<span class="text-danger">*</span></label>
                                <textarea class="form-control" wire:model="incident_description" rows="3" placeholder="Describe the incident"></textarea>
                                @error('incident_description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" wire:click="save">
                        {{ $isEdit ? 'Update Incident' : 'Save Incident' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
        <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>

        <script>
            // Toastr notifications
            window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
            window.addEventListener('toastr:success', e => toastr.success(e.detail.message));

            // Initialize Chosen dropdowns
            function initChosen() {
                $('.chosen-select').chosen({
                    width: '100%',
                    no_results_text: "No result found",
                    search_contains: true
                })
                .off('change')
                .on('change', function() {
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
                $('.chosen-select').each(function() {
                    const el = $(this);
                    const model = el.attr('wire:model');
                    const value = @this.get(model);
                    if (value !== undefined && value !== null) {
                        el.val(value).trigger('chosen:updated');
                    }
                });
                initChosen();
            });

            // Refresh chosen manually
            document.addEventListener('refreshChosen', () => {
                const chosen = $('.chosen-select');
                if (chosen.length) {
                    chosen.trigger('chosen:updated');
                }
            });

            // Clear all inputs
            document.addEventListener('resetField', () => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
            });

            // Clear search input
            window.addEventListener('clear-search-input', () => {
                const input = document.querySelector('input[wire\\:model="search"]');
                if (input) input.value = '';
            });

            // Modal open/close events
            window.addEventListener('open-war-modal', () => {
                $("#warModal").modal('show');
            });
            window.addEventListener('open-edit-modal', () => {
                $("#warModal").modal('show');
            });
            window.addEventListener('closeModal', () => {
                $("#warModal").modal('hide');
            });

            window.addEventListener('open-assign-modal', () => {
                $("#assignModal").modal('show');
            });

            window.addEventListener('closeAssignModal', () => {
                $("#assignModal").modal('hide');
            });

            // Handle modal hide and remove backdrop properly
            document.addEventListener('livewire:init', () => {
                Livewire.on('modelHide', () => {
                    $("#warModal").modal('hide');
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = "";
                });
            });
        </script>
        @endpush
</div>