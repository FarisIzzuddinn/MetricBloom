<!-- KPI List total -->
<div class="row">
    @foreach ($kpis as $kpi)
        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary">{{ $kpi->pernyataan_kpi }}</h6>
                    <p class="mb-1"><strong>Target:</strong> {{ $kpi->sasaran }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination Controls -->
<div class="mt-4 text-center">
    {{ $kpis->links('pagination::bootstrap-5') }}
</div>
