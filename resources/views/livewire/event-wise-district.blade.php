<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Event Permission (District Level)</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                @foreach ($uniqueEventDistricts as $index => $row)
                                <div class="chirt-stack">
                                    <div class="label">{{ $row['district'] ?? 'unknown'}}</div>
                                    <div class="stack-chirt">
                                        @if($row['total_campaign_percentage'] > 0)
                                        <div class="bar j-purple-bg" style="width:{{$row['total_campaign_percentage']}}%">{{$row['total_campaign_percentage']}}%</div>
                                        @endif
                                        @if($row['percent']['pending'] > 0)
                                            <div class="bar j-yellow-bg" style="width:{{$row['percent']['pending']}}%">{{$row['percent']['pending']}}%</div>
                                        @endif
                                        @if($row['percent']['applied_awaiting'] > 0)
                                            <div class="bar j-gray-bg" style="width:{{$row['percent']['applied_awaiting']}}%">{{$row['percent']['applied_awaiting']}}%</div>
                                        @endif
                                        @if($row['percent']['approved'] > 0)
                                            <div class="bar j-green-bg" style="width:{{$row['percent']['approved']}}%">{{$row['percent']['approved']}}%</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
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
                            <a href="{{route('admin.dashboard')}}" class="btm-small blue-btm">Back to State Dashboard</a>
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
    @endpush
</div>