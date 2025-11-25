<div>
    <div class="row g-4">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-megaphone-fill me-2 text-primary"></i> Campaigns
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Admin</a>
                    </li>
                    <li class="breadcrumb-item active text-primary">Campaigns</li>
                </ol>
            </div>
            <div>
                <button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#uploadcampaignerModal">
                    <i class="bi bi-upload me-1"></i> Import Campaigner
                </button>
                <button class="btn btn-primary btn-sm" wire:click="openCampaignModal" data-bs-toggle="modal"
                    data-bs-target="#campaignModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Campaign
                </button>
            </div>
        </div>


        <!-- Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 filter-card">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Campaigns</h5>
                    <div class="d-flex align-items-center">
                        <div wire:ignore>
                            <select wire:model="filter_by_assembly" class="form-select chosen-select">
                                <option value="">Filer by Assembly</option>
                                @foreach ($assembly as $assemb)
                                <option value="{{ $assemb->id }}">
                                    {{ $assemb->assembly_name_en }} ({{ $assemb->assembly_code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div  wire:ignore>
                            <select wire:model="filter_by_district" class="form-select chosen-select">
                                <option value="">Filer by District</option>
                                @foreach ($districts as $district)
                                <option value="{{ $district->id }}">
                                    {{ $district->name_en }} ({{ $district->name_bn }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div  wire:ignore>
                            <select wire:model="filter_by_zone" class="form-select chosen-select">
                                <option value="">Filer by Zone</option>
                                @foreach ($zones as $z)
                                    <option value="{{ $z->id }}">{{ $z->name }}</option>
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
                                    <th>#</th>
                                    <th>Campaigner</th>
                                    <th>Assembly</th>
                                    <th>Event Type</th>
                                    <th>Date & Time</th>
                                    <th>Permissions</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($campaigns as $index => $camp)
                                <tr class="text-center">

                                    <!-- SL -->
                                    <td class="fw-bold text-dark">
                                        {{ $campaigns->firstItem() + $index }}
                                    </td>

                                    <!-- Campaigner -->
                                    <td class="text-start">
                                        <div class="fw-semibold">{{ ucwords($camp->campaigner->name) }}</div>
                                        <div class="text-muted small"><i class="bi bi-telephone"></i> {{ $camp->campaigner->mobile }}</div>
                                        <div class="small">{{ $camp->address }}</div>
                                    </td>

                                    <!-- Assembly -->
                                    <td class="text-start">
                                        <div class="fw-semibold">{{ ucwords($camp->assembly->assembly_name_en ?? '_') }}</div>
                                        <div class="text-muted small">Code: {{ $camp->assembly->assembly_code ?? '-' }}</div>
                                        <div class="small text-primary">
                                            ({{ ucwords($camp->assembly->assemblyPhase->phase->name ?? 'N/A') }})
                                        </div>
                                    </td>

                                    <!-- Event Type -->
                                    <td class="fw-semibold">
                                        {{ ucwords($camp->category->name) ?? '-' }}
                                    </td>

                                    <!-- Dates -->
                                    <td class="text-start">
                                        <div class="mb-1">
                                            <i class="bi bi-calendar-event text-primary me-1"></i>
                                            <strong>Campaign:</strong>
                                            {{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}
                                        </div>
                                        <div>
                                            <i class="bi bi-calendar-check text-danger me-1"></i>
                                            <strong>Last Permission:</strong>
                                            {{ date('d M Y, h:i A', strtotime($camp->last_date_of_permission)) }}
                                        </div>
                                    </td>

                                    <!-- Permission Count -->
                                    <td>
                                        <span class="badge bg-danger">  
                                            {{ $camp->category->permissions->count() ?? 0 }} Required
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <select class="form-select form-select-sm px-2 w-auto mx-auto"
                                            wire:change="statusChanged({{ $camp->id }}, $event.target.value)">
                                            <option value="pending" @selected($camp->status == 'pending')>Pending</option>
                                            <option value="rescheduled" @selected($camp->status == 'rescheduled')>Rescheduled</option>
                                            <option value="cancelled" @selected($camp->status == 'cancelled')>Cancelled</option>
                                            <option value="completed" @selected($camp->status == 'completed')>Completed</option>
                                        </select>

                                        @if($camp->status == 'rescheduled' && $camp->rescheduled_at)
                                            <small class="text-primary d-block mt-1">
                                                <i class="bi bi-clock-history"></i>
                                                {{ date('d M Y, h:i A', strtotime($camp->rescheduled_at)) }}
                                            </small>
                                        @endif

                                        @if($camp->status == 'cancelled' && $camp->cancelled_remarks)
                                            <small class="text-danger d-block mt-1">
                                                <i class="bi bi-x-circle"></i>
                                                {{ ucwords($camp->cancelled_remarks) }}
                                            </small>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="btn-group">

                                            <!-- Edit -->
                                            <button class="btn btn-sm btn-outline-primary"
                                                title="Edit Campaign"
                                                wire:click="edit({{ $camp->id }})"
                                                data-bs-toggle="modal" data-bs-target="#campaignModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Permission -->
                                            <a href="{{ route('admin.campaigns.permission', $camp->id) }}"
                                                class="btn btn-sm btn-outline-success"
                                                title="View Permissions">
                                                <i class="bi bi-file-earmark-arrow-up"></i>
                                            </a>

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
                    {{ $campaigns->links('pagination.custom') }}
                </div>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="RescheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            {{$selected_status == 'rescheduled' ? 'Rescheduled Campaign' : 'Cancel Campaign'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    @if($selected_status == 'rescheduled')
                    <div class="modal-body">
                        <label class="form-label">Rescheduled Date</label>
                        <input type="datetime-local" wire:model="rescheduled_at" class="form-control">

                        @error('rescheduled_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if($selected_status == 'cancelled')
                    <div class="modal-body">
                        <label class="form-label">Cancelled Remarks</label>
                        <textarea wire:model="cancelled_remarks" class="form-control" rows="3"></textarea>

                        @error('cancelled_remarks')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button class="btn btn-primary" wire:click="saveCampaignStatus">
                            Save
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <!-- Form -->
        <div wire:ignore.self class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel"
        aria-hidden="true" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="campaignModalLabel">{{ $isEdit ? 'Edit Campaign' : 'Add Campaign' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form wire:submit.prevent="save"
                            wire:key="campaign-form-{{ $campaign_id ?? 'new' }}">
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

                                <!-- Event Category -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Category</label>
                                    <select class="form-control" wire:model="event_category_id">
                                        <option value="">Select Event Category</option>
                                        @foreach($eventCategory as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" wire:model="address">
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Campaign Date -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Campaign Date</label>
                                    <input type="datetime-local" class="form-control" wire:model="campaign_date">
                                    @error('campaign_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Last date of permission -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Last Date Of Permission</label>
                                    <input type="datetime-local" class="form-control" wire:model="last_date_of_permission">
                                    @error('last_date_of_permission') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Campaigner</label>
                                    <select class="form-control" wire:model="campaigner_id">
                                        <option value="">Select Campaigner</option>
                                        @foreach($campaigners as $camp)
                                            <option value="{{ $camp->id }}">{{ $camp->name }}({{$camp->mobile}})</option>
                                        @endforeach
                                    </select>
                                    @error('campaigner_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" wire:model="remarks" rows="3"></textarea>
                                    @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
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
        window.addEventListener('close-modal', event => {
            let modalId = event.detail.modalId;
            let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            modal.hide();
        });
    </script>
    <script>
        document.addEventListener('livewire:init', function () {

            Livewire.on('open-reschedule-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('RescheduleModal'));
                modal.show();
            });

            Livewire.on('close-reschedule-modal', () => {
                let modal = bootstrap.Modal.getInstance(document.getElementById('RescheduleModal'));
                modal.hide();
            });

        });
    </script>
    <script>
        window.addEventListener('refreshChosen', () => {
            $('.chosen-select').val('').trigger('chosen:updated');
        });
    </script>
    @endpush
</div>
