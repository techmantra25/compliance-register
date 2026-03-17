<div>

<style>
    .inner-wrap {
        border-radius:10px;
        overflow:hidden;
        height:100%;
    }

    .yellow-bg {
        background:#FFF2DB;
        border: 1px solid #F7CC7C;
    }

    .yellow-bg h3 {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        text-align:center;
        display:block;
        background:#F7CC7C;
        padding: 17px;
    }

    .green-bg {
        background:#E9FFEC;
        border: 1px solid #5AB05B;
    }

    .green-bg h3 {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        text-align:center;
        display:block;
        background:#5AB05B;
        padding: 17px;
    }

    .graph-part {
       padding:25px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table td, .custom-table th {
        padding: 5px 11px;
    }
    .custom-table th {
        background: #5ab05b;
    }

    .custom-table td {
        border:1px solid #b3b3b3;
        font-size:13px;
    }

    .custom-table th:first-child {
        border-top-left-radius: 9px; 
    }

    .custom-table th:last-child {
        border-top-right-radius: 9px; 
    }

    .custom-table-blue th {
        background: #01B1C6;
    }

    .block-stack h4 {
        font-size: 16px;
        margin-bottom: 12px;
    }

    .blue-bg {
        background:#DEFBFF;
        border:1px solid #01B1C6;
    }

    .blue-bg h3 {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        text-align:center;
        display:block;
        background:#01B1C6;
        padding: 17px;
    }

</style>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                
                <!-- ===================== CHART ===================== -->
                <div class="col-md-12 col-lg-6 mb-4">
                    <div class="inner-wrap yellow-bg">
                        <h3>Nomination Vetting (State View) - {{ $this->phases->count() }} Phases</h3>

                        <div class="graph-part">
                            <div class="row mb-5 mb-5-lg-0">
                                @foreach($this->phases as $key => $phase)
                                <div class="col-md-6">
                                    <div class="chrat-place phase-click"
                                        data-url="{{ route('admin.phasewise.district', $phase->id) }}">
                                        <canvas 
                                            id="phase{{ $key+1 }}" 
                                            width="280"
                                            data-chart='@json($chartData[$key]["data"])'
                                            data-phase="{{ $chartData[$key]["phase_name"] }}">
                                        </canvas>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="color-label justify-content-center mb-4">
                                <div class="color-grid"><span style="background-color: #dc3545;"></span>Pending</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Inappropriate Documents</div>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Completed</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== SUMMARY ===================== -->
                <div class="col-md-12 col-lg-6 mb-4">
                    <div class="inner-wrap green-bg">
                        <h3 class="mb-0">
                            Nomination Documents Processing Report as on {{ now()->format('d M Y') }}.
                        </h3>

                        <div class="graph-part">
                            <div class="row">

                                <!-- Overall -->
                                <div class="col-md-12 mb-4">
                                    <div class="block-stack">
                                        <h4>Overall Summary</h4>
                                        <table class="custom-table">
                                            <thead>
                                                <th>Status</th>
                                                <th>Count</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Records</td>
                                                    <td>{{ $overall['total'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pending</td>
                                                    <td>{{ $overall['pending'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Inappropriate Documents</td>
                                                    <td>{{ $overall['inappropriate'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td>{{ $overall['completed'] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Phase 1 -->
                                <div class="col-md-6">
                                    <div class="block-stack">
                                        <h4>
                                            {{ $phaseArray[0]['name'] ?? '' }} 
                                            ({{ $phaseArray[0]['assembly'] ?? 0 }} Seats)
                                        </h4>
                                        <table class="custom-table">
                                            <thead>
                                                <th>Status</th>
                                                <th>Count</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Records</td>
                                                    <td>{{ $phaseArray[0]['total_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pending</td>
                                                    <td>{{ $phaseArray[0]['pending_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Inappropriate Documents</td>
                                                    <td>{{ $phaseArray[0]['inappropriate_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td>{{ $phaseArray[0]['completed_records'] ?? 0 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Phase 2 -->
                                <div class="col-md-6">
                                    <div class="block-stack">
                                        <h4>
                                            {{ $phaseArray[1]['name'] ?? '' }} 
                                            ({{ $phaseArray[1]['assembly'] ?? 0 }} Seats)
                                        </h4>
                                        <table class="custom-table">
                                            <thead>
                                                <th>Status</th>
                                                <th>Count</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Records</td>
                                                    <td>{{ $phaseArray[1]['total_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pending</td>
                                                    <td>{{ $phaseArray[1]['pending_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Inappropriate Documents</td>
                                                    <td>{{ $phaseArray[1]['inappropriate_records'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td>{{ $phaseArray[1]['completed_records'] ?? 0 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== TABLE ===================== -->
                <div class="col-md-12">
                    <div class="inner-wrap blue-bg">
                        <h3>Nomination Documents Processing Report</h3>
                        <div class="graph-part">
                            
                            <div class="block-stack table-responsive">
                                <table class="custom-table custom-table-blue ">
                                    <thead>
                                        <th>Phase</th>
                                        <th>District</th>
                                        <th>Assembly Number</th>
                                        <th>Assembly Name</th>
                                        <th>Candidate Name</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        @foreach($tableData as $row)
                                        <tr>
                                            <td>{{ $row['phase'] }}</td>
                                            <td>{{ $row['district'] }}</td>
                                            <td>{{ $row['assembly_no'] }}</td>
                                            <td>{{ $row['assembly_name'] }}</td>
                                            <td>{{ $row['candidate'] }}</td>
                                            <td>{{ $row['status'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
        <script>

            window.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll("canvas[id^='phase']").forEach(canvas => {
                    
                    let counts = JSON.parse(canvas.dataset.chart);
                    let phaseNumber = canvas.dataset.phase;
                    phaseNumber = phaseNumber.replace(/\b\w/g, char => char.toUpperCase());
                    let ctx = canvas.getContext('2d');

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: counts,
                                borderColor: ['#dc3545', '#FDB747','#1BC976'],
                                backgroundColor: ['#dc3545', '#FDB747','#1BC976'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: { display: false }
                            }
                        },
                        plugins: [{
                            afterDraw(chart) {
                                const ctx = chart.ctx;
                                ctx.save();
                                ctx.font = 'normal 13px Arial';
                                ctx.fillStyle = '#333';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                // ctx.fillText('Phase', chart.width / 2, chart.height / 2);
                                ctx.fillText(phaseNumber, chart.width / 2, chart.height / 2);
                                ctx.restore();
                            }
                        }]
                    });
                });
            });
        </script>
        
        <script>
            document.querySelectorAll('.phase-click').forEach(div => {
                div.addEventListener('click', function () {
                    window.location.href = this.dataset.url;
                });
            });
        </script>

    @endpush
</div>