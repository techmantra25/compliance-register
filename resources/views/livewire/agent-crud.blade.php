<div>
    <div class="row g-4">
        <!-- 🧭 Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Contact List
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Contacts
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary btn-sm" wire:click="newAgent" data-bs-toggle="modal"
                    data-bs-target="#agentModal">
                    <i class="bi bi-plus-circle me-1"></i> Add New Contacts
                </button>
            </div>
        </div>

        <!-- 🟦 Main Content -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"> Contacts</h5>

                    <div class="d-flex align-items-center">
                        <input type="text" wire:model="search" wire:keyup="filterAgents($event.target.value)"
                            class="form-control form-control-sm w-auto me-2" placeholder="Search here...">

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
                                    <th>Sl.No</th>
                                    <th> Name</th>
                                    <th>Mobile No/Whatsapp No</th>
                                    <th>Email</th>
                                    <th>Area/District</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agents as $agent)
                                <tr wire:key="agent-{{ $agent->id }}">
                                    <td>{{ $agents->firstItem() + $loop->index }}</td>
                                    <td>{{ $agent->name }}</td>
                                    <td>
                                       <p> Mobile No: {{$agent->contact_number}}</p> 
                                       <p> Whatsapp No: {{$agent->whatsapp_number}}</p>
                                    </td>
                                    <td>{{ $agent->email ?? '-' }}</td>
                                    <td>{{ $agent->area ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            wire:click="edit({{ $agent->id }})" data-bs-toggle="modal"
                                            data-bs-target="#agentModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No agents found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 d-flex justify-content-end">
                        {{ $agents->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🟢 Agent Modal -->
    {{-- <div wire:ignore.self class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="agentModalLabel">
                        {{ $editMode ? 'Update Agent' : 'Add Agent' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetForm"></button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}"
                    wire:key="agent-form-{{ $editId ?? 'new' }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Category <span class="text-danger">*</span></label>
                            <select wire:model="agent_type" class="form-control">
                                <option value="">-- Select Type --</option>
                                <option value="bureaucrat">Bureaucrat</option>
                                <option value="political">Political</option>
                                <option value="other">Other</option>
                            </select>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" wire:model="designation" class="form-control">
                            @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" wire:model="contact_number" class="form-control">
                            @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alt Contact Number</label>
                            <input type="text" wire:model="contact_number_alt_1" class="form-control">
                            @error('contact_number_alt_1') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                            wire:click="resetForm">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ $editMode ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agentModalLabel"> {{ $editMode ? 'Update Contact' : 'Add New Contact' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                     <form wire:submit.prevent="{{ $editMode ? 'updateAgent' : 'saveAgent' }}">
                    <div class="mb-3">
                        <label for="agent_type" class="form-label">Select Category *</label>
                        <select wire:model="agent_type" id="agent_type" class="form-select">
                            <option value="">-- Select Category --</option>
                            <option value="bureaucrat">Bureaucrat</option>
                            <option value="political">Political</option>
                            <option value="other">Other</option>
                        </select>
                        @error('agent_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Bureaucrat Form -->
                    <div id="bureaucrat_fields" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text" class="form-control" wire:model="name" placeholder="Enter Name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designation">Designation *</label>
                                <select id="designation" wire:model="designation" class="form-select">
                                    <option value="">-- Select Designation --</option>
                                    <option value="mla">MLA</option>
                                    <option value="mp">MP</option>
                                    <option value="collector">Collector</option>
                                    <option value="commissioner">Commissioner</option>
                                    <option value="chairman">Chairman</option>
                                </select>
                                @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Area/District *</label>
                                <input type="text" class="form-control" wire:model="area"
                                    placeholder="Enter Area/District">
                                @error('area') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile No *</label>
                                <input type="number" class="form-control" wire:model="mobile_no"
                                    placeholder="Enter Mobile Number">
                                @error('mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone No</label>
                                <input type="number" class="form-control" wire:model="phone_no"
                                    placeholder="Enter Phone Number">
                                @error('phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Id</label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter Email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Comments</label>
                                <textarea class="form-control" wire:model="comments"
                                    placeholder="Enter Comments"></textarea>
                                @error('comments') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Political Form -->
                    <div id="political_fields" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3" wire:ignore>
                                <label for="assemblies_id" class="form-label">Assembly</label>
                                <select wire:model="assemblies_id" id="assemblies_id" class="form-select chosen-select">
                                    <option value="">-- Select Assembly No --</option>
                                    @foreach ($assemblies as $assembly)
                                    <option value="{{ $assembly->id }}">
                                        {{$assembly->assembly_name_en}}({{ $assembly->assembly_code }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('assemblies_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text" class="form-control" wire:model="name" placeholder="Enter Name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile No *</label>
                                <input type="number" class="form-control" wire:model="mobile_no"
                                    placeholder="Enter Mobile No">
                                @error('mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Whatsapp No</label>
                                <input type="number" class="form-control" wire:model="whatsapp_no"
                                    placeholder="Enter Whatsapp No">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Id</label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter Email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Designation</label>
                                <input type="text" class="form-control" wire:model="designation"
                                    placeholder="Enter Designation">
                                @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Comments</label>
                                <textarea class="form-control" wire:model="comments"
                                    placeholder="Enter Comments"></textarea>
                                @error('comments') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Other Form -->
                    <div id="other_fields" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text" class="form-control" wire:model="name" placeholder="Enter Name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mobile No *</label>
                                <input type="number" class="form-control" wire:model="mobile_no"
                                    placeholder="Enter Mobile No">
                                @error('mobile_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Whatsapp No</label>
                                <input type="number" class="form-control" wire:model="whatsapp_no"
                                    placeholder="Enter Whatsapp No">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Id</label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter Email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Designation</label>
                                <input type="text" class="form-control" wire:model="designation"
                                    placeholder="Enter Designation">
                                @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Area/District</label>
                                <input type="text" class="form-control" wire:model="area"
                                    placeholder="Enter Area/District">
                                @error('area') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Comments</label>
                                <textarea class="form-control" wire:model="comments"
                                    placeholder="Enter Comments"></textarea>
                                @error('comments') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" wire:click="{{ $editMode ? 'updateAgent' : 'saveAgent' }}">
                    {{ $editMode ? 'Update' : 'Save' }}
                </button>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
        // Initialize Chosen dropdowns
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

// Function to show/hide fields based on category
function toggleCategoryFields() {
    const selected = $('#agent_type').val();
    $('#bureaucrat_fields, #political_fields, #other_fields').addClass('d-none');

    if (selected === 'bureaucrat') $('#bureaucrat_fields').removeClass('d-none');
    else if (selected === 'political') $('#political_fields').removeClass('d-none');
    else if (selected === 'other') $('#other_fields').removeClass('d-none');
}

// Initialize Chosen when page loads
$(document).ready(function () {
    initChosen();
    
    // Show/Hide Fields based on selected Category
    $('#agent_type').on('change', function () {
        toggleCategoryFields();
    });
});

// Reinitialize Chosen when modal is shown
$('#agentModal').on('shown.bs.modal', function () {
    setTimeout(() => {
        $('.chosen-select').chosen('destroy');
        $('.chosen-select').chosen({ width: '100%' });
        $('.chosen-select').trigger('chosen:updated');
        
        // Restore the visible fields after Chosen reinitializes
        toggleCategoryFields();
    }, 200);
});

// Handle Livewire updates (morph/re-render)
Livewire.hook('morph.updated', ({ el, component }) => {
    // Update Chosen with Livewire values
    $('.chosen-select').each(function () {
        const el = $(this);
        const model = el.attr('wire:model');
        const liveValue = @this.get(model);

        if (liveValue !== undefined && liveValue !== null) {
            el.val(liveValue).trigger('chosen:updated');
        }
    });
    
    // Preserve the visible category fields after Livewire updates
    toggleCategoryFields();
});

// Livewire hook for when content updates (alternative/backup)
document.addEventListener('livewire:update', function () {
    setTimeout(() => {
        toggleCategoryFields();
    }, 100);
});

// Toastr message listener
window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
window.addEventListener('toastr:error', event => toastr.error(event.detail.message));

window.addEventListener('close-modal', event => {
    $('#agentModal').modal('hide');
});

window.addEventListener('agent-edit-loaded', event => {
    const type = event.detail.type;

    $('#agent_type').val(type).trigger('chosen:updated');
    
    toggleCategoryFields();

    setTimeout(() => toggleCategoryFields(), 200);
});

    </script>

    @endpush

</div>