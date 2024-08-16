@extends('layout')
@section('title', 'Pengurusan Banduan')
@section('body')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<body>
  <div class="wrapper">
      <aside id="sidebar">
          <div class="d-flex">
              <button class="toggle-btn" type="button">
                  <i class="lni lni-world"></i>
              </button>
              <div class="sidebar-logo">
                  <a href="#">JABATAN PENJARA MALAYSIA</a>
              </div>
          </div>
          <ul class="sidebar-nav">
              <li class="sidebar-item">
                  <a href="/home" class="sidebar-link">
                      <i class="lni lni-dashboard"></i>
                      <span>Dashboard</span>
                  </a>
              </li>
              <li class="sidebar-item">
                  <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                      data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                      <i class="lni lni-grid-alt"></i>
                      <span>View KPI</span>
                  </a>
                  <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                              data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                              <i class="lni lni-protection"></i>
                              Sektor Keselamatan
                          </a>
                          <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                              <a href="/KeselamatanKoreksional/KeselamatanInteligen" class="sidebar-link">Keselamatan Inteligen</a>
                            </li>
                            <li class="sidebar-item">
                              <a href="/KeselamatanKoreksional/PengurusanBanduan" class="sidebar-link">Pengurusan Banduan</a>
                            </li>
                            <li class="sidebar-item">
                              <a href="/KeselamatanKoreksional/TahananRadikal" class="sidebar-link">Tahanan Radikal</a>
                            </li>
                          </ul>
                      </li>
                  </ul>
              </li>
              <li class="sidebar-item">
                  <a href="#" class="sidebar-link">
                      <i class="lni lni-popup"></i>
                      <span>Notification</span>
                  </a>
              </li>
              <li class="sidebar-item">
                  <a href="#" class="sidebar-link">
                      <i class="lni lni-cog"></i>
                      <span>Setting</span>
                  </a>
              </li>
          </ul>
          <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>    
      </aside>
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
  </div>
  <script>
   const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function () {
      document.querySelector("#sidebar").classList.toggle("expand");
    });
  </script>
@endsection





