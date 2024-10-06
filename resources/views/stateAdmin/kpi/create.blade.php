@extends('layoutNoName')

@section('content')
<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<div class="container">
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
</div>
@endsection
