<div>
    <div class="row g-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-map-fill me-2 text-primary"></i> Zone Management
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none">Admin</a></li>
                    <li class="breadcrumb-item active text-primary">Zones</li>
                </ol>
            </div>
        </div>

        <!-- Left: Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Zones</h5>

                    <div class="d-flex align-items-center gap-2">
                        <input type="text" 
                            wire:model="search" 
                            wire:keyup="filterZones($event.target.value)"
                            class="form-control form-control-sm" 
                            placeholder="Search...">

                        <button class="btn btn-sm btn-danger" wire:click="resetInputFields">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Zone Name</th>
                                    <th>Districts</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($zones as $index => $zone)
                                    <tr wire:key="zone-{{ $zone->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ ucwords($zone->name) }}</td>
                                        <td width="50%">
                                            @if(!empty($zone->district_list))
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($zone->district_list as $key=>$dist)
                                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-sm">
                                                            <i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ $dist }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_update_zone'))
                                                <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $zone->id }})"><i class="bi bi-pencil"></i></button>
                                            @endif
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_delete_zone'))
                                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $zone->id }})"><i class="bi bi-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No zones found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">{{ $isEdit ? 'Edit Zone' : 'Add Zone' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save" autocomplete="off" wire:key="employee-form-{{ $zone_id ?? 'new' }}">
                        <div class="mb-3">
                            <label class="form-label">Zone Name</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Districts</label>
                            <div wire:ignore>
                                <select wire:model="districts" multiple class="form-select chosen-select" size="6">
                                    @foreach ($allDistricts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('districts') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reasons</label>
                            <textarea wire:model="reasons" class="form-control" rows="3" placeholder="Optional..."></textarea>
                            @error('reasons') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-sm" wire:click="resetInputFields"><i class="bi bi-x"></i> Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">{{ $isEdit ? 'Update' : 'Save' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔁 Loading Spinner -->
    <div class="loader-container" wire:loading wire:target="save,delete,edit">
        <div class="loader"></div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));

        window.addEventListener('showConfirm', e => {
            let id = e.detail[0].itemId;
            Swal.fire({
                title: "Delete Zone?",
                text: "Are you sure you want to delete this zone?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) @this.call('delete', id);
            });
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
        function initChosen() {
            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found"
            }).off('change').on('change', function (e) {
                let model = $(this).attr('wire:model');
                if (model) {
                    @this.set(model, $(this).val());
                    @this.call('DistrictUpdate', $(this).val());
                }
            });
        }

        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            initChosen();
            //  After re-init, sync the Livewire value back to Chosen
            $('.chosen-select').each(function () {
                const el = $(this);
                const model = el.attr('wire:model');
                if (model && @this.get(model)) {
                    el.val(@this.get(model)).trigger('chosen:updated');
                }
            });
        });

        $(document).ready(function () {
            initChosen();
        });

        window.addEventListener('ResetForm', event => {
            document.querySelectorAll('input').forEach(input => input.value = '');
            const chosen = $('.chosen-select');
            if (chosen.length) {
                chosen.val('').trigger('chosen:updated');
                $('.chosen-single span').text('Filter by Districts');
            }
        });
    </script>
    @endpush
</div>
