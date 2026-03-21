<div>
    <style>

    .document-tabs a{
        cursor:pointer;
    }

    .preview-box{
        height: 600px;
        border:1px solid #ddd;
        background:#fafafa;
        overflow:hidden;
        display:flex;
    }


    #editor{
        min-height:400px;
    }

    </style>
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
        {{-- Left Section: Title + Candidate Info --}}
        <div class="mb-2">
            <h4 class="fw-bold mb-2 text-dark">Document Preview @if($versionData) (V-{{$versionData->version}}) @endif</h4>
        </div>
        
        {{-- Right Section: Upload Acknowledgement Copy + Back Button --}}
        <div class="d-flex flex-column align-items-end gap-2">
            {{-- Back Button --}}
            <a href="{{ route('admin.candidates.documents', ['candidate'=>$candidateId]) }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>
    </div>
    <div class="card shadow-sm border-0 p-3 mt-4">
        <div class="mb-4">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <strong class="title-text">Candidate Name</strong>
                    <h6>{{ $candidateName ?? 'N/A' }}</h6>
                </div>
                <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                    <strong class="title-text">Assembly Name & No</strong>
                    <h6>{{ $assemblyName ?? 'N/A' }}</h6>
                </div>

                <div class="col-md-6 col-lg-1 mb-4 mb-lg-0">
                    <strong class="title-text">Phase</strong>
                    <h6>{{ $phase ?? 'N/A' }}</h6>
                </div>

                <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                    <strong class="title-text">Last Date of Nomination</strong>
                    <h6>{{ $nomination_date
                            ? \Carbon\Carbon::parse($nomination_date)->format('d M Y')
                            : 'N/A' }}</h6>
                </div>
                <div class="col-md-6 col-lg-4">
                    <strong class="title-text">Final Status</strong>
                    <h6>
                        {!! getFinalDocStatus($candidateData->document_collection_status, 'icon') !!}
                        {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
                    </h6>
                </div>
            </div>
            <!-- <table class="table table-sm table-borderless mb-0">

                <tr>
                    <th class="text-nowrap pe-3">Candidate Name</th>
                    <td>: {{ $candidateName ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th class="text-nowrap pe-3">Assembly Name & No</th>
                    <td>: {{ $assemblyName ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th class="text-nowrap pe-3">Phase</th>
                    <td>: {{ $phase ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th class="text-nowrap pe-3">Last Date of Nomination form Submission</th>
                    <td>
                        : {{ $nomination_date
                            ? \Carbon\Carbon::parse($nomination_date)->format('d M Y')
                            : 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th class="text-nowrap pe-3">Final Status</th>
                    <td>
                        :
                        {!! getFinalDocStatus($candidateData->document_collection_status, 'icon') !!}
                        {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
                    </td>
                </tr>

            </table> -->
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-center">
            {{-- APPROVED --}}
            @if(
                is_null($candidateData->legal_associate_id) || 
                Auth::guard('admin')->user()->id == $candidateData->legal_associate_id
            )
                @if($candidateData->status == "without_criminal_full_generation")

                    <span class="badge bg-success">
                        <i class="bi bi-check-circle"></i>
                        Candidate Approved — Acknowledgement Form Generated
                    </span>

                    <button class="btn btn-success btn-sm" wire:click="downloadAcknowledgement">

                        <i class="bi bi-download"></i>
                        Download Acknowledgement Form

                    </button>
                    {{-- <button class="btn btn-danger" wire:click="downloadObservationMemo">
                        <i class="bi bi-download"></i>
                        Download Observation Memo
                    </button> --}}


                {{-- REJECTED --}}
                @elseif($candidateData->status == "without_criminal_rejected_observation_only")

                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle"></i>
                        Inappropriate Documents — Observation Memo Generated
                    </span>

                    <button class="btn btn-danger btn-sm" wire:click="downloadObservationMemo">

                        <i class="bi bi-download"></i>
                        Download Observation Memo

                    </button>



                {{-- DEFAULT (STATUS NULL / NOT PROCESSED) --}}
                @else

                    <button class="btn btn-outline-success btn-sm" onclick="confirmApprove()">

                        <i class="bi bi-check-circle"></i>
                        Approved & Generate Acknowledgement Form

                    </button>

                    <button class="btn btn-outline-danger btn-sm" onclick="confirmReject()">

                        <i class="bi bi-x-circle"></i>
                        Inappropriate Documents & Generate Observation Memo

                    </button>

                @endif
            @endif

        </div>

        <div class="card-body px-0">

            <div class="row">

                <!-- Document List -->
                <div class="col-md-3 col-lg-2 border-end">

                    <h6 class="section-header">Document List</h6>
                     @if(count($versions) > 0)
                        <div class="dropdown mb-3">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle w-100"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                Version {{ $version_index }}
                            </button>

                            <div class="dropdown-menu w-100">

                                @foreach($versions as $version_item)
                                    <a class="dropdown-item {{ $version_item->version == $version_index ? 'active' : '' }}"
                                    href="{{ route('admin.candidates.documents.preview', ['candidate'=>$candidateId,'version'=>$version_item->version]) }}"
                                    title="Uploaded by {{ $version_item->generatedBy->name ?? 'N/A' }} at {{ $version_item->created_at->format('d M Y H:i') }}">
                                        
                                        V{{ $version_item->version }} Preview
                                        
                                        @if($version_item->version == $version_index)
                                            ✓
                                        @endif
                                    </a>
                                @endforeach

                                <div class="dropdown-divider"></div>

                            </div>
                        </div>
                    @endif
                   <div class="list-group document-tabs">
                       @foreach ($availableDocuments as $index => $item)

                       <a href="javascript:void(0)"
                           class="list-group-item list-group-item-action {{ $active_tab==$index ? 'active' : '' }}"
                           wire:click="ChangeDocument('{{ $index }}',{{$version_index}})">

                           {{ $item }}

                       </a>

                       @endforeach
                   </div>

                </div>


                <!-- Preview -->
                <div class="col-md-6 col-lg-7 border-end">

                    <h6 class="section-header">Preview</h6>

                    <div class="preview-box">
                        {{-- {{dd($active_file)}} --}}
                        @if($active_file)

                            @php
                                $extension = strtolower(pathinfo($active_file, PATHINFO_EXTENSION));
                            @endphp

                            {{-- PDF --}}
                            @if($extension == 'pdf')

                                <iframe 
                                    src="{{ asset($active_file) }}" 
                                     width="100%" style="border:none; height:600px">
                                </iframe>

                            {{-- Image --}}
                            @else

                                <img 
                                    src="{{ asset($active_file) }}" 
                                    class="img-fluid m-auto rounded">

                            @endif

                        @else

                        <div class="text-center text-muted py-5">
                            No document available
                        </div>

                        @endif

                        </div>

                </div>


                <!-- CKEditor -->
                <div class="col-md-3 col-lg-3" wire:ignore>

                    <h6 class="section-header">Observation</h6>

                    <textarea
                        id="editor"
                        class="form-control"
                        rows="10"
                    >{{ $observation_description }}</textarea>

                </div>

            </div>

        </div>
        
            <div class="card-footer flex-column flex-md-row d-flex justify-content-between gap-2 align-items-center">
                {{-- APPROVED --}}
                @if(
                    is_null($candidateData->legal_associate_id) || 
                    Auth::guard('admin')->user()->id == $candidateData->legal_associate_id
                )
                    @if($candidateData->status == "without_criminal_full_generation")

                        <span class="badge bg-success ">
                            <i class="bi bi-check-circle"></i>
                            Candidate Approved — Acknowledgement Form Generated
                        </span>

                        <button class="btn btn-success btn-sm" wire:click="downloadAcknowledgement">

                            <i class="bi bi-download"></i>
                            Download Acknowledgement Form

                        </button>
                        {{-- <button class="btn btn-danger" wire:click="downloadObservationMemo">
                            <i class="bi bi-download"></i>
                            Download Observation Memo
                        </button> --}}


                    {{-- REJECTED --}}
                    @elseif($candidateData->status == "without_criminal_rejected_observation_only")

                        <span class="badge bg-danger ">
                            <i class="bi bi-x-circle"></i>
                            Inappropriate Documents — Observation Memo Generated
                        </span>

                        <button class="btn btn-danger btn-sm" wire:click="downloadObservationMemo">

                            <i class="bi bi-download"></i>
                            Download Observation Memo

                        </button>



                    {{-- DEFAULT (STATUS NULL / NOT PROCESSED) --}}
                    @else

                        <button class="btn btn-outline-success btn-sm" onclick="confirmApprove()">

                            <i class="bi bi-check-circle"></i>
                            Approved & Generate Acknowledgement Form

                        </button>

                        <button class="btn btn-outline-danger btn-sm" onclick="confirmReject()">

                            <i class="bi bi-x-circle"></i>
                            Inappropriate Documents & Generate Observation Memo

                        </button>

                    @endif
                @endif

            </div>

    </div>
    <div class="loader-container" wire:loading wire:target="downloadAcknowledgement, downloadObservationMemo">
        <div class="loader"></div>
    </div>
@push('scripts')
<script src="{{ asset('build/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('toastr:success', (event) => {
            toastr.success(event.message);
        });
        
        Livewire.on('toastr:error', (event) => {
            toastr.error(event.message);
        });
    });
    document.addEventListener("DOMContentLoaded", function () {

        let editor = CKEDITOR.replace('editor', {
            height: 600,
            toolbar: [
                { name: 'styles', items: ['Format','Font','FontSize'] },
                { name: 'basicstyles', items: ['Bold','Italic'] },
                { name: 'paragraph', items: ['NumberedList','BulletedList'] }
            ]
        });

        editor.on('change', function () {

            let data = editor.getData();

            @this.set('observation_description', data);

        });

    });

    function confirmApprove() {

        Swal.fire({
            title: "Generate Acknowledgement Form?",
            text: "Are you sure you want to approve this candidate and generate the Acknowledgement form?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Approve"
        }).then((result) => {

            if (result.isConfirmed) {

                @this.call('GenerateAcknowledgementForm');

            }

        });

    }


    function confirmReject() {

        Swal.fire({
            title: "Generate Observation Memo?",
            text: "Are you sure you want to generate the observation memo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes"
        }).then((result) => {

            if (result.isConfirmed) {

                @this.call('GenerateObservationMemo');

            }

        });

    }

</script>
@endpush
</div>