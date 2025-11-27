<div>
    <style>
        .timeline {
            list-style: none;
            padding: 20px 0 20px;
            position: relative;
        }

        /* Vertical Line */
        .timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #dee2e6;
            left: 20px; /* Position the line */
            margin-left: -1.5px;
        }

        /* Timeline Item */
        .timeline-item {
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item:after, .timeline-item:before {
            content: " ";
            display: table;
        }
        .timeline-item:after {
            clear: both;
        }

        /* Timeline Dot (Badge) */
        .timeline-badge {
            color: #fff;
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 1.2em;
            text-align: center;
            position: absolute;
            top: 5px;
            left: 0;
            margin-left: 0;
            background-color: #6c757d; /* Default color */
            z-index: 100;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 4px rgba(0,0,0,.1);
        }
        .timeline-badge i {
            line-height: 1;
            vertical-align: middle;
        }

        /* Timeline Content Panel */
        .timeline-panel {
            width: calc(100% - 70px); /* Adjust width */
            float: right;
            padding: 10px 15px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Panel Pointer (Arrow) */
        .timeline-panel:before {
            position: absolute;
            top: 17px;
            left: 45px;
            right: auto;
            display: inline-block;
            border-top: 10px solid transparent;
            border-left: 0 solid #ccc;
            border-right: 10px solid #e9ecef;
            border-bottom: 10px solid transparent;
            content: " ";
        }
        .timeline-panel:after {
            position: absolute;
            top: 18px;
            left: 46px;
            right: auto;
            display: inline-block;
            border-top: 9px solid transparent;
            border-left: 0 solid #fff;
            border-right: 9px solid #fff;
            border-bottom: 9px solid transparent;
            content: " ";
        }

        /* Text size adjustment for small content */
        .text-sm { font-size: 0.9rem; }
        .text-xs { font-size: 0.8rem; }
    </style>
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-primary mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <nav aria-label="breadcrumb">
                            </nav>
                            <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-dark btn-sm text-end">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <i class="bi bi-person-circle me-2"></i> {{ $candidate->name }}
                    </h4>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Email:</strong>
                            <span class="text-dark">{{ $candidate->email }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Contact:</strong>
                            <span class="text-dark">{{ $candidate->contact_number }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Assembly ID:</strong>
                            <span class="text-dark">{{ $candidate->assembly_id }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Status:</strong>
                            <span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $candidate->document_collection_status) }}</span>
                        </div>
                        {{-- Add more candidate details here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Candidate Journey Timeline</h5>
                </div>
                <div class="card-body pt-4 pb-1">

                    <div class="timeline">
                        @forelse ($timeline as $item)
                            <div class="timeline-item">
                                <div class="timeline-badge {{ $item['badge_color'] }}">
                                    @if ($item['action'] == 'Insert')
                                        <i class="bi bi-plus-circle"></i>
                                    @elseif ($item['action'] == 'Update')
                                        <i class="bi bi-pencil-square"></i>
                                    @elseif (str_contains($item['action'], 'Uploaded'))
                                        <i class="bi bi-file-earmark-arrow-up"></i>
                                    @elseif (str_contains($item['action'], 'Verification'))
                                        <i class="bi bi-patch-check"></i>
                                    @else
                                        <i class="bi bi-info-circle"></i>
                                    @endif
                                </div>

                                <div class="timeline-panel">
                                    <div class="timeline-heading d-flex justify-content-between align-items-center">
                                        <h6 class="timeline-title text-dark mb-0">{{ $item['title'] }}</h6>
                                        <small class="text-muted"><i class="bi bi-calendar me-1"></i> {{ $item['date'] }}</small>
                                    </div>
                                    <div class="timeline-body mt-2">
                                        <p class="mb-1 text-sm">{!! $item['details'] !!}</p>
                                        <p class="text-xs text-muted mb-0">
                                            Action By: User ID {{ $item['changed_by'] }} at {{ $item['time'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center">No journey logs found for this candidate.</div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

