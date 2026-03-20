<div>
    <div class="row g-4">
        <!-- Header -->
       <div class="d-flex flex-wrap justify-content-between align-items-center">
    
    <div>
        <h4 class="fw-bold mb-1 text-dark">
            <i class="bi bi-building me-2 text-primary"></i> {{ __('admin/assemblies.title') }}
        </h4>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="#" class="text-decoration-none text-muted">
                        <i class="bi bi-grid-fill me-1"></i> {{ __('admin/assemblies.breadcrumb_admin') }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary" aria-current="page">
                    {{ __('admin/assemblies.breadcrumb_assemblies') }}
                </li>
            </ol>
        </nav>
    </div>

    <button class="btn btn-sm btn-success" wire:click="exportCsv">
        Export CSV
    </button>

</div>

        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <!-- <h5 class="fw-bold mb-0">{{ __('admin/assemblies.list_title') }}</h5> -->
                    <div class="row justify-content-end align-items-center">
                        <!-- District filter -->
                        <div class="col-md-4" wire:ignore>
                            <select wire:model="district_id" class="form-select form-select-sm chosen-select"  data-placeholder="Select Assembly">
                                <option value="">{{ __('admin/assemblies.filter_district') }}</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}</option>
                                @endforeach
                            </select>
                            @error('district_id') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                            wire:model="search"
                            class="form-control form-control-sm"
                            placeholder="{{ __('admin/assemblies.search_placeholder') }}"
                            wire:keyup="filterData($event.target.value)">
                        </div>

                        <div class="col-auto text-right">
                        <button class="btn btn-sm btn-danger ms-2" wire:click="resetFilters">
                            <i class="bi bi-x"></i> {{ __('admin/assemblies.reset_button') }}
                        </button>
                        </div>
                    </div>
                </div>


                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin/assemblies.table_code') }}</th>
                                    <th>{{ __('admin/assemblies.table_name_en') }}</th>
                                    <th>{{ __('admin/assemblies.table_name_bn') }}</th>
                                    <th>{{ __('admin/assemblies.table_district') }}</th>
                                    <th>Candidates</th>
                                    <th>{{ __('admin/assemblies.table_status') }}</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assemblies as $assembly)
                                    <tr wire:key="assembly-{{ $assembly->id }}">
                                        <td>
                                            {{ $assemblies->firstItem() + $loop->index }}
                                        </td>
                                        <td>{{ $assembly->assembly_code }}</td>

                                        <!-- Dynamic name based on locale -->
                                        <td>
                                            {{ app()->getLocale() === 'bn' ? $assembly->assembly_name_bn : $assembly->assembly_name_en }}
                                        </td>
                                        <td>{{ $assembly->assembly_name_bn }}</td>

                                        <td>
                                            {{ app()->getLocale() === 'bn' 
                                                ? ($assembly->district->name_bn ?? 'N/A') 
                                                : ($assembly->district->name_en ?? 'N/A') }}
                                        </td>
                                        <td>
                                            @if($assembly->candidates->count())
                                                <ul class="mb-0 ps-3">
                                                    @foreach($assembly->candidates as $candidate)
                                                        <li>{{ $candidate->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No Candidates</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="tooltip-wrapper m-1">
                                                <span class="badge bg-{{ $assembly->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ $assembly->status == 'active' 
                                                        ? __('admin/assemblies.status_active') 
                                                        : __('admin/assemblies.status_inactive') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $employee = $this->getAssignedEmployee($assembly->id);
                                            @endphp

                                            @if($employee)
                                                <span class="badge bg-primary">
                                                    {{ $employee->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="tooltip-wrapper m-1">
                                                {{-- <button class="btn btn-sm btn-outline-success" wire:click="editItem({{$assembly->id}})">
                                                    <i class="bi bi-pencil"></i>
                                                </button> --}}
                                                <button class="btn btn-sm btn-outline-primary" wire:click="assignEmployees({{$assembly->id}})">
                                                    Assign
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">
                                            {{ __('admin/assemblies.no_data') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        {{ $assemblies->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- <div class="modal fade" id="updateModal" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Update Assembly
                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            wire:click="resetFormData">
                    </button>
                </div>

                <form wire:submit.prevent="updateStatus">
                    <div class="modal-body">

                        <div class="row">

                            <!-- English Name -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label">
                                    Assembly Name (English)
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    class="form-control"
                                    wire:model="assembly_name_en" id="assembly_name_en">

                                @error('assembly_name_en')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Bengali Name -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label">
                                    Assembly Name (Bengali)
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    class="form-control"
                                    wire:model="assembly_name_bn" id="assembly_name_bn">

                                @error('assembly_name_bn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal"
                                wire:click="resetFormData">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-primary btn-sm">
                            Update
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="assignModal" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5>Assign Employees</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Select Employees</label>

                    <div wire:ignore>
                        <select class="form-control chosen-select" wire:model="assignedEmployee">
                            <option value="">Select Employee</option>
                           @foreach($employees as $emp)
                                @php
                                    $stats = $this->getEmployeeStats($emp->id);
                                @endphp

                                <option value="{{ $emp->id }}">
                                    {{ $emp->name }}
                                    ({{ $stats['completed'] }} Completed,
                                    {{ $stats['pending'] }} Pending)
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="saveAssignments">Save</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Loading Spinner -->
    <div class="loader-container" wire:loading wire:target="resetFilters,editItem">
        <div class="loader"></div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
            window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
        </script>
        <script>
            
            window.addEventListener('ResetForm', event => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
                const chosen = $('.chosen-select');
                if (chosen.length) {
                    chosen.val('').trigger('chosen:updated');
                    $('.chosen-single span').text('Filter by district');
                }
            });
        </script>
        <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
        <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
        <script>
           function initChosen() {
                $('.chosen-select').chosen({
                    width: '100%',
                    no_results_text: "No result found"
                }).off('change').on('change', function () {
                    let model = $(this).attr('wire:model');

                    if (model) {
                        @this.set(model, $(this).val());
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

            Livewire.hook('morph.updated', () => {
                initChosen();

                setTimeout(() => {
                    $('.chosen-select').trigger('chosen:updated');
                }, 200);
            });

            $(document).ready(function () {
                initChosen();
            });

            window.addEventListener('openUpdateModel', (event) => {
                $('#assembly_name_en').val(event.detail[0].assembly_name_en);
                $('#assembly_name_bn').val(event.detail[0].assembly_name_bn);

                $('#updateModal').modal('show');
            });

            window.addEventListener('closeUpdateModel', () => {
                $('#updateModal').modal('hide');
            });
        </script>

        <script>
            window.addEventListener('openAssignModal', () => {
                $('#assignModal').modal('show');

                setTimeout(() => {
                    $('.chosen-select').trigger('chosen:updated');
                }, 300);
            });
            window.addEventListener('closeAssignModal', () => {
                $('#assignModal').modal('hide');
            });

           window.addEventListener('refreshChosen', () => {
                setTimeout(() => {
                    $('.chosen-select').each(function () {
                        let el = $(this);
                        let model = el.attr('wire:model');

                        if (model) {
                            let value = @this.get(model);
                            el.val(value).trigger('chosen:updated'); // single value
                        }
                    });
                }, 200);
            });
        </script>

    @endpush
</div>
