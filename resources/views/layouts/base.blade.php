<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: "Source Sans Pro", sans-serif !important;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-5.3.0-alpha/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/tom-select/tom-select.bootstrap5.min.css') }}">


    @stack('style')

    <title>{{ $title ?? 'No Title' }} | Website Poin Pelanggaran</title>
</head>

<body class="bg-light">

    @include('partials.toast-alerts')

    @yield('base')

    <script src="{{ asset('vendors/bootstrap-5.3.0-alpha/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/tom-select/tom-select.base.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>

    <script>
        feather.replace({ 'aria-hidden': 'true' })
    </script>


    @stack('script')

</body>

</html>