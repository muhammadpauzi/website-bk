@extends('layouts.base')

@push('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('base')
<div class="col py-5">
    @yield('content')
</div>
@endsection