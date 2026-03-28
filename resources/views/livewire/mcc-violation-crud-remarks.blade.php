<div>
    <style>
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
    <!-- HEADER -->
    <div class="row align-items-center mb-4  mb-md-5">

        <div class="col-md-6 mb-4 mb-md-0">
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-chat-left-text me-2 text-primary"></i>
                Complaint Remarks
            </h4>

            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item">
                    <a href="#" class="text-muted text-decoration-none">Complaint</a>
                </li>
                <li class="breadcrumb-item active text-primary">
                    Remarks Trail
                </li>
            </ol>
        </div>

        <div class="col-md-6 text-start text-md-end">
            <div class="d-flex align-items-center gap-2 justify-content-start justify-content-md-end">
                @if($groupMembers->has(auth()->guard('admin')->id()))
                    @if($mcc->status !== 'resolved')
                        <a href="#add-remark" class="btn btn-primary btn-md">Add Remark</a>
                    @endif
                @endif
                <a href="{{ route('admin.mcc_violation') }}" 
                class="btn btn-md btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </a>
            </div>
        </div>

    </div>
    <div class="mb-3 mt-2">
        <div class="card shadow-sm border-0 p-3">

            <div class="card-body bg-white p-0">

                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <h5 class="fw-bold mb-4">
                        Complaint Details
                    </h5>
                </div>
                    
                <div class="row pb-3">
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Complaint Code</strong>
                        {{ $mcc->mcc_code }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Category</strong>
                        {{ $mcc->category }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Block</strong>
                        {{ $mcc->block }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                        <strong class="title-text">GP</strong>
                        {{ $mcc->gp }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Complainer</strong>
                        {{ $mcc->complainer_name }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Phone</strong>
                        {{ $mcc->complainer_phone }}
                    </div>
                    @if($mcc->legalAssociate)
                    <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Assigned To</strong>
                        {{ $mcc->legalAssociate->name }}
                    </div>
                    @endif
                    <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                        <strong class="title-text">Status</strong>
                        {{ $mcc->status }}
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 mb-4">
                         <strong class="title-text">Group Members:</strong>

                        @foreach($groupMembers as $name)
                            <span class="badge bg-info">{{ $name }}</span>
                        @endforeach
                    </div>
                    <div class="col-6 col-md-6 col-lg-3 mb-4">
                        <strong class="title-text">Keywords</strong>

                        @php
                            $keywords = $mcc->keywords ? explode(',', $mcc->keywords) : [];
                        @endphp

                        <div class="mt-1 d-flex flex-wrap gap-1">
                            @foreach($keywords as $key)
                                <span class="badge bg-primary">
                                    {{ trim($key) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- MAIN LAYOUT -->
                <div class="row">

                    <!-- LEFT: REMARKS -->
                    <div class="col-lg-6 mb-4 mb-md-0">
                        <h5 class="section-header">Remarks</h5>
                        <div class="chat-stack">
                            <div class="chat-box">

                                @forelse($remarks as $index=> $r)

                                    @php
                                        $isMe = $r->admin_id == auth()->guard('admin')->id();

                                        // Tagged users
                                        $taggedIds = $r->tag_with ? explode(',', $r->tag_with) : [];
                                        $taggedUsers = \App\Models\Admin::whereIn('id', $taggedIds)
                                                        ->pluck('name')
                                                        ->toArray();

                                        // Sender name
                                        $senderName = $isMe 
                                            ? 'Me' 
                                            : ($r->legalAssociate->name ?? 'User');
                                    @endphp

                                    <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">

                                        <div class="chat-bubble {{ $isMe ? 'me' : 'other' }}">

                                            <!-- USER NAME -->
                                            <div class="small fw-semibold mb-1 title-text">
                                                {{ $senderName }}
                                            </div>

                                            <!-- MESSAGE -->
                                            <div class="mb-2">
                                                @if($index == 0)
                                                    <div class="small fw-semibold mb-1 text-danger">
                                                        Complaint Description:
                                                    </div> 
                                                @endif
                                                {!! $r->remarks !!}
                                            </div>

                                            <!-- TAGGED USERS -->
                                            {{-- @if($index>0) --}}
                                                @if(!empty($taggedUsers))
                                                    <div class="mb-2">
                                                        <small class="text-muted">Tag With:</small><br>

                                                        @foreach($taggedUsers as $user)
                                                            @if($senderName!==$user)
                                                                <span class="badge bg-warning text-dark me-1">
                                                                    {{ $user }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            {{-- @endif --}}

                                            <!-- FILE BUTTONS (F1, F2) -->
                                            @if($r->supportingDocuments->count())
                                                <div class="mt-3 d-flex gap-2 preview-list">
                                                    @foreach($r->supportingDocuments as $index => $doc)

                                                        @php
                                                        $fileName = basename($doc->file_path);
                                                        $name = pathinfo($fileName, PATHINFO_FILENAME);
                                                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                                                    @endphp

                                                    <button 
                                                        class="text-start"
                                                        wire:click="selectFile('{{ asset($doc->file_path) }}')"
                                                    >
                                                        {{ Str::limit($name, 15) }}.{{ $ext }}
                                                    </button>

                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- TIME -->
                                            <div class="text-end small mt-1 {{ $isMe ? 'text-muted' : 'text-muted' }}">
                                                {{ $r->created_at->format('d M Y h:i A') }}
                                            </div>

                                        </div>

                                    </div>

                                @empty
                                    <div class="text-muted text-center">No remarks found</div>
                                @endforelse

                            </div>
                        </div>

                    </div>


                    <!-- RIGHT: PREVIEW -->
                    <div class="col-lg-6">
                        <h5 class="section-header">Preview</h5>

                        
                            @if($selectedFile)

                            @php
                                $extension = strtolower(pathinfo($selectedFile, PATHINFO_EXTENSION));

                                $docTypes = ['doc','docx','xls','xlsx','ppt','pptx','txt','csv','odt','ods','odp'];
                            @endphp

                            {{-- 🖼️ IMAGE --}}
                            @if(in_array($extension, ['jpg','jpeg','png','gif','bmp','webp']))
                                <div class="preview-image-stack">
                                    <img src="{{ $selectedFile }}" 
                                        class="img-fluid border rounded"
                                        style="max-height: 500px; object-fit: contain;">
                                </div>

                            {{-- 📄 PDF --}}
                            @elseif($extension === 'pdf')
                                <iframe src="{{ $selectedFile }}" 
                                        style="width:100%; height:500px; border:none;">
                                </iframe>

                            {{-- 📄 DOC / DOCX / PPT / XLS (Google Viewer) --}}
                            @elseif(in_array($extension, $docTypes))
                                <iframe 
                                    src="https://docs.google.com/gview?url={{ urlencode($selectedFile) }}&embedded=true"
                                    width="100%" 
                                    style="border:none; height:500px">
                                </iframe>

                            {{-- 📊 CSV / TXT --}}
                            @elseif(in_array($extension, ['csv','txt']))
                                <div class="bg-light p-3 rounded border text-start">
                                    <strong>Preview:</strong>
                                    <pre class="small text-muted" style="max-height: 400px; overflow-y: auto;">
                        File preview not available. Please download.
                                    </pre>
                                    <a href="{{ $selectedFile }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                        Download File
                                    </a>
                                </div>

                            {{-- 📊 Excel special UI --}}
                            @elseif(in_array($extension, ['xlsx','xls']))
                                <div class="text-center p-4 bg-light border rounded">
                                    <i class="bi bi-file-earmark-excel text-success fs-1 mb-2"></i>
                                    <h6>Excel File</h6>
                                    <p class="small text-muted mb-2">
                                        You can download and open this file in Excel or Google Sheets.
                                    </p>
                                    <a href="{{ $selectedFile }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="bi bi-download"></i> Download Excel
                                    </a>
                                </div>

                            {{-- 📁 FALLBACK --}}
                            @else
                                <div class="text-center p-4">
                                    <i class="bi bi-file-earmark text-secondary fs-1"></i>
                                    <p class="mt-2">Preview not available</p>
                                    <a href="{{ $selectedFile }}" target="_blank" class="btn btn-primary btn-sm">
                                        Open File
                                    </a>
                                </div>
                            @endif

                        @else
                            <div class="text-muted text-center mt-5">
                                Click file to preview
                            </div>
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ADD REMARK -->
    @if($groupMembers->has(auth()->guard('admin')->id()))
        <div id="add-remark" class="card shadow-sm border-0 mt-4 p-3">
           
            <div class="card-body p-0">
                <h5 class="fw-bold mb-4">Add Remark</h5>

                @if($mcc->status == 'resolved')
                    <div class="alert alert-success">
                        Case already resolved
                    </div>
                @else
                    <form wire:submit.prevent="saveRemark">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3" wire:ignore>
                                    <textarea class="form-control" id="editor" placeholder="Write remark"></textarea>
                                </div>
                                <div>
                                    @error('remarks')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <input type="file" wire:model="attachment" class="form-control" multiple>
                                    @error('attachment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if(!empty($attachment))
                                        <div class="attachment-wrapper mt-3">

                                            @foreach($attachment as $index => $file)

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
                                                            <div class="file-name">
                                                                {{ Str::limit($file->getClientOriginalName(), 25) }}
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
                                <div class="mb-3" wire:ignore>
                                    <label class="form-label">Tag With</label>

                                    <select id="tagUsers" wire:model="tag_with" class="form-control chosen-select" multiple>
                                        @foreach($allUsers as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} ({{ $user->role_label }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    <div class="d-flex justify-content-end align-items-start flex-wrap">
                            <button class="btn btn-primary btn-md"
                                    wire:loading.attr="disabled"
                                    wire:target="saveRemark,attachment">

                                <span wire:loading.remove wire:target="saveRemark,attachment">
                                    Add Remark
                                </span>

                                <span wire:loading wire:target="saveRemark,attachment">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Please wait...
                                </span>
                            </button>
                    </div>

                    </form>
                @endif
            </div>
        </div>
    @endif

    <div class="loader-container" wire:loading wire:target="saveRemark,attachment">
        <div class="loader"></div>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
            window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
        </script>
        <script src="{{ asset('build/ckeditor/ckeditor.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {

            //  Initialize CKEditor
            window.editorInstance = CKEDITOR.replace('editor', {
                height: 200,
                toolbar: [
                    { name: 'styles', items: ['Format','Font','FontSize'] },
                    { name: 'basicstyles', items: ['Bold','Italic'] },
                    { name: 'paragraph', items: ['NumberedList','BulletedList'] }
                ]
            });

            //  Sync data to Livewire (ONLY set, not call function)
            window.editorInstance.on('change', function () {
                let data = window.editorInstance.getData();
                @this.set('remark', data);
            });

        });


        //  Reset form + CKEditor
        window.addEventListener('ResetFormData', event => {

            $('.chosen-select').val('').trigger('chosen:updated');
            // Reset normal inputs
            document.querySelectorAll('input, textarea, select').forEach(el => {

                if (el.type === 'checkbox' || el.type === 'radio') {
                    // optional
                } 
                else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } 
                else {
                    el.value = '';
                }

            });

            // Reset CKEditor properly
            if (window.editorInstance) {
                window.editorInstance.setData('');
            }

        });
        
        </script>
         <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    
        <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>

        <script>
            function initChosen() {
            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found",
                search_contains: true
            })
            .off('change')
            .on('change', function () {
                let model = $(this).attr('wire:model');
                if (model) {
                    @this.set(model, $(this).val());
                }
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            initChosen();
        });
        
        </script>
    @endpush
</div>