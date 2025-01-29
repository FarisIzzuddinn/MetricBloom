@extends('layout')
@section('content')


    @include('alert')
    
    @foreach ($kpis as $kpi)
        <div>{{ $kpi->kpi_name }}</div>
    @endforeach



@endsection



