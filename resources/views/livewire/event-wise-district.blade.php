<div>
    
    <section class="dash-wrapper">
        <div class="container">

            <div class="row mb-4 justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Event Permission (District Level)</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                {{-- @dd($uniqueEventDistricts) --}}
                                @foreach ($uniqueEventDistricts as $index => $row)
                                    <div class="chirt-stack">
                                        <div class="label">{{ $row['district'] ?? 'N/A'}}
                                            <span>(Total:{{$row['total_campaigns'] ?? 'N/A'}})</span>
                                        </div>
                                        <div class="stack-chirt">
                                            {{-- @if($row['percent']['cancelled'] > 0)
                                                <div class="bar j-pink-bg" style="width:{{$row['percent']['cancelled']}}%">
                                                    {{$row['percent']['cancelled']}}%
                                                </div>
                                            @endif

                                            @if($row['percent']['pending'] > 0)
                                                <div class="bar j-yellow-bg" style="width:{{$row['percent']['pending']}}%">{{$row['percent']['pending']}}%</div>
                                            @endif
                                            @if($row['percent']['applied_awaiting'] > 0)
                                                <div class="bar j-red-bg" style="width:{{$row['percent']['applied_awaiting']}}%">{{$row['percent']['applied_awaiting']}}%</div>
                                            @endif
                                            @if($row['percent']['approved'] > 0)
                                                <div class="bar j-green-bg" style="width:{{$row['percent']['approved']}}%">{{$row['percent']['approved']}}%</div>
                                            @endif --}}
                                            @if($row['percent']['cancelled'] > 0)
                                                <div class="bar j-pink-bg"
                                                    style="width:{{$row['percent']['cancelled']}}%"
                                                    data-tooltip="Cancelled: {{$row['percent']['cancelled']}}%"
                                                    data-color="#f3a3a3">
                                                    {{$row['cancelled_or_rescheduled']}}
                                                </div>
                                                @endif

                                                @if($row['percent']['pending'] > 0)
                                                <div class="bar j-yellow-bg"
                                                    style="width:{{$row['percent']['pending']}}%"
                                                    data-tooltip="Pending: {{$row['percent']['pending']}}%"
                                                    data-color="#FDB747">
                                                    {{$row['pending_applications']}}
                                                </div>
                                                @endif

                                                @if($row['percent']['applied_awaiting'] > 0)
                                                <div class="bar j-red-bg"
                                                    style="width:{{$row['percent']['applied_awaiting']}}%"
                                                    data-tooltip="Applied-Awaiting: {{$row['percent']['applied_awaiting']}}%"
                                                    data-color="#f46674">
                                                    {{$row['applied_awaiting']}}
                                                </div>
                                                @endif

                                                @if($row['percent']['approved'] > 0)
                                                <div class="bar j-green-bg"
                                                    style="width:{{$row['percent']['approved']}}%"
                                                    data-tooltip="Approved: {{$row['percent']['approved']}}%"
                                                    data-color="#1BC976">
                                                    {{$row['approved_received']}}
                                                </div>
                                                @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <div class="color-grid"><span style="background-color: #f3a3a3;"></span>Cancelled or Rescheduled
                                </div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending
                                    Application</div>
                                <div class="color-grid"><span style="background-color: #f46674;"></span>Applied-Awaiting
                                    Approval</div>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved Copy
                                    Received</div>
                            </div>
                            <a href="{{route('admin.dashboard')}}" class="btm-small blue-btm">Back to State Dashboard</a>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        
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
                responsive: true, 
                maintainAspectRatio: false, 
                }
            });
        </script>
      <script>
            document.addEventListener("DOMContentLoaded", () => {

                // Create tooltip box
                let tooltip = document.createElement("div");
                tooltip.className = "chirt-tooltip";
                document.body.appendChild(tooltip);

                document.querySelectorAll(".bar").forEach(bar => {
                    
                    bar.addEventListener("mousemove", e => {

                        let text = bar.dataset.tooltip;  // Already contains label + %
                        let color = bar.dataset.color;  // Background color of bar
                        let count = bar.innerText.trim(); // Count inside the bar

                        tooltip.innerHTML = `
                            <span class="dot" style="background:${color}"></span>
                            <div>
                                ${text}  
                                <br> <small style="opacity:0.8;">(${count} events)</small>
                            </div>
                        `;

                        tooltip.style.left = (e.pageX + 20) + "px";
                        tooltip.style.top = (e.pageY + 15) + "px";

                        tooltip.style.opacity = 1;
                        tooltip.style.transform = "translateY(0)";
                    });

                    bar.addEventListener("mouseleave", () => {
                        tooltip.style.opacity = 0;
                        tooltip.style.transform = "translateY(5px)";
                    });

                });
            });
            </script>



    @endpush
</div>