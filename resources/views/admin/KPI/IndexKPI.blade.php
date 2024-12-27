@extends('layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<div class="container-fluid">
    <div class="row">
        <div class="head-title mb-4">
            <div class="left">
                <h1 class="text-dark">KPI Management</h1>
                <ul class="breadcrumb">
                    <li><a href="#" class="text-muted">KPI Management</a></li>
                </ul>
            </div>
            @include('admin.KPI.add')
        </div>

        @include('alert')

        <!-- Check if there are any KPI records -->
        @if($addKpis->isEmpty())
            <div class="alert alert-warning mt-3" role="alert">
                No KPI data available.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered mt-0 p-0">
                    <thead class="table-light">
                        <tr>
                            <th class="small-text text-secondary">BIL</th>
                            <th class="small-text text-secondary">KPI</th>
                            <th class="small-text text-secondary">PDF</th>
                            <th class="small-text text-secondary">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addKpis as $addKpi)
                            <tr>
                                <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                                <td class="small-text kpi-statement">{{ $addKpi->pernyataan_kpi }}</td>
                                <td>
                                    @if($addKpi->pdf_file_path)
                                        @php
                                            // Extract the file name from the file path
                                            $fileName = basename($addKpi->pdf_file_path);
                                        @endphp
                                        
                                        <!-- Inline SVG for PDF Icon -->
                                        <a href="{{ url('/storage/' . $addKpi->pdf_file_path) }}" target="_blank" class="d-flex align-items-center text-decoration-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf me-2" viewBox="0 0 16 16" style="color: #d9534f;">
                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                            </svg>
                                            {{ $fileName }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @include('admin.KPI.edit')
                                    @include('admin.KPI.read')
                                    @include('admin.KPI.delete')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-container colors" style="background-color: transparent;">
                {{ $addKpis->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editKpiModal = document.getElementById('editKpi');
        editKpiModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const modal = event.target; // Modal being shown

            // Retrieve data attributes
            const kpiId = button.getAttribute('data-kpi-id');
            const terasId = button.getAttribute('data-teras-id');
            const sectorsId = button.getAttribute('data-sectors-id');
            const pernyataan = button.getAttribute('data-pernyataan');
            const sasaran = button.getAttribute('data-sasaran');
            const jenisSasaran = button.getAttribute('data-jenis-sasaran');
            const owners = JSON.parse(button.getAttribute('data-owners') || '[]'); // Fallback to empty array

            // Log the data to the console for debugging
            console.log('KPI ID:', kpiId);  // This should print the correct kpi_id

            // Populate modal fields
            modal.querySelector('#editTeras').value = terasId;
            modal.querySelector('#editSO').value = sectorsId;
            modal.querySelector('#editPernyataanKpi').value = pernyataan;
            modal.querySelector('[name="sasaran"]').value = sasaran;
            modal.querySelector('[name="jenis_sasaran"]').value = jenisSasaran;

            // Set the correct kpi_id in the hidden field
            modal.querySelector('#editKpiId').value = kpiId;

            // Update the form action URL dynamically to include the correct kpi_id
            const formActionUrl = `/admin/addKpi/update/${kpiId}`; // Correct route URL
            modal.querySelector('form').action = formActionUrl;

            // Clear all owner checkboxes
            const ownerCheckboxes = modal.querySelectorAll('input[name="owners[]"]');
            ownerCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Check the correct owner checkboxes
            owners.forEach(ownerId => {
                const ownerCheckbox = modal.querySelector(`input[name="owners[]"][value="${ownerId}"]`);
                if (ownerCheckbox) {
                    ownerCheckbox.checked = true;
                }
            });
        });
    });
</script>
@endsection
