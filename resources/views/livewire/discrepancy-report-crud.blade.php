<div>
    <div class="row g-4">
        <!-- 🧭 Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i> Social Media Reports
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-grid-fill me-1"></i> Admin
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            Social Media Reports
                        </li>
                    </ol>
                </nav>
            </div>

            <div>
                <button class="btn btn-primary btn-sm" wire:click="newReport" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Report
                </button>
            </div>
        </div>
        <!-- 🔍 Search -->

        <!-- 🧾 Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Reports</h5>

                    <div class="d-flex align-items-center">
                        
                        <div class="mx-2" style="width: 300px;" wire:ignore>
                            <select wire:model="selected_assembly_id" class="form-select form-select-sm chosen-select">
                                <option value="">-- Select Assembly --</option>
                                @foreach ($assemblies as $assembly)
                                    <option value="{{ $assembly->id }}">{{ $assembly->assembly_name_en }}({{$assembly->assembly_code}}) ({{$assembly->assembly_name_bn}})</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text"
                            wire:model="search"
                            wire:keyup="filterReport($event.target.value)"
                            class="form-control form-control-sm w-auto me-2"
                            placeholder="Search here...">
                        <button class="btn btn-sm btn-danger" wire:click="resetFormfield">
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
                                    <th>Assembly</th>
                                    <th>District</th>
                                    <th>Social Media</th>
                                    <th>Report Type</th>
                                    <th>Report</th>
                                    <th>Created At</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $index => $item)
                                    <tr>
                                        <td>{{ $reports->firstItem() + $index }}</td>
                                        <td>{{ $item->assembly->assembly_name_en ?? '-' }}</td>
                                        <td>{{ $item->assembly->district->name_en ?? '-' }}</td>
                                        <td>{{ $item->social_media ?? '-' }}</td>
                                        <td>
                                            @if($item->report_type == 'Approved')
                                                <span class="badge bg-success">{{ $item->report_type }}</span>
                                            @else
                                                 <span class="badge bg-danger">{{ $item->report_type }}</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($item->report, 60) }}</td>
                                        <td>{{ $item->created_at->format('d M, Y h:i:s A') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                wire:click="edit({{ $item->id }})"
                                                data-bs-toggle="modal" data-bs-target="#reportModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $item->id }})"
                                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                <i class="bi bi-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-3">
                                            <i class="bi bi-inbox"></i> No reports found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $reports->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🧱 Modal: Add/Edit Report -->
        <div wire:ignore.self class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="reportModalLabel">
                            {{ $editMode ? 'Edit Report' : 'Add New Report' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}" wire:key="report-form-{{ $editId ?? 'new' }}">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Assembly <span class="text-danger">*</span></label>
                                    <div wire:ignore>
                                        <select wire:model="assembly_id" class="form-select form-select-sm chosen-select">
                                            <option value="">-- Select Assembly --</option>
                                            @foreach ($assemblies as $assembly)
                                                <option value="{{ $assembly->id }}">{{ $assembly->assembly_name_en }}({{$assembly->assembly_code}}) ({{$assembly->assembly_name_bn}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    @error('assembly_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Social Media <span class="text-danger">*</span></label>
                                    <select wire:model="social_media" class="form-select form-select-sm" wire:change="changeSocialMedia($event.target.value)">
                                        <option value="">-- Select Platform --</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Twitter">Twitter(now X)</option>
                                        <option value="Instagram">Instagram</option>
                                    </select>
                                    @error('social_media') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                @if($social_media)
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <select wire:model="report_type" class="form-select form-select-sm" wire:change="changeStatus($event.target.value)">
                                        <option value="Approved">Approved</option>
                                        <option value="Mismatched">Mismatched</option>
                                    </select>
                                    @error('report_type') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                @endif
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Report Details(remarks)</label>
                                        <textarea wire:model="report" class="form-control form-control-sm" rows="3" placeholder="Describe the remarks..."></textarea>
                                        @error('report') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Source URL</label>
                                        <input type="url" wire:model="source_url" class="form-control form-control-sm" placeholder="https://example.com/source-link">
                                        @error('source_url') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Screenshot / Image </label>
                                        <input type="file" wire:model="screenshot" accept="image/*" class="form-control form-control-sm">
                                        @error('screenshot') <span class="text-danger small">{{ $message }}</span> @enderror

                                        @if ($screenshot)
                                            <div class="mt-2">
                                                <img src="{{ $screenshot->temporaryUrl() }}" alt="Preview" class="img-thumbnail" width="120">
                                            </div>
                                        @endif
                                        @if ($existing_screenshot && !$screenshot)
                                            <div class="mt-2">
                                                <label class="small text-muted">Current Image:</label><br>
                                                <a href="{{ asset($existing_screenshot) }}" target="_blank">
                                                    <img src="{{ asset($existing_screenshot) }}" class="img-thumbnail" width="120">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancel
                            </button>
                            @if($social_media && $report_type)
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-save"></i> {{ $editMode ? 'Update' : 'Save' }}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="loader-container" wire:loading wire:target="edit,resetFilters,screenshot,newReport">
            <div class="loader"></div>
        </div>
    </div>
    <!-- 🧩 Close Modal Event -->
    @push('scripts')
        <script>
            window.addEventListener('ResetFormData', event => {
                document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
                const chosen = $('.chosen-select');
                if (chosen.length) {
                    chosen.val('').trigger('chosen:updated');
                    $('.chosen-single span').text('Filter by assembly');
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

            Livewire.hook('morph.updated', ({ el, component }) => {
                initChosen();
                // After re-init, sync the Livewire value back to Chosen
                $('.chosen-select').each(function () {
                    const el = $(this);
                    const model = el.attr('wire:model');
                    if (model && @this.get(model)) {
                        el.val(@this.get(model)).trigger('chosen:updated');
                    }
                });
            });

            $(document).ready(function () {
                initChosen();
            });
        </script>
    @endpush

</div>
