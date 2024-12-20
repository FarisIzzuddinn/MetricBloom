{{-- view button  --}}
<button class="btn btn-info btn-sm" onclick="viewKpiDetails({{ json_encode($addKpi) }})">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
        <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
    </svg>
</button>

 {{-- modal display detail kpi  --}}
 <div class="modal fade" id="kpiDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">KPI Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Teras</strong></td>
                            <td id="kpiTeras"></td>
                        </tr>
                        <tr>
                            <td><strong>Sektor</strong></td>
                            <td id="kpiSektor"></td>
                        </tr>
                        <tr>
                            <td><strong>KPI Statement</strong></td>
                            <td id="kpiStatement"></td>
                        </tr>
                        <tr>
                            <td><strong>PDF File</strong></td>
                            <td id="kpiPdf"></td>
                        </tr>
                        <tr>
                            <td><strong>States</strong></td>
                            <td>
                                <ul id="kpiStates" class="mb-0"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Institutions</strong></td>
                            <td>
                                <ul id="kpiInstitutions" class="mb-0"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Bahagian</strong></td>
                            <td>
                                <ul id="kpiBahagian" class="mb-0"></ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
     // display details kpi function 
     function viewKpiDetails(kpi) {
        // Populate KPI Statement
        document.getElementById('kpiTeras').textContent = kpi.teras 
            ? kpi.teras.teras || 'N/A' 
            : 'No Teras Found';

        // Check and display Sector (SO) name
        document.getElementById('kpiSektor').textContent = kpi.sector 
            ? kpi.sector.name || 'N/A' 
            : 'No Sector Found';

        document.getElementById('kpiStatement').textContent = kpi.pernyataan_kpi || 'N/A';

        // Populate PDF File
        document.getElementById('kpiPdf').innerHTML = kpi.pdf_file_path 
            ? `<a href="/storage/${kpi.pdf_file_path}" target="_blank">Download PDF</a>` 
            : 'No PDF';

        // Populate States
        const kpiStates = kpi.states || [];
        const statesList = document.getElementById('kpiStates');
        statesList.innerHTML = kpiStates.length 
            ? kpiStates.map(state => `<li>${state.name}</li>`).join('')
            : '<li>No States Assigned</li>';

        // Populate Institutions
        const kpiInstitutions = kpi.institutions || [];
        const institutionsList = document.getElementById('kpiInstitutions');
        institutionsList.innerHTML = kpiInstitutions.length 
            ? kpiInstitutions.map(institution => `<li>${institution.name}</li>`).join('')
            : '<li>No Institutions Assigned</li>';

        // Populate Bahagian
        const kpiBahagians = kpi.bahagians || [];
        const bahagianList = document.getElementById('kpiBahagian');
        bahagianList.innerHTML = kpiBahagians.length 
            ? kpiBahagians.map(bahagian => `<li>${bahagian.nama_bahagian}</li>`).join('')
            : '<li>No Bahagian Assigned</li>';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('kpiDetailsModal'));
        modal.show();
    }
</script>