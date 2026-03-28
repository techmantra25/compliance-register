<div>
   <style>
        .status-dropdown {
            background: #f8f9fa;
            border: 1px solid #dee2e6 !important;
            cursor: pointer;
            transition: 0.2s;
        }
        .status-dropdown:hover {
            background: #eef2f6;
        }
        .alert {
            border-left-width: 4px;
            border-left-style: solid;
        }
        .alert-primary { border-left-color: #0d6efd; }
        .alert-danger { border-left-color: #dc3545; }
        .file-card {
            width: 110px;
            text-align: center;
            position: relative;
        }
        .file-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            /* overflow: hidden; */
            margin: auto;
            position: relative;
        }
        .file-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
        .file-box i {
            font-size: 28px;
            color: #6c757d;
        }
        .file-name {
            margin-top: 6px;
            font-size: 12px;
            word-break: break-word;
            line-height: 1.2;
        }
        .file-remove {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 99;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .attachment-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            flex-direction:column;
        }

        .attachment-card {
            position: relative;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            padding:4px;
            width: 100%;
            background: #fafafa;
        }

        .attachment-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attachment-img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 6px;
        }

        .file-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f1f1;
            border-radius: 6px;
            font-size: 20px;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-size: 13px;
            font-weight: 600;
            margin-top:0;
        }

        .file-size {
            font-size: 11px;
            color: #777;
        }

        .remove-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ff4d4f;
            color: white;
            width: 18px;
            height: 18px;
            font-size: 11px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="row g-4">
        
        <div class="row justify-content-between align-items-center pt-4">

            <div class="col-sm col-md">
                <div class="mb-4 mb-md-0">
                    <h4 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-megaphone-fill me-2 text-primary"></i> Complaint Manager
                    </h4>
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">Admin</a>
                        </li>
                        <li class="breadcrumb-item active text-primary">Complaint</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm col-md text-start text-md-end">
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_export_mcc'))
                {{-- <button class="btn btn-primary btn-sm" wire:click="exportMcc">
                    <i class="bi bi-download me-1"></i> Export MCC
                </button> --}}
                @endif
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_import_mcc'))
                {{-- <button class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#importMccModal">
                    <i class="bi bi-upload me-1"></i> Import MCC
                </button> --}}
                @endif
                @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_add_mcc'))
                <button class="btn btn-primary btn-md" wire:click="openMccModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Complaint
                </button>
                @endif
            </div>

        </div>


        <!-- Table -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 p-3 ">

                <div class="card-header bg-white">
                    <div class="row g-2 mb-4 justify-content-center">
                        <div class="col-md-12 col-lg-6">
                            <div class="canditate-search">
                                <input type="text" wire:model="search" wire:keyup="filterCampaign($event.target.value)"
                                class="form-control form-control-sm"
                                placeholder="Search here...">
                                
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-2 g-2">
                        <div class="col-md-4 col-lg-3">
                            <div wire:ignore class="">
                                <select wire:model="filter_by_status" id="statusSelect" class="form-select">
                                    <option></option>
                                    <option value="Live">Live</option>
                                    <option value="Parked">Parked</option>
                                    <option value="Archive">Archive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div wire:ignore class="">
                                <select wire:model="filter_by_assembly" id="assemblySelect" class="form-select">
                                    <option></option>
                                    @foreach ($assembly as $assemb)
                                    <option value="{{ $assemb->id }}">
                                        ({{ $assemb->assembly_code }}) {{ $assemb->assembly_name_en }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div wire:ignore>
                                <select wire:model="filter_by_category" id="categorySelect" class="form-select">
                                    <option></option>
                                    <option value="For AITC">For AITC</option>
                                    <option value="Against AITC">Against AITC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-1">
                            <button class="btn btn-sm btn-danger" wire:click="resetFilters">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle mobile-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Assembly</th>
                                    <th>Block & GP</th>
                                    <th>Complainer Details</th>
                                    <th>Date & Time</th>
                                    <th>Assign To</th>
                                    <th width="10%">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mccList as $key => $item)
                                    <tr>
                                        <td>
                                            <h6 class="responsive-title">Code</h6>

                                            <div class="fw-bold">{{ $item->mcc_code }}</div>

                                            <div class="text-muted small">
                                                @if($item->category == 'For AITC')
                                                    <span class="badge bg-primary">{{ ucwords($item->category) }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ ucwords($item->category) }}</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-start">
                                            <h6 class="responsive-title">Assembly</h6>
                                            
                                            <div class="fw-semibold">{{ ucwords(optional($item->assembly)->assembly_name_en ?? '_') }}</div>
                                            <div class="text-muted small">District: {{ optional(optional($item->assembly)->district)->name_en }}</div>
                                            <div class="small text-primary">
                                                {{ ucwords(optional(optional(optional($item->assembly)->assemblyPhase)->phase)->name ?? 'N/A') }}
                                            </div>
                                        </td>

                                        <td>
                                            <h6 class="responsive-title">Block & GP</h6>

                                            <div class="fw-bold">{{ ucwords($item->block) }}</div>
                                            <div class="text-muted small">@if($item->gp) GP: {{ ucwords($item->gp) }} @endif</div>
                                        </td>

                                        <td>
                                            <h6 class="responsive-title">Complainer Details</h6>

                                            <div class="fw-bold">{{ ucwords($item->complainer_name) }}</div>
                                            <div class="text-muted small">
                                                @if($item->complainer_phone) <i class="bi bi-telephone me-1"></i> {{ $item->complainer_phone }} @endif
                                            </div>
                                        </td>

                                        <td>
                                            <h6 class="responsive-title">Date & Time</h6>

                                            {{ $item->created_at->format('d-m-Y h:i A') }}
                                        </td>

                                        <td>
                                            <h6 class="responsive-title">Assign To</h6>

                                           @if($item->action_taken)
                                                <span class="badge bg-success">
                                                    {{ ucwords($item->legalAssociate->name ?? 'Assigned') }}
                                                </span>
                                            @else
                                                <button class="btn btn-sm btn-outline-primary"
                                                        wire:click="openAssignModal({{ $item->id }})">
                                                    <i class="bi bi-person-check"></i> Assign To
                                                </button>

                                            @endif
                                        </td>

                                        <td>
                                            <h6 class="responsive-title">Status</h6>

                                            <span class="badge
                                                @if($item->status == 'Live') bg-warning
                                                @elseif($item->status == 'Parked') bg-info
                                                @elseif($item->status == 'Archive') bg-success
                                                @else bg-secondary
                                                @endif">

                                                {{ ucwords(str_replace('_',' ', $item->status)) }}

                                            </span>
                                        </td>

                                        <td class="">
                                            <h6 class="responsive-title">Action</h6>
                                            <!-- Edit Button -->
                                            @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_update_mcc') && $item->status == "Live")
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                            wire:click="edit({{ $item->id }})">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <span class="tooltip-text">Edit Complaint</span>
                                                </div>
                                            </div>
                                            @endif
                                            <!-- View MCC Log -->
                                            {{-- @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_view_mcc_log'))
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{ route('admin.mcc_log_details', $item->id) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-clock-history"></i>
                                                    </a>
                                                    <span class="tooltip-text">View MCC Log</span>
                                                </div>
                                            </div>
                                            @endif --}}
                                            {{-- 
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="view({{ $item->id }})">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <span class="tooltip-text">View Details</span>
                                                </div>
                                            </div> --}}
                                            <div class="btn-group m-1">
                                                <div class="tooltip-wrapper">
                                                    <a href="{{route('admin.mcc_violation_remarks', $item->id)}}" class="btn btn-sm btn-outline-primary position-relative">
                                                        View Remarks <i class="bi bi-arrow-right"></i>
                                                        {{-- @php
                                                            $unreadRemarks = $item->RemarksData()->where('is_read', 0)->count();
                                                        @endphp --}}

                                                        {{-- @if($unreadRemarks > 0)
                                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                {{ $unreadRemarks }}
                                                            </span>
                                                        @endif --}}

                                                    </a>
                                                    <span class="tooltip-text">View Remarks</span>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-danger fw-bold">
                                            No Records Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-2 d-flex justify-content-end">
                    {{ $mccList->links('pagination.custom') }}
                </div>
            </div>
        </div>


        <!-- Form -->
        <div wire:ignore.self class="modal fade" id="mccModal" tabindex="-1" aria-labelledby="mccModalLabel"
            ria-hidden="true" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="mccModalLabel">{{ $isEdit ? 'Edit Complaint' : 'Add Complaint' }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form wire:submit.prevent="save" 
                            wire:key="mcc-form-{{ $mcc_id ?? 'new' }}" enctype="multipart/form-data">

                            <div class="row">

                                <!-- LEFT SIDE -->
                                <div class="col-md-6">
                                    <div class="row">

                                        <!-- Assembly -->
                                        <div class="col-md-7 mb-3">
                                            <label class="form-label">Assembly<span class="text-danger">*</span></label>
                                            <div wire:ignore>
                                                <select id="modalAssemblySelect" class="form-control" wire:model="assembly_id">
                                                    <option value="">Select Assembly</option>
                                                    @foreach($assembly as $a)
                                                        <option value="{{ $a->id }}">
                                                            {{$a->assembly_number}}-{{ $a->assembly_name_en }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('assembly_id') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">
                                                Category<span class="text-danger">*</span>
                                            </label>

                                            <div class="d-flex gap-4">

                                                <label class="form-check d-flex align-items-center gap-2" style="cursor:pointer;">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        value="For AITC"
                                                        name="category"
                                                        wire:model="category">
                                                    <span>For AITC</span>
                                                </label>

                                                <label class="form-check d-flex align-items-center gap-2" style="cursor:pointer;">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        value="Against AITC"
                                                        name="category"
                                                        wire:model="category">
                                                    <span>Against AITC</span>
                                                </label>

                                            </div>

                                            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>

                                        <!-- Assign -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Assign To<span class="text-danger">*</span></label>

                                            <div wire:ignore>
                                                <select  id="modalAssignSelect" class="form-control" wire:model="action_taken">
                                                    <option value="">Select Legal Associate</option>
                                                    @foreach($legalAssociates as $associate)
                                                        <option value="{{ $associate->id }}">
                                                            {{ ucwords($associate->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             @error('action_taken')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                         <!-- Description -->
                                        <div class="mb-3">
                                            <label class="form-label">Complaint Description<span class="text-danger">*</span></label>
                                            <!-- <textarea class="form-control" rows="10"
                                                wire:model="complainer_description"
                                                placeholder="Write your complain here"></textarea> -->
                                                <div wire:ignore>
                                                    <textarea id="complaint_description" class="form-control"></textarea>
                                                </div>
                                                @error('complainer_description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>
                                        
                                    </div>
                                </div>

                                <!-- RIGHT SIDE -->
                                <div class="col-md-6">
                                    <div class="row">

                                        <!-- Block -->
                                        <div class="col-md-7 mb-3">
                                            <label>Block/Municipality/Town</label>
                                            <input class="form-control" wire:model="block">
                                            @error('block') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <!-- GP -->
                                        <div class="col-md-5 mb-3">
                                            <label>GP/Ward</label>
                                            <input class="form-control" wire:model="gp">
                                        </div>
                                        <!-- Name -->
                                        <div class="col-12 mb-3">
                                            <label>Complainer Name</label>
                                            <input class="form-control" wire:model="complainer_name">
                                        </div>
                                        <!-- Phone -->
                                        <div class="col-12 mb-3">
                                            <label>Complainer Phone</label>
                                            <input type="text" maxlength="10" class="form-control" wire:model="complainer_phone">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Keywords</label>
                                            <div id="keyword-box" class="form-control d-flex flex-wrap gap-2 align-items-center" style="min-height: 45px; cursor: text;">
                                                @foreach($keywords as $word)
                                                    <span class="badge bg-primary d-flex align-items-center">
                                                        {{ $word }}
                                                        <span class="ms-2" wire:click="removeKeyword('{{ $word }}')" style="cursor:pointer;">&times;</span>
                                                        </span>
                                                @endforeach
                                                <input 
                                                    type="text" 
                                                    id="keyword-input"
                                                    wire:model="keywordInput"
                                                    wire:keydown.enter.prevent="addKeyword"
                                                    style="border:none; outline:none; flex:1; min-width:120px;"
                                                    placeholder="Write Keyword And Press Enter"
                                                    >
                                            </div>
                                        </div>

                                    </div>
                                   
                                    <div class="mb-3">
                                        <label class="form-label">Supporting Documents</label>

                                        <input type="file" class="form-control" wire:model="new_documents" multiple>
                                        @if($errors->has('supporting_documents.*'))
                                            @foreach($errors->get('supporting_documents.*') as $messages)
                                                @foreach($messages as $message)
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @endforeach
                                            @endforeach
                                        @endif

                                        <!-- Loader -->
                                        <div wire:loading wire:target="new_documents" class="text-muted mt-2">
                                            <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                                        </div>

                                        <!-- Selected Files Preview -->
                                        @if(!empty($supporting_documents))
                                        <div class="attachment-wrapper mt-3">

                                            @foreach($supporting_documents as $index => $file)

                                                @php
                                                    $ext = strtolower($file->getClientOriginalExtension());
                                                    $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                                @endphp

                                                <div class="attachment-card">

                                                    <!-- Remove -->
                                                    <span class="remove-btn"
                                                        wire:click="removeTempFile({{ $index }})">
                                                        ✕
                                                    </span>

                                                    <div class="attachment-content">

                                                        @if($isImage)
                                                            <img src="{{ $file->temporaryUrl() }}" class="attachment-img">
                                                        @else
                                                            <div class="file-icon">
                                                                <i class="bi bi-paperclip"></i>
                                                            </div>
                                                        @endif

                                                        <div class="file-info">
                                                            @php
                                                                $originalName = $file->getClientOriginalName();
                                                                $name = pathinfo($originalName, PATHINFO_FILENAME);
                                                                $ext = pathinfo($originalName, PATHINFO_EXTENSION);

                                                                $shortName = Str::limit($name, 25); // truncate only name
                                                            @endphp

                                                            <div class="file-name">
                                                                {{ $shortName }}.{{ $ext }}
                                                            </div>

                                                            <div class="file-size">
                                                                {{ number_format($file->getSize() / 1024, 1) }} KB
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Progress -->
                                                    <div class="progress mt-2" wire:loading wire:target="new_documents">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                            style="width: 100%">
                                                        </div>
                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>
                                        @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button"
                            class="btn btn-primary btn-md"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            wire:target="save,supporting_documents">

                        <span wire:loading.remove wire:target="save,supporting_documents">
                            {{ $isEdit ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Processing...
                        </span>

                        <span wire:loading.delay wire:target="supporting_documents">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Uploading files...
                        </span>

                    </button>

                    </div>
                </div>
            </div>
        </div>

        {{-- <div wire:ignore class="modal fade" id="escalationModal" tabindex="-1" aria-labelledby="actionTakenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-l"> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Escalated To</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Escalated To</label>
                        <input type="text" class="form-control" wire:model="action_taken">
                        @error('action_taken') <small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-sm" wire:click="saveActionTaken">Save</button>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div wire:ignore.self class="modal fade" id="importMccModal" tabindex="-1"
            aria-labelledby="importMccModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-3">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="uploadcampaignerModalLabel">Upload MCC</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row g-3">
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {!! session('error') !!}
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="col-12">
                                <a href="{{ asset('assets/sample-csv/bulk-mcc.csv') }}" download
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Download Sample CSV
                                </a>
                            </div>

                            <div class="col-12">
                                <label for="mccFile" class="form-label fw-semibold mt-3">Upload MCC CSV</label>
                                <input type="file" class="form-control" id="mccFile" wire:model="mccFile" accept=".csv">
                                    @error('mccFile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror

                                <div wire:loading wire:target="mccFile" class="text-muted mt-2">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="resetForm">Close</button>

                        <button type="button" class="btn btn-primary"
                            wire:click="saveMcc"
                            wire:loading.remove
                            wire:target="mccFile">
                            <i class="bi bi-upload me-1"></i>Upload
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- view modal --}}
        {{-- <div wire:ignore.self class="modal fade" id="viewMccModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">MCC Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        @if($viewMcc)

                        <div class="row g-3">

                            <div class="col-md-6">
                                <strong class="text-primary">MCC Code:</strong>
                                <div>{{ $viewMcc->mcc_code }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Assembly:</strong>
                                <div>{{ $viewMcc->assembly->assembly_name_en ?? 'N/A' }}</div>
                                <div class="text-muted small">District: {{ optional(optional($viewMcc->assembly)->district)->name_en }}</div>
                                <div class="small">
                                    {{ ucwords(optional(optional(optional($viewMcc->assembly)->assemblyPhase)->phase)->name ?? 'N/A') }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Category:</strong>
                                <div>{{ $viewMcc->category }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Block:</strong>
                                <div>{{ $viewMcc->block }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">GP:</strong>
                                <div>{{ $viewMcc->gp }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Complainer Detail</strong>
                                <div>{{ $viewMcc->complainer_name }}</div>
                                <div>Phone: {{ $viewMcc->complainer_phone }}</div>
                            </div>

                            <div class="col-md-12">
                                <strong class="text-primary">Description:</strong>
                                <div>{{ $viewMcc->complainer_description }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Assigned To:</strong>
                                <div>{{ $viewMcc->legalAssociate->name ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong class="text-primary">Date:</strong>
                                <div>{{ $viewMcc->created_at->format('d-m-Y h:i A') }}</div>
                            </div>

                        </div>

                        @endif

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div> --}}


        <div wire:ignore.self class="modal fade" id="assignModal" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Assign Legal Associate</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="fw-bold">Complainer Name</label>
                            <div class="text-primary">{{ $complainer_name }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign To</label>

                            <select id="associateSelect" class="form-control" wire:model="associate_id">>
                                <option value="">Select Legal Associate</option>

                                @foreach($legalAssociates as $associate)
                                    <option value="{{ $associate->id }}">
                                        {{ ucwords($associate->name) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('associate_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button class="btn btn-primary" wire:click="updateAssign">
                            Assigned
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="loader-container" wire:loading wire:target="save,openMccModal,edit">
            <div class="loader"></div>
        </div>

    </div>
        @push('scripts')
        <script src="{{ asset('build/ckeditor/ckeditor.js') }}"></script>

        {{-- <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}"> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
        {{-- <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script> --}}

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>

        <script>
            window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
            window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
        </script>

        <script>
          function initSelect2() {

                // FILTER DROPDOWNS
                $('#statusSelect').select2({
                    width: '100%',
                    placeholder: 'Filter by Status',
                   
                }).off('change').on('change', function () {
                    @this.set('filter_by_status', $(this).val());
                });

                $('#assemblySelect').select2({
                    width: '100%',
                    placeholder: 'Filter by Assembly',
                }).off('change').on('change', function () {
                    @this.set('filter_by_assembly', $(this).val());
                });

                $('#categorySelect').select2({
                    width: '100%',
                    placeholder: 'Filter by Category',
                }).off('change').on('change', function () {
                    @this.set('filter_by_category', $(this).val());
                });

                // MODAL DROPDOWNS
                $('#modalAssemblySelect').select2({
                    dropdownParent: $('#mccModal'),
                    width: '100%',
                    placeholder: 'Select Assembly',
                }).off('change').on('change', function () {
                    @this.set('assembly_id', $(this).val());
                });

                $('#modalAssignSelect').select2({
                    dropdownParent: $('#mccModal'),
                    width: '100%',
                    placeholder: 'Select Legal Associate',
                }).off('change').on('change', function () {
                    @this.set('action_taken', $(this).val());
                });

                $('#associateSelect').select2({
                    dropdownParent: $('#assignModal'),
                    width: '100%',
                    placeholder: 'Assign Legal Associate',
                }).off('change').on('change', function () {
                    @this.set('associate_id', $(this).val());
                });
            }

            // Initial load
            document.addEventListener("DOMContentLoaded", function () {
                initSelect2();
            });

            // Re-init after Livewire DOM updates
            Livewire.hook('morph.updated', () => {
                initSelect2();
            });

            document.addEventListener('resetField', () => {
                // document.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
                document.querySelectorAll('input:not([type="file"]), textarea, select').forEach(el => el.value = '');
            });
            document.addEventListener('modelHide', () => {
                $('#campaignerModal').modal('hide');
            });

        </script>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('refreshChosen', () => {
                    $(".chosen-select").trigger("chosen:updated");
                });


                Livewire.on('modelHide', () => {
                    $("#mccModal").modal('hide');

                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = "";
                });
            });

        </script>

        <script>
            window.addEventListener('closeModal', () => {
                $("#mccModal").modal('hide');
                // $("#importMccModal").modal('hide');
                $("#assignModal").modal('hide'); 
            });
            window.addEventListener('open-edit-modal', () => {
                $("#mccModal").modal('show');

                setTimeout(() => {
                    initSelect2();
                    initCkEditor();

                    $('#modalAssemblySelect').val(@this.get('assembly_id')).trigger('change');
                    $('#modalAssignSelect').val(@this.get('action_taken')).trigger('change');

                }, 300);
            });
            window.addEventListener('open-mcc-modal', () => {
                $("#mccModal").modal('show');

                setTimeout(() => {
                    initCkEditor();
                }, 300);    
            });
            // window.addEventListener('open-view-modal', () => {
            //     $("#viewMccModal").modal('show');
            // });
            window.addEventListener('open-assign-modal', () => {
                $("#assignModal").modal('show');
            });
        </script>

        <script>
            window.addEventListener('clear-search-input', () => {
                const input = document.querySelector('input[wire\\:model="search"]');
                if (input) input.value = '';
            });
        </script>
        <script>
            let editor;

            function initCkEditor() {
                if (editor) {
                    editor.destroy(true);
                }

                editor = CKEDITOR.replace('complaint_description', {
                    height: 200,
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                        { name: 'links', items: ['Link'] }
                    ],
                    removeButtons: 'Subscript,Superscript,Anchor,SpecialChar,Styles,Font,FontSize',
                    resize_enabled: false
                });

                editor.setData(@this.get('complainer_description') || '');

                editor.on('change', function () {
                    @this.set('complainer_description', editor.getData());
                });
            }
        </script>
        @endpush
</div>