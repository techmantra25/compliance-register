<div>
    <div class="row g-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-people-fill me-2 text-primary"></i> Employee Management
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Employees
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#zoneModal"> <i class="bi bi-map me-2"></i>Zones</button>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Employees</h5>
                    <input type="text" wire:model="search" wire:keyup="filterEmployees($event.target.value)"
                        class="form-control form-control-sm w-auto" placeholder="Search...">
                </div>

               <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name & Email</th>
                                        <th>Mobile</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $admin)
                                        <tr wire:key="admin-{{ $admin->id }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle fs-4 me-2 text-secondary"></i>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ ucwords($admin->name) }}</div>
                                                        <span class="text-muted small">{{ $admin->email }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $admin->mobile ?? '-' }}</td>

                                            <td class="text-center">
                                                @php
                                                    $role_text = ucwords(str_replace('_', ' ', $admin->role));
                                                    $role_class = $admin->role === 'admin' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info';
                                                @endphp
                                                <span class="badge {{ $role_class }} px-2 py-1">
                                                    {{ $role_text }}
                                                </span>
                                            </td>

                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'employee_suspend_employee_status'))
                                                @if ($admin->role !== 'admin')
                                                    <td class="text-center">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch-{{ $admin->id }}"
                                                                wire:change="toggleStatus({{ $admin->id }})"
                                                                {{ $admin->suspended_status == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label small text-nowrap" for="statusSwitch-{{ $admin->id }}">
                                                                @if ($admin->suspended_status == 1)
                                                                    <span class="text-success fw-bold">Active</span>
                                                                @else
                                                                    <span class="text-danger fw-bold">Suspended</span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <span class="badge bg-secondary-subtle text-secondary py-1">Permanent</span>
                                                    </td>
                                                @endif
                                            @endif

                                            @if ($admin->id !== 1)
                                            <td class="text-center text-nowrap">
                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'employee_update_employee'))
                                                <button class="btn btn-sm btn-outline-primary me-1" title="Edit" wire:click="edit({{ $admin->id }})">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                @endif

                                                <a href="{{ route('admin.employees.permissions', $admin->id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Permissions">
                                                    <i class="bi bi-shield-lock"></i>
                                                </a>

                                                @if(childUserAccess(Auth::guard('admin')->user()->id,'employee_delete_employee'))
                                                @if ($admin->id !== 1)
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete" wire:click="confirmDelete({{ $admin->id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                                @endif
                                            </td>
                                            @else
                                                <td class="text-center text-muted">-</td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-info-circle-fill me-1"></i> No employees found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🟦 Right Column: Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">{{ $isEdit ? 'Edit Employee' : 'Add Employee' }}</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save" 
                        autocomplete="off" 
                        wire:key="employee-form-{{ $admin_id ?? 'new' }}">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" wire:model="name" class="form-control" autocomplete="off">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                wire:model="email" 
                                class="form-control" 
                                autocomplete="off"
                                placeholder="Enter employee email">
                            @error('email') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" wire:model="mobile" class="form-control">
                            @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Zones</label>
                            <select wire:model.defer="zone_id" class="form-select">
                                <option value="">Select zone</option>
                                @foreach ($zones as $zone_item)
                                    <option value="{{$zone_item->id}}">{{$zone_item->name}}</option>
                                @endforeach
                            </select>
                            @error('zone_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select wire:model.defer="role" class="form-select">
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                                <option value="legal_associate">Legal Associate</option>
                            </select>
                            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" wire:model.defer="password" class="form-control">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-sm" wire:click="resetInputFields">
                                    <i class="bi bi-x"></i> Cancel
                                </button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                style="background-color: #438a7a; border-color: #438a7a;">
                                {{ $isEdit ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="modal fade" id="zoneModal" tabindex="-1" aria-labelledby="zoneModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="zoneModalLabel">
                       Zone Wise District
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($zones->count())
                        <div class="table-responsive">
                           <table class="table table-bordered align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Zone Name</th>
                                        <th width="50%">Districts</th>
                                        {{-- <th>Reasons</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($zones as $zone)
                                        <tr>
                                            <td>{{ $zone->name }}</td>

                                            <!-- District badge list -->
                                            <td>
                                                @foreach($zone->district_list as $district)
                                                    <span class="badge bg-primary text-dark me-1 mb-1">
                                                        {{ $district }}
                                                    </span>
                                                @endforeach
                                            </td>

                                            {{-- <td>{{ $zone->reasons }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    @else
                        <p class="text-muted">No zone data available.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- 🔁 Loading spinner -->
    <div class="loader-container" wire:loading wire:target="save, delete, edit,resetInputFields">
        <div class="loader"></div>
    </div>
    @push('scripts')
    <!-- ✅ Toastr setup -->
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('showConfirm', function (event) {
            let itemId = event.detail[0].itemId;
            Swal.fire({
                title: "Delete Agent?",
                text: "Are you sure you want to delete this agent?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', itemId);
                }
            });
        });
        window.addEventListener('ResetForm', event => {
            document.querySelectorAll('input').forEach(input => input.value = '');
            const chosen = $('.chosen-select');
            if (chosen.length) {
                chosen.val('').trigger('chosen:updated');
                $('.chosen-single span').text('Filter by Vendor');
            }
        });
    </script>
    
    
    @endpush
</div>
