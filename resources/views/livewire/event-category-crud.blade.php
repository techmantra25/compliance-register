<div>
    <div class="row g-4">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-calendar-event-fill me-2 text-primary"></i> Event Categories
                </h4>
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">Admin</a></li>
                    <li class="breadcrumb-item active text-primary">Event Categories</li>
                </ol>
            </div>
        </div>

        <!-- Table -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Categories</h5>
                    <input type="text" wire:model="search" wire:keyup="filter($event.target.value)"
                           class="form-control form-control-sm w-auto" placeholder="Search...">
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $cat)
                                    <tr wire:key="event-cat-{{$cat->id}}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $cat->name }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:click="toggleStatus({{ $cat->id }})"
                                                    {{ $cat->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_update_event_category'))
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="edit({{ $cat->id }})">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            @endif
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_event_category_required_permission_list'))
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    wire:click="openPermissionModal({{ $cat->id }})">
                                                    Required Permissions
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No categories found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">{{ $isEdit ? 'Edit Category' : 'Add Category' }}</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save" wire:key="event-form-{{ $category_id ?? 'new' }}">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label><br>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    wire:model="status">
                                <label class="form-check-label">
                                    {{ $status ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-sm" wire:click="resetInputFields">
                                <i class="bi bi-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ $isEdit ? 'Update' : 'Save' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @if($showPermissionModal)
            <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Required Permissions — {{ $current_category->name }}
                            </h5>
                            <button class="btn-close" wire:click="$set('showPermissionModal', false)"></button>
                        </div>

                        <div class="modal-body">

                            <table class="table table-bordered align-middle">
                                <thead class="">
                                    <tr>
                                        <th width="35%">Permission Required</th>
                                        <th width="35%">Issuing Authority / Department</th>
                                        <th width="10%">Status</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($permissionRows as $index => $row)
                                        <tr wire:key="required-{{$index}}">
                                            <td>
                                                <input type="text"
                                                    class="form-control"
                                                    wire:model="permissionRows.{{ $index }}.permission_required">

                                                @if(isset($rowErrors[$index]['permission_required']))
                                                    <small class="text-danger">
                                                        {{ $rowErrors[$index]['permission_required'] }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <input type="text"
                                                    class="form-control"
                                                    wire:model="permissionRows.{{ $index }}.issuing_authority">
                                            </td>

                                            <td class="text-center">
                                                <input type="checkbox"
                                                    class="form-check-input"
                                                    wire:model="permissionRows.{{ $index }}.status">
                                            </td>

                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm"
                                                        wire:click="removeRow({{ $index }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach

                                </tbody>
                            </table>

                            <button class="btn btn-sm btn-secondary"
                                wire:click="addPermissionRow">
                                + Add Row
                            </button>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-danger"
                                wire:click="$set('showPermissionModal', false)">
                                Cancel
                            </button>

                            <button class="btn btn-primary"
                                wire:click="savePermissions">
                                Save Changes
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            @endif

    </div>
    @push('scripts')
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
    </script>
    @endpush
</div>
