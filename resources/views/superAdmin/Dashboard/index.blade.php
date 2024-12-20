@extends('layout')
@section('content')
@php
    $bahagianIds = session('bahagianIds', []);
@endphp

<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 100%;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        border-radius: 16px;
        padding: 20px;
        background: linear-gradient(145deg, #f0f0f0, #ffffff);
        transition: transform 0.3s ease-in-out;
    }

    .chart-container:hover {
        transform: scale(1.05);
    }

    .card {
        transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(-5px);
    }

    .kpi-card {
        border-left: 5px solid #007bff;
        transition: background-color 0.3s, transform 0.3s ease-in-out;
    }

    .kpi-card[data-status="achieved"] {
        border-left-color: #4caf50;
    }

    .kpi-card[data-status="pending"] {
        border-left-color: #ffcc02;
    }

    .kpi-card[data-status="not Achieved"] {
        border-left-color: #f44336;
    }

    .kpi-card:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transform: scale(1.03);
    }

    canvas {
        width: 100% !important;
        height: 300px !important;
    }

    #detailsSection {
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container-fluid">
    {{-- statistic card  --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5>Total KPI</h5>
                    <h2>{{ $totalKpi }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card kpi-card mb-1">
                <div class="card-body">
                    <h5>Achieved KPI</h5>
                    <h2>{{ $achievedKpi }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card kpi-card mb-1">
                <div class="card-body">
                    <h5>Pending KPI</h5>
                    <h2>{{ $pendingKpi }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card  kpi-card mb-1">
                <div class="card-body">
                    <h5>Not Achieved KPI</h5>
                    <h2>{{ $notAchievedKpi }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- State KPI Overview -->
    <div class="row mt-4">
        <div id="kpi-chart" style="width: 100%; height: 400px;"></div>
    </div>

    <div class="row mt-4">
        <!-- KPI Details Section -->
        <div class="col-md-12">
            <div id="detailsSections">
                <ul id="detailsList" class="list-group"></ul>
            </div>
        </div>
    </div>
    

    {{-- bahagian  --}}
    <div class="row mt-4">
        <!-- KPI Total Bahagian Chart -->
        <div class="col-md-7">
            <div class="chart-panel">
                <div id="kpiTotalBahagian" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    
        <!-- KPI Summary Pie Chart -->
        <div class="col-md-5">
            <div class="chart-panel">
                <div id="kpiSummaryPie" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <!-- KPI Details Section -->
        <div class="col-md-12">
            <div id="detailsSection">
                <ul id="detailsList" class="list-group"></ul>
            </div>
        </div>
    </div>
    
</div>

<!-- Include jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables or other jQuery-dependent scripts -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stateData = @json($stateNames);
        const totalKpis = @json($totalKpis);
        const kpiDetails = @json($drilldownData);

        Highcharts.chart('kpi-chart', {
            chart: {
                type: 'column',
                borderColor: '#000', // Adds black border
                borderWidth: 2, // Sets border width
                spacing: [10, 10, 15, 10], // Adds spacing inside the border
            },
            title: {
                text: 'State KPI Overview'
            },
            xAxis: {
                categories: stateData,
                title: {
                    text: 'States'
                }
            },
            yAxis: { 
                title: {
                    text: 'Total KPIs'
                }
            },
            tooltip: {
                shared: true
            },
            series: [
                {
                    name: 'Total KPIs',
                    type: 'column',
                    data: totalKpis,
                    color: '#007bff',
                    point: {
                        events: {
                            click: function () {
                                const stateIndex = this.index; // Index of the clicked bar
                                const stateName = stateData[stateIndex].toLowerCase(); // Convert state name to lowercase
                                const details = kpiDetails[stateName]; // Fetch details using lowercase keys
                                displayDetails(stateName, details); // Pass the normalized state name and details
                            }
                        }
                    }
                }
            ],
            credits: { enabled: false },
            exporting: { enabled: true }
        });
        
        // Function to display details of a state
        function displayDetails(stateName, details) {
            let detailsSection = document.getElementById('detailsSections');
            if (!detailsSection) {
                detailsSection = document.createElement('div');
                detailsSection.id = 'detailsSections';
                detailsSection.className = 'mt-4';
                document.body.appendChild(detailsSection);
            }

            if (!details || (details.state_kpis.length === 0 && details.institution_kpis.length === 0)) {
                detailsSection.innerHTML = `<div class="alert alert-warning">No KPI details available for ${stateName.charAt(0).toUpperCase() + stateName.slice(1)}.</div>`;
                return;
            }

            // Render state-level KPIs
            const stateRows = details.state_kpis
                .map(kpi => `
                    <tr>
                        <td>${kpi.name}</td>
                        <td class="text-center">${parseFloat(kpi.target).toFixed(2)}</td>
                        <td class="text-center">${parseFloat(kpi.achievement).toFixed(2)}%</td>
                        <td class="text-center">
                            <span class="badge ${
                                kpi.status === 'achieved'
                                    ? 'bg-success'
                                    : kpi.status === 'pending'
                                    ? 'bg-warning text-dark'
                                    : 'bg-danger'
                            }">${kpi.status}</span>
                        </td>
                    </tr>
                `)
                .join('');

            // Render institution-level KPIs
            const institutionRows = details.institution_kpis
                .map(kpi => `
                    <tr>
                        <td>${kpi.institution_name}</td>
                        <td>${kpi.name}</td>
                        <td class="text-center">${parseFloat(kpi.target).toFixed(2)}</td>
                        <td class="text-center">${parseFloat(kpi.achievement).toFixed(2)}%</td>
                        <td class="text-center">
                            <span class="badge ${
                                kpi.status === 'achieved'
                                    ? 'bg-success'
                                    : kpi.status === 'pending'
                                    ? 'bg-warning text-dark'
                                    : 'bg-danger'
                            }">${kpi.status}</span>
                        </td>
                    </tr>
                `)
                .join('');

            const tableHtml = `
                <div class="card shadow-sm rounded fade-in">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">KPI Details for  ${stateName.charAt(0).toUpperCase() + stateName.slice(1)}</h5>
                        <button id="hideTableButton" class="btn btn-sm btn-light">Hide Table</button>
                    </div>
                    <div class="card-body p-4">
                        <h5>State KPIs</h5>
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>KPI Name</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Achievement</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${stateRows}
                            </tbody>
                        </table>

                        <h5 class="mt-4">Institution KPIs</h5>
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Institution Name</th>
                                    <th>KPI Name</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Achievement</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${institutionRows}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            detailsSection.innerHTML = tableHtml;

            // Attach the event listener AFTER the button is added to the DOM
            const hideButton = document.getElementById('hideTableButton');
            hideButton.addEventListener('click', function () {
                detailsSection.innerHTML = ''; // Clear the content to hide the table
            });
        }
    });


    // Total KPI bahagian
    document.addEventListener('DOMContentLoaded', function () {
        const kpiData = @json($kpiBahagianData);

        if (!kpiData || kpiData.length === 0) {
            console.error('No data available to display.');
            return;
        }

        const categories = kpiData.map(item => item.name);
        const totalKpiData = kpiData.map(item => parseInt(item.total_kpi) || 0);

        let currentChart;

        function initializeChart(type = 'column') {
            if (currentChart) currentChart.destroy();

            currentChart = Highcharts.chart('kpiTotalBahagian', {
                chart: {
                    type: type,
                    borderColor: '#000', // Adds black border
                    borderWidth: 2, // Sets border width
                    spacing: [10, 10, 15, 10], // Adds spacing inside the border
                },
                title: {
                    text: 'Total KPI by Bahagian',
                    style: {
                        fontSize: '30px', // Set the desired font size
                        fontWeight: 'bold', // Optional: Make the title bold
                        color: '#333333', // Optional: Set title text color
                    },
                },
                xAxis: {
                    categories: categories,
                    title: { text: 'Bahagian' },
                },
                yAxis: type !== 'pie'
                    ? [
                        {
                            title: { text: 'Total' },
                            allowDecimals: false,
                        },
                    ]
                    : null,
                series:
                    type === 'pie'
                        ? [
                            {
                                name: 'Total KPI',
                                data: categories.map((name, index) => ({
                                    name: name,
                                    y: totalKpiData[index],
                                })),
                                colorByPoint: true,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}: {point.y}', // Display name and value
                                    style: {
                                        color: '#000', // Set text color for pie chart labels
                                        fontWeight: 'bold', // Make text bold
                                        fontSize: '14px', // Optional: Adjust font size
                                    },
                                },
                            },
                        ]
                        : [
                            {
                                name: 'Total KPI',
                                data: totalKpiData,
                                color: '#007bff',
                                dataLabels: {
                                    enabled: true, // Enable labels for column/bar/line
                                    format: '{y}', // Show only the value
                                    style: {
                                        color: 'black', // Change the text color to red
                                        fontWeight: 'bold', // Optional: Make text bold
                                        fontSize: '16px', // Optional: Adjust font size
                                    },
                                },
                                point: {
                                    events: {
                                        click: function () {
                                            const index = this.index; // Get index of the clicked bar
                                            const selectedData = kpiData[index]; // Get data for the clicked bar
                                            displayDetails(selectedData);
                                        },
                                    },
                                },
                            },
                        ],
                tooltip: {
                    shared: type !== 'pie',
                    pointFormat:
                        type === 'pie'
                            ? '{point.name}: <b>{point.y}</b>'
                            : '{series.name}: <b>{point.y}</b>',
                },
                credits: { enabled: false },
                exporting: { enabled: true },
            });
        }

        // Function to hide the table
        function hideTable() {
            const detailsSection = document.getElementById('detailsSection');
            if (detailsSection) {
                detailsSection.innerHTML = ''; // Clear the content of the section
            }
        }


        function displayDetails(selectedData) {
            let detailsSection = document.getElementById('detailsSection');
            if (!detailsSection) {
                detailsSection = document.createElement('div');
                detailsSection.id = 'detailsSection';
                detailsSection.className = 'mt-4';
                document.body.appendChild(detailsSection);
            }

            // Parse `kpis` if it's a string
            let kpis;
            if (typeof selectedData.kpis === 'string') {
                kpis = JSON.parse(selectedData.kpis);
            } else {
                kpis = selectedData.kpis;
            }

            const rowsPerPage = 5; // Number of rows per page
            let currentPage = 1; // Current page

            // Function to render table with pagination
            function renderTable(page = 1) {
                const startIndex = (page - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;
                const paginatedData = kpis.slice(startIndex, endIndex);

                // Generate table rows
                const rowsHtml = paginatedData
                    .map(
                        kpi => `
                        <tr>
                            <td>${kpi.name}</td>
                            <td class="text-center">${kpi.target.toFixed(2)}</td>
                            <td class="text-center">${kpi.achievement}</td>
                            <td class="text-center">
                                <span class="badge ${
                                    kpi.status === 'achieved'
                                        ? 'bg-success'
                                        : kpi.status === 'pending'
                                        ? 'bg-warning text-dark'
                                        : 'bg-danger'
                                }">${kpi.status}</span>
                            </td>
                        </tr>`
                    )
                    .join('');

                // Render table
                const tableHtml = `
                    <div class="card shadow-sm rounded fade-in">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">KPI Details for: ${selectedData.name}</h5>
                            <button id="hideTableButton" class="btn btn-sm btn-light">Hide Table</button>
                        </div>
                        <div class="card-body p-4">
                            <table class="table table-hover table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>KPI Name</th>
                                        <th class="text-center">Target</th>
                                        <th class="text-center">Achievement</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rowsHtml}
                                </tbody>
                            </table>
                            ${renderPagination()}
                        </div>
                    </div>
                `;

                detailsSection.innerHTML = tableHtml;

                // Attach event listener to the Hide Table button
                const hideButton = document.getElementById('hideTableButton');
                hideButton.addEventListener('click', hideTable);

                // Attach event listeners for pagination
                const paginationButtons = document.querySelectorAll('.pagination-button');
                paginationButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const page = parseInt(this.dataset.page);
                        currentPage = page;
                        renderTable(page);

                        // Scroll smoothly to the table on page change
                        detailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });

                // Scroll smoothly to the table when it is rendered
                detailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            // Function to render pagination controls
            function renderPagination() {
                const totalPages = Math.ceil(kpis.length / rowsPerPage);

                if (totalPages <= 1) return ''; // No need for pagination

                let paginationHtml = '<nav class="bg-white"><ul class="pagination justify-content-center">';

                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <button class="page-link pagination-button" data-page="${i}">${i}</button>
                        </li>`;
                }

                paginationHtml += '</ul></nav>';
                return paginationHtml;
            }

            // Initial render
            renderTable(currentPage);
        }

        initializeChart();       
    });

    document.addEventListener('DOMContentLoaded', function () {
        const kpiData = @json($kpiBahagianData);

        if (!kpiData || kpiData.length === 0) {
            console.error('No data available to display.');
            return;
        }

        const chartData = kpiData.map(item => ({
            name: item.name,
            y: parseInt(item.total_kpi) || 0
        }));
        
        
        Highcharts.chart('kpiSummaryPie', {
            chart: {
                type: 'pie',
                borderColor: '#000', // Adds black border
                borderWidth: 2, // Sets border width
                spacing: [10, 10, 15, 10], // Adds spacing inside the border
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                },
            },
            title: {
                text: 'KPI Summary',
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f} %',
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold'
                        },
                        distance: 20
                    },
                    point: {
                        events: {
                            click: function () {
                                const status = this.name.toLowerCase().trim(); // Status: Achieved, Pending, Not Achieved
                                fetchKpiByStatus(status);
                            }
                        }
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                type: 'pie',
                name: 'Total KPI',
                data: [
                    { name: 'Achieved', y: {{ $achievedPercentage }}, color: '#4caf50' },
                    { name: 'Pending', y: {{ $pendingPercentage }}, color: '#ffcc02' },
                    { name: 'Not Achieved', y: {{ $notAchievedPercentage }}, color: '#f44336' }
                ]
            }],
            credits: { enabled: false }
        });

        // Fetch KPIs based on status via AJAX
        function fetchKpiByStatus(status) {
            $.ajax({
                url: `/Dashboard/SuperAdmin`, // Replace this with your route
                method: 'GET',
                data: { status: status },
                success: function (response) {
                    displayKpiDetails(response);
                },
                error: function (xhr, status, error) {
                    console.error(`Error fetching ${status} KPI details:`, error);
                }
            });
        }

        // Display KPI Details
        function displayKpiDetails(data) {
            const detailsSection = document.getElementById('detailsSection');
            detailsSection.innerHTML = ''; // Clear existing data

            if (!Array.isArray(data)) {
                data = Object.values(data);
            }

            if (!data.length) {
                detailsSection.innerHTML = '<p>No KPI details available for this status.</p>';
                return;
            }

            const tableHtml = `
               <table class="table table-bordered table-striped mt-2 text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>KPI Name</th>
                            <th>Target</th>
                            <th>Achievement</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.map(item => `
                            <tr>
                                <td>${item.pernyataan_kpi}</td>
                                <td>${item.sasaran}</td>
                                <td>${item.pencapaian}</td>
                                <td>
                                    <span class="badge ${item.status === 'achieved' ? 'bg-success' : 'bg-danger'}">
                                        ${item.status === 'achieved' ? 'achieved' : 'not achieved'}
                                    </span>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;

            detailsSection.innerHTML = tableHtml;
        }

    });
</script>
@endsection