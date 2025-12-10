<div>
    <section class="dash-wrapper">
        <div class="container">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-4">

                            <div class="inner-wrapper">
                                <div class="title-head">MCC Phase {{ $phaseName }} District View</div>

                                <div class="wrappper-bpdy">
                                    <div class="bar-chirt-option">
                                        @foreach ($districtChart as $row)
                                            <div class="chirt-stack">
                                                <div class="label">{{ $row['district'] }}</div>
                                                <div class="stack-chirt">
                                                    @if($row['percent']['pending'] > 0)
                                                        <div class="bar j-grey-bg"
                                                            style="width:{{ $row['percent']['pending'] }}%"
                                                            data-tooltip="Pending: {{ $row['percent']['pending'] }}%"
                                                            data-color="#A7A7A7">
                                                            {{ $row['pending'] }}
                                                        </div>
                                                    @endif

                                                    @if($row['percent']['processed'] > 0)
                                                        <div class="bar j-yellow-bg"
                                                            style="width:{{ $row['percent']['processed'] }}%"
                                                            data-tooltip="Processed: {{ $row['percent']['processed'] }}%"
                                                            data-color="#FDB747">
                                                            {{ $row['processed'] }}
                                                        </div>
                                                    @endif

                                                    @if($row['percent']['resolved'] > 0)
                                                        <div class="bar j-green-bg"
                                                            style="width:{{ $row['percent']['resolved'] }}%"
                                                            data-tooltip="Resolved: {{ $row['percent']['resolved'] }}%"
                                                            data-color="#1BC976">
                                                            {{ $row['resolved'] }}
                                                        </div>
                                                    @endif

                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="color-label mb-5 mt-4">
                                        <div class="color-grid"><span style="background-color: #A7A7A7;"></span>Pending To Processed</div>
                                        <div class="color-grid"><span style="background-color: #FDB747;"></span>Processed</div>
                                        <div class="color-grid"><span style="background-color: #1BC976;"></span>Confirm Resolved</div>
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

    {{-- TOOLTIP SCRIPT --}}
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {

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
                            <br> <small style="opacity:0.8;">(${count} MCC)</small>
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

