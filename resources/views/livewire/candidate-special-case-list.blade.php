<div>
    <div class="row g-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 mb-md-5 mb-lg-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Special Case Candidate list
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Candidates
                        </li>
                    </ol>
                </nav>
            </div>
        </div> 

        <!--  Main Content -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 ">
                <div class="card-header bg-white">

                    <div class="row g-2 mb-4 justify-content-center align-items-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="canditate-search">
                                <input type="text"
                                wire:model="search" wire:keyup="filterCandidates($event.target.value)"
                                class="form-control form-control-sm"
                                placeholder="Search candidate...">

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-center gap-2">

                            <!-- Reset Button -->
                            <button class="btn btn-sm btn-danger"
                                    wire:click="resetForm" style="padding: 7px">
                                Reset Filters
                            </button>

                        </div>
                    </div>

                    <!-- 🔹 Row 1 -->
                    <div class="row g-2 mb-4">

                        <div class="col-md-3 col-lg-3" wire:ignore>
                            <select wire:model="filter_by_assembly" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by Assembly</option>
                                @foreach ($assemblies as $assembly)
                                <option value="{{ $assembly->id }}">
                                    {{ $assembly->assembly_name_en }} -{{ $assembly->assembly_number }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-3" wire:ignore>
                            <select wire:model="filter_by_district" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ $district->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-3" wire:ignore>
                            <select wire:model="filter_by_phase" class="form-select form-select-sm chosen-select">
                                <option value="">Filter by Phase</option>
                                @foreach ($phases as $phase)
                                    <option value="{{ $phase->id }}">
                                        {{ ucwords($phase->name) }}
                                        ({{ \Carbon\Carbon::parse($phase->last_date_of_nomination)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <select wire:model="filter_by_status" class="form-select form-select-sm select-style" wire:change="filterByStatus($event.target.value)">
                                <option value="">Filter by Final Status</option>
                                @foreach (getFinalDocStatus() as $key => $status)
                                    <option value="{{ $key }}">
                                        {{ $status['icon'] }} {{ $status['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-2">
                            {{ $candidates->total() }} Nominations
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Candidate</th>
                                    <th>Assembly</th>
                                    <th>Documents</th>
                                    <th >Final Status</th>
                                    <th style="width:91px;">Last Date of Nomination</th>
                                    <th style="max-width: 250px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidates as $candidate)
                                <tr wire:key="candidate-{{ $candidate->id }}">
                                    <td>{{ $candidates->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="fw-semibold text-primary">
                                            {{ ucwords($candidate->name) }}
                                        </div>

                                        <div class="text-muted small">

                                            @if($candidate->email)
                                                <span>
                                                    <i class="bi bi-envelope-fill text-primary me-1"></i>
                                                    {{ $candidate->email }}
                                                </span>
                                                <br>
                                            @endif

                                            <span>
                                                <i class="bi bi-telephone-fill text-success me-1"></i>
                                                {{ $candidate->contact_number ?? '-' }}

                                                @if($candidate->contact_number_alt_1)
                                                    , {{ $candidate->contact_number_alt_1 }}
                                                @endif
                                            </span>
                                            <br>

                                            <span>
                                                District: 
                                                {{ $candidate->assembly->district->name_en ?? 'N/A' }}
                                            </span>

                                        </div>
                                    </td>

                                    <td>
                                        <span>
                                            @if(!empty($candidate->assembly->assembly_number))
                                                {{ $candidate->assembly->assembly_number }} 
                                            @endif
                                            {{ $candidate->assembly->assembly_name_en ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                       @php
                                            $uploaded = $candidate->VedifiedDocuments->groupBy('type')->count();
                                        @endphp

                                        <span>
                                            <span
                                                class="{{ $uploaded == $required_document ? 'text-success' : 'text-danger' }}">{{
                                                $uploaded }}</span>/<span>{{ $required_document }}</span>
                                        </span>
                                    </td>
                                    
                                    <td>
                                        {{ getFinalDocStatus($candidate->document_collection_status, 'icon') }}
                                        {{ getFinalDocStatus($candidate->document_collection_status, 'label') }}
                                        <br>
                                        @if($candidate->is_criminal_offence == 1)
                                            <span class="badge bg-warning text-dark ms-1">
                                                Criminal Offence Case
                                            </span>

                                                @if($candidate->legalAssociate)
                                                    <div class="small text-muted mt-1">
                                                        Handled by: <strong>{{ $candidate->legalAssociate->name }}</strong>
                                                    </div>
                                                @else
                                                    <div class="small text-danger mt-1">
                                                        Legal Associate not assigned
                                                    </div>
                                                @endif
                                        @endif
                                    </td>

                                    <td>
                                        {{
                                            optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                                            ? \Carbon\Carbon::parse(
                                                optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                                            )->format('d M Y')
                                            : 'N/A'
                                        }}
                                    </td>

                                    <td class="">
                                        @if($authUser->role=='legal_associate')
                                            <div class="tooltip-wrapper">
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                    Preview <i class="bi bi-arrow-right-circle ms-1"></i>
                                                </a>
                                                <span class="tooltip-text">Preview Documents</span>
                                                </div>
                                        @else
                                            @if($candidate->document_collection_status !== 'rejected')

                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_assign_agents'))
                                                <div class="tooltip-wrapper m-1">
                                                    <button 
                                                        class="btn btn-sm btn-outline-{{ count($candidate->agents) > 0 ? 'primary' : 'danger' }}"
                                                        wire:click="openAgentModal({{ $candidate->id }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#assignAgentModal">
                                                        <i class="bi bi-people"></i>
                                                    </button>

                                                    <span class="tooltip-text">
                                                    {{ count($candidate->agents) > 0 ? 'View or Change Assigned Agent' : 'Assign Agent to Candidate' }}
                                                    </span>
                                                </div>
                                                @endif

                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_update_candidate'))
                                                <div class="tooltip-wrapper m-1">
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="edit({{ $candidate->id }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#candidateModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <span class="tooltip-text">Edit Candidate</span>
                                                </div>
                                                @endif

                                            @endif

                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_candidate_journey_timeline'))
                                                <div class="tooltip-wrapper m-1">
                                                    <a href="{{ route('admin.candidates.journey', $candidate->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-clock-history"></i>
                                                    </a>
                                                    <span class="tooltip-text">Candidate Journey Timeline</span>
                                                </div>
                                            @endif
                                        @endif
                                        </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        No candidates found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 d-flex justify-content-between align-items-center">

                        <!-- Total Count -->
                        <div>
                            Showing {{ $candidates->firstItem() }} to {{ $candidates->lastItem() }}
                            of {{ $candidates->total() }} entries
                        </div>

                        <!-- Pagination -->
                        <div>
                            {{ $candidates->links('pagination.custom') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="loader-container" wire:loading wire:target="">
        <div class="loader"></div>
    </div>
    @push('scripts')
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
            window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
    </script>
    <script>
       window.addEventListener('ResetFormData', event => {

            document.querySelectorAll('input, textarea, select').forEach(el => {

                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                } 
                else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } 
                else {
                    el.value = '';
                }

            });

        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
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

        document.addEventListener('livewire:load', function () {
            initChosen();
        });

        Livewire.hook('message.processed', (message, component) => {
            initChosen();
        });

        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });

        $('#candidateModal').on('shown.bs.modal', function () {
            setTimeout(() => initChosen(), 150);
        });
    </script>

    <script>
        window.addEventListener('close-upload-modal', () => {
            $('#uploadcandidateModal').modal('hide');
        });
        Livewire.on('refreshChosen', (value) => {

            setTimeout(() => {
                $('#assembly_id')
                    .val(value)
                    .trigger('chosen:updated');
            }, 100);

        });

        window.addEventListener('refreshChosen', () => {
            $('.chosen-select').trigger('chosen:updated');
        });

        window.addEventListener('clearSearch', () => {
            $('input[wire\\:model]').val('');
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('resetAllFilters', () => {
                $('.chosen-select').val('').trigger('chosen:updated');
                $('input[wire\\:model="search"]').val('');
            });
        });

    </script>

    @endpush
</div>