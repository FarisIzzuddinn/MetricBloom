<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header with Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      /* Sidebar Styles */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    background-color: #343a40;
    color: white;
    padding-top: 56px;
    z-index: 0;
    width: 250px;
    transition: width 0.3s ease-in-out;
}

.sidebar.collapsed {
    width: 0px; /* Adjust this width as needed for collapsed state */
}

.sidebar a {
    color: white;
    text-decoration: none;
    padding: 10px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sidebar.collapsed a {
    text-align: center;
    overflow: visible;
    white-space: normal;
}

.sidebar a i {
    margin-right: 10px;
}

.sidebar.collapsed a i {
    margin-right: 0;
}

/* Content adjustment */
.content {
    margin-left: 250px;
    padding-top: 56px;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    transition: all 0.3s;
}

.main-content.collapsed {
    margin-left: 0px; /* Adjust this to match the sidebar collapsed width */
}

.navbar {
    z-index: 1;
}

.navbar-nav .nav-link {
    display: flex;
    align-items: center;
    padding: 0 25px;
}

.navbar-nav .nav-link i {
    font-size: 1.25rem;
}

.navbar-brand img, .navbar-nav .nav-link img {
    height: 30px;
    width: 30px;
    object-fit: cover;
}

@media (max-width: 992px) {
    .sidebar {
        width: 200px; /* Adjust width for responsive view */
    }
    .main-content {
        margin-left: 200px; /* Adjust margin to match the sidebar width */
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 100px; /* Reduce width for smaller screens */
    }

    .sidebar.collapsed {
        width: 0;
    }

    .sidebar a {
        display: block; /* Hide text in collapsed sidebar */
    }

    .sidebar.collapsed a {
        display: none; /* Ensure text is hidden in collapsed state */
    }

    .sidebar i {
        display: block; /* Ensure icons are still visible */
    }

    .main-content {
        margin-left: 0px; /* Adjust margin to fit the sidebar */
    }
}

@media (max-width: 576px) {
    .navbar-brand, .navbar-nav .nav-link {
        display: flex;
        align-items: center;
        padding: 0 10px;
    }

    .navbar-brand img, .navbar-nav .nav-link img {
        height: 25px;
        width: 25px;
    }
}

#sidebarToggle {
    padding: 2px 8px;
    font-size: 14px;
}

#sidebarToggle i {
    font-size: 20px;
}

    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-dark bg-dark sticky-sm-top">
        <div class="container-fluid">
            <!-- Sidebar Toggle -->
            <button class="btn btn-outline-light me-3" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
           
            <!-- System Title -->
            <a class="navbar-brand fs-6" href="#">JABATAN PENJARA MALAYSIA</a>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <!-- Notification Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-bell"></i>
                        </a>
                    </li>
                    <!-- System Settings -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear"></i>
                        </a>
                    </li>
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('picture/profil_picture.jpg') }}" alt="Profile" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>@include('logout')</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        @include('sidebar')
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
        });
    </script>
</body>
</html>
