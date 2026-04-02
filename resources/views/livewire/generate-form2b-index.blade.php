<div>
    <div class=" g-4">
        <!-- Header -->
       <div class="row justify-content-between align-items-center mb-3">

        <div class="col-md col-lg">
            <div class="mb-4 mb-md-0">
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-building me-2 text-primary"></i> Independent Candidates List
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Independent Candidates
                        </li>
                    </ol>
                </nav>
            </div>
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
                            <select id="assemblySelect" class="form-select form-control form-select-md">
                                <option value="">Filter by assembly</option>
                                @foreach($assemblyList as $assembly)
                                    <option value="{{ $assembly->id }}">{{ $assembly->assembly_name_en }} -{{ $assembly->assembly_number }}</option>
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
                                    <th>status</th>
                                    <th class="text-center">Action</th>
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
                                            <div class="tooltip-wrapper m-1">
                                                <span class="badge bg-{{ $assembly->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ $assembly->status == 'active' 
                                                        ? __('admin/assemblies.status_active') 
                                                        : __('admin/assemblies.status_inactive') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="tooltip-wrapper m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{route('admin.form-2b-create', $assembly->id)}}" class="btn btn-sm btn-outline-success">
                                                    Generate Form 2B
                                                    </a>
                                                    <span class="tooltip-text">Generate Form 2B PDF</span>
                                                </div>
                                            </div>
                                            {{-- <div class="tooltip-wrapper m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{route('admin.form-2b-create', $assembly->id)}}" class="btn btn-sm btn-outline-success">
                                                    History
                                                    </a>
                                                    <span class="tooltip-text">History</span>
                                                </div>
                                            </div> --}}
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
    <!-- Loading Spinner -->
    <div class="loader-container" wire:loading wire:target="resetFilters">
        <div class="loader"></div>
    </div>

    @push('scripts')

    <!--  jQuery (ONLY ONCE in whole project) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--  Local Select2 -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <!--  SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    console.log("jQuery:", typeof $);
    console.log("Select2:", typeof $.fn.select2);
    </script>

    <script>
    function initSelect2() {

        // Destroy old instances
        if ($('#assignassemblySelect').hasClass("select2-hidden-accessible")) {
            $('#assignassemblySelect').select2('destroy');
        }

        //  Destroy old instances (important for Livewire)
        if ($('#districtSelect').hasClass("select2-hidden-accessible")) {
            $('#districtSelect').select2('destroy');
        }

        if ($('#assemblySelect').hasClass("select2-hidden-accessible")) {
            $('#assemblySelect').select2('destroy');
        }

        //  Initialize Select2
        $('#districtSelect').select2({
            width: '100%',
            placeholder: "Filter by District",
            allowClear: true
        });

        $('#assemblySelect').select2({
            width: '100%',
            placeholder: "Filter by Assembly",
            allowClear: true
        });

         $('#assignassemblySelect').select2({
            width: '100%',
            dropdownParent: $('#assignModal'), // VERY IMPORTANT for modal
            placeholder: "Select Employee",
            allowClear: true
        });

        //  Sync with Livewire
        $('#districtSelect').off('change').on('change', function () {
            @this.set('district_id', $(this).val());
        });

        $('#assemblySelect').off('change').on('change', function () {
            @this.set('filter_by_assembly', $(this).val());
        });
    }

    // First Load
    document.addEventListener("DOMContentLoaded", function () {
        initSelect2();
    });

    //  After Livewire Update
    Livewire.hook('morph.updated', () => {

        initSelect2();
        // Sync Livewire → UI
        $('#districtSelect').val(@this.get('district_id')).trigger('change.select2');
        $('#assemblySelect').val(@this.get('filter_by_assembly')).trigger('change.select2');
    });
    </script>
    <!-- Toastr -->
    <script>
    window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
    window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
    </script>

    <!--  Reset Form -->
    <script>
    window.addEventListener('ResetForm', () => {
        $('#districtSelect').val(null).trigger('change');
        $('#assemblySelect').val(null).trigger('change');
        document.querySelectorAll('input, textarea, select').forEach(el => {
            el.value = '';
        });
    });
    </script>

    @endpush


    
</div>
