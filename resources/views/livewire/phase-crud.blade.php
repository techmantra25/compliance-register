<div>
    <style>

    .assemblies-box{
        max-height:120px;
        overflow-y:auto;
        display:flex;
        flex-wrap:wrap;
        gap:4px;
        }

        .assembly-badge{
        font-size:11px;
        padding:3px 6px;
        background:#f8f9fa;
        border:1px solid #dee2e6;
        color:#333;
        border-radius:10px;
    }
    </style>
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <ul class="nav nav-tabs card-header-tabs">

                <li class="nav-item">
                    <a class="nav-link {{ $active_tab == 1 ? 'active' : '' }}" wire:click="$set('active_tab',1)"
                        style="cursor:pointer">

                        <i class="bi bi-list"></i> Phase List

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $active_tab == 2 ? 'active' : '' }}" wire:click="$set('active_tab',2)"
                        style="cursor:pointer">

                        <i class="bi bi-plus-circle"></i>
                        {{ $isEdit ? 'Edit Phase' : 'Add Phase' }}

                    </a>
                </li>

            </ul>

        </div>

        <div class="card-body">

            {{-- TAB 1 LIST --}}

            @if($active_tab == 1)

            <div class="d-flex justify-content-between mb-3">

                <h5 class="fw-bold">Phases</h5>

                <div class="d-flex gap-2">

                    <input type="text" wire:model="search" wire:keyup="filterData($event.target.value)"
                        class="form-control form-control-sm" placeholder="Search...">

                    <button class="btn btn-sm btn-danger" wire:click="resetInputFields">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>

                </div>

            </div>
           <div class="table-responsive">

            <table class="table table-sm align-middle table-bordered">

                <thead class="table-light">

                    <tr>

                        <th width="10%">Phase</th>

                        <th width="20%">Dates</th>

                        <th width="55%">Assemblies</th>

                        <th width="15%">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($phases as $phase)

                    @php
                    $assemblies = $phase->assemblies;
                    @endphp

                    <tr wire:key="phase-{{ $phase->id }}">

                        <td class="fw-semibold">
                            {{ ucwords($phase->name) }}
                        </td>

                        <td>

                            <div class="small">

                                <div class="mb-1">
                                    <strong>Nomination:</strong>
                                    {{ \Carbon\Carbon::parse($phase->last_date_of_nomination)->format('d M Y') }}
                                </div>

                                <div class="mb-1">
                                    <strong>Election:</strong>
                                    {{ \Carbon\Carbon::parse($phase->date_of_election)->format('d M Y') }}
                                </div>

                                <div>
                                    <strong>Silent Period:</strong>
                                    {{ \Carbon\Carbon::parse($phase->last_date_of_mcc)->format('d M Y') }}
                                </div>

                            </div>

                        </td>

                        <td>

                            <div class="assemblies-box">

                                @foreach($assemblies as $key=>$assembly)

                                <span class="badge assembly-badge">

                                    {{ $assembly }} ({{$key}})

                                </span>

                                @endforeach

                            </div>

                            <div class="mt-1">

                                <span class="badge bg-info text-dark">

                                    Total: {{ count($assemblies) }}

                                </span>

                            </div>

                        </td>

                        <td>

                            <button wire:click="edit({{ $phase->id }})" class="btn btn-sm btn-outline-primary">

                                <i class="bi bi-pencil"></i>

                            </button>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center text-muted py-4">
                            No phases found
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
            @endif



            {{-- TAB 2 FORM --}}

            @if($active_tab == 2)

            <div class="card shadow-sm border-0 p-3">

                <h5 class="fw-bold mb-3">

                    {{ $isEdit ? 'Edit Phase' : 'Add Phase' }}

                </h5>

                <form wire:submit.prevent="save">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Phase Name</label>

                            <input type="text" wire:model.defer="name" class="form-control">

                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Last Date of Nomination</label>

                            <input type="date" wire:model.defer="last_date_of_nomination" class="form-control">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Date of Election</label>

                            <input type="date" wire:model.defer="date_of_election" class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Silent Period Start</label>

                            <input type="date" wire:model.defer="last_date_of_mcc" class="form-control">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Assemblies</label>

                        <div wire:ignore>
                            <select wire:model="assembly_ids" multiple class="form-select chosen-select">

                            @foreach($assemblies as $assembly)

                            <option value="{{ $assembly->id }}">
                            {{$assembly->assembly_number}} - {{ $assembly->assembly_name_en }}
                            </option>

                            @endforeach

                            </select>
                            </div>

                    </div>

                    <div class="d-flex justify-content-between">

                        <button type="button" class="btn btn-danger btn-sm" wire:click="resetInputFields">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-primary btn-sm">

                            {{ $isEdit ? 'Update' : 'Save' }}

                        </button>

                    </div>

                </form>

            </div>

            @endif

        </div>

    </div>
    @push('scripts')

        <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
        <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>

        <script>

        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));


        function initChosen()
        {
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


        function refreshChosen()
        {
            $('.chosen-select').each(function () {

                const el = $(this);
                const model = el.attr('wire:model');

                if(model && @this.get(model)){

                    el.val(@this.get(model)).trigger('chosen:updated');

                }

            });
        }


        document.addEventListener("livewire:navigated", () => {

            setTimeout(() => {

                initChosen();
                refreshChosen();

            }, 100);

        });


        Livewire.hook('morph.updated', () => {

            setTimeout(() => {

                initChosen();
                refreshChosen();

            }, 100);

        });


        $(document).ready(function () {

            initChosen();
            refreshChosen();

        });


        window.addEventListener('ResetForm', () => {

            $('.chosen-select').val([]).trigger('chosen:updated');

        });

        </script>

        @endpush

</div>