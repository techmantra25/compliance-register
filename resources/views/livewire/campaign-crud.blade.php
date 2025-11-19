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
                <button class="btn btn-secondary btn-sm me-2" wire:click="importCampaigner">
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
            <div class="card shadow-sm border-0 p-3">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Campaigns</h5>

                    <input type="text" wire:model="search"
                        class="form-control form-control-sm w-auto"
                        placeholder="Search...">
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Candidates</th>
                                    <th>Assembly</th>
                                    <th>Phase</th>
                                    <th>Event Type</th>
                                    <th>Place</th>
                                    <th>Date & Time</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($campaigns as $index => $camp)
                                    <tr wire:key="campaign-row-{{ $camp->id }}">
                                        <td>{{ $campaigns->firstItem() + $index }}</td>

                                        <td>{{ $camp->candidate_name }}</td>

                                        <td>{{ $camp->assembly->assembly_name_en ?? '-' }}</td>

                                        <td>{{ $camp->phase ?? '-' }}</td>

                                        <td>{{ $camp->category->name ?? '-' }}</td>

                                        <td>{{ $camp->address }}</td>

                                        <td>{{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}</td>

                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="edit({{ $camp->id }})" data-bs-toggle="modal" data-bs-target="#campaignModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- <button class="btn btn-sm btn-danger"
                                                    wire:click="delete({{ $camp->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-3">
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
                                                <option value="{{ $a->id }}" data-code="{{ $a->assembly_code }}">
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
    <div class="loader-container" wire:loading wire:target="save,openCampaignModal">
        <div class="loader"></div>
    </div>

    </div>
    @push('scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
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
            $('#campaignModal').modal('hide');
        });

    </script>
    @endpush
</div>
