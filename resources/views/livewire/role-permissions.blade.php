<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-people-fill me-2 text-primary"></i> Employee Management
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.employees')}}" class="text-decoration-none text-muted">
                            <i class="bi bi-people-fill me-1"></i> Admin
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">
                        Employees
                    </li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">
                        Permissions
                    </li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">
                        {{ ucwords($admin->name) }}
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('admin.employees') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-3 pb-2">
            <h5 class="fw-bold mb-0">Module wise Permissions</h5>
        </div>

        <div class="card-body">
            @foreach($modules as $module)
                <div class="mt-4 mb-2">
                    <h6 class="fw-bold text-secondary">{{ $module->name }}</h6>
                </div>

                <div class="row g-3">
                    @php
                        $permissions = DB::table('permissions')
                            ->where('parent_module_id', $module->id)
                            ->get();
                    @endphp

                    @foreach($permissions as $per)
                        <div class="col-md-4">
                            <label class="form-check-label d-flex align-items-center" style="cursor:pointer;">
                                <input 
                                    type="checkbox"
                                    class="form-check-input me-2"
                                    wire:change="togglePermission({{ $admin->id }}, {{ $per->id }})"
                                    {{ in_array($per->id, $assignedPermissions) ? 'checked' : '' }}
                                >
                                <span>{{ $per->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <hr>
            @endforeach

        </div>
    </div>
    @push('scripts')
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
    </script>
    @endpush
</div>

