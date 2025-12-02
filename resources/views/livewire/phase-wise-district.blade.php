<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dash Board</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Event Permission (Sate Lavel)</div>
                        <div class="wrappper-bpdy">

                            <div class="bar-chirt-option">
                                <div class="chirt-stack">
                                    <div class="label">District A</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:60%">60%</div>
                                        <div class="bar j-yellow-bg" style="width:10%">10%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:20%">20%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District B</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:40%">40%</div>
                                        <div class="bar j-yellow-bg" style="width:10%">10%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:5%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District c</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:50%">50%</div>
                                        <div class="bar j-yellow-bg" style="width:29%">29%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:5%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District D</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:80%">40%</div>
                                        <div class="bar j-yellow-bg" style="width:5%">10%</div>
                                        <div class="bar j-gray-bg" style="width:5%">10%</div>
                                        <div class="bar j-green-bg" style="width:10%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District E</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:70%">70%</div>
                                        <div class="bar j-yellow-bg" style="width:5%">5%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:10%">10%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="color-label mb-5">
                                <div class="color-grid"><span style="background-color: #D28BDF;"></span>Total Events
                                </div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending
                                    Application</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span>Applied-Awaiting
                                    Approval</div>
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved Copy
                                    Received</div>
                            </div>
                            <a href="" class="btm-small blue-btm">Back to state Dashboard</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting Phase 1 District View</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                @foreach ($uniqueDistricts as $index => $row)
                                <div class="chirt-stack">
                                    <div class="label">{{ $row['district'] ?? 'unknown'}}</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:{{ $row['percent']['approved'] }}%">{{
                                            $row['percent']['approved'] }}%
                                        </div>
                                        <div class="bar j-yellow-bg"
                                            style="width:{{ $row['percent']['pending_at_fox'] }}%">{{
                                            $row['percent']['pending_at_fox'] }}%</div>
                                        <div class="bar j-gray-bg"
                                            style="width:{{ $row['percent']['pending_submission'] }}%">{{
                                            $row['percent']['pending_submission'] }}%</div>
                                        <div class="bar j-green-bg" style="width:{{ $row['percent']['rejected'] }}%">{{
                                            $row['percent']['rejected'] }}%</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="color-label mb-5">
                                <div class="color-grid"><span style="background-color: #1BC976;"></span>Approved
                                    Complete</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Pending at Fox
                                </div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span>Pending
                                    Submissin at Fox</div>
                                <div class="color-grid"><span style="background-color: #F46674;"></span>Rejected</div>

                            </div>
                            <a href="{{route('admin.dashboard')}}" class="btm-small blue-btm">Back to state
                                Dashboard</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting (Phase-wise Status) - 8 Phases</div>
                        <div class="wrappper-bpdy">

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inner-wrapper">
                        <div class="title-head">Mcc Complaints Phase 1 District Wise View</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                <div class="chirt-stack">
                                    <div class="label">District B</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:40%">40%</div>
                                        <div class="bar j-yellow-bg" style="width:10%">10%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:5%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District c</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:50%">50%</div>
                                        <div class="bar j-yellow-bg" style="width:29%">29%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:5%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District D</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:80%">40%</div>
                                        <div class="bar j-yellow-bg" style="width:5%">10%</div>
                                        <div class="bar j-gray-bg" style="width:5%">10%</div>
                                        <div class="bar j-green-bg" style="width:10%">5%</div>
                                    </div>
                                </div>
                                <div class="chirt-stack">
                                    <div class="label">District E</div>
                                    <div class="stack-chirt">
                                        <div class="bar j-blue-bg" style="width:70%">70%</div>
                                        <div class="bar j-yellow-bg" style="width:5%">5%</div>
                                        <div class="bar j-gray-bg" style="width:10%">10%</div>
                                        <div class="bar j-green-bg" style="width:10%">10%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="color-label mb-5">
                                <div class="color-grid"><span style="background-color: #3363e8;"></span>Received</div>
                                <div class="color-grid"><span style="background-color: #FDB747;"></span>Escalated</div>
                                <div class="color-grid"><span style="background-color: #A7A7A7;"></span>Pending Disposal
                                </div>
                            </div>
                            <a href="#" class="btm-small blue-btm">Back to state Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});




    </script>


</body>

</html>