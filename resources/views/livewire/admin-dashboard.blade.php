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
                            <a href="#" class="btm-small blue-btm">Click for Distric View (Bar Chart)</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting (Phase-wise Status) - {{ $this->phases->count() }} Phases</div>
                        <div class="wrappper-bpdy">
                            <div class="row">
                                @foreach($this->phases as $key => $phase)
                                    <div class="col-md-3">
                                        <div class="inner-grid">
                                            <div class="chrat-place">
                                                <canvas 
                                                    id="phase{{ $key+1 }}" 
                                                    width="100"
                                                    data-chart='@json($chartData[$key]["data"])'
                                                    data-phase="{{ $chartData[$key]["phase_name"] }}"
                                                    >
                                                </canvas>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <h6>Legend</h6>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved & Complete</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending at FOX</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span >Pending Submission</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected (if any)</div>
                            </div>
                            <a href="#" class="btm-small blue-btm">Click for Distric View (Bar Chart)</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting (Phase-wise Status) - 8 Phases</div>
                        <div class="wrappper-bpdy">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 1</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 2</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 3</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 4 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 5</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 6 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 7 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 8 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
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
                            <a href="#" class="btm-small blue-btm">Click for Distric View (Bar Chart)</a>
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
                                        <h2>Phase 1</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 2</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 3</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 4 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 5</h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 6 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 7 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="inner-grid">
                                        <h2>Phase 8 </h2>
                                        <div class="grid-total">
                                            166
                                        </div>
                                        <div class="grid-label j-green-bg">
                                            100
                                        </div>
                                        <div class="grid-label j-yellow-bg">
                                        50
                                        </div>
                                        <div class="grid-label j-gray-bg">
                                        10
                                        </div>
                                        <div class="grid-label j-red-bg">
                                        6
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
                            <a href="#" class="btm-small blue-btm">Click for Distric View (Bar Chart)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->
        <!-- <script src="./assets/js/main.js"></script> -->


    <script>
        var ctx = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Total Event Scheduled",	"Applied-Awaiting Approval ",	"Pending Application",	"Approved-Copy Received"],
                datasets: [{    
                    data: [500,	600, 800, 600],
                    borderColor: ['#1BC976', '#FDB747', '#F46674', '#5B86FC'], 
                    backgroundColor: ['#1BC976', '#FDB747', '#F46674', '#5B86FC'],
                    borderWidth: 1 
                }]},         
            options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
            
            }
        });

        // window.addEventListener('DOMContentLoaded', function () {

        //     var canvas = document.getElementById("phase1");
        //     if (!canvas) {
        //         console.error("Canvas not found");
        //         return;
        //     }

        //     var counts = JSON.parse(canvas.dataset.chart);

        //     var ctx = canvas.getContext('2d');

        //     new Chart(ctx, {
        //         type: 'doughnut',
        //         data: {
        //             datasets: [{
        //                 data: counts,
        //                 borderColor: ['#1BC976', '#FDB747', '#A7A7A7', '#F46674'],
        //                 backgroundColor: ['#1BC976', '#FDB747', '#A7A7A7', '#F46674'],
        //                 borderWidth: 1
        //             }]
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             cutout: '70%',
        //             plugins: {
        //                 legend: { display: false }
        //             }
        //         },
        //         plugins: [{
        //             afterDraw(chart) {
        //                 const ctx = chart.ctx;
        //                 const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

        //                 ctx.save();
        //                 ctx.font = 'normal 13px Arial';
        //                 ctx.fillStyle = '#333';
        //                 ctx.textAlign = 'center';
        //                 ctx.textBaseline = 'middle';
        //                 ctx.fillText('Phase', chart.width / 2, chart.height / 2);
        //                 ctx.fillText('1', chart.width / 2, chart.height / 2 + 16);
        //                 ctx.restore();
        //             }
        //         }]
        //     });

        // });
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
                            borderColor: ['#1BC976', '#FDB747', '#A7A7A7', '#F46674'],
                            backgroundColor: ['#1BC976', '#FDB747', '#A7A7A7', '#F46674'],
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
    @endpush
</div>


















































