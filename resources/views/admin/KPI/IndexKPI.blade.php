@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<div class="container-fluid">
    <div class="row">
        <div class="head-title">
            <div class="left">
                <h1>KPI Management</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">KPI Management</a>
                    </li>
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
                    <thead>
                        <tr>
                            <th class="small-text">BIL</th>
                            <th class="small-text">KPI</th>
                            <th class="small-text">PDF</th>
                            <th class="small-text">ACTION</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addKpis as $addKpi)
                            <tr>
                                <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                                <td class="small-text kpi-statement">{{ $addKpi->pernyataan_kpi }}</td>
                                <td>
                                    @if($addKpi->pdf_file_path)
                                        <a href="{{ url('/storage/' . $addKpi->pdf_file_path) }}" target="_blank">Download PDF</a>
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
