@extends('layouts.error')

@php
$title = __($exception->getMessage() ?: 'Not Found')
@endphp
@section('content')
<div class="py-5 my-5 text-center">
    <h1>😞</h1>
    <h1 class="fw-bold">404</h1>
    {{-- <h5>{{ __($exception->getMessage() ?: 'Not Found') }}</h5> --}}
    <hr class="mx-auto d-block my-4" style="width: 100px;">
    <p class="text-danger fw-bold">Halaman Tidak Tersedia!</p>
    <a href="{{ route('dashboard.index') }}">Kembali Ke Halaman Dashboard</a>
</div>

@endsection