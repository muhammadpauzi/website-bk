<ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active fw-bold' :'' }}" aria-current="page"
            href="{{ route('dashboard.index') }}">Dashboard</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Data Utama</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item {{ request()->routeIs('students.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('students.index') }}">Data Siswa</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Notifications</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Switch account</a>
    </li>
    {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
        <ul class="dropdown-menu gap-1 p-2 rounded-3 mx-0 shadow w-220px">
            <li><a class="dropdown-item rounded-2 active" href="#">Action</a></li>
            <li><a class="dropdown-item rounded-2" href="#">Another action</a></li>
            <li><a class="dropdown-item rounded-2" href="#">Something else here</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item rounded-2" href="#">Separated link</a></li>
        </ul>
    </li> --}}
    {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
        <ul class="dropdown-menu dropdown-menu-dark gap-1 p-2 rounded-3 mx-0 border-0 shadow w-220px">
            <li><a class="dropdown-item rounded-2 active" href="#">Action</a></li>
            <li><a class="dropdown-item rounded-2" href="#">Another action</a></li>
            <li><a class="dropdown-item rounded-2" href="#">Something else here</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item rounded-2" href="#">Separated link</a></li>
        </ul>
    </li> --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </li>
</ul>