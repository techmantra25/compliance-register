<div>

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold text-dark">Campaign Details</h4>

        <div class="d-flex flex-column align-items-end gap-2">
            <a href="{{ route('admin.campaigns') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">

                <!-- Assembly -->
                <div class="col-6 col-md-2 mb-4">
                    <strong class="title-text">Assembly</strong>
                    ({{ $camp->assembly->assembly_code ?? 'N/A' }})
                    {{ $camp->assembly->assembly_name_en ?? 'N/A' }}
                </div>

                <!-- Phase -->
                <div class="col-6 col-md-1 mb-4">
                    <strong class="title-text">Phase</strong>
                    {{ optional(optional($camp->assembly->assemblyPhase)->phase)->name ?? 'N/A' }}
                </div>

                <!-- Event Type -->
                <div class="col-6 col-md-2 mb-4">
                    @if($camp->event_category_others)
                        <strong class="title-text">Other Event Category</strong> {{ $camp->event_category_others }}
                    @else
                        <strong class="title-text">Event Category</strong>{{ $camp->category->name ?? 'N/A' }}
                    @endif
                </div>

                <!-- Address -->
                <div class="col-6 col-md-2 mb-4">
                    <strong class="title-text">Address</strong>
                    {{ $camp->address }}
                </div>

                <!-- Dates -->
                <div class="col-6 col-md-2 mb-4">
                    <strong class="title-text">Date & Time</strong>

                    <div>
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        {{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}
                    </div>

                </div>

                <!-- Campaigner -->
                <div class="col-6 col-md-3 mb-4">
                    <strong class="title-text">Campaigner Details</strong>

                    @foreach($camp->campaigners as $c)
                        <div class="mt-2">
                            <i class="bi bi-person text-primary me-1"></i>
                            {{ ucwords($c->name) }}
                        </div>

                        <div>
                            <i class="bi bi-phone text-primary me-1"></i>
                            {{ $c->mobile ?? 'N/A' }}
                        </div>
                    @endforeach
                </div>

                <!-- Keywords -->
                <div class="col-6 col-md-3 mb-4">
                    <strong class="title-text">Keywords</strong>

                    <div class="btn-grup flex-wrap gap-1">
                    @if($camp->keywords)
                        @foreach(explode(',', $camp->keywords) as $key)
                            <span class="badge bg-primary">{{ $key }}</span>
                        @endforeach
                    @else
                        N/A
                    @endif
                    </div>
                </div>

                <!-- Remarks -->
                <div class="col-6 col-md-3 mb-4">
                    <strong class="title-text">Remarks</strong>
                    {{ $camp->remarks ?? 'N/A' }}
                </div>

                <div class="col-12 col-md-5 mb-4">
                    <strong class="title-text">Uploaded Files</strong>

                    <div class="btn-group flex-wrap gap-2">

                        @forelse($camp->documents as $doc)

                            @php
                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            @endphp

                            <div class="file-card border rounded p-2" style="width:70px">

                                <!-- Preview -->
                                <div class="file-box text-center mb-2">
                                    @if($isImage)
                                        <a href="{{ asset($doc->file_path) }}" target="_blank">
                                            <img src="{{ asset($doc->file_path) }}"
                                                style="width:100%; height:80px; object-fit:cover; border-radius:6px;">
                                        </a>
                                    @else
                                        <a href="{{ asset($doc->file_path) }}" target="_blank">
                                            <i class="bi bi-file-earmark-text fs-2 text-secondary"></i>
                                        </a>
                                    @endif
                                </div>

                                <!-- File Name -->
                                <div class="small text-truncate">
                                    {{ basename($doc->file_path) }}
                                </div>

                            </div>

                        @empty
                            <span class="text-muted">No files uploaded</span>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>