@extends('layout')
@section('content')

@include('alert')

<div class="container-fluid mt-3">
    <div class="row g-4">
        <!-- KPI Summary Cards -->
        @php
            $kpiData = [
                [
                    'title' => 'Total KPI', 
                    'count' => $totalUserKpi, 
                    'bg' => 'primary', 
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16"><path d="M11 0H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM6 3h4v1H6V3z"/></svg>'
                ],
                [
                    'title' => 'Achieved', 
                    'count' => $statusCounts['achieved'], 
                    'bg' => 'success', 
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M16 8a8 8 0 1 0-8 8 8 8 0 0 0 8-8zM8 0a8 8 0 0 1 6.32 3.68l-9.64 9.64a8.02 8.02 0 0 1-.8-3.68A8 8 0 0 1 8 0z"/></svg>'
                ],
                [
                    'title' => 'Pending', 
                    'count' => $statusCounts['pending'], 
                    'bg' => 'warning', 
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16"><path d="M8 0a1 1 0 0 1 1 1v5h6a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9v5a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9H1a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h6V1a1 1 0 0 1 1-1z"/></svg>'
                ],
                [
                    'title' => 'Not Achieved', 
                    'count' => $statusCounts['not achieved'], 
                    'bg' => 'danger', 
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 0 8 8 8 8 0 0 0-8-8zM3.5 8a.5.5 0 0 1 .707-.707L8 9.793l3.793-3.793a.5.5 0 0 1 .707.707L8.707 10.5l3.793 3.793a.5.5 0 0 1-.707.707L8 11.207 4.207 14a.5.5 0 0 1-.707-.707L7.293 10.5 3.5 6.707a.5.5 0 0 1 .707-.707L8 9.793l-3.793-3.793z"/></svg>'
                ]
            ];
        @endphp

        @foreach($kpiData as $data)
        <div class="col-md-3">
            <div class="card bg-{{ $data['bg'] }} text-white shadow-lg rounded-4">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi {{ $data['icon'] }} display-6 me-2"></i>
                        <h6 class="mb-0">{{ $data['title'] }}</h6>
                    </div>
                    <h4 class="display-5 fw-bold mt-2">{{ $data['count'] }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex mt-3">
        <button class="btn btn-success btn-lg shadow-sm border-0 rounded-3 px-2 py-1"
                style="font-weight: bold; transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;"
                onmouseover="this.style.backgroundColor='#45a049'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.15)';"
                onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='translateY(0px)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';"
                onclick="openReportInNewTab()">
            <i class="bi bi-file-earmark-pdf"></i> View KPI Report
        </button>
    </div>
    

    <!-- KPI Tabs -->
    <ul class="nav nav-tabs mt-4" id="kpiTab">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#bahagian">Bahagian</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#state">State</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#institution">Institution</a></li>
    </ul>

    <div class="tab-content mt-3">
        @php
            $sections = [
                ['id' => 'bahagian', 'name' => 'Bahagian', 'data' => $currentKpiAccess, 'relation' => 'bahagians'],
                ['id' => 'state', 'name' => 'State', 'data' => $currentKpiAccess, 'relation' => 'states'],
                ['id' => 'institution', 'name' => 'Institution', 'data' => $currentKpiAccess, 'relation' => 'institutions'],
            ];
        @endphp

        @foreach($sections as $section)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $section['id'] }}">
            <div class="d-flex gap-2 mb-2">
                <input type="text" class="form-control" id="search{{ ucfirst($section['id']) }}" placeholder="Search KPI or Status...">
                <select class="form-select" id="owner{{ ucfirst($section['id']) }}">
                    <option value="">Filter by Owner</option>
                    @foreach ($section['data'] as $access)
                        @foreach ($access->kpi->{$section['relation']} as $owner)
                            <option value="{{ $owner->name }}">{{ $owner->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-light sticky-top">
                        <tr>
                            <th>Bil.</th>
                            <th>KPI</th>
                            <th>Owner</th>
                            <th>Achievement (%)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $section['id'] }}Table">
                        @php $index = 1; @endphp
                        @foreach ($section['data'] as $access)
                            @foreach ($access->kpi->{$section['relation']} as $owner)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $access->kpi->pernyataan_kpi }}</td>
                                    <td class="owner">{{ $owner->name }}</td>
                                    <td>{{ $owner->pivot->peratus_pencapaian }}%</td>
                                    <td>
                                        @if($owner->pivot->status == 'achieved')
                                            <span class="badge bg-success">{{ $owner->pivot->status }}</span>
                                        @elseif($owner->pivot->status == 'pending')
                                            <span class="badge bg-warning">{{ $owner->pivot->status }}</span>
                                        @elseif($owner->pivot->status == 'not achieved')
                                            <span class="badge bg-danger">{{ $owner->pivot->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $owner->pivot->status }}</span> <!-- Default color if status is not one of the expected values -->
                                        @endif
                                    </td>             
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function filterTable(inputId, selectId, tableId) {
        document.getElementById(inputId).addEventListener("keyup", function () {
            applyFilters(inputId, selectId, tableId);
        });

        document.getElementById(selectId).addEventListener("change", function () {
            applyFilters(inputId, selectId, tableId);
        });

        function applyFilters(inputId, selectId, tableId) {
            let searchFilter = document.getElementById(inputId).value.toLowerCase();
            let ownerFilter = document.getElementById(selectId).value.toLowerCase();
            let rows = document.querySelectorAll(`#${tableId} tr`);

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                let owner = row.querySelector(".owner") ? row.querySelector(".owner").innerText.toLowerCase() : "";

                let matchesSearch = text.includes(searchFilter);
                let matchesOwner = ownerFilter === "" || owner.includes(ownerFilter);

                row.style.display = matchesSearch && matchesOwner ? "" : "none";
            });
        }
    }

    filterTable("searchBahagian", "ownerBahagian", "bahagianTable");
    filterTable("searchState", "ownerState", "stateTable");
    filterTable("searchInstitution", "ownerInstitution", "institutionTable");

    // butto generate report
    function openReportInNewTab() {
        // Open the report in a new tab
        window.open("{{ route('viewerReport') }}", "_blank");
    }
</script>

@endsection
