@extends('layout')
@section('content')
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

    #kpiSearch {
    width: 100%;
    max-width: 400px;
    margin-bottom: 15px;
}

#loadingMessage {
    font-size: 16px;
    color: #888;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #ddd;
}

.modal-footer {
    justify-content: space-between;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}
.input-group {
    width: 100%;
    display: flex;
}

.input-group-text {
    height: 200%;
    align-items: center;
    justify-content: center;
    display: flex;
}

.form-control {
    flex: 1;
    min-width: 0; /* Prevent input from growing excessively */
}

</style>

<div class="container-fluid">
    {{-- statistic card  --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-1 bg-primary rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard-check mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg> Total KPI
                    </h5>
                    <h2 class="display-4">{{ $totalKpi }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#kpiDetailsModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-success rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                        </svg>Achieved
                    </h5>
                    <h2 class="display-4">{{ $achievedKpi }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#achievedKpiModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-warning rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hourglass-split mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg>Pending
                    </h5>
                    <h2 class="display-4">{{ $pendingKpi }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
            </div>
        </div>
    
        <div class="col-md-3">
            <div class="card mb-1 bg-danger rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg> Not Achieved
                    </h5>
                    <h2 class="display-4">{{ $notAchievedKpi }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
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

{{-- <!-- Achieved KPI Modal -->
<div class="modal fade" id="achievedKpiModal" tabindex="-1" aria-labelledby="achievedKpiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="achievedKpiModalLabel">Achieved KPIs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="achievedKpiList">
                    <div class="text-center" id="loadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KPI Details Modal -->
<div class="modal fade" id="kpiDetailsModal" tabindex="-1" aria-labelledby="kpiDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="kpiDetailsModalLabel"><i class="bi bi-clipboard-check"></i> All KPIs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3" style="max-width: 100%;">
                            <span class="input-group-text bg-light" id="basic-addon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                id="kpiSearch" 
                                class="form-control" 
                                placeholder="Search KPI by title..." 
                                aria-label="Search KPIs"
                                aria-describedby="basic-addon1"
                            />
                        </div>
                    </div>
                </div>
                

                <!-- Display Paginated KPIs -->
                <div id="kpiListContainer">
                    <!-- Dynamic KPIs will be injected here -->
                    <div class="text-center py-4">
                        <div id="loadingSpinner" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Fetching KPIs, please wait...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
//    function fetchAchievedKpis() {
//         $.ajax({
//             url: '/achieved-kpis', // Make sure this URL matches your route
//             type: 'GET',
//             success: function (data) {
//                 if (data.length === 0) {
//                     $('#kpiListContainer').html('<p>No achieved KPIs found.</p>');
//                 } else {
//                     let html = '';
//                     data.forEach(kpi => {
//                         html += `<li class="list-group-item">
//                                     <strong>${kpi.pernyataan_kpi}</strong>
//                                     <p>Status: ${kpi.status}</p>
//                                 </li>`;
//                     });
//                     $('#kpiListContainer').html(`<ul class="list-group">${html}</ul>`);
//                 }
//             },
//             error: function (xhr) {
//                 console.error('Error fetching achieved KPIs:', xhr.responseText);
//                 $('#kpiListContainer').html('<p class="text-danger">Failed to load data.</p>');
//             }
//         });
//     }

//     $(document).ready(function() {
//         // When the modal opens
//         $('#kpiDetailsModal').on('show.bs.modal', function () {
//             loadKpis(); // Call the function to load the KPIs
//         });

//         // Function to load the KPIs via AJAX
//         function loadKpis(page = 1, searchQuery = '') {
//             $.ajax({
//                 url: '/kpis/all', // Ensure the correct URL for this route
//                 method: 'GET',
//                 data: {
//                     page: page, // Pass the page for pagination
//                     search: searchQuery // Pass the search query
//                 },
//                 beforeSend: function() {
//                     $('#kpiListContainer').html('<p>Loading KPIs...</p>');
//                 },
//                 success: function(response) {
//                     // Inject the HTML response into the container
//                     $('#kpiListContainer').html(response);
//                 },
//                 error: function() {
//                     $('#kpiListContainer').html('<p>Error loading KPIs.</p>');
//                 }
//             });
//         }

//         // Handle Search Functionality
//         $('#kpiSearch').on('input', function() {
//             var query = $(this).val();
//             loadKpis(1, query); // Reset to page 1 and apply the search query
//         });

//         // Handle Pagination (if required)
//         $(document).on('click', '.pagination a', function (e) {
//             e.preventDefault();
//             var page = $(this).attr('href').split('page=')[1];
//             loadKpis(page); // Call the function with the selected page number
//         });
//     });

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
                </table>`;
            detailsSection.innerHTML = tableHtml;
        }
    });
</script>
@endsection