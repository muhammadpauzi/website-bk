{{-- @extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error')) --}}

@extends('layouts.error')

@php
$title = __($exception->getMessage() ?: 'Server Error')
@endphp
@section('content')
<div class="py-5 my-5 text-center">
    <h1 class="fw-bolder">😞 500</h1>
    <h5>{{ __($exception->getMessage() ?: 'Server Error') }}</h5>
    <hr class="mx-auto d-block my-4" style="width: 100px;">
    <p class="text-danger">Mmmm... Maaf, Ada Sesuatu Yang Salah</p>

    <a href="{{ route('dashboard.index') }}">Kembali Ke Halaman Dashboard</a>
</div>

@endsection