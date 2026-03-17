<div>
<style>
    .table-stack {
        background: #f7f7f7;
        border: 1px solid #d3d3d3;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-stack h3 {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        text-align:center;
        display:block;
        background:#e7e7e7;
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
        border-top-left-radius: 0px; 
    }

    .custom-table th:last-child {
        border-top-right-radius:0px; 
    }

    .custom-table-yellow td {
        border-color:#d8d8d8;
    }

    .custom-table-yellow th {
    background: #e2f1e3;
    font-size: 13px;
    border: 1px solid #c8c8c8;
    border-bottom:mone;
    }
</style>

    <section class="dash-wrapper">
    <div class="container">
        <div class="row mb-4 justify-content-center">
            <div class="col-md-12 col-lg-9">

                <!-- ================= TABLE SECTION ================= -->
                <div class="table-stack">
                    <h3>Nomination Vetting {{ $phaseName }} District View</h3>

                    <div class="graph-part">

                        <div class="color-label justify-content-center mb-4">
                            <div class="color-grid">
                                <span style="background-color: #198754;"></span>Submitted & Checked
                            </div>
                            <div class="color-grid">
                                <span style="background-color: #ffc107;"></span>Not Submitted
                            </div>
                            <div class="color-grid">
                                <span style="background-color: #dc3545;"></span>Incomplete
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="custom-table custom-table-yellow">
                                <thead>
                                    <th style="width:200px;">District Name</th>
                                    <th>Total Assembly</th>
                                    <th>Submitted & Checked</th>
                                    <th>Not Submited</th>
                                    <th>Incomplete</th>
                                    <th style="width:300px;"></th>
                                </thead>

                                <tbody>
                                    @foreach($districtChart as $row)
                                    <tr>
                                        <td>{{ $row['district'] }}</td>
                                        <td>{{ $row['total_assembly'] }}</td>
                                        <td>{{ $row['submitted_checked'] }}</td>
                                        <td>{{ $row['not_submitted'] }}</td>
                                        <td>{{ $row['incomplete'] }}</td>

                                        <td>
                                            <div class="progress bg-white" style="height:24px;">

                                                <!-- Submitted -->
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                                    style="width: {{ $row['percent']['approved'] }}%">
                                                    {{ $row['submitted_checked'] }}
                                                </div>

                                                <!-- Not Submitted -->
                                                <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                                    style="width: {{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%">
                                                    {{ $row['not_submitted'] }}
                                                </div>

                                                <!-- Incomplete -->
                                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                                    style="width: {{ $row['percent']['vetting_in_progress_at_fox'] + $row['percent']['pending_acknowledgement_copy'] }}%">
                                                    {{ $row['incomplete'] }}
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                            </table>
                        </div>
                    </div>
                </div>


                <!-- ================= BAR CHART SECTION ================= -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="inner-wrapper">

                            <div class="title-head" style="color: #3e0b0f;">
                                Nomination Vetting {{ $phaseName }} District View
                            </div>

                            <div class="wrappper-bpdy">

                                <div class="bar-chirt-option">
                                    @foreach ($districtChart as $row)
                                        <div class="chirt-stack">

                                            <div class="label">
                                                {{ $row['district'] }}
                                            </div>

                                            <div class="stack-chirt">

                                                @if($row['percent']['approved'] > 0)
                                                    <div class="bar j-green-bg"
                                                        style="width:{{ $row['percent']['approved'] }}%"
                                                        data-tooltip="Submitted & Checked: {{ $row['percent']['approved'] }}%"
                                                        data-color="#1BC976">
                                                        {{ $row['approved'] }}
                                                    </div>
                                                @endif

                                                @if($row['percent']['document_yet_to_be_received_by_fox_for_vetting'] > 0)
                                                    <div class="bar j-pink-bg"
                                                        style="width:{{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%"
                                                        data-tooltip="Not Submitted: {{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%"
                                                        data-color="#ffc107">
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
                                                        data-tooltip="Pending: {{ $row['percent']['pending_acknowledgement_copy'] }}%"
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

                                <!-- Legend -->
                                <div class="color-label mb-5">
                                    <div class="color-grid">
                                        <span style="background-color: #1BC976;"></span>Submitted & Checked
                                    </div>
                                    <div class="color-grid">
                                        <span style="background-color: #FDB747;"></span>Inappropriate Documents
                                    </div>
                                    <div class="color-grid">
                                        <span style="background-color: #A7A7A7;"></span>Pending
                                    </div>
                                </div>

                                <a href="{{ route('admin.dashboard') }}" class="btm-small">
                                    Back to State Dashboard
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

                        let text = bar.dataset.tooltip;  
                        let color = bar.dataset.color;  
                        let count = bar.innerText.trim(); 
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
