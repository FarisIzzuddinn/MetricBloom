@extends('layout')
@section('title', 'Pengurusan Banduan')
@section('body')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

@include('sidebar')
      <div class="main">
          <main class="content px-3 py-4">
              <div class="container-fluid">
                  <div class="mb-3">
                      <h3 class="fw-bold fs-4 mb-3">Sektor Keselamatan</h3><br>

                      <h3 class="fw-bold fs-4 my-3 ki">Pengurusan Banduan</h3>
                      
                      <div class="row">
                        <div class="col-12">
                          <table class="table table-striped">
                            <thead>
                                <tr class="highlight">
                                    <th scope="col">Kod</th>
                                    <th scope="col">Tajuk KPI</th>
                                    <th scope="col">Sasaran KPI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->Kod }}</td>
                                    <td>{{ $item->Tajuk_KPI }}</td>
                                    <td>{{ $item->Sasaran_KPI }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>

                  </div>
              </div>
          </main>
      </div>
@endsection





