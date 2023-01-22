@extends('layouts.base')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
@endpush

@section('base')
<nav class="navbar navbar-expand-lg py-3 border-bottom fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-lg">
        <a class="navbar-brand fw-bold" href="#">BK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
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
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">Settings</a>
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
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">Settings</a>
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
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">Settings</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <div class="text-center text-lg-start py-3 py-lg-0">
                <small class="fw-bold text-white">Muhammad Pauzi</small>
            </div>
        </div>
    </div>
</nav>
{{--
<div class="nav-scroller bg-body shadow-sm">
    <nav class="nav" aria-label="Secondary navigation">
        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        <a class="nav-link" href="#">
            Friends
            <span class="badge text-bg-light rounded-pill align-text-bottom">27</span>
        </a>
        <a class="nav-link" href="#">Explore</a>
        <a class="nav-link" href="#">Suggestions</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
    </nav>
</div> --}}

<main class="container-lg my-5 py-2">
    <div class="row">
        @yield('content')
    </div>
</main>
@endsection

@push('script')
<script src="{{ asset('assets/js/app.js') }}"></script>
@endpush