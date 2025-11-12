<div>
    <div class="row g-4">
        <!-- 🧭 Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Candidate Nomination List
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
            <div>
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadcandidateModal">
                    <i class="bi bi-upload me-1"></i>Upload Candidate
                </button>
                <button class="btn btn-primary btn-sm" wire:click="newCandidate" data-bs-toggle="modal" data-bs-target="#candidateModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Candidate
                </button>
            </div>
        </div>

        <!--  Main Content -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Candidate Contacts</h5>

                    <div class="d-flex align-items-center">
                        <input type="text"
                            wire:model="search"
                            wire:keyup="filterCandidates($event.target.value)"
                            class="form-control form-control-sm w-auto me-2"
                            placeholder="Search here...">

                        <button class="btn btn-sm btn-danger" wire:click="resetForm">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                           <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Candidate Details</th>
                                    <th>Agent</th>
                                    <th>Assembly</th>
                                    <th>Documents Count</th>
                                    <th style="width: 300px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidates as $candidate)
                                    <tr wire:key="candidate-{{ $candidate->id }}">
                                        <td>{{ $candidates->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="fw-semibold text-primary">{{ ucwords($candidate->name) }}</div>
                                            <div class="text-muted small">
                                                @if($candidate->email)
                                                <span><strong>Email:</strong> {{ $candidate->email ?? '-' }}</span><br>
                                                @endif
                                                <span><strong>Contact:</strong> {{ $candidate->contact_number ?? '-' }}
                                                    @if($candidate->contact_number_alt_1) 
                                                    ,{{ $candidate->contact_number_alt_1 ?? '-' }}
                                                    @endif
                                                </span><br>
                                                <span><strong>District:</strong> {{ $candidate->assembly->district->name_en ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            @if ($candidate->agents->isNotEmpty())
                                                @foreach ($candidate->agents as $agent)
                                                    <div class="d-flex mb-1">
                                                        <i class="bi bi-person-badge text-primary me-1"></i>
                                                        <div>
                                                            <strong>{{ ucwords($agent->name) }}</strong>
                                                            <span class="text-muted small">
                                                                ({{ $agent->contact_number }}@if($agent->contact_number_alt_1) / {{ $agent->contact_number_alt_1}}@endif)
                                                            </span>
                                                            @if($agent->email)
                                                                <div class="small text-muted">{{ $agent->email }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                             <span> {{ $candidate->assembly->assembly_name_en ?? 'N/A' }}
                                                    ({{ $candidate->assembly->assembly_code ?? '-' }})
                                                </span>
                                        </td>
                                      <td>
                                            @php
                                                $uploaded = $candidate->documents->groupBy('type')->count();
                                            @endphp

                                            <span>
                                                <span class="{{ $uploaded == $required_document ? 'text-success' : 'text-danger' }}">{{ $uploaded }}</span> / <span>{{ $required_document }}</span>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if($authUser->role=='legal associate')
                                                <a href="#"
                                                    class="btn btn-sm btn-outline-success"
                                                    title="Verify Documents">
                                                    <i class="bi bi-check2-square"></i> Verify Documents
                                                </a>
                                                
                                            @else
                                                <button class="btn btn-sm btn-outline-{{count($candidate->agents)>0?"primary":"danger"}}"
                                                    wire:click="openAgentModal({{ $candidate->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#assignAgentModal" title="Assign Agent">
                                                    <i class="bi bi-people"></i> 
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="edit({{ $candidate->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#candidateModal"
                                                    title="Edit Candidate">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="{{ route('admin.candidates.documents', ['candidate' => $candidate->id]) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="View Candidate Document Collections">
                                                        <i class="bi bi-folder2"></i>
                                                    </a>
                                                
                                                <a href="{{ route('admin.candidates.journey', ['candidate'=>$candidate->id]) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            No candidates found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-2 d-flex justify-content-end">
                        {{ $candidates->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- upload candidate modal --}}
    <div wire:ignore.self class="modal fade" id="uploadcandidateModal" tabindex="-1" aria-labelledby="uploadcandidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="uploadcandidateModalLabel">Upload Candidate</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="resetForm"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Download Sample CSV -->
                        <div class="col-12">
                            <a href="{{ asset('upload_candidate_sample.csv') }}" download class="btn btn-outline-primary">
                                <i class="bi bi-download me-1"></i>Download Sample CSV
                            </a>
                        </div>

                        <!-- Upload Field -->
                        <div class="col-12">
                            <label for="candidateFile" class="form-label fw-semibold mt-3">Upload Candidate CSV</label>
                            <input type="file" class="form-control" id="candidateFile" wire:model="candidateFile" accept=".csv">
                            @error('candidateFile')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            @if($csvError)
                                <small class="text-danger d-block mt-1">{{ $csvError }}</small>
                            @endif
                            <div wire:loading wire:target="candidateFile" class="text-muted mt-2">Uploading...</div>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetForm">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="saveCandidate">
                        <i class="bi bi-upload me-1"></i>Upload
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!--  Candidate Modal -->
    <div wire:ignore.self class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="candidateModalLabel">
                        {{ $editMode ? 'Update Candidate' : 'Add Candidate' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="resetForm"></button>
                </div>
                <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}" wire:key="agent-form-{{ $editId ?? 'new' }}">
                    <div class="modal-body">
                        <div class="row">
                            {{-- 🔹 Agent Name --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" class="form-control">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 🔹 Designation --}}
                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" wire:model="designation" class="form-control">
                                @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div> --}}

                            {{-- 🔹 Email --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" wire:model="email" class="form-control">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 🔹 Contact Number --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" wire:model="contact_number" class="form-control">
                                @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 🔹 Alt Contact Number --}}
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alt Contact Number</label>
                                <input type="text" wire:model="contact_number_alt_1" class="form-control">
                                @error('contact_number_alt_1') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- 🔹 Agent --}}
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Assemblies <span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select wire:model="assembly_id" class="form-select chosen-select">
                                        <option value="">Select one</option>
                                        @foreach ($assemblies as $assembly)
                                            <option value="{{ $assembly->id }}">
                                                {{ $assembly->assembly_name_en }} ({{ $assembly->assembly_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assembly_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" wire:click="resetForm">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ $editMode ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignAgentModal" tabindex="-1" aria-labelledby="assignAgentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- extra-large modal -->
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="assignAgentModalLabel">
                        <i class="bi bi-person-plus text-primary me-2"></i> Assign Agents
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    @foreach ($agentsList as $index => $agent)
                        <div class="row align-items-end mb-3" wire:key="agent-row-{{ $index }}">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model.defer="agentsList.{{ $index }}.name" placeholder="Agent Name">
                                @error('agentsList.' . $index . '.name') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model.defer="agentsList.{{ $index }}.contact_number" placeholder="Primary Contact">
                                @error('agentsList.' . $index . '.contact_number') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Alternate Contact</label>
                                <input type="text" class="form-control" wire:model.defer="agentsList.{{ $index }}.contact_number_alt_1" placeholder="Alt Contact">
                                @error('agentsList.' . $index . '.contact_number_alt_1') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" wire:model.defer="agentsList.{{ $index }}.email" placeholder="Email">
                                @error('agentsList.' . $index . '.email') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-12 text-end mt-2">
                                @if($index > 0)
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeAgentRow({{ $index }})">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                @endif
                            </div>
                            <hr class="my-2">
                        </div>
                    @endforeach

                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-success mt-2" wire:click="addAgentRow">
                            <i class="bi bi-plus-circle me-1"></i> Add More Agent
                        </button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button wire:click="saveAgents" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Save All
                    </button>
                </div>
            </div>
        </div>
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
                    $('.chosen-single span').text('Select one');
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
                    }
                });
            }

            document.addEventListener("livewire:navigated", () => {
                initChosen();
            });

            Livewire.hook('morph.updated', () => {
                setTimeout(() => {
                    initChosen();
                    $('.chosen-select').each(function () {
                        const el = $(this);
                        const model = el.attr('wire:model');
                        if (model) {
                            const val = @this.get(model);
                            if (val) el.val(val).trigger('chosen:updated');
                        }
                    });
                }, 400); // increase delay slightly
            });

            $(document).ready(function () {
                initChosen();
            });
        </script>
         <script>
            // document.addEventListener('livewire:load', () => {
                window.addEventListener('close-upload-modal', () => {
                    const modalEl = document.getElementById('uploadcandidateModal');
                    if (!modalEl) return;

                    // Ensure a Bootstrap modal instance exists
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    if (!modal) {
                        modal = new bootstrap.Modal(modalEl);
                    }

                    // Properly hide modal (Bootstrap will clean up the backdrop)
                    modal.hide();

                    // Fallback cleanup (rare cases)
                    setTimeout(() => {
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style = '';
                    }, 500);
                });
            window.addEventListener('toastr:success', event => toastr.success(event.detail.message));

            // });
            </script>
        {{-- <script>
            window.addEventListener('close-upload-modal', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('uploadcandidateModal'));
                alert('hi');
                 modal.hide();
            });
        </script> --}}
    @endpush
</div>
