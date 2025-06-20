@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Teras" />

            @include('admin.teras.create')
        </div>
    </div>

    <div id="tableView" class="card-body">
        <div class="table-responsive">
            <table class="table" id="terasTable" style="border-collapse: collapse; border-radius: 0px; border: 0.5px solid #ccc;">
                <thead>
                    <tr class="table-secondary">
                        <th>Bil.</th>
                        <th>Teras</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teras as $index => $tera)
                        <tr>
                            <td>{{ ($teras->currentPage() - 1) * $teras->perPage() + $loop->iteration }}</td>
                            <td>{{ $tera->name }}</td>
                            <td>
                                <div class="d-flex">
                                    @include('admin.teras.edit')
                                    @include('admin.teras.delete')
                                </div>  
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Tiada Teras Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4 pagination-container">
            {{ $teras->links() }}
        </div>
    </div>
</div>

@include('toast-notification')

@endsection
