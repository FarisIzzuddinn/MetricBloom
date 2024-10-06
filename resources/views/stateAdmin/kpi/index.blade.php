@extends('layoutNoName')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<div class="head-title">
    <div class="left">
        <h1>KPI Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('stateAdmin.dashboard') }}">KPI Management</a>
            </li>
        </ul>
    </div>
</div>

<a href="{{ route('admin-state-kpis.create') }}" class="btn btn-primary mb-3">Assign New KPI</a>

<table class="table">
    <thead>
        <tr>
            <th>KPI</th>
            <th>Institutions</th> <!-- Changed to plural if multiple institutions can be assigned -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kpis as $kpi)
        <tr>
            <td>{{ $kpi->pernyataan_kpi }}</td>
            <td>
                @if ($kpi->institutions->isNotEmpty())
                    @foreach ($kpi->institutions as $institution)
                        {{ $institution->name }}<br> <!-- Display each institution name -->
                    @endforeach
                @else
                    No Institution Assigned
                @endif
            </td>
            <td>
                <a href="{{ route('admin-state-kpis.edit', $kpi->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin-state-kpis.destroy', $kpi->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
