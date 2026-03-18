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
    .tab-pill-stack {
        display:flex;
        column-gap:8px;
        margin-bottom:15px;
        align-items:center;
        justify-content:space-between;
    }
    .tab-pill-stack a {
        background: #e5e5e5;
        color: #000;
        text-decoration: none;
        padding: 8px 24px;
        border-radius: 10px;
    }
    .tab-pill-stack a.active {
        background: #198754;
        color: #fff;
    }
    .tab-container .tab-content:not(:first-child) {
        display:none;
    }
</style>

    <section class="dash-wrapper">
    <div class="container">
        <div class="row mb-4 justify-content-center">
            <div class="col-md-12 col-lg-9">

                <!-- ================= TABLE SECTION ================= -->
                
                <div class="tab-pill-stack">
                    
                    <div class="">
                        @foreach ($phaseData as $phase_item)
                            <a href="{{route('admin.phasewise.district',$phase_item->id)}}" class="{{$tab==$phase_item->id?"active":""}}">{{$phase_item->name}}</a>
                        @endforeach
                    </div>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btm-small">
                             Back to State Dashboard
                        </a>
                    </div>
                </div>
                
                <div class="tab-container">
                
                    <div id="tab-1" class="tab-content">
                        <div  class="table-stack">
                        <h3>Nomination Vetting {{ $phaseName }} District View</h3>
    
                        <div class="graph-part">
    
                            <div class="color-label justify-content-center mb-4">
                                <div class="color-grid">
                                    <span style="background-color: #198754;"></span>Submitted & Checked
                                </div>
                                <div class="color-grid">
                                    <span style="background-color: #dc3545;"></span>Not Submitted
                                </div>
                                <div class="color-grid">
                                    <span style="background-color: #ffc107;"></span>Incomplete
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
                                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                                        style="width: {{ $row['percent']['document_yet_to_be_received_by_fox_for_vetting'] }}%">
                                                        {{ $row['not_submitted'] }}
                                                    </div>
    
                                                    <!-- Incomplete -->
                                                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
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
                    </div>
                    
                    <div id="tab-2" class="tab-content">
                        tab 2
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
                        borderColor: ['#1BC976', '#FDB747', '#5B86FC', '#F46674'], 
                        backgroundColor: ['#1BC976', '#FDB747', '#5B86FC', '#F46674'],
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
            
            $(function() {
              $('.tab-pill-stack a').click(function() {
            
                // Check for active
                $('a').removeClass('active');
                $(this).addClass('active');
            
                // Display active tab
                let currentTab = $(this).attr('href');
                $('.tab-container .tab-content').hide();
                $(currentTab).show();
            
                return false;
              });
            });    
            
            
            
            
        </script>
    @endpush
</div>
