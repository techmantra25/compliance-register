<div>
     <style>
        .section-title {
            font-weight: 600;
            font-size: 20px;
            padding: 10px 0;
        }
        .card-header {
            font-weight: 600;
            font-size: 16px;
        }
        .stat-number {
            font-size: 28px;
            font-weight: bold;
        }
        .chart-box {
            height: 300px;
        }
        .legend-box {
            display:inline-block;
            width:12px;
            height:12px;
            border-radius:3px;
        }
        .chart-container {
            border: 1px solid #ffd271;
            background: #fffdf4;
            border-radius: 10px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }
        .chosen-container .chosen-default{
            font-size: 14px;
        }

       
    </style>
    <!-- Title -->
    <h3 class="mb-4 fw-bold">Admin Dashboard</h3>

    <!-- ---------- NOMINATION STATUS ---------- -->
    <div class="card shadow-sm mb-4 border-0" id="nomination-status-card">

        <!-- Header -->
        <div class="card-header bg-warning bg-opacity-25 fw-semibold d-flex justify-content-between align-items-center">
            <span>Nomination Status</span>
        </div>

        <div class="card-body">

            <!-- Filters -->
            <div class="row mb-3 align-items-end">

                <div class="col-md-3" wire:ignore>
                    <label>Districts</label>
                    <select wire:model="district" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach ($allDistricts as $district_item)
                            <option value="{{ $district_item->id }}">{{ $district_item->name_en }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3" wire:ignore>
                    <label>Phases</label>
                    <select wire:model="phase" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach ($allPhases as $phase_item)
                            <option value="{{ $phase_item->id }}">{{ $phase_item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3" wire:ignore>
                    <label>Assemblies</label>
                    <select wire:model="assembly" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach($allAssemblies as $assembly_item)
                            <option value="{{ $assembly_item->id }}">{{ $assembly_item->assembly_name_en }} ({{ $assembly_item->assembly_code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- RESET BUTTON -->
                <div class="col-md-3 text-end">
                    <button class="btn btn-sm btn-secondary mt-3"
                            wire:click="resetFilters">
                        Reset Filters
                    </button>
                </div>

            </div>

            <!-- Stats + Chart -->
            <div class="row mt-4">

                <!-- Left Side Numbers -->
                <div class="col-md-6">

                    <div class="row">
                        <!-- Row 1 -->
                        <div class="col-md-6">
                            <div class="py-5 px-3 rounded bg-warning bg-opacity-10 mb-3 d-flex justify-content-between">
                                <div class="fw-semibold">Nomination Documents Received</div>
                                <div class="stat-number text-warning">{{ $nominationDocumentsReceived }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="py-5 px-3 rounded bg-warning bg-opacity-10 mb-3 d-flex justify-content-between">
                                <div class="fw-semibold">Documents Pending</div>
                                <div class="stat-number text-warning">{{ $documentsPending }}</div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="col-md-6">
                            <div class="py-5 px-3 rounded bg-warning bg-opacity-10 mb-3 d-flex justify-content-between">
                                <div class="fw-semibold">Under Vetting</div>
                                <div class="stat-number text-warning">{{ $underVetting }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="py-5 px-3 rounded bg-warning bg-opacity-10 mb-3 d-flex justify-content-between">
                                <div class="fw-semibold">Vetted but not Submitted</div>
                                <div class="stat-number text-warning">{{ $vettedButNotSubmitted }}</div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Right Side Chart -->
                <div class="col-md-6">

                    <div class="chart-container p-3">
                        <div id="nominationChart" style="width: 100%; height: 300px;"></div>
                    </div>
                    <!-- Chart Legend -->
                    <div class="small text-muted d-none d-md-block text-center mt-2">
                        <span class="me-3"><span class="legend-box bg-warning"></span> Received</span>
                        <span class="me-3"><span class="legend-box bg-info"></span> Pending</span>
                        <span class="me-3"><span class="legend-box bg-primary"></span> Vetting</span>
                        <span><span class="legend-box bg-secondary"></span> Vetted</span>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- ---------- EVENT PERMISSION STATUS ---------- -->
    <div class="card shadow-sm mb-4 border-0" id="campaign-permission-status-card">
        <div class="card-header bg-info bg-opacity-25 fw-semibold">
            Campaign Permission Status
        </div>

        <div class="card-body">

            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Districts</label>
                    <select wire:model="campaignDistrict" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach ($allDistricts as $district_item)
                            <option value="{{ $district_item->id }}">{{ $district_item->name_en }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Assemblies</label>
                    <select wire:model="campaignAssembly" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach($allAssemblies as $assembly_item)
                            <option value="{{ $assembly_item->id }}">
                                {{ $assembly_item->assembly_name_en }} ({{ $assembly_item->assembly_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Event Categories</label>
                    <select wire:model="campaignEventCategory" class="form-select chosen-select">
                        <option value=""></option>
                        @foreach ($allEventCategories as $eventCategory)
                            <option value="{{ $eventCategory->id }}">{{ $eventCategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 text-end">
                    <button class="btn btn-sm btn-secondary mt-3" wire:click="resetFilters">
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- CHART LEFT | VALUES RIGHT -->
            <div class="row mt-3">
                
                <!-- LEFT: Pie Chart -->
                <div class="col-md-6">
                    <div class="chart-container p-3 bg-info bg-opacity-10 rounded">
                        <div id="campaignChart" style="width: 100%; height: 300px;"></div>
                    </div>
                     <!-- Chart Legend -->
                    <div class="small text-muted d-none d-md-block text-center mt-2">
                        <span class="me-3"><span class="legend-box bg-info"></span> Total</span>
                        <span class="me-3"><span class="legend-box bg-warning"></span> Pending</span>
                        <span><span class="legend-box bg-success"></span> Approved</span>
                    </div>
                </div>

                <!-- RIGHT: Stats -->
                <div class="col-md-6">
                    <div class="py-4 px-3 bg-info bg-opacity-10 rounded mb-3 flex justify-content-between">
                        <div class="stat-number text-info">{{ $totalCampaigns }}</div>
                        <div class="fw-semibold">Total Campaigns</div>
                    </div>

                    <div class="py-4 px-3 bg-info bg-opacity-10 rounded mb-3 flex justify-content-between">
                        <div class="stat-number text-info">{{ $pendingCampaigns }}</div>
                        <div class="fw-semibold">Pending</div>
                    </div>

                    <div class="py-4 px-3 bg-info bg-opacity-10 rounded flex justify-content-between">
                        <div class="stat-number text-info">{{ $approvedCampaigns }}</div>
                        <div class="fw-semibold">Permission Received</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="row">

        <!-- Phase Wise Assemblies -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary bg-opacity-25 fw-semibold">
                    Phase Wise Assemblies
                </div>
                <div class="card-body">
                    <div id="phaseAssemblyChart" style="width:100%; height:350px;"></div>
                </div>
            </div>
        </div>

        <!-- Zone Wise Assemblies -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-success bg-opacity-25 fw-semibold">
                    Zone Wise Assemblies
                </div>
                <div class="card-body">
                    <div id="zoneAssemblyChart" style="width:100%; height:350px;"></div>
                </div>
            </div>
        </div>

    </div>


    <div class="loader-container" wire:loading wire:target="ChangeNominationField">
        <div class="loader"></div>
    </div>
    @push('scripts')

    <!-- Google Charts Loader -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        /* ------------------------------
            Handle Livewire Events
        ------------------------------ */
        document.addEventListener("livewire:navigated", () => {
            drawNominationChart();
            drawCampaignChart();
        });

        document.addEventListener("livewire:update", () => {
            drawNominationChart();
            drawCampaignChart();
        });


        /* ------------------------------
            NOMINATION CHART
        ------------------------------ */
        function drawNominationChart() {
            google.charts.load("current", { packages: ["corechart"] });

            google.charts.setOnLoadCallback(function () {

                var data = google.visualization.arrayToDataTable([
                    ["Status", "Count"],
                    ["Received", {{ $nominationDocumentsReceived }}],
                    ["Pending", {{ $documentsPending }}],
                    ["Under Vetting", {{ $underVetting }}],
                    ["Vetted Not Submitted", {{ $vettedButNotSubmitted }}],
                ]);

                var options = {
                    pieHole: 0.45,
                    chartArea: { width: "90%", height: "90%" },
                    colors: ["#ffc107", "#0dcaf0", "#0d6efd", "#6c757d"],
                    legend: { position: "bottom" }
                };

                var chart = new google.visualization.PieChart(
                    document.getElementById("nominationChart")
                );

                chart.draw(data, options);
            });
        }


        /* ------------------------------
            CAMPAIGN PERMISSION CHART
        ------------------------------ */
        function drawCampaignChart() {
            google.charts.load("current", { packages: ["corechart"] });

            google.charts.setOnLoadCallback(function () {

                var data = google.visualization.arrayToDataTable([
                    ["Status", "Count"],
                    ["Total", {{ $totalCampaigns }}],
                    ["Pending", {{ $pendingCampaigns }}],
                    ["Approved", {{ $approvedCampaigns }}],
                ]);

                var options = {
                    pieHole: 0.40,
                    chartArea: { width: "90%", height: "90%" },
                    colors: ["#0dcaf0", "#ffc107", "#198754"],
                    legend: { position: "bottom" },
                };

                var chart = new google.visualization.PieChart(
                    document.getElementById("campaignChart")
                );

                chart.draw(data, options);
            });
        }

    </script>
    <script>
        google.charts.load('current', {packages: ['bar']});
        google.charts.setOnLoadCallback(drawAllCharts);

        function drawAllCharts() {
            drawPhaseWiseAssemblyChart();
            drawZoneWiseAssemblyChart();
        }

        /* ------------------------------------------
            PHASE WISE ASSEMBLIES
        -------------------------------------------*/
        function drawPhaseWiseAssemblyChart() {

            let phaseData = @json($phaseWiseAssemblies);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Phase');
            data.addColumn('number', 'Assemblies');

            phaseData.forEach(row => {
                data.addRow([
                    `${row.phase_name} (${row.election_date})`,
                    row.assemblies
                ]);
            });

            var options = {
                bars: 'horizontal',
                height: 350,
                legend: { position: 'none' },
                colors: ['#3a1212'],
                chartArea: { width: '70%' },
                hAxis: {
                    title: 'Number of Assemblies',
                    minValue: 0
                }
            };

            var chart = new google.charts.Bar(
                document.getElementById('phaseAssemblyChart')
            );

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        /* ------------------------------------------
            ZONE WISE ASSEMBLIES
        -------------------------------------------*/
        function drawZoneWiseAssemblyChart() {

            let zoneData = @json($zoneWiseAssemblies);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Zone');
            data.addColumn('number', 'Assemblies');

            zoneData.forEach(row => {
                data.addRow([
                    row.zone_name,
                    row.assemblies
                ]);
            });

            var options = {
                bars: 'horizontal',
                height: 350,
                legend: { position: 'none' },
                colors: ['#198754'],
                chartArea: { width: '70%' },
                hAxis: {
                    title: 'Number of Assemblies',
                    minValue: 0
                }
            };

            var chart = new google.charts.Bar(
                document.getElementById('zoneAssemblyChart')
            );

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

    </script>


    <link rel="stylesheet" href="{{ asset('assets/css/component-chosen.css') }}">
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
        function initChosen() {
            $('.chosen-select').chosen({
                width: '100%',
                no_results_text: "No result found",
                placeholder_text_single: "Select option",
                search_contains: true
            })
            .off('change')
            .on('change', function (e) {
                let model = $(this).attr('wire:model');
                if (model) {
                    @this.call('ChangeNominationField', model, $(this).val());
                }
            });

            // Force chosen to show placeholder if empty
            $('.chosen-select').each(function () {
                if (!$(this).val() || $(this).val().length === 0) {
                    $(this).next('.chosen-container')
                        .find('.chosen-single span')
                        .text('Select option');
                }
            });
        }


        document.addEventListener("livewire:navigated", () => {
            initChosen();
        });

        Livewire.hook('morph.updated', ({ el, component }) => {

            initChosen();  // Reinitialize Chosen after DOM update

            $('.chosen-select').each(function () {
                const select = $(this);
                const model = select.attr('wire:model');

                if (!model) return;

                let value = @this.get(model);

                console.log(model + ": " + value);
                if (value) {
                    // If Livewire has value, apply it
                    select.val(value).trigger('chosen:updated');
                } else {
                    // If Livewire cleared the value, reset the Chosen UI
                    select.val('').trigger('chosen:updated');

                    // FIX placeholder text
                    select.next('.chosen-container')
                        .find('.chosen-single span')
                        .text('Select option');

                    select.next('.chosen-container')
                        .find('.search-field input')
                        .attr('placeholder', 'Select option');
                }
            });
        });


        $(document).ready(function () {
            initChosen();
        });

        // window.addEventListener('ResetForm', event => {
        //     document.querySelectorAll('input').forEach(input => input.value = '');

        //     const chosen = $('.chosen-select');
        //     if (chosen.length) {
        //         chosen.val('').trigger('chosen:updated');

        //         // Update all placeholders
        //         $('.chosen-single span').text('Select option');
        //         $('.search-field input').attr('placeholder', 'Select option');
        //     }
        // });

    </script>
    @endpush
</div>

