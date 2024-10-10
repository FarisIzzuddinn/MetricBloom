@extends('layout')

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

<a href="{{ route('admin-institution-kpis.create') }}" class="btn btn-primary mb-3">Assign New KPI</a>

<table class="table">
    <thead>
        <tr>
            <th>KPI</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kpis as $kpi)
        <tr>
            <td>{{ $kpi->pernyataan_kpi }}</td>
            <td> @if($kpi->users->isNotEmpty())
                @foreach ($kpi->users as $user)
                    {{ $user->name }}@if(!$loop->last), @endif
                @endforeach
            @else
                No users assigned
            @endif</td>
            
            <td>
                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $kpi->id }}" data-name="{{ $kpi->pernyataan_kpi }}" data-institutions="{{ json_encode($kpi->institutions->pluck('id')) }}">
                    Edit
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-name="{{ $kpi->pernyataan_kpi }}" data-url="{{ route('admin-state-kpis.destroy', $kpi->id) }}">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
