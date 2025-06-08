@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Sektor" />
            @include('admin.SO.create')
        </div>
    </div>

    <div id="tableView" class="card-body">
        <div class="table-responsive">
            <table class="table" id="sectorTable" style="border-collapse: collapse; border-radius: 0px; border: 0.5px solid #ccc;">
                <thead>
                    <tr class="table-secondary">
                        <th>Bil.</th>
                        <th>Sektor</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sectors as $index => $sector)
                        <tr>
                            <td>{{ ($sectors->currentPage() - 1) * $sectors->perPage() + $loop->iteration }}</td>
                            <td>{{ $sector->name }}</td>
                            <td>
                                <div class="d-flex">
                                    @include('admin.SO.edit')
                                    @include('admin.SO.delete')
                                </div> 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Tiada Sektor Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4 pagination-container">
            {{ $sectors->links() }}
        </div>
    </div>
</div>

@include('toast-notification')
@endsection