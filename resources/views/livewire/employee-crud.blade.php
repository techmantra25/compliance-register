<div>

    <div class="row g-4">

        {{-- HEADER --}}
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

                        <li class="breadcrumb-item active text-primary">
                            Employees
                        </li>
                    </ol>
                </nav>
            </div>
        </div>


        {{-- EMPLOYEE LIST --}}
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">Employees</h5>

                    <div class="d-flex gap-2">

                        <input type="text" wire:model="search" wire:keyup="filterCandidates($event.target.value)" class="form-control form-control-sm"
                            placeholder="Search employee">

                        <button class="btn btn-sm btn-danger" wire:click="resetInputFields">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>

                    </div>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name & Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>


                            <tbody>

                                @forelse ($admins as $admin)

                                <tr wire:key="admin-{{ $admin->id }}">

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="fw-bold">{{ $admin->name }}</div>
                                        <small class="text-muted">{{ $admin->email }}</small>
                                    </td>

                                    <td>{{ $admin->mobile ?? '-' }}</td>

                                    <td>
                                        <span class="badge {{ $admin->role_badge }}">
                                            {{ $admin->role_label }}
                                        </span>
                                    </td>


                                    <td>

                                        @if ($admin->id !== 1)
                                            <div class="form-check form-switch">

                                                <input class="form-check-input" type="checkbox"
                                                    wire:change="toggleStatus({{ $admin->id }})"
                                                    {{ $admin->suspended_status ? 'checked' : '' }}>

                                            </div>

                                        @else

                                            <span class="badge bg-secondary">Permanent</span>

                                        @endif

                                    </td>


                                    <td>
                                        @if($admin->id !== 1)
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="edit({{ $admin->id }})">

                                                <i class="bi bi-pencil"></i>

                                            </button>
                                       
                                            @if ($admin->role == 'employee')
                                                <a href="{{ route('admin.employees.permissions',$admin->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">

                                                    <i class="bi bi-shield-lock"></i>

                                                </a>
                                            @endif
                                         @endif

                                    </td>

                                </tr>

                                @empty

                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
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



        {{-- FORM SECTION --}}
        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        {{ $isEdit ? 'Edit Employee' : 'Add Employee' }}
                    </h5>
                </div>


                <div class="card-body">

                    <form wire:submit.prevent="save" wire:key="employee-form-{{ $admin_id ?? 'new' }}">

                        {{-- NAME --}}
                        <div class="mb-3">

                            <label class="form-label">Name</label>

                            <input type="text" wire:model="name" class="form-control">

                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>



                        {{-- EMAIL --}}
                        <div class="mb-3">

                            <label class="form-label">Email</label>

                            <input type="email" wire:model="email" class="form-control">

                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>



                        {{-- MOBILE --}}
                        <div class="mb-3">

                            <label class="form-label">Mobile</label>

                            <input type="text" wire:model="mobile" class="form-control">

                            @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>



                        {{-- ROLE --}}
                        <div class="mb-3">

                            <label class="form-label">Role</label>

                            <select wire:model="role" class="form-select" wire:change="ChangeRole($event.target.value)">

                                <option value="">Select Role</option>

                                <option value="admin">
                                    Super Admin
                                </option>
                                <option value="employee">
                                    Employee(L2)
                                </option>

                                <option value="legal_associate">
                                    Legal Associate(L1/TM)
                                </option>

                            </select>

                            @error('role')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>



                        {{-- DISTRICT SELECT --}}
                        @if($role=="employee2")
                            <div class="mb-3">
                                <label class="form-label">Districts</label>
                                <div wire:ignore>
                                    <select id="districtSelect"
                                        wire:model="districts"
                                        multiple
                                        class="form-select chosen-select"
                                        size="6">

                                        @foreach ($allDistricts as $district)

                                        <option value="{{ $district->id }}">
                                            {{ $district->name_en }}
                                        </option>

                                        @endforeach

                                    </select>
                                </div>

                                @error('districts')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>

                            {{-- ASSEMBLY SELECTOR --}}
                            <div class="mb-3">

                                <label class="form-label">Assemblies</label>

                                <div class="border rounded p-2" style="max-height:250px;overflow:auto">

                                    @foreach($allAssemblies as $assembly)

                                        <div class="form-check" wire:key="assembly-{{ $assembly->id }}">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            wire:model="assemblies"
                                            value="{{ $assembly->id }}"
                                            wire:change="handleAssemblyChange({{ $assembly->id }}, $event.target.checked)"
                                            id="assembly{{ $assembly->id }}">

                                        <label class="form-check-label"
                                            for="assembly{{ $assembly->id }}">

                                        {{ $assembly->assembly_name_en }}

                                        @if($assembly->district)
                                        <span class="text-muted small">
                                        ({{ $assembly->district->name_en }})
                                        </span>
                                        @endif

                                        </label>

                                        </div>

                                        @endforeach

                                </div>

                                @error('assemblies')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        @endif


                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between">

                            <button type="button" wire:click="resetInputFields" class="btn btn-danger btn-sm">

                                Cancel

                            </button>


                            <button type="submit" class="btn btn-primary btn-sm">

                                {{ $isEdit ? 'Update' : 'Save' }}

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>


    </div>



    {{-- LOADER --}}
    <div class="loader-container" wire:loading wire:target="save,delete,edit">

        <div class="loader"></div>

    </div>



    @push('scripts')

    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>


    <script>
        window.addEventListener('ResetForm', event => {

            document.querySelectorAll('input, textarea, select').forEach(el => {

                if (el.type === 'checkbox' || el.type === 'radio') {
                    // el.checked = false;
                } 
                else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } 
                else {
                    el.value = '';
                }

            });

        });
        function initChosen() {

            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found"
            }).off('change').on('change', function () {

                let model = $(this).attr('wire:model');

                if (model) {
                    @this.set(model, $(this).val());
                    @this.call('DistrictUpdate', $(this).val());
                }

            });

        }


        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });


        Livewire.hook('morph.updated', () => {
            initChosen();
        });


        $(document).ready(function () {
            initChosen();
        });


        window.addEventListener('toastr:success', event => {
            toastr.success(event.detail.message)
        });

        window.addEventListener('AssignAssembly', function (event) {
            let selected = event.detail[0].itemId;
            document.querySelectorAll('input[id^="assembly"]').forEach(cb => {
                let val = parseInt(cb.value);

                if (selected.includes(val)) {
                    cb.checked = true;
                } else {
                    cb.checked = false;
                }
            });

            // 🔥 Sync back to Livewire
            Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                .set('assemblies', selected);
        });

       window.addEventListener('refreshChosen', () => {

            setTimeout(() => {

                $('.chosen-select').each(function () {

                    const el = $(this)
                    const model = el.attr('wire:model')

                    if (model) {

                        let value = @this.get(model)

                        if (value) {
                            el.val(value).trigger('chosen:updated')
                        }

                    }

                })

            }, 100)

        })
    </script>

    @endpush

</div>