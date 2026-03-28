<div>
    <div class=" g-4">
        <!-- Header -->
       <div class="row justify-content-between align-items-center mb-3">

        <div class="col-md col-lg">
            <div class="mb-4 mb-md-0">
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
        </div>

        <div class="col-md text-end col-lg">
            <button class="btn btn-md btn-success" wire:click="exportCsv">
                Export CSV
            </button>
        </div>

    </div>

        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">

                <div class="row justify-content-center mb-4">
                    <div class="col-md-12 col-lg-6">
                        <div class="canditate-search">

                            <input type="text"
                            wire:model="search"
                            class="form-control form-control-md"
                            placeholder="{{ __('admin/assemblies.search_placeholder') }}"
                            wire:keyup="filterData($event.target.value)">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white mb-4">
                    <!-- <h5 class="fw-bold mb-0">{{ __('admin/assemblies.list_title') }}</h5> -->
                    <div class="row justify-content-center align-items-center">
                        <!-- District filter -->
                        <div class="col-md-3 mb-4 mb-md-0" wire:ignore>
                            <select id="districtSelect" class="form-select form-control form-select-md">
                                <option value="">{{ __('admin/assemblies.filter_district') }}</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-4 mb-md-0" wire:ignore>
                            <select id="employeeSelect" class="form-select form-control form-select-md">
                                <option value="">Filter by Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-auto text-md-right">
                            <button class="btn btn-sm btn-danger" wire:click="resetFilters">
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
                                        <td>
                                            {{ $assembly->assembly_code }}
                                        </td>

                                        <!-- Dynamic name based on locale -->
                                        <td>
                                            {{ app()->getLocale() === 'bn' ? $assembly->assembly_name_bn : $assembly->assembly_name_en }}
                                        </td>
                                        <td>
                                            {{ $assembly->assembly_name_bn }}
                                        </td>

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
                        <select id="assignEmployeeSelect" class="form-control" wire:model="assignedEmployee">
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
                    <button class="btn btn-primary" onclick="confirmSave()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Spinner -->
    <div class="loader-container" wire:loading wire:target="resetFilters,editItem">
        <div class="loader"></div>
    </div>

    @push('scripts')

    <!-- ✅ jQuery (ONLY ONCE in whole project) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ✅ Local Select2 -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <!-- ✅ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    console.log("jQuery:", typeof $);
    console.log("Select2:", typeof $.fn.select2);
    </script>

    <script>
    function initSelect2() {

        // Destroy old instances
        if ($('#assignEmployeeSelect').hasClass("select2-hidden-accessible")) {
            $('#assignEmployeeSelect').select2('destroy');
        }

        // 🔥 Destroy old instances (important for Livewire)
        if ($('#districtSelect').hasClass("select2-hidden-accessible")) {
            $('#districtSelect').select2('destroy');
        }

        if ($('#employeeSelect').hasClass("select2-hidden-accessible")) {
            $('#employeeSelect').select2('destroy');
        }

        // ✅ Initialize Select2
        $('#districtSelect').select2({
            width: '100%',
            placeholder: "Filter by District",
            allowClear: true
        });

        $('#employeeSelect').select2({
            width: '100%',
            placeholder: "Filter by Employee",
            allowClear: true
        });

         $('#assignEmployeeSelect').select2({
            width: '100%',
            dropdownParent: $('#assignModal'), // 🔥 VERY IMPORTANT for modal
            placeholder: "Select Employee",
            allowClear: true
        });

        // ✅ Sync with Livewire
        $('#districtSelect').off('change').on('change', function () {
            @this.set('district_id', $(this).val());
        });

        $('#employeeSelect').off('change').on('change', function () {
            @this.set('filter_by_employee', $(this).val());
        });
    }

    // ✅ First Load
    document.addEventListener("DOMContentLoaded", function () {
        initSelect2();
    });

    // ✅ After Livewire Update
    Livewire.hook('morph.updated', () => {

        initSelect2();

        // 🔄 Sync Livewire → UI
        $('#districtSelect').val(@this.get('district_id')).trigger('change.select2');
        $('#employeeSelect').val(@this.get('filter_by_employee')).trigger('change.select2');
        $('#assignEmployeeSelect').val(@this.get('assignedEmployee')).trigger('change.select2');
    });
    </script>

    <!-- ✅ Toastr -->
    <script>
    window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
    window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
    </script>

    <!-- ✅ Reset Form -->
    <script>
    window.addEventListener('ResetForm', () => {
        $('#districtSelect').val(null).trigger('change');
        $('#employeeSelect').val(null).trigger('change');
    });
    </script>

    <!-- ✅ Modal -->
    <script>
    window.addEventListener('openAssignModal', () => {
        $('#assignModal').modal('show');

         setTimeout(() => {
            initSelect2(); 
        }, 300);
    });

    window.addEventListener('closeAssignModal', () => {
        $('#assignModal').modal('hide');
    });
    </script>

    <!-- ✅ SweetAlert -->
    <script>
    function confirmSave() {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save this assignment?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Save"
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Please wait...",
                    text: "Saving & sending email",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                @this.call('saveAssignments');
            }
        });
    }

    // SUCCESS
    window.addEventListener('assignment-success', event => {
        Swal.close();
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: event.detail.message
        });
    });

    // WARNING
    window.addEventListener('assignment-warning', event => {
        Swal.close();
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: event.detail.message
        });
    });

    // ERROR
    window.addEventListener('assignment-error', event => {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: event.detail.message
        });
    });

    window.addEventListener('closeSwal', () => {
        Swal.close();
    });
    </script>

    @endpush


    
</div>
