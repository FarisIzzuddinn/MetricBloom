@extends('layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<div class="">
    <div class="head-title mb-3">
        <div class="left">
            <h1>KPI Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('stateAdmin.dashboard')}}">KPI Management</a>
                </li>/
                <li>
                    <a href="">Create</a>
                </li>
            </ul>
        </div>
    </div>

    <form action="{{ route('stateAdmin.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="kpi">Select KPI:</label>
            <select name="kpi_id" class="form-control" required>
                @foreach($kpis as $kpi)
                    <option value="{{ $kpi->id }}">{{ $kpi->pernyataan_kpi }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="institution">Select Institution:</label>
            <select name="institution_id" class="form-control" required>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Assign KPI To Institution</button>
    </form>

    <!-- Modal for Duplicate Assignment Alert -->
    @if ($errors->any())
    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateModalLabel">Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $errors->first('msg') }} <!-- Mesej amaran -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Script untuk memaparkan modal jika ada kesalahan -->
<script>
    $(document).ready(function() {
        @if ($errors->any())
            $('#duplicateModal').modal('show');
        @endif
    });
</script>

@endsection
