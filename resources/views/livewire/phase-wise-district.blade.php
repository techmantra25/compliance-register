<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting {{ $phaseName }} District View</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                @foreach ($districtChart as $index => $row)
                                <div class="chirt-stack">
                                    <div class="label">{{ $row['district'] ?? 'unknown'}}</div>
                                    <div class="stack-chirt">
                                        @if($row['percent']['approved'] > 0)
                                            <div class="bar j-green-bg"
                                                style="width:{{ $row['percent']['approved'] }}%"
                                                data-tooltip="Approved: {{ $row['percent']['approved'] }}%"
                                                data-color="#1BC976">
                                                {{ $row['approved'] }}
                                            </div>
                                        @endif

                                        @if($row['percent']['document_yet_to_be_received_by_fox_for_vetting'] > 0)
                                            <div class="bar j-pink-bg"
                                                style="width:{{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%"
                                                data-tooltip="Yet to Receive: {{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%"
                                                data-color="#f3a3a3">
                                                {{ $row['document_yet_to_be_received_for_vetting'] }}
                                            </div>
                                        @endif

                                        @if($row['percent']['vetting_in_progress_at_fox'] > 0)
                                            <div class="bar j-yellow-bg"
                                                style="width:{{ $row['percent']['vetting_in_progress_at_fox'] }}%"
                                                data-tooltip="Vetting in Progress: {{ $row['percent']['vetting_in_progress_at_fox'] }}%"
                                                data-color="#FDB747">
                                                {{ $row['vetting_in_progress_at_fox'] }}
                                            </div>
                                        @endif

                                        @if($row['percent']['pending_acknowledgement_copy'] > 0)
                                            <div class="bar j-gray-bg"
                                                style="width:{{ $row['percent']['pending_acknowledgement_copy'] }}%"
                                                data-tooltip="Pending Ack Copy: {{ $row['percent']['pending_acknowledgement_copy'] }}%"
                                                data-color="#A7A7A7">
                                                {{ $row['pending_acknowledgement_copy'] }}
                                            </div>
                                        @endif

                                        @if($row['percent']['rejected'] > 0)
                                            <div class="bar j-red-bg"
                                                style="width:{{ $row['percent']['rejected'] }}%"
                                                data-tooltip="Rejected: {{ $row['percent']['rejected'] }}%"
                                                data-color="#F46674">
                                                {{ $row['rejected'] }}
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved
                                    Complete</div>
                                <div class="color-grid"><span style="background-color: #f3a3a3;"></span>Document Yet to be Received For Vetting
                                </div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Vetting in Progress at Fox
                                </div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span>Pending Acknowledgement Copy</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected</div>

                            </div>
                            <a href="{{route('admin.dashboard')}}" class="btm-small blue-btm">Back to State
                                Dashboard
                            </a>
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
                                <br> <small style="opacity:0.8;">(${count} Nomination)</small>
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
