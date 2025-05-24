@extends('layout')
@section('content')

@include('toast-notification')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h1 class="h3 fw-bold text-dark">Papan Pemuka</h1>
        
        <!-- ======================= year filter ====================== -->

        <div class="dropdown">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-medium">Tahun Penilaian:</span>
                <button class="btn btn-primary" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ date('Y') }} 
                </button>
                <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                    <!-- Search box -->
                    <input type="text" id="yearSearch" class="form-control mb-2" placeholder="Search year...">
                    
                    @php
                        $years = DB::table('add_kpis')
                            ->selectRaw('DISTINCT year')
                            ->whereNotNull('year')
                            ->orderBy('year', 'desc')
                            ->pluck('year');
                    @endphp
        
                    @foreach ($years as $year)
                        <li><a class="dropdown-item year-item" href="#">{{ $year }}</a></li>
                    @endforeach
                </ul> 
            </div>
        </div>
    </div>

  

    <!-- ======================= card statistic ====================== -->
    <div class="row g-4 mb-4">
        @php
            $cards = [
                ['title' => 'Jumlah KPI', 'value' => $totalKpi, 'color' => 'bg-total', 'icon' => 'clipboard-data'],
                ['title' => 'Sektor Keselamatan Dan Koreksional', 'value' => $skkKpi, 'color' => 'bg-skk', 'icon' => 'shield-shaded'],
                ['title' => 'Sektor Pemasyarakatan', 'value' => $smKpi, 'color' => 'bg-sm', 'icon' => 'people'],
                ['title' => 'Sektor Pengurusan', 'value' => $spKpi, 'color' => 'bg-sp', 'icon' => 'bar-chart-line'],
                ['title' => 'Bahagian & Unit', 'value' => $bduKpi, 'color' => 'bg-bdu', 'icon' => 'briefcase'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col kpi-card" data-title="{{ $card['title'] }}">
                <div class="card card-hover shadow-sm h-100">
                    <div class="card-header {{ $card['color'] }} py-1"></div>
                    <div class="card-body d-flex align-items-center py-3">
                        <div class="d-flex align-items-center justify-content-center {{ $card['color'] }} rounded p-3 me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-{{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary text-uppercase small fw-bold mb-2">{{ $card['title'] }}</h6>
                            <h3 class="fw-bold mb-2">{{ $card['value'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    
    <!-- ======================= kpi owner ====================== -->

    <div class="card mb-4">
        <div class="card-header py-2 py-md-3 rounded-top">
            <div class="w-100">
                <h5 class="mb-0 text-center fw-bold"></h5>
            </div>
        </div>
        <div class="card-body">
            <div id="chart" style="height: 400px;"></div>
        </div>
        <div class="card-footer text-end small text-muted">
            {{-- Last updated: March 9, 2025 --}}
        </div> 
    </div>  


    <!-- ======================= pecahan kpi mengikut bahagian & unit ====================== -->

    <div class="card shadow mb-4">
        <div class="card-header py-2 py-md-3 rounded-top">
            <h5 class="mb-0 text-center fw-bold">Pecahan KPI mengikut Bahagian & Unit</h5>
        </div>
        <div class="card-body p-2">
            <div class="sectors-container">
                @foreach($sectors as $sector)
                    <div class="sector mb-3">
                        <h5 class="sector-heading rounded p-2 ps-3 mb-2 border shadow-sm">
                            {{ $sector['name'] }}
                        </h5>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
                            @foreach($sector['bahagian'] as $bahagian)
                                <div class="col">
                                    <div class="department-card p-2 h-100">
                                        <div class="d-flex flex-column align-items-center">
                                            <img src="{{ asset('storage/' . $bahagian['icon']) }}" alt="{{ $bahagian['nama_bahagian'] }}" class="department-icon mb-2" width="40">
                                            <h6 class="department-name mb-0 small text-center">{{ $bahagian['nama_bahagian'] }}</h6>
                                        </div>
                                        <div class="department-metrics mt-2 text-center">
                                            <span class="badge bg-primary">{{ count($bahagian['kpis'] ?? []) }} KPI</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ======================= ringkasan kpi ====================== -->

    @foreach ($sectors as $sector)
        <div class="card shadow-sm mb-4">
            <div class="card-header py-2 rounded-top">
                <h5 class="mb-0 text-center fw-bold">{{ $sector['name'] }} ({{ $selectedYear }})</h5>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center">Tajuk KPI</th>
                                <th class="text-center">Indikator</th>
                                <th class="text-center">Pemilik</th>
                                <th class="text-center">Kamus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sector['bahagian'] as $bahagian)
                                @forelse ($bahagian['kpis'] as $kpi)
                                    <tr>
                                        <td>{{ $kpi['pernyataan_kpi'] }}</td>
                                        <td>{{ $kpi['indikator'] }}</td>
                                        <td class="text-center">{{ $kpi['pemilik'] ?? '-' }}</td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tiada KPI tersedia</td>
                                    </tr>
                                @endforelse
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>


<script src="{{ asset('js/script.js') }}"></script><!-- custom js -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!-- apex chart -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
<!-- ECharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

<script>
    $(document).ready(function() {
        // Year search functionality
        $('#yearSearch').on('keyup', function() {
            let filter = $(this).val().toLowerCase();
            $('.year-item').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(filter));
            });
        });

        // Year selection event
        $('.year-item').on('click', function() {
            let selectedYear = $(this).text().trim();
            $('#yearDropdown').text(selectedYear);
            fetchKpiData(selectedYear);
        });

        // Fetch KPI data based on selected year
        function fetchKpiData(year) {
            $.ajax({
                url: '/all/get-infografik',
                type: 'GET',
                data: { year: year },
                dataType: 'json',
                success: function(response) {
                    // Update all sections with the retrieved data
                    updateKpiCards(response);
                    updatePecahanKpi(response.sectors);
                    updateSectorTables(response.sectors, year);
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        }

        // Update KPI count cards with animation
        function updateKpiCards(data) {
            $('.kpi-card').each(function() {
                let title = $(this).data('title').trim();
                let newValue = data[title] || 0;
                let numberElement = $(this).find('.card-body h3');
                animateNumber(numberElement, parseInt(numberElement.text()) || 0, newValue, 800);
            });
        }

        // Animate number count
        function animateNumber(element, start, end, duration) {
            let range = end - start;
            let startTime = null;

            function animationStep(timestamp) {
                if (!startTime) startTime = timestamp;
                let progress = Math.min((timestamp - startTime) / duration, 1);
                let currentValue = Math.floor(progress * range + start);
                element.text(currentValue);
                if (progress < 1) {
                    requestAnimationFrame(animationStep);
                }
            }

            requestAnimationFrame(animationStep);
        }

        // Update Pecahan KPI section
        function updatePecahanKpi(sectors) {
            let sectorsContainer = $('.sectors-container');
            sectorsContainer.empty();
            
            sectors.forEach(sector => {
                let sectorHtml = `
                    <div class="sector mb-3">
                        <h5 class="sector-heading rounded p-2 ps-3 mb-2 border shadow-sm">
                            ${sector.name}
                        </h5>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
                `;
                
                sector.bahagian.forEach(bahagian => {
                    sectorHtml += `
                        <div class="col">
                            <div class="department-card p-2 h-100">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="/storage/${bahagian.icon}" alt="${bahagian.nama_bahagian}" class="department-icon mb-2" width="40">
                                    <h6 class="department-name mb-0 small text-center">${bahagian.nama_bahagian}</h6>
                                </div>
                                <div class="department-metrics mt-2 text-center">
                                    <span class="badge bg-primary">${bahagian.kpi_count} KPI</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                sectorHtml += `</div></div>`;
                sectorsContainer.append(sectorHtml);
            });
        }

        // Update sector tables with KPI data
        function updateSectorTables(sectors, year) {
            // Remove all existing sector cards
            $('.card.shadow-sm.mb-4').not('.card.shadow.mb-4').remove();
            
            // Create a container for new sector cards
            let container = $('.container-fluid');
            
            // Create new sector cards
            sectors.forEach(sector => {
                let tableRows = '';
                
                // Build rows for each bahagian and their KPIs
                sector.bahagian.forEach(bahagian => {
                    if (bahagian.kpis && bahagian.kpis.length > 0) {
                        bahagian.kpis.forEach(kpi => {
                            tableRows += `
                                <tr>
                                    <td>${kpi.pernyataan_kpi || '-'}</td>
                                    <td>${kpi.indikator || '-'}</td>
                                    <td class="text-center">${kpi.pemilik || '-'}</td>
                                    <td></td>
                                </tr>
                            `;
                        });
                    }
                });
                
                // If no KPIs found, show message
                if (!tableRows) {
                    tableRows = `
                        <tr>
                            <td colspan="4" class="text-center">Tiada KPI tersedia</td>
                        </tr>
                    `;
                }
                
                // Create the sector card with table
                let sectorCard = `
                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-2 rounded-top">
                            <h5 class="mb-0 text-center fw-bold">${sector.name}</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">Tajuk KPI</th>
                                            <th class="text-center">Indikator</th>
                                            <th class="text-center">Pemilik</th>
                                            <th class="text-center">Kamus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${tableRows}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
                
                // Append the sector card to the container
                container.append(sectorCard);
            });
        }

        // Initialize with current year
        fetchKpiData(new Date().getFullYear());

        var chart = echarts.init(document.getElementById('chart'));

        var option = {
            title: {
                text: 'Pemilik KPI',
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c} ({d}%)'  // Format to show name, value, and percentage
            },
            legend: {
                orient: 'vertical',
                left: 'left'
            },
            series: [
                {
                    name: 'KPIs',
                    type: 'pie',
                    radius: '50%',
                    data: [
                        { value: {{ $data['kjp'] }}, name: 'Komisioner Jeneral Penjara' },
                        { value: {{ $data['states'] }}, name: 'States' },
                        { value: {{ $data['institutions'] }}, name: 'Institutions' },
                        { value: {{ $data['bahagian'] }}, name: 'Bahagian & Unit' }
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },
                    label: {
                        show: true,
                        formatter: '{b}: {c}'  // Show name and value on the pie segments
                    }
                }
            ]
        };

        chart.setOption(option);

    });
</script>
@endsection