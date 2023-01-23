<ul class="navbar-nav ms-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active fw-bold' :'' }}" aria-current="page"
            href="{{ route('dashboard.index') }}">Dashboard</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Data Utama</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li>
                <a class="dropdown-item {{ request()->routeIs('parents.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('parents.index') }}">Data Orang Tua</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->routeIs('students.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('students.index') }}">Data Siswa</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->routeIs('teachers.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('teachers.index') }}">Data Guru</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->routeIs('classes.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('classes.index') }}">Data Kelas</a>
            </li>
        </ul>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Data
            Pelanggaran</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li>
                <a class="dropdown-item {{ request()->routeIs('offense-categories.*') ? 'active fw-bold' : '' }}"
                    href="{{ route('offense-categories.index') }}">Data Kategori</a>
            </li>
        </ul>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">Notifications</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Switch account</a>
    </li> --}}
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
        <a class="nav-link dropdown-toggle fw-bold text-white" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span data-feather="user" class="icon-size me-1"></span>
            {{
            auth()->user()->name }}</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="#">Detail Akun</a></li>
            <li>
                <form action="{{ route('auth.logout') }}" method="POST"
                    onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-bg-danger">Keluar</button>
                </form>
            </li>
        </ul>
    </li>
</ul>