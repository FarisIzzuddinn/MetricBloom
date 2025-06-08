@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Institusi" />
            @include('superAdmin.Institution.create')
        </div>
    </div>

    <div id="tableView" class="card-body">
        <div class="table-responsive">
            <table class="table" id="institutionsTable" style="border-collapse: collapse; border-radius: 0px; border: 0.5px solid #ccc;">
                <thead>
                    <tr class="table-secondary">
                        <th>Bil</th>
                        <th>Nama</th>
                        <th>Negeri</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($institutions as $index => $institution)
                        <tr>
                            <td>{{ ($institutions->currentPage() - 1) * $institutions->perPage() + $loop->iteration }}</td>
                            <td>{{ $institution->name }}</td>
                            <td>
                                @if($institution->state)
                                    {{ $institution->state->name }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @include('superAdmin.Institution.edit')
                                    @include('superAdmin.Institution.delete')
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-muted" colspan="4">Tiada Institusi Tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4 pagination-container">
            {{ $institutions->links() }}
        </div>
    </div>
</div>

@include('toast-notification')

@endsection