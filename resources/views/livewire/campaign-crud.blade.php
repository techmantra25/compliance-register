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
                {{-- @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_import_campaigner'))
                <button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#uploadcampaignerModal">
                    <i class="bi bi-upload me-1"></i> Import Campaigner
                </button>
                @endif --}}
                @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_add_campaign'))
                <button class="btn btn-primary btn-sm" wire:click="openCampaignModal" data-bs-toggle="modal"
                    data-bs-target="#campaignModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Campaign
                </button>
                @endif
            </div>
        </div>


        <!-- Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 ">

                <div class="card-header bg-white">

                    <div class="row g-2 mb-4 justify-content-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="canditate-search">
                                <input type="text" wire:model="search" wire:keyup="filterCampaign($event.target.value)" class="form-control form-control-sm me-2" placeholder="Search here...">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ROW 1 : FILTERS --}}
                    <div class="row g-2 mb-2 justify-content-center">

                        <div class="col-md-6 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_assembly" class="form-select chosen-select">
                                <option value="">Filter by Assembly</option>
                                @foreach ($assembly as $assemb)
                                    <option value="{{ $assemb->id }}">
                                        ({{ $assemb->assembly_code }}) {{ $assemb->assembly_name_en }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_district" class="form-select chosen-select">
                                <option value="">Filter by District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ $district->name_en }} ({{ $district->name_bn }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-2" wire:ignore>
                            <select wire:model="filter_by_zone" class="form-select chosen-select">
                                <option value="">Filter by Zone</option>
                                @foreach ($zones as $z)
                                    <option value="{{ $z->id }}">{{ $z->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-2">
                            <select wire:model="filter_by_status" class="form-select select-style" wire:change="filterStatus($event.target.value)">
                                <option value="">Filter by Status</option>
                                @foreach ($statuses as $status_item)
                                    <option value="{{ $status_item }}">{{ ucwords($status_item) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2 text-md-center text-end">
                            <button class="btn btn-sm btn-danger"
                                wire:click="resetFilters">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>

                    </div>

                    {{-- ROW 2 : SEARCH + RESET --}}
                    <div class="d-flex align-items-center gap-2 justify-content-end">

                        

                        

                    </div>

                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table align-middle">

                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="50">#</th>
                                    <th class="text-start">Campaign Details</th>
                                    <th class="text-start">Campaigner</th>
                                    <th>Permissions</th>
                                    <th width="160">Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($campaigns as $index => $camp)

                                <tr wire:key="item-{{$index}}">

                                    <!-- SL -->
                                    <td class="text-center fw-bold">
                                        {{ $campaigns->firstItem() + $index }}
                                    </td>


                                    <!-- Campaign Details -->
                                    <td class="text-start">

                                        <div class="fw-semibold text-dark mb-1">
                                            <i class="bi bi-megaphone text-primary me-1"></i>
                                            {{ ucwords(optional($camp->category)->name) ?? '-' }}
                                        </div>

                                        <div class="small text-muted mb-1">
                                            <i class="bi bi-geo-alt text-danger"></i>
                                            {{ ucwords(optional($camp->assembly)->assembly_name_en ?? '-') }}
                                        </div>

                                        <div class="small text-muted">

                                            <i class="bi bi-calendar-event text-success me-1"></i>

                                            {{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}

                                        </div>

                                        <div class="small text-secondary">

                                            Permission Last Date:

                                            <strong>
                                                {{ date('d M Y', strtotime($camp->last_date_of_permission)) }}
                                            </strong>

                                        </div>

                                    </td>



                                    <!-- Campaigner -->
                                    <td>

                                        @foreach($camp->campaigners as $campaigner)

                                        <div class="d-flex align-items-center mb-2">

                                            {{-- <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                style="width:34px;height:34px;font-size:13px;font-weight:600">

                                                {{ strtoupper(substr($campaigner->name,0,1)) }}

                                            </div> --}}

                                            <div>

                                                <div class="fw-semibold">
                                                    {{ ucwords($campaigner->name) }}
                                                </div>

                                                <div class="small text-muted">
                                                    <i class="bi bi-telephone"></i>
                                                    {{ $campaigner->mobile }}
                                                </div>

                                            </div>

                                        </div>

                                        @endforeach

                                    </td>


                                    <!-- Permissions -->
                                    @php
                                    $required = $camp->category->permissions->count();
                                    $approved = $camp->permissions->where('doc_type','approved_copy')->count();
                                    @endphp

                                    <td class="text-center">

                                        <div class="progress" style="height:7px">

                                            <div class="progress-bar
                    {{ $approved == $required ? 'bg-success' : 'bg-warning' }}"
                                                style="width:{{ $required ? ($approved/$required)*100 : 0 }}%">
                                            </div>

                                        </div>

                                        <div class="small fw-semibold mt-1">
                                            {{ $approved }}/{{ $required }}
                                        </div>

                                    </td>



                                    <!-- Status -->
                                    <td class="text-center">

                                        <select wire:change="statusChanged({{ $camp->id }}, $event.target.value)"
                                            class="form-select form-select-sm rounded-pill fw-semibold text-center">

                                            <option value="pending" @selected($camp->status=='pending')>
                                                ⏳ Pending
                                            </option>

                                            <option value="rescheduled" @selected($camp->status=='rescheduled')>
                                                🔄 Rescheduled
                                            </option>

                                            <option value="cancelled" @selected($camp->status=='cancelled')>
                                                ❌ Cancelled
                                            </option>

                                            <option value="completed" @selected($camp->status=='completed')>
                                                ✅ Completed
                                            </option>

                                        </select>

                                    </td>



                                    <!-- Action -->
                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <button class="btn btn-outline-primary" wire:click="edit({{ $camp->id }})"
                                                data-bs-toggle="modal" data-bs-target="#campaignModal">

                                                <i class="bi bi-pencil"></i>

                                            </button>


                                            <a href="{{ route('admin.campaigns.permission',$camp->id) }}"
                                                class="btn btn-outline-success">

                                                <i class="bi bi-file-earmark-check"></i>

                                            </a>

                                        </div>

                                    </td>


                                </tr>

                                @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle"></i>
                                        No campaigns found
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
                            <input type="datetime-local" wire:model="new_campaign_date" class="form-control"
                            min="{{ now()->format('Y-m-d\TH:i') }}">

                            @error('new_campaign_date')
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
                        <button class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetSelectField()">Cancel</button>
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
                                                    ({{$a->assembly_code}}){{ $a->assembly_name_en }}
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
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <label class="form-label">Campaign Date</label>
                                    <input type="datetime-local" class="form-control" wire:model="campaign_date">
                                    @error('campaign_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Last date of permission -->
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <label class="form-label">Last Date Of Permission</label>
                                    <input type="datetime-local" class="form-control" wire:model="last_date_of_permission">
                                    @error('last_date_of_permission') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-12 col-lg-6 mb-3">
                                    <div wire:ignore>
                                        <label class="form-label">Event Campaigners</label>
                                        <select class="form-control chosen-select" multiple wire:model="campaigner_ids">
                                            @foreach($campaigners as $camp)
                                                <option value="{{ $camp->id }}">
                                                    {{ ucwords($camp->name) }} ({{ $camp->mobile }})
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>

                                        @error('campaigner_ids')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
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
    
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
        <script>
            window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
            window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        </script>

    <script>
        window.addEventListener('reload-page', () => {
            setTimeout(() => {
                location.reload();
            }, 2000); // 2 seconds
        });
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

            setTimeout(() => {

                $('.chosen-select').each(function () {

                    let el = $(this);
                    let model = el.attr('wire:model');

                    if (!model) return;

                    let component = Livewire.find(
                        el.closest('[wire\\:id]').attr('wire:id')
                    );

                    let value = component.get(model);

                    if (el.prop('multiple')) {
                        // multiple select (campaigners)
                        el.val(value).trigger('chosen:updated');
                    } else {
                        // single select (assembly)
                        el.val(value).trigger('chosen:updated');
                    }

                });

            }, 200);

        });

        document.addEventListener('resetField', () => {
            document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
        });
        document.addEventListener('modelHide', () => {
            $('#uploadcampaignerModal').modal('hide');
            $('#campaignerModal').modal('hide');
            $('#campaignModal').modal('hide');
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
        document.addEventListener('DOMContentLoaded', function () {
            $('#RescheduleModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#campaignModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
    @endpush
</div>
