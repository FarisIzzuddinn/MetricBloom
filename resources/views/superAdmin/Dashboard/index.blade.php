@extends('layout')

@section('content')

Display Global KPI 
<div class="row">
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-primary text-white">
            <div class="card-header">Total KPIs</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-success text-white">
            <div class="card-header">Achieved</div>
            <div class="card-body">
                <h5 class="card-title">{{ $achievedKpis }}</h5>
            </div>
        </div>
    </div> 
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-warning text-white">
            <div class="card-header">Pending</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pendingKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-info text-white">
            <div class="card-header">Average Achievement</div>
            <div class="card-body">
                <h5 class="card-title">{{ $averageAchievement }}%</h5>
            </div>
        </div>
    </div>
</div>

{{-- User Institution Summary
<div class="card mt-4 bg-light shadow-sm border-0">
    <div class="card-body p-4">
        <h5 class="card-title text-primary mb-4">User & Institution Summary</h5>
        <div class="row text-center">
            <!-- Top Institutions -->
            <div class="col-md-4">
                <div class="card p-3 border-0 bg-white rounded shadow-sm">
                    <h6 class="card-subtitle mb-2 text-muted">Top Institutions</h6>
                    <ul class="list-unstyled">
                        <li class="py-2"><i class="bi bi-star text-success"></i> Institution 1</li>
                        <li class="py-2"><i class="bi bi-star text-success"></i> Institution 2</li>
                    </ul>
                </div>
            </div>
            <!-- Underperforming Institutions -->
            <div class="col-md-4">
                <div class="card p-3 border-0 bg-white rounded shadow-sm">
                    <h6 class="card-subtitle mb-2 text-muted">Underperforming Institutions</h6>
                    <ul class="list-unstyled">
                        <li class="py-2"><i class="bi bi-exclamation-circle text-danger"></i> Institution 3</li>
                        <li class="py-2"><i class="bi bi-exclamation-circle text-danger"></i> Institution 4</li>
                    </ul>
                </div>
            </div>
            <!-- Active Users -->
            <div class="col-md-4">
                <div class="card p-3 border-0 bg-white rounded shadow-sm">
                    <h6 class="card-subtitle mb-2 text-muted">Active Users</h6>
                    @foreach ($roles as $role)
                        <p class="mb-1"><i class="bi bi-person-badge text-primary"></i> {{ $role->name }} : <span class="font-weight-bold">{{ $role->users_count}}</span></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}

  

@endsection