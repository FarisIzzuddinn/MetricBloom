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

    <form id="assignKpiForm" action="{{ route('institutionAdmin.kpi.assign') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="kpi">Select KPI</label>
            <select name="kpi_id" class="form-control" required>
                <option value="">Select a KPI</option>
                @foreach($kpis as $kpi)
                    <option value="{{ $kpi->id }}">{{ $kpi->pernyataan_kpi }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="user_id">Select User (Grouped by Sector)</label>
            <select class="form-control" name="user_id" id="user_id" required>
                <option value="">Select a User</option>
                @foreach ($usersGroupedBySector as $sectorName => $users)
                    <optgroup label="{{ $sectorName }}">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} 
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>        

        <button type="submit" class="btn btn-primary" id="assignKpiButton">Assign KPI To Sector User</button>
    </form>

</div>
@endsection
