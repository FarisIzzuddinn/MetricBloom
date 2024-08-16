@extends('layout')
@section('title', 'Keselamatan Inteligen')
@section('body')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<body>
@include('sidebar')
<div class="container">
      <div class="main">
          <main class="content px-3 py-4">
              <div class="container-fluid">
                  <div class="mb-3">
                      <h3 class="fw-bold fs-4 mb-3">Sektor Keselamatan</h3><br>

                      <h3 class="fw-bold fs-4 my-3 ki">Keselamatan Inteligen</h3>
                      
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

                      <h3 class="fw-bold fs-4 my-3 ki">Institutions</h3>
                      <div class="row">
                        <div class="col-12">
                          <table class="table table-striped">
                            <thead>
                                <tr class="highlight">
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">State</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($institutions as $institution)
                                <tr>
                                    <td>{{ $institution->id }}</td>
                                    <td>{{ $institution->name }}</td>
                                    <td>{{ $institution->state }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
                      
                  </div>
              </div>
          </main>
      </div>
  </div>
  <script>
   const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function () {
      document.querySelector("#sidebar").classList.toggle("expand");
    });
  </script>
@endsection





