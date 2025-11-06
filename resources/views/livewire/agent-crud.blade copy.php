<div>
    <div class="row g-4">
        <!-- 🧭 Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Agent Contact List
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Agents
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary btn-sm" wire:click="newAgent" data-bs-toggle="modal" data-bs-target="#agentModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Agent
                </button>
            </div>
        </div>

        <!-- 🟦 Main Content -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Agent Contacts</h5>

                    <div class="d-flex align-items-center">
                        <input type="text"
                            wire:model="search"
                            wire:keyup="filterAgents($event.target.value)"
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
                                    <th>#</th>
                                    <th>Agent Name</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Alt Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agents as $agent)
                                    <tr wire:key="agent-{{ $agent->id }}">
                                        <td>{{ $agents->firstItem() + $loop->index }}</td>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->designation ?? '-' }}</td>
                                        <td>{{ $agent->email ?? '-' }}</td>
                                        <td>{{ $agent->contact_number ?? '-' }}</td>
                                        <td>{{ $agent->contact_number_alt_1 ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="edit({{ $agent->id }})"
                                                data-bs-toggle="modal"
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
    <div wire:ignore.self class="modal fade" id="agentModal" tabindex="-1" aria-labelledby="agentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="agentModalLabel">
                        {{ $editMode ? 'Update Agent' : 'Add Agent' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="resetForm"></button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}" wire:key="agent-form-{{ $editId ?? 'new' }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" class="form-control">
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

    @push('scripts')
        <script>
            window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
        </script>

        <script>
            window.addEventListener('ResetForm', event => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
            });
        </script>
    @endpush
</div>
