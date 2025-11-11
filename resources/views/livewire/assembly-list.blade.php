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
        </div>

        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">{{ __('admin/assemblies.list_title') }}</h5>
                    <div class="d-flex justify-content-end align-items-center">
                        <!-- District filter -->
                        <div class="mx-2" style="width: 300px;" wire:ignore>
                            <select wire:model="district_id" class="form-select form-select-sm w-auto chosen-select">
                                <option value="">{{ __('admin/assemblies.filter_district') }}</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ app()->getLocale() === 'bn' ? $district->name_bn : $district->name_en }}</option>
                                @endforeach
                            </select>
                            @error('district_id') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>

                        <!-- Search -->
                        <input type="text"
                            wire:model="search"
                            class="form-control form-control-sm w-auto"
                            placeholder="{{ __('admin/assemblies.search_placeholder') }}"
                            wire:keyup="filterData($event.target.value)">

                        <!-- Reset -->
                        <button class="btn btn-sm btn-danger ms-2" wire:click="resetFilters">
                            <i class="bi bi-x"></i> {{ __('admin/assemblies.reset_button') }}
                        </button>
                    </div>
                </div>


                <!-- Table -->
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin/assemblies.table_code') }}</th>
                                    <th>{{ __('admin/assemblies.table_name_en') }}</th>
                                    <th>{{ __('admin/assemblies.table_name_bn') }}</th>
                                    <th>{{ __('admin/assemblies.table_district') }}</th>
                                    <th>{{ __('admin/assemblies.table_status') }}</th>
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
                                            <span class="badge bg-{{ $assembly->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ $assembly->status == 'active' 
                                                    ? __('admin/assemblies.status_active') 
                                                    : __('admin/assemblies.status_inactive') }}
                                            </span>
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
    <div class="loader-container" wire:loading wire:target="edit,resetFilters">
        <div class="loader"></div>
    </div>

    @push('scripts')
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
                // ✅ After re-init, sync the Livewire value back to Chosen
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
        </script>

    @endpush
</div>
