<div>
    <div class="row g-4">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-file-earmark-text-fill me-2 text-primary"></i>
                    Document Type Management
                </h4>

                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted text-decoration-none">Admin</a>
                    </li>
                    <li class="breadcrumb-item active text-primary">
                        Document Types
                    </li>
                </ol>
            </div>
        </div>

        <!-- LEFT TABLE -->
        <div class="col-lg-8">

            <div class="card shadow-sm border-0 p-3">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">Document Types</h5>

                    <div class="d-flex align-items-center">

                        <input type="text"
                            wire:model.live="search"
                            wire:key="search-input-{{ $searchResetKey }}"
                            class="form-control form-control-sm w-auto me-2"
                            placeholder="Search documents...">

                        <button type="button" class="btn btn-sm btn-danger" wire:click="resetInputFields">
                            Reset Filter
                        </button>

                    </div>
                </div>


                <div class="card-body p-2">

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Document Name</th>
                                    <th>Key</th>
                                    <th width="120">Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>


                            <tbody x-data="sortableTable(@this)" x-ref="tableBody" wire:ignore>
                                @foreach($documents as $index => $doc)
                                <tr data-id="{{ $doc->id }}" wire:key="item-{{ $doc->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $doc->name }}</td>
                                    <td>{{ $doc->key }}</td>
                                    <td>
                                        <input type="checkbox" wire:click="toggleStatus({{ $doc->id }})" {{ $doc->status ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <button wire:click="edit({{ $doc->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <!-- RIGHT FORM -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 p-3">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        {{ $isEdit ? 'Edit Document Type' : 'Add Document Type' }}

                    </h5>

                </div>


                <div class="card-body">

                    <form wire:submit.prevent="save" wire:key="document-form-{{ $editId ?? 'new' }}">

                        <div class="mb-3">

                            <label class="form-label">Document Name</label>

                            <input type="text"
                                   wire:model="name"
                                   class="form-control">

                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Key</label>

                            <input type="text"
                                   wire:model="key"
                                   class="form-control"
                                   placeholder="Example: pan_card">

                            @error('key')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <div class="d-flex justify-content-between">

                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    wire:click="resetInputFields">

                                <i class="bi bi-x"></i> Cancel

                            </button>

                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_view_add_nomination_documents'))
                                <button type="submit"
                                        class="btn btn-primary btn-sm">

                                    {{ $isEdit ? 'Update' : 'Save' }}

                                </button>
                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
    </script>
    <script>
    function sortableTable(livewireComponent) {
        return {
            init() {
                let el = this.$refs.tableBody;

                new Sortable(el, {
                    animation: 150,
                    handle: 'td',
                    onEnd: function () {
                        let items = [];
                        el.querySelectorAll('tr').forEach((row, index) => {
                            items.push({ value: row.dataset.id, order: index + 1 });
                        });
                        @this.call('updatePosition', items);
                    }
                });
            }
        }
    }
    </script>
    @endpush
</div>