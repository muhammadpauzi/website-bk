{{-- @extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

@extends('layouts.error')

@php
$title = __($exception->getMessage() ?: 'Forbidden')
@endphp
@section('content')
<div class="py-5 my-5 text-center">
    <h1 class="fw-bolder">😞 403</h1>
    <h5>{{ __($exception->getMessage() ?: 'Forbidden') }}</h5>
    <hr class="mx-auto d-block my-4" style="width: 100px;">
    <p class="text-danger">Anda tidak memiliki hak untuk mengakses halaman ini</p>

    <a href="{{ route('dashboard.index') }}">Kembali Ke Halaman Dashboard</a>
</div>

@endsection