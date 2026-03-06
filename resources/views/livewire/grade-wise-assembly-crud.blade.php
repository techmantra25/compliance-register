<div>
    <div class="row g-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-calendar2-event me-2 text-primary"></i>Grade Wise Assembly</h4>
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none">Admin</a></li>
                    <li class="breadcrumb-item active text-primary">Grade Wise Assembly</li>
                </ol>
            </div>
        </div>

        <!-- Left Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Grade Wise Assembly</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" 
                            wire:model.live="search"
                            class="form-control" 
                            placeholder="Search by grade and assembly">

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
                                    <th width="10%">Grade</th>
                                    <th>Dates</th>
                                    <th>Assemblies</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td class="fw-bold">{{ ucwords($grade->name) }}</td>

                                    <td>
                                        {{ now()->format('d M Y') }}
                                    </td>

                                    <td width="45%">
                                        @if($grade->assemblies->count())
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($grade->assemblies as $assembly)
                                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-sm">
                                                        <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                                                        {{ $assembly->assembly_name_en }}
                                                        ({{ $assembly->assembly_code }})
                                                    </span>
                                                @endforeach
                                            </div>

                                            <div class="mt-2">
                                                <span class="badge bg-info text-dark px-2 py-2">
                                                    {{ $grade->assemblies->count() }} Assemblies
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button wire:click="edit({{ $grade->id }})"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                <td colspan="4" class="text-center text-muted">No Grades Found</td>
                                </tr>
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
                    <h5 class="fw-bold mb-0">{{ $isEdit ? 'Edit Grade' : 'Add Grade' }}</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save" autocomplete="off"  wire:key="grade-form-{{ $grade_id ?? 'new' }}">
                        <div class="mb-3">
                            <label class="form-label">Grade Name</label>
                            <input type="text" wire:model.defer="name" class="form-control">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
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

        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            initChosen();
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
