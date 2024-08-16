@extends('layout')
@section('title', 'Dashboard')
@section('body')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    .status-kuning {
        background-color: yellow;
    }
    .status-hijau {
        background-color: green;
    }
    .status-merah {
        background-color: red;
    }

    .kpi-statement {
        white-space: pre-wrap; /* Membolehkan pembalut perkataan */
        word-wrap: break-word; /* Membolehkan perkataan panjang untuk membalut */
        max-width: 300px; /* Tetapkan lebar maksimum yang sesuai */
    }
</style>
@include('sidebar')
<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Key Performance Index(KPI)</h3>
                <div class="custom-bg-white border border-grey border-2 p-3 rounded shadow"> 
                    <div class="table-responsive table-responsive-sm">
                        <table class="table mt-3 p-3">
                            <thead>
                                <tr class="border border-dark table-success text-start">
                                    {{-- <th>Bil</th> --}}
                                    <th>Teras</th>
                                    <th>SO</th>
                                    <th>Negeri</th>
                                    <th>Pemilik</th>
                                    <th>KPI</th>
                                    <th>Penyataan KPI</th>
                                    <th>Sasaran</th>
                                    <th>Jenis Sasaran</th>
                                    <th>Pencapaian</th>
                                    <th>Peratus Pencapaian</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kpis as $index => $kpi)
                                <tr class="border table-light border-dark">
                                        {{-- <td>{{ $index + 1 }}</td> --}}
                                        <td>{{ $kpi->teras }}</td>
                                        <td>{{ $kpi->so }}</td>
                                        <td>{{ $kpi->negeri }}</td>
                                        <td>{{ $kpi->pemilik }}</td>
                                        <td>{{ $kpi->kpi }}</td>
                                        <td class="kpi-statement">{{ $kpi->penyataan_kpi }}</td>
                                        <td>{{ $kpi->sasaran }}</td>
                                        <td>{{ $kpi->jenis_sasaran }}</td>
                                        <td>{{ $kpi->pencapaian }}</td>
                                        <td>{{ number_format($kpi->peratus_pencapaian, 2) }}</td>
                                        <td class="status-{{ strtolower($kpi->status) }}">{{ $kpi->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody>
                                @foreach ($addKpis as $addKpi)
                                    <tr class="border table-light border-dark">
                                        <td>{{ $addKpi->teras }}</td>
                                        <td>{{ $addKpi->SO }}</td>
                                        <td>{{ $addKpi->negeri }}</td>
                                        <td>{{ $addKpi->pemilik }}</td>
                                        <td>{{ $addKpi->pernyataan_kpi }}</td>
                                        <td>{{ $addKpi->sasaran }}</td>
                                        <td>{{ $addKpi->jenis_sasaran }}</td>
                                        <td>{{ $addKpi->pencapaian }}</td>
                                        <td>{{ number_format($addKpi->peratus_pencapaian, 2) }}</td>
                                        <td class="status-{{ strtolower($addKpi->status) }}">{{ $addKpi->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="text-end">Peratus Pencapaian Keseluruhan: <strong>{{ number_format($overallAchievement, 2) }}</strong></p>
                    </div> 
                </div>
            </div>
        </main>
    </div>
</div>      

@endsection
