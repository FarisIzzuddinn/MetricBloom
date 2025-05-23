@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Teras" />

            @include('admin.teras.create')
        </div>
    </div>

     <!-- Filter and Search Section -->
     <div class="filter-section mb-4">
        <div class="row d-flex align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Carian Teras...">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
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
                        <th>Bil.</th>
                        <th>Teras</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teras as $index => $tera)
                        <tr>
                            <td>{{ ($teras->currentPage() - 1) * $teras->perPage() + $loop->iteration }}</td>
                            <td>{{ $tera->teras }}</td>
                            <td>
                                <div class="d-flex">
                                    @include('admin.teras.edit')
                                    @include('admin.teras.delete')
                                </div>  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="emptyMessage" class="alert alert-info mt-3" style="display: none;">
                Tiada teras sepadan dengan kriteria carian anda.
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4 pagination-container">
            {{ $teras->links() }}
        </div>
    </div>
</div>

@include('toast-notification')

<script>
    function setEditModal(terasName, updateUrl) {
        // Set the Teras name in the input field
        document.getElementById('editTerasName').value = terasName;

        // Update the form action URL to match the correct update route
        document.getElementById('editForm').setAttribute('action', updateUrl);
    }

    function setDeleteModal(terasName, deleteUrl) {
        // Set the Teras name in the modal for confirmation
        document.getElementById('deleteTerasName').textContent = terasName;

        // Update the delete form action with the correct URL
        document.getElementById('deleteTerasForm').setAttribute('action', deleteUrl);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const searchButton = document.getElementById("searchButton");
        const resetFilters = document.getElementById("resetFilters");
        const tableRows = document.querySelectorAll("#institutionsTable tbody tr");
        const emptyMessage = document.getElementById("emptyMessage");

        function filterTable() {
            let searchValue = searchInput.value.toLowerCase();
            let found = false;

            tableRows.forEach(row => {
                let terasName = row.children[1].textContent.toLowerCase(); // Get the 'Teras' column
                if (terasName.includes(searchValue)) {
                    row.style.display = ""; // Show matching rows
                    found = true;
                } else {
                    row.style.display = "none"; // Hide non-matching rows
                }
            });

            // Show/hide the empty message based on results
            emptyMessage.style.display = found ? "none" : "block";
        }

        // Search Button Click Event
        searchButton.addEventListener("click", filterTable);

        // Input Field Keyup Event (Live Search)
        searchInput.addEventListener("keyup", filterTable);

        // Reset Button Click Event
        resetFilters.addEventListener("click", function() {
            searchInput.value = ""; // Clear search field
            tableRows.forEach(row => row.style.display = ""); // Show all rows
            emptyMessage.style.display = "none"; // Hide empty message
        });
    });
</script> 

@endsection
