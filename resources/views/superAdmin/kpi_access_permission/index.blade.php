@extends('layout')
@section('content')
@include('alert')

<style>





</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-1">Manage KPI Access</h1>
            <p class="text-muted">
                Assign KPI permissions to users with the "Viewer" role and manage existing access.
            </p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Assign KPI Access Section -->
        <div class="col-md-12 col-lg-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-key me-2"></i> Assign KPI Access</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('accessKpi.store') }}">
                        @csrf

                        <!-- KPI Selection -->
                        <div class="mb-3">
                            <label for="kpi" class="form-label fw-semibold">Choose KPI</label>
                            <div class="input-group">
                                <select name="kpi_id" id="kpi" class="form-select kpi-select2" required>
                                    <option value="" disabled selected>Select KPI...</option>
                                    @foreach($allKpi as $kpi)
                                        <option value="{{ $kpi->id }}">{{ $kpi->pernyataan_kpi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- User Selection -->
                        <div class="mb-3">
                            <label for="user" class="form-label fw-semibold">Choose User</label>
                            <div class="input-group">
                                <select name="user_id" id="user" class="form-select user-select2" required>
                                    <option value="" disabled selected>Select User...</option>
                                    @foreach($userWithRoleViewer as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-check-circle me-2"></i> Grant Access
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current KPI Access Section -->
        <div class="col-md-12 col-lg-7">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-check me-2"></i> Active KPI Access
                    </h5>
                </div>
        
                <!-- Filter Section -->
                <div class="card-body pb-0">
                    <form method="GET" action="{{ route('accessKpi.filter') }}" class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search_kpi" class="form-control" placeholder="Search KPI..." value="{{ request('search_kpi') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="user_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach($userWithRoleViewer as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-success w-50"><i class="bi bi-filter"></i> Filter</button>
                            <a href="{{ route('accessKpi') }}" class="btn btn-secondary w-50"><i class="bi bi-x-circle"></i> Reset</a>
                        </div>
                    </form>
                </div>
        
                <!-- KPI Access Table -->
                <div class="card-body">
                    @if($currentKpiAccess->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-emoji-frown fs-1"></i>
                            <p class="mt-2">No KPI access assigned yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 40%">KPI</th>
                                        <th>User</th>
                                        <th>Granted On</th>
                                        <th>Assigned By</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currentKpiAccess as $access)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-wrap" style="max-width: 250px;">{{ $access->kpi->pernyataan_kpi }}</td>
                                            <td>{{ $access->user->name }}</td>
                                            <td>{{ $access->created_at->format('d M Y, h:i A') }}</td>
                                            <td>{{ $access->assignedBy ? $access->assignedBy->name : 'N/A' }}</td> 
                                            <td class="text-center">
                                                <form method="POST" action="{{ route('accessKpi.destroy', $access->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $currentKpiAccess->links('pagination::bootstrap-5') }}
                        </div>                  
                    @endif
                </div>
            </div>
        </div>        
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".kpi-select2, .user-select2").select2({
            placeholder: "Select an option...",
            allowClear: true,
            width: '100%',
            templateResult: function(option) {
                if (!option.id) return option.text;
                let text = option.text.length > 200 ? option.text.match(/.{1,80}/g).join('<br>') : option.text;
                return $('<span>' + text + '</span>');
            }
        });
    });
</script>

@endsection
