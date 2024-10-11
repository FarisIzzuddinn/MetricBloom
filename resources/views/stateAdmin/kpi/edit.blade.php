@extends('layout')

@section('content')
<h1>Edit KPI Assignment</h1>
<form action="{{ route('admin-state-kpis.update', $kpiAssignment->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="kpi_id">KPI</label>
        <select name="kpi_id" class="form-control" required>
            @foreach ($kpis as $kpi)
                <option value="{{ $kpi->id }}" {{ $kpiAssignment->kpi_id == $kpi->id ? 'selected' : '' }}>{{ $kpi->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="institution_id">Institution</label>
        <select name="institution_id" class="form-control" required>
            @foreach ($institutions as $institution)
                <option value="{{ $institution->id }}" {{ $kpiAssignment->institution_id == $institution->id ? 'selected' : '' }}>{{ $institution->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update KPI Assignment</button>
</form>
@endsection
