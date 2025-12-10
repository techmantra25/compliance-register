<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Event Permission (State View)</div>
                        <div class="wrappper-bpdy">
                            <div class="chrat-place">
                                <canvas width="300" id="myChart"></canvas>
                            </div>
                             <a href="{{route('admin.eventwise.district')}}" class="btm-small blue-btm">Click for District View</a> 
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting (State View) - {{ $this->phases->count() }} Phases</div>
                        <div class="wrappper-bpdy">
                            <div class="row">
                                {{-- @dd($this->phases) --}}
                                @foreach($this->phases as $key => $phase)
                                    <div class="col-md-3">
                                        <div class="inner-grid">
                                            <div class="chrat-place phase-click"
                                                data-url="{{ route('admin.phasewise.district', $phase->id) }}">
                                                <canvas 
                                                    id="phase{{ $key+1 }}" 
                                                    width="100"
                                                    data-chart='@json($chartData[$key]["data"])'
                                                    data-phase="{{ $chartData[$key]["phase_name"] }}">
                                                </canvas>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <h6>Legend</h6>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved & Complete</div>
                                <div class="color-grid"><span style="background-color: #f3a3a3;"></span>Document Yet To Be Received By Fox For Vetting</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Vetting in Progress at FOX</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span >Pending Acknowledgement Copy</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected (if any)</div>
                            </div>
                             <p class="btm-small blue-btm">Click on Phase to Check the Details View</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="inner-wrapper">
                        <div class="title-head">
                            MCC Complaints (State-view) - {{ $this->phases->count() }} Phases
                        </div>

                        <div class="wrappper-bpdy">
                            <div class="row">
                                @foreach($this->phases as $phase)
                                    <div class="col-md-3 mb-4">
                                        <div class="inner-grid">
                                            <div class="chrat-place">
                                                <canvas 
                                                    id="mcc{{ $phase->id }}" 
                                                    width="100"
                                                    data-url="{{ route('admin.phasewise.mcc', $phase->id) }}"
                                                    data-phase="{{ $phase->name }}"
                                                    data-pending="{{ $phaseWiseStatus[$phase->id]['pending_to_processed'] ?? 0 }}"
                                                    data-processed="{{ $phaseWiseStatus[$phase->id]['processed'] ?? 0 }}"
                                                    data-resolved="{{ $phaseWiseStatus[$phase->id]['confirm_resolved'] ?? 0 }}"
                                                >
                                                </canvas>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <h6>Legend</h6>
                                <div class="color-grid">
                                    <span style="background-color: #A7A7A7;"></span>Pending To Processed
                                </div>
                                <div class="color-grid">
                                    <span style="background-color: #FDB747;"></span>Processed
                                </div>
                                <div class="color-grid">
                                    <span style="background-color: #1BC976;"></span>Confirm Resolved
                                </div>
                            </div>

                            <p class="btm-small blue-btm">
                                Click on Phase to Check the Details View
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
        <script>
            var totalScheduled = @json($totalScheduled);
            var pending = @json($pending);
            var appliedAwaitingApproval = @json($appliedAwaitingApproval);
            var approvedCopyReceived = @json($approvedCopyReceived);
            var cancelledOrRescheduled = @json($cancelledOrRescheduled);


            var ctx = document.getElementById("myChart").getContext('2d');
                const centerTextPluginMainChart = {
                    id: 'centerTextMain',
                    afterDraw(chart) {
                        const ctx = chart.ctx;
                        ctx.save();

                        const text = "Total Events : " + totalScheduled;

                        ctx.font = 'bold 18px Arial';
                        ctx.fillStyle = '#333';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(text, chart.width / 2, chart.height / 2);

                        ctx.restore();
                    }
                };


            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Pending Application","Applied-Awaiting Approval", "Approved-Copy Received" ,"Cancelled or Rescheduled"],
                    datasets: [{    
                        data: [pending,appliedAwaitingApproval,approvedCopyReceived,cancelledOrRescheduled],
                        borderColor: ['#FDB747','#F46674','#1BC976', '#f3a3a3'], 
                        backgroundColor: ['#FDB747','#F46674','#1BC976', '#f3a3a3'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                     cutout: "60%",
                    plugins: {
                        legend: { display: true }
                    }
                },
                 plugins: [centerTextPluginMainChart]
            });

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
                                borderColor: ['#1BC976','#f3a3a3', '#FDB747', '#A7A7A7', '#F46674'],
                                backgroundColor: ['#1BC976','#f3a3a3', '#FDB747', '#A7A7A7', '#F46674'],
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

        <script>
            var phaseStatus = @json($phaseWiseStatus);
        </script>
        <script>
            function createAutoTotalDoughnutChart(chartId, chartData, chartOptions = {}) {
                const ctx = document.getElementById(chartId).getContext('2d');
                
                if (!ctx) {
                    console.error(`Element with id "${chartId}" not found`);
                    return null;
                }
                
                const total = chartData.datasets[0].data.reduce((a, b) => a + b, 0);
                
                const defaultOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        datalabels: {
                            display: false
                        }
                    }
                };
                const options = { ...defaultOptions, ...chartOptions };
                
                return new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: options,
                    plugins: [{
                        afterDraw: function(chart) {
                            const ctx = chart.ctx;
                            const width = chart.width;
                            const height = chart.height;
                            const centerX = width / 2;
                            const centerY = height / 2;

                            const chartTotal = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

                            ctx.save();
                            ctx.font = 'normal 13px Arial';
                            ctx.fillStyle = '#333';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            if (chart.data.phaseName) {
                                ctx.fillText(chart.data.phaseName, centerX, centerY);
                            }

                            ctx.restore();
                        }
                    }]
                });
            }
        </script>

        <script>
            Object.keys(phaseStatus).forEach(function(phaseId, index) {

                let chartId = 'mcc' + (index + 1);
                let canvas = document.getElementById(chartId);
                if (!canvas) return;
                let data = phaseStatus[phaseId];
                let redirectUrl = canvas.dataset.url;
                let phaseName = "Phase " + (index + 1);

                createAutoTotalDoughnutChart(chartId, {
                    phaseName: phaseName,
                    datasets: [{
                        data: [
                            data.pending_to_processed,
                            data.processed,
                            data.confirm_resolved
                        ],
                        backgroundColor: ['#A7A7A7', '#FDB747', '#1BC976'],
                        borderColor: ['#A7A7A7', '#FDB747', '#1BC976'],
                        borderWidth: 1
                    }]
                });

                canvas.style.cursor = "pointer";

                canvas.onclick = function () {
                    window.location.href = redirectUrl;
                };

            });
        </script>
    @endpush
</div>


















































