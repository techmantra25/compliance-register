<div>
    <div class="row g-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-calendar2-event me-2 text-primary"></i> Phase Master</h4>
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none">Admin</a></li>
                    <li class="breadcrumb-item active text-primary">Phases</li>
                </ol>
            </div>
        </div>

        <!-- Left Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Phases</h5>
                    <input type="text" wire:model="search" class="form-control form-control-sm w-auto" wire:keyup="filterData($event.target.value)" placeholder="Search...">
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Dates</th>
                                    <th>Total Assembly</th>
                                    <th>Assemblies</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($phases as $phase)
                                    <tr wire:key="phase-{{ $phase->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($phase->name) }}</td>
                                         <td>
                                            <div class="d-flex flex-column small">
                                                <div>
                                                    <i class="bi bi-calendar-check text-success me-1"></i>
                                                    <strong>Nomination:</strong> 
                                                    {{ \Carbon\Carbon::parse($phase->last_date_of_nomination)->format('d M Y') }}
                                                </div>
                                                <div class="mt-1">
                                                    <i class="bi bi-calendar-event text-danger me-1"></i>
                                                    <strong>Election:</strong> 
                                                    {{ \Carbon\Carbon::parse($phase->date_of_election)->format('d M Y') }}
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-info text-dark px-2 py-2">
                                                <i class="bi bi-person-badge me-1"></i> 
                                                {{ count($phase->assemblies) }}
                                            </span>
                                        </td>
                                        <td width="45%">
                                            @if(!empty($phase->assemblies))
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($phase->assemblies as $key=>$assembly)
                                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-sm">
                                                            <i class="bi bi-geo-alt-fill text-primary me-1"></i> {{ $assembly }} ({{$key}})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="edit({{ $phase->id }})" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No phases found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">{{ $isEdit ? 'Edit Phase' : 'Add Phase' }}</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save" autocomplete="off"  wire:key="phase-form-{{ $phase_id ?? 'new' }}">
                        <div class="mb-3">
                            <label class="form-label">Phase Name</label>
                            <input type="text" wire:model.defer="name" class="form-control">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Date of Nomination</label>
                            <input type="date" wire:model.defer="last_date_of_nomination" class="form-control">
                            @error('last_date_of_nomination') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Election</label>
                            <input type="date" wire:model.defer="date_of_election" class="form-control">
                            @error('date_of_election') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3" >
                            <label class="form-label">Assemblies</label>
                            <div wire:ignore>
                                <select wire:model="assembly_ids" multiple class="form-select chosen-select">
                                    @foreach($assemblies as $assembly)
                                        <option value="{{ $assembly->id }}">{{ $assembly->assembly_name_en }}({{$assembly->assembly_code}})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('assembly_ids') <small class="text-danger">{{ $message }}</small> @enderror
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
    <div class="loader-container" wire:loading wire:target="save,delete,edit,resetInputFields">
        <div class="loader"></div>
    </div>

    <!-- JS Scripts -->
    @push('scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>

        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        function initChosen() {
            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found"
            }).off('change').on('change', function (e) {
                let model = $(this).attr('wire:model');
                if (model) {
                    @this.set(model, $(this).val());
                    @this.call('assemblyUpdate', $(this).val());
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

        window.addEventListener('ResetForm', event => {
            document.querySelectorAll('input').forEach(input => input.value = '');
        });
    </script>
    @endpush
</div>
