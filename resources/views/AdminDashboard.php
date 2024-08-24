<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        #sidebar {
            width: 50px; /* Collapsed width */
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        #sidebar.expanded {
            width: 250px; /* Expanded width */
        }

        #content {
            width: 100%;
            padding: 20px;
            margin-left: 80px;
            transition: all 0.3s;
        }

        #sidebar.expanded + #content {
            margin-left: 250px;
        }

        .sidebar-header {
            padding: 20px;
         
        }

        .list-unstyled li {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .list-unstyled li a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .list-unstyled li i {
            font-size: 3.0em; /* Icon size */
            margin-right: 10px;
            min-width: 40px;
            text-align: center;
        }

        .list-unstyled li span {
            display: none; /* Hide text by default */
        }

        #sidebar.expanded .list-unstyled li span {
            display: inline; /* Show text when expanded */
        }

         .sidebar-logo {
        width: 40px; /* Adjust width as needed */
        height: auto; /* Maintain aspect ratio */
    }

        #sidebar:not(.locked):hover .list-unstyled li span {
            display: inline; /* Show text on hover */
        }

        .list-unstyled li a:hover {
            background: #007bff;
        }

      
        /* Hover effect */
        #sidebar:not(.locked):hover {
            width: 250px;
        }

        #sidebar:not(.locked):hover + #content {
            margin-left: 250px;
        }

        /* Media Query for smaller screens */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -80px;
            }

            #sidebar.collapsed {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            #sidebar.show {
                margin-left: 0;
            }

            #sidebar.expanded {
                margin-left: 0;
            }

            #sidebar.expanded + #content {
                margin-left: 250px;
            }
        }

        img {
          position: absolute;
          width: 100px;
          height: 100px;
          top: 2%;
          left: 0%;
      }
      
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark">
              <div class="sidebar-header">
                <img src="{{ asset('picture/logopenjara.png') }}" alt="Logo" class="sidebar-logo">
            </div>
            <ul class="list-unstyled components">
              @if(Auth::check())
            @php
                $userPermissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();
            @endphp

            @if(in_array('view permissions', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('permissions') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>Permissions</span>
                    </a>
                </li>
            @endif

            @if(in_array('view roles', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('roles') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                        </svg>
                        <span>Roles</span>
                    </a>
                </li>
            @endif

            @if(in_array('view users', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('users') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                        </svg>
                        <span>Users</span>
                    </a>
                </li>
            @endif

            @if(in_array('view dashboard', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('admin.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            @if(in_array('view teras', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('teras.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>teras</span>
                    </a>
                </li>
            @endif

            @if(in_array('view so', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('so.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>SO</span>
                    </a>
                </li>
            @endif

            @if(in_array('view add kpi', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('admin.kpi') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                        </svg>
                        <span>Add KPI</span>
                    </a>
                </li>
            @endif

            @if(in_array('view user dashboard', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('user.kpi.input') }}" class="sidebar-link">
                        <i class="lni lni-dashboard"></i>
                        <span>User Dashboard</span>
                    </a>
                </li>
            @endif
        @endif
            </ul>
            @include('logout')
        </nav>

       

        <!-- Page Content -->
        <div id="content">
            <div class="container-fluid">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <button type="button" id="sidebarCollapse" class="btn btn-dark ms-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                  </svg>
              </button>
                {{-- <div class="h3 mt-2">Dashboard</div> --}}
                <div>
                    <input type="search" class="form-control m-2" placeholder="Search (Ctrl+/)">
                </div>
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16" class="bi bi-globe m-2 ms-4" viewBox="0 0 16 16">
                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" width="16" height="16" class="bi bi-brightness-low m-2" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8m.5-9.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 11a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m5-5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m-11 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9.743-4.036a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707m-7.779 7.779a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707m7.072 0a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707M3.757 4.464a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" width="16" height="16" class="bi bi-bell m-2" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                    </svg>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('expanded');
        });
    </script>
</body>
</html>