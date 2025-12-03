<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8 mb-4">
                    <div class="inner-wrapper">
                        <div class="title-head">Nomination Vetting {{ $phaseName }} District View</div>
                        <div class="wrappper-bpdy">
                            <div class="bar-chirt-option">
                                @foreach ($districtChart as $index => $row)
                                <div class="chirt-stack">
                                    <div class="label">{{ $row['district'] ?? 'unknown'}}</div>
                                    <div class="stack-chirt">
                                        @if($row['percent']['approved'] > 0)
                                            <div class="bar j-green-bg" style="width:{{ $row['percent']['approved'] }}%">{{
                                                $row['percent']['approved'] }}%
                                            </div>
                                        @endif
                                        @if($row['percent']['pending_at_fox'] > 0)
                                        <div class="bar j-yellow-bg"
                                            style="width:{{ $row['percent']['pending_at_fox'] }}%">{{
                                            $row['percent']['pending_at_fox'] }}%</div>
                                        @endif
                                        @if($row['percent']['pending_submission'] > 0)
                                            <div class="bar j-gray-bg"
                                                style="width:{{ $row['percent']['pending_submission'] }}%">{{
                                                $row['percent']['pending_submission'] }}%</div>
                                        @endif
                                        @if($row['percent']['rejected'] > 0)
                                            <div class="bar j-red-bg" style="width:{{ $row['percent']['rejected'] }}%">{{
                                                $row['percent']['rejected'] }}%</div>
                                        @endif
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
                            <a href="{{route('admin.dashboard')}}" class="btm-small blue-btm">Back to State
                                Dashboard
                            </a>
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
