<div>
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline:before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #e5e5e5;
        }

        .timeline-item {
            position: relative;
            padding-left: 70px;
            margin-bottom: 30px;
        }

        .timeline-badge {
            position: absolute;
            left: 15px;
            width: 30px;
            height: 30px;
            background: #0d6efd;
            border-radius: 50%;
            text-align: center;
            color: #fff;
            line-height: 30px;
            font-size: 14px;
            box-shadow: 0 0 0 3px #fff;
        }

        .timeline-panel {
            background: #fff;
            border-radius: 8px;
            padding: 15px 20px;
            border: 1px solid #e5e5e5;
        }

        .timeline-title {
            font-weight: 600;
            font-size: 15px;
        }

        .timeline-body {
            font-size: 14px;
        }

        .badge-status {
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
        }

    </style>
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-flag me-2"></i> MCC Log
                        </h4>

                        <a href="{{ route('admin.mcc_violation') }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Assembly:</strong>
                            <span class="text-dark">{{ $mcc->assembly->assembly_name_en }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Block:</strong>
                            <span class="text-dark">{{ ucwords($mcc->block) }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong class="d-block text-muted">Status:</strong>
                            <span class="badge bg-info text-capitalize">
                                {{ str_replace('_',' ', $mcc->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i> MCC Activity Timeline
                    </h5>
                </div>
                <div class="card-body pt-4 pb-1">
                    <div class="timeline">
                        @forelse ($timeline as $item)
                            <div class="timeline-item">
                                <div class="timeline-badge {{ $item['badge_color'] }}">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                </div>

                                <div class="timeline-panel">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="timeline-title">{{ $item['title'] }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i> {{ $item['date'] }}
                                        </small>
                                    </div>

                                    <div class="timeline-body mt-2">
                                        {!! $item['details'] !!}

                                        <p class="text-muted mt-2 mb-0">
                                            <i class="bi bi-person"></i>Action By 
                                            <strong>{{ $item['changed_by'] }}</strong>
                                            <span class="ms-2"><i class="bi bi-clock"></i> {{ $item['time'] }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center">No log records found for this MCC.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
