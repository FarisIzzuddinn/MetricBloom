<style>
    img {
        position: absolute;
        width: 75px;
        height: 75px;
        top: 2%;
        left: 0%;
    }
</style>

<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn ms-1 me-3" type="button">
            <img src="{{ asset('picture/logopenjara.png') }}" alt="Logo Penjara">
        </button>
        <div class="sidebar-logo mt-3">
            <a href="#">JABATAN PENJARA MALAYSIA</a>
        </div>
    </div>

    <ul class="sidebar-nav">
        @if(Auth::check())
            @php
                $userPermissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();
            @endphp

            @if(in_array('view permissions', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('permissions') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>Permissions</span>
                    </a>
                </li>
            @endif

            @if(in_array('view roles', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('roles') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                        </svg>
                        <span>Roles</span>
                    </a>
                </li>
            @endif

            @if(in_array('view users', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ url('users') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                        </svg>
                        <span>Users</span>
                    </a>
                </li>
            @endif

            @if(in_array('view dashboard', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('admin.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            @if(in_array('view teras', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('teras.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>teras</span>
                    </a>
                </li>
            @endif

            @if(in_array('view so', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('so.index') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <span>SO</span>
                    </a>
                </li>
            @endif

            @if(in_array('view add kpi', $userPermissions))
                <li class="sidebar-item">
                    <a href="{{ route('admin.kpi') }}" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill me-3" viewBox="0 0 16 16">
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
</aside>
