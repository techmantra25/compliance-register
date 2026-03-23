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
                <div class="col-md-4 mb-3">
                    <strong>Assembly</strong><br>
                    ({{ $camp->assembly->assembly_code ?? 'N/A' }})
                    {{ $camp->assembly->assembly_name_en ?? 'N/A' }}
                </div>

                <!-- Phase -->
                <div class="col-md-4 mb-3">
                    <strong>Phase</strong><br>
                    {{ optional(optional($camp->assembly->assemblyPhase)->phase)->name ?? 'N/A' }}
                </div>

                <!-- Event Type -->
                <div class="col-md-4 mb-3">
                    @if($camp->event_category_others)
                        <strong>Other Event Category</strong><br> {{ $camp->event_category_others }}
                    @else
                        <strong>Event Category</strong><br>{{ $camp->category->name ?? 'N/A' }}
                    @endif
                </div>

                <!-- Address -->
                <div class="col-md-4 mb-3">
                    <strong>Address</strong><br>
                    {{ $camp->address }}
                </div>

                <!-- Dates -->
                <div class="col-md-4 mb-3">
                    <strong>Date & Time</strong>

                    <div>
                        <i class="bi bi-calendar-event text-primary me-1"></i>
                        {{ date('d M Y, h:i A', strtotime($camp->campaign_date)) }}
                    </div>

                </div>

                <!-- Campaigner -->
                <div class="col-md-4 mb-3">
                    <strong>Campaigner Details</strong>

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

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <strong>Status</strong><br>

                    @if($camp->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($camp->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif($camp->status == 'rescheduled')
                        <span class="badge bg-info">Rescheduled</span>
                    @elseif($camp->status == 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($camp->status) }}</span>
                    @endif
                </div>

                <!-- Keywords -->
                <div class="col-md-4 mb-3">
                    <strong>Keywords</strong><br>

                    @if($camp->keywords)
                        @foreach(explode(',', $camp->keywords) as $key)
                            <span class="badge bg-primary">{{ $key }}</span>
                        @endforeach
                    @else
                        N/A
                    @endif
                </div>

                <!-- Remarks -->
                <div class="col-md-12 mb-3">
                    <strong>Remarks</strong><br>
                    {{ $camp->remarks ?? 'N/A' }}
                </div>

                <div class="col-md-12 mt-3">
                    <strong>Uploaded Files</strong>

                    <div class="d-flex flex-wrap gap-3 mt-2">

                        @forelse($camp->documents as $doc)

                            @php
                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            @endphp

                            <div class="file-card border rounded p-2" style="width:120px">

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