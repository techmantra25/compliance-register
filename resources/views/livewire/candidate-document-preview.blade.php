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
                <div class="col-6 col-md-6 col-lg-3 mb-4 mb-lg-4">
                    <strong class="title-text">Candidate Name</strong>
                    {{ $candidateName ?? 'N/A' }}
                </div>
                <div class="col-6 col-md-6 col-lg-2 mb-4 mb-lg-4">
                    <strong class="title-text">Assembly Name & No</strong>
                    {{ $assemblyName ?? 'N/A' }}
                </div>

                <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                    <strong class="title-text">Phase</strong>
                    {{ $phase ?? 'N/A' }}
                </div>
                <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                    <strong class="title-text">Age</strong>
                    {{ $candidateData->age ?? 'N/A' }}
                </div>
                <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                    <strong class="title-text">Serial No</strong>
                    {{ $candidateData->serial_no ?? 'N/A' }}
                </div>
                <div class="col-6 col-md-6 col-lg-1 mb-4 mb-lg-4">
                        <strong class="title-text">Part No</strong>
                        {{ $candidateData->part_no ?? 'N/A' }}
                </div>

                <div class="col-6 col-md-6 col-lg-3 mb-4 mb-lg-4">
                    <strong class="title-text">Last Date of Nomination</strong>
                    {{ $nomination_date
                            ? \Carbon\Carbon::parse($nomination_date)->format('d M Y')
                            : 'N/A' }}
                </div>
                <div class="col-6 col-md-6 col-lg-4">
                    <strong class="title-text">Final Status</strong>
                    
                    {!! getFinalDocStatus($candidateData->document_collection_status, 'icon') !!}
                    {{ getFinalDocStatus($candidateData->document_collection_status, 'label') }}
                    
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
         @php
            $isApprovedVersion = false;
            $isRejectedVersion = false;

            if ($versionData) {
                if (!empty($versionData->observations) || !empty($versionData->others)) {
                    $isRejectedVersion = true;
                } else {
                    $isApprovedVersion = true;
                }
            }
        @endphp

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-center">
            {{-- APPROVED --}}
            @if(
                is_null($candidateData->legal_associate_id) || 
                Auth::guard('admin')->user()->id == $candidateData->legal_associate_id
            )
                 {{-- VERSION BASED APPROVED --}}
                    @if($versionData && $isApprovedVersion)
                    <h6 class="mb-0"><span class="badge bg-success">
                        <i class="bi bi-check-circle"></i>
                        Candidate Approved — Acknowledgement Form Generated
                    </span>
                    </h6>

                    <button class="btn btn-success  btn-md" wire:click="downloadAcknowledgement">

                        <i class="bi bi-download"></i>
                        Download Acknowledgement Form

                    </button>
                    {{-- <button class="btn btn-danger" wire:click="downloadObservationMemo">
                        <i class="bi bi-download"></i>
                        Download Observation Memo
                    </button> --}}


                {{-- REJECTED --}}
                @elseif($versionData && $isRejectedVersion)

                    <h6 class="mb-0">
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle"></i>
                            Inadequate Documents — Observation Memo Generated
                        </span>
                    </h6>

                    <button class="btn btn-danger btn-md" wire:click="downloadObservationMemo">

                        <i class="bi bi-download"></i>
                        Download Observation Memo

                    </button>



                {{-- DEFAULT (STATUS NULL / NOT PROCESSED) --}}
                @else

                    <button class="btn btn-outline-success  btn-md" onclick="confirmApprove()">

                        <i class="bi bi-check-circle"></i>
                        Approved & Generate Acknowledgement Form

                    </button>

                    <button class="btn btn-outline-danger btn-md" onclick="confirmReject()">

                        <i class="bi bi-x-circle"></i>
                        Inadequate Documents & Generate Observation Memo

                    </button>

                @endif
            @endif

        </div>

        <div class="card-body px-0">

            <div class="row">

                <!-- Document List -->
                <div class="col-md-3 col-lg-2 mb-4 mb-md-0">

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
                                 @if($candidateData->document_collection_status === 'ready_for_vetting')

                                    @php
                                        $isLatest = !request()->has('version');
                                    @endphp

                                    <a class="dropdown-item {{ $isLatest ? 'active' : '' }}"
                                    href="{{ route('admin.candidates.documents.preview', ['candidate' => $candidateId]) }}">
                                        
                                        Latest Preview
                                        
                                        @if($isLatest)
                                            ✓
                                        @endif
                                    </a>

                                @endif

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
                <div class="col-md-6 col-lg-7 mb-4 mb-md-0">

                    <h6 class="section-header">Preview</h6>

                    <div class="preview-box">
                        {{-- {{dd($active_file)}} --}}
                        @if($active_file)
                            @php
                                $extension = strtolower(pathinfo($active_file, PATHINFO_EXTENSION));
                                $fileUrl = asset($active_file);

                                $docTypes = ['doc','docx','xls','xlsx','ppt','pptx','txt','csv','odt','ods','odp'];
                            @endphp

                            {{-- PDF --}}
                            @if($extension == 'pdf')

                                <iframe 
                                    src="{{ asset($active_file) }}" 
                                     width="100%" style="border:none; height:600px">
                                </iframe>

                            {{-- Image --}}
                            @elseif(in_array($extension, $docTypes))

                            <iframe 
                                src="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true"
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

                <div class="col-md-3 col-lg-3 border-start">
                    @php
                        $canEditObservation = !$versionData || (!$isApprovedVersion && !$isRejectedVersion);
                    @endphp

                    <h6 class="section-header">Observation</h6>

                    @if(
                        $candidateData->document_collection_status !== 'verified_pending_submission'
                        &&
                        (
                            is_null($candidateData->legal_associate_id) || 
                            Auth::guard('admin')->user()->id == $candidateData->legal_associate_id
                        )
                    )
                    <!-- Checkboxes -->
                    <div class="mb-3">

                        <h5 class="s0-heading">Select Observations</h5>

                        <div class="check-list">

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs1" 
                                    onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }}
                                    {{ in_array('Candidate’s Epic is Missing', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs1">Candidate’s Epic is Missing</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs2" 
                                    onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }}
                                    {{ in_array('Proposer Epic has not been received', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs2">Proposer Epic has not been received</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs3" onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }} {{ in_array('SC/ST Certificate not Received', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs3">SC/ST Certificate not Received</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs4" onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }} {{ in_array('No due certificate received', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs4">No due certificate received</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs5" onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }} {{ in_array('Certified copy of the electoral roll not received', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs5">Certified copy of the electoral roll not received</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs6" onchange="updateObservation()" {{ !$canEditObservation ? 'disabled' : '' }} {{ in_array('AITC is shown as a national party', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs6">AITC is shown as a national party</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="obs_other" 
                                    onchange="toggleOthers()" {{ !$canEditObservation ? 'disabled' : '' }}
                                    {{ in_array('Others', $selectedObservations ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obs_other">Others (Specify Reason)</label>
                            </div>

                        </div>

                    </div>

                    <!-- CKEditor (Only for Others) -->
                    <div id="others_editor_box" class="box-written" style="display: {{ in_array('Others', $selectedObservations ?? []) ? 'block' : 'none' }};" wire:ignore>
                        <textarea id="editor" class="form-control">{{ $observation_others_description }}</textarea>
                    </div>
                    @endif

                </div>

            </div>

        </div>
        
            <div class="card-footer flex-column flex-md-row d-flex justify-content-between gap-2 align-items-center">
                {{-- APPROVED --}}
                @if(
                    (is_null($candidateData->legal_associate_id) || 
                    Auth::guard('admin')->user()->id == $candidateData->legal_associate_id)
                     &&
                    $canEditObservation 
                )
                      @if($versionData && $isApprovedVersion)

                        <h6 class="mb-0">
                            <span class="badge bg-success ">
                                <i class="bi bi-check-circle"></i>
                                Candidate Approved — Acknowledgement Form Generated
                            </span>
                        </h6>

                        <button class="btn btn-success btn-md" wire:click="downloadAcknowledgement">

                            <i class="bi bi-download"></i>
                            Download Acknowledgement Form

                        </button>
                        {{-- <button class="btn btn-danger" wire:click="downloadObservationMemo">
                            <i class="bi bi-download"></i>
                            Download Observation Memo
                        </button> --}}


                    {{-- REJECTED --}}
                    
                    @elseif($versionData && $isRejectedVersion)

                        <h6 class="mb-0">
                        <span class="badge bg-danger ">
                            <i class="bi bi-x-circle"></i>
                            Inadequate Documents — Observation Memo Generated
                        </span>
                        </h6>

                        <button class="btn btn-danger btn-md" wire:click="downloadObservationMemo">

                            <i class="bi bi-download"></i>
                            Download Observation Memo

                        </button>



                    {{-- DEFAULT (STATUS NULL / NOT PROCESSED) --}}
                    @else
                        <button class="btn btn-outline-success btn-md" onclick="confirmApprove()">
                            <i class="bi bi-check-circle"></i>
                            Approved & Generate Acknowledgement Form
                        </button>
                        <button class="btn btn-outline-danger btn-md" onclick="confirmReject()">
                            <i class="bi bi-x-circle"></i>
                            Inadequate Documents & Generate Observation Memo
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

        editor.on('instanceReady', function () {
            editor.setReadOnly(@json(!$canEditObservation));
        });

        // Set initial data from Livewire
        editor.setData(@this.get('observation_others_description') || '');

        editor.on('change', function () {
            let data = editor.getData();
            @this.call('saveOthersDescription', data);
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

        let observations = [];

        if (document.getElementById('obs1').checked) {
            observations.push("Candidate’s Epic is Missing");
        }

        if (document.getElementById('obs2').checked) {
            observations.push("Proposer Epic has not been received");
        }

        if (document.getElementById('obs3').checked) {
            observations.push("SC/ST Certificate not Received");
        }

        if (document.getElementById('obs4').checked) {
            observations.push("No due certificate received");
        }

        if (document.getElementById('obs5').checked) {
            observations.push("Certified copy of the electoral roll not received");
        }

        if (document.getElementById('obs6').checked) {
            observations.push("AITC is shown as a national party");
        }

        if (document.getElementById('obs_other').checked) {
            observations.push("Others");
        }

        if (observations.length === 0) {
            toastr.error('Please select at least one observation before generating the memo.');
            // Swal.fire({
            //     icon: "warning",
            //     title: "No Observation Selected",
            //     text: "Please select at least one observation before generating the memo.",
            //     confirmButtonColor: "#d33"
            // });
            return;
        }

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

    function updateObservation() {

        let observations = [];

        if (document.getElementById('obs1').checked) {
            observations.push("Candidate’s Epic is Missing");
        }

        if (document.getElementById('obs2').checked) {
            observations.push("Proposer Epic has not been received");
        }

        if (document.getElementById('obs3').checked) {
            observations.push("SC/ST Certificate not Received");
        }

        if (document.getElementById('obs4').checked) {
            observations.push("No due certificate received");
        }

        if (document.getElementById('obs5').checked) {
            observations.push("Certified copy of the electoral roll not received");
        }

         if (document.getElementById('obs6').checked) {
            observations.push("AITC is shown as a national party");
        }

        if (document.getElementById('obs_other').checked) {
            observations.push("Others");
        }

        // send JSON to Livewire
        @this.call('saveObservations', observations);
    }

    function toggleOthers() {

        let isChecked = document.getElementById('obs_other').checked;

        document.getElementById('others_editor_box').style.display = isChecked ? 'block' : 'none';

        updateObservation(); // also update main observations
    }

</script>
@endpush
</div>