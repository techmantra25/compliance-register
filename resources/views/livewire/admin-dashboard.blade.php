<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Event Permission (District View)</div>
                        <div class="wrappper-bpdy">
                            <div class="chrat-place">
                                <canvas width="300" id="myChart"></canvas>
                            </div>
                             <a href="{{route('admin.eventwise.district')}}" class="btm-small blue-btm">Click for Distric View</a> 
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting (Phase-wise Status) - {{ $this->phases->count() }} Phases</div>
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
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending at FOX</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span >Pending Submission</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected (if any)</div>
                            </div>
                             <p class="btm-small blue-btm">Click on Phase to Check the Details View</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="inner-wrapper">
                        <div class="title-head">MCC Complaints (Phase-wise Status) - 8 Phases</div>
                        <div class="wrappper-bpdy">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc1" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc2" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc3" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc4" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc5" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc6" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc7" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <div class="chrat-place">
                                            <canvas 
                                                id="mcc8" 
                                                width="100">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="color-label mb-5">
                                <h6>Legend</h6>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved & Complete</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending at FOX</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span >Pending Submission</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected (if any)</div>
                            </div>
                            <a href="#" class="btm-small blue-btm">Click for Distric View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->
        <!-- <script src="./assets/js/main.js"></script> -->
  
        <script>
            var totalScheduled = @json($totalScheduled);
            var pending = @json($pending);
            var appliedAwaitingApproval = @json($appliedAwaitingApproval);
            var approvedCopyReceived = @json($approvedCopyReceived);


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
                    labels: ["Pending Application","Applied-Awaiting Approval", "Approved-Copy Received"],
                    datasets: [{    
                        data: [pending,appliedAwaitingApproval,approvedCopyReceived],
                        borderColor: ['#FDB747','#F46674','#5B86FC'], 
                        backgroundColor: ['#FDB747','#F46674','#5B86FC'],
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
                            const centerX = chart.width / 2;
                            const centerY = chart.height / 2;
                            
                            const chartTotal = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            
                            ctx.save();
                            
                                ctx.font = 'bold 16px Arial';
                                ctx.fillStyle = '#666';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                //ctx.fillText('Total', centerX, centerY - 15);
                                ctx.font = 'bold 24px Arial';
                                ctx.fillStyle = '#333';
                                
                                //ctx.fillText(chartTotal.toString(), centerX, centerY + 10);
                            
                            ctx.restore();
                        }
                    }]
                });
            }

            const chart1 = createAutoTotalDoughnutChart('mcc1', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart2 = createAutoTotalDoughnutChart('mcc2', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart3 = createAutoTotalDoughnutChart('mcc3', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart4 = createAutoTotalDoughnutChart('mcc4', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart5 = createAutoTotalDoughnutChart('mcc5', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart6 = createAutoTotalDoughnutChart('mcc6', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart7 = createAutoTotalDoughnutChart('mcc7', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });

            const chart8 = createAutoTotalDoughnutChart('mcc8', {
                datasets: [{    
                    data: [500, 600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#A7A7A7'],
                    borderWidth: 1 
                }]
            });
        </script>
    @endpush
</div>


















































