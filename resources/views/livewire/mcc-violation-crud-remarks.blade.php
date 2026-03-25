<div>

    <style>
       .chat-box {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            background: #f5f7fb;
            border-radius: 10px;
        }

        .chat-bubble {
            max-width: 75%;
            padding: 10px 12px;
            border-radius: 12px;
        }

        .chat-bubble.me {
            background: #fff;
            color: #000;
            border-bottom-right-radius: 0;
        }

        .chat-bubble.other {
            background: #fff;
            color: #000;
            border-bottom-left-radius: 0;
        }
    </style>
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center">

        <div>
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

        <div>
            <a href="{{ route('admin.mcc_violation') }}" 
            class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>

    </div>
    <div class="mb-3 mt-2">
        <div class="card shadow-sm border-0 p-3">

            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <h5 class="fw-bold mb-4">
                        Complaint Details
                    </h5>
                </div>
                    
                <div class="row">
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Complaint Code</strong>
                        {{ $mcc->mcc_code }}
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Category</strong>
                        {{ $mcc->category }}
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Block</strong>
                        {{ $mcc->block }}
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">GP</strong>
                        {{ $mcc->gp }}
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-4">
                        <strong class="title-text">Complainer</strong>
                        {{ $mcc->complainer_name }}
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Phone</strong>
                        {{ $mcc->complainer_phone }}
                    </div>
                    @if($mcc->legalAssociate)
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Assigned To</strong>
                        {{ $mcc->legalAssociate->name }}
                    </div>
                    @endif
                    <div class="col-md-6 col-lg-2 mb-4 mb-lg-4">
                        <strong class="title-text">Status</strong>
                        {{ $mcc->status }}
                    </div>
                    <div class="">
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
            <div class="card-body">
                <!-- MAIN LAYOUT -->
                <div class="row">

                    <!-- LEFT: REMARKS -->
                    <div class="col-lg-6">
                        <h5 class="fw-bold mb-3">Remarks</h5>

                        <div class="chat-box">

                            @forelse($remarks as $key=> $r)

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
                                        <div class="small fw-semibold mb-1 text-muted">
                                            {{ $senderName }}
                                        </div>

                                        <!-- MESSAGE -->
                                        <div class="mb-2">
                                            {!! $r->remarks !!}
                                        </div>

                                        <!-- TAGGED USERS -->
                                        @if($key>0)
                                            @if(!empty($taggedUsers))
                                                <div class="mb-2">
                                                    <small class="text-muted">Tag With:</small><br>

                                                    @foreach($taggedUsers as $user)
                                                        <span class="badge bg-warning text-dark me-1">
                                                            {{ $user }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif

                                        <!-- FILE BUTTONS (F1, F2) -->
                                        @if($r->supportingDocuments->count())
                                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                                @foreach($r->supportingDocuments as $index => $doc)

                                                    <button 
                                                        class="btn btn-sm btn-outline-{{ $isMe ? 'primary' : 'primary' }}"
                                                        wire:click="selectFile('{{ asset($doc->file_path) }}')"
                                                    >
                                                        F{{ $index + 1 }}
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


                    <!-- RIGHT: PREVIEW -->
                    <div class="col-lg-6">
                        <h5 class="fw-bold mb-3">Preview</h5>

                        @if($selectedFile)

                            @if(Str::endsWith($selectedFile, ['jpg','jpeg','png','webp']))
                                <img src="{{ $selectedFile }}" class="img-fluid border rounded">
                            @else
                                <iframe src="{{ $selectedFile }}" width="100%" height="400px"></iframe>
                            @endif

                        @else
                            <div class="text-muted text-center mt-5">
                                Click F1, F2 to preview file
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ADD REMARK -->
    <div class="card mt-4">
        <div class="card-header">
            <h6>Add Remark</h6>
        </div>

        <div class="card-body">

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
                         <button class="btn btn-primary btn-sm"
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