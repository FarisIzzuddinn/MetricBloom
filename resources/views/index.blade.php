<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/layout.css') }}">
	<title>Jabatan Penjara Malaysia</title>
    <style>
        .avatar-wrapper {
            position: relative;
            display: inline-block;
            width: 50px; /* Adjust size as needed */
            height: 50px; /* Adjust size as needed */
            border-radius: 50%;
            background-color: white; /* Inverted white border */
            overflow: hidden; /* Ensures the image stays within the circle */
            padding-top: 5px; /* Thickness of the white border */
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<body>
	<!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar-closed">
        <a href="#" class="brand">
            <div class="featured-image mb-3 text-center mt-4 ms-2">
                <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid " style="max-width: 60px;">
            </div>
            <span class="sidebar-text ms-3" style="display: block; color: #003300; font-weight: bold; font-size: 20px; margin-top: 10px;">
            <span class="sidebar-text" style="display: block; color: #003300; font-weight: bold; font-size: 20px; margin-top: 10px; text-align: center;">JABATAN PENJARA <br> MALAYSIA </span>
        </a>
        <nav class="side-menu">
            @include('sidebar')
        </nav>
    </aside>
    <!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </div>
            <div class="d-flex align-items-center ms-auto">
                <h4 class="mt-2 me-3 mb-0"> {{ auth()->user()->name }} </h4>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-wrapper">
                            <img src="{{ asset('avatars/' . auth()->user()->avatar ?? 'default_pic.jpg') }}" alt="Profile" class="avatar-img">
                        </div>
                    </a>                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                        <li>@include('logout')</li>
                    </ul>
                </li>
            </div>            
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			@yield('content')
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
</body>

<script>
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

    allSideMenu.forEach(item=> {
        const li = item.parentElement;

        item.addEventListener('click', function () {
            allSideMenu.forEach(i=> {
                i.parentElement.classList.remove('active');
            });
            li.classList.add('active');
        });
    });

    // TOGGLE SIDEBAR
    const menuBar = document.querySelector('#content nav .bi.bi-list');
    const sidebar = document.getElementById('sidebar');

    menuBar.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
    });
</script>
</html>
