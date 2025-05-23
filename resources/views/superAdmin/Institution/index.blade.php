@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Institusi" />

            @include('superAdmin.Institution.create')
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="filter-section mb-4">
        <div class="row d-flex align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Carian Institusi...">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select class="form-select" id="stateFilter">
                    <option value="">All States</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12 d-md-block d-none">
                <button id="resetFilters" class="btn btn-outline-secondary w-100">Set Semula</button>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="card-body">
        <div class="table-responsive">
            <table class="table" id="institutionsTable">
                <thead>
                    <tr class="table-secondary">
                        <th>Bil</th>
                        <th>Nama</th>
                        <th>Negeri</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($institutions as $index => $institution)
                        <tr class="institution-item" data-state="{{ $institution->state_id }}" data-name="{{ $institution->name }}">
                            <td>{{ ($institutions->currentPage() - 1) * $institutions->perPage() + $loop->iteration }}</td>
                            <td>{{ $institution->name }}</td>
                            <td>
                                @if($institution->state)
                                    {{ $institution->state->name }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @include('superAdmin.Institution.edit')
                                    @include('superAdmin.Institution.delete')
                                </div>
                            </td>
                        </tr>

                        
                    @endforeach
                </tbody>
            </table>
            <div id="emptyMessage" class="alert alert-info mt-3" style="display: none;">
                Tiada institusi sepadan dengan kriteria carian anda.
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4 pagination-container">
            {{ $institutions->links() }}
        </div>
    </div>
</div>

@include('toast-notification')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const stateFilter = document.getElementById('stateFilter');
        const institutionItems = document.querySelectorAll('.institution-item');
        const resetButton = document.getElementById('resetFilters');
        const emptyMessage = document.getElementById('emptyMessage');

        function filterInstitutions() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedState = stateFilter.value;
            let visibleCount = 0;

            institutionItems.forEach(item => {
                const institutionName = item.getAttribute('data-name').toLowerCase();
                const institutionState = item.getAttribute('data-state');
                const nameMatch = institutionName.includes(searchTerm);
                const stateMatch = selectedState === '' || institutionState === selectedState;

                if (nameMatch && stateMatch) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide empty message
            emptyMessage.style.display = visibleCount === 0 ? 'block' : 'none'; 
        }

        searchInput.addEventListener('keyup', filterInstitutions);
        searchButton.addEventListener('click', filterInstitutions);
        stateFilter.addEventListener('change', filterInstitutions);
        resetButton.addEventListener('click', resetFilters);

        // Delete modal functionality
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const institutionId = button.getAttribute('data-permission-id');
                const institutionName = button.getAttribute('data-permission-name');

                document.getElementById('deletePermissionName').textContent = institutionName;
                document.getElementById('deletePermissionForm').action = `/institutions/${institutionId}`;
            });
        }

        function resetFilters() {
            // Clear search input
            searchInput.value = '';
            
            // Reset state filter to default (empty/all)
            stateFilter.value = '';
            
            // Re-filter institutions to show all
            filterInstitutions();
        }

        // Initialize responsive table behavior
        const tableContainer = document.querySelector('.table-responsive');
        if (tableContainer) {
            const handleResize = () => {
                const table = tableContainer.querySelector('table');
                if (window.innerWidth < 768 && table) {
                    table.classList.add('table-sm');
                } else if (table) {
                    table.classList.remove('table-sm');
                }
            };
            
            // Run on load and resize
            handleResize();
            window.addEventListener('resize', handleResize);
        }
    });
</script>
@endsection