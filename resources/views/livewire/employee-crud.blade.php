<div>
    <div class="row g-4">
        <!-- 🧭 Page Header -->
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

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Suspend Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $admin)
                                <tr wire:key="admin-{{ $admin->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($admin->name) }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->mobile ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $admin->role === 'admin' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }}">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </td>
                                    @if ($admin->role !== 'admin')
                                        
                                    
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                wire:change="toggleStatus({{ $admin->id }})"
                                                {{ $admin->suspended_status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $admin->suspended_status == 1 ? 'Active' : 'Suspended' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $admin->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        @if($admin->id !==1)
                                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $admin->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                  @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        No employees found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                <option value="legal associate">Legal Associate</option>
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
