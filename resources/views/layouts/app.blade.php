<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Firefly') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/firefly/css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/firefly/js/app.js') }}" defer></script>
</head>
<body class="bg-white font-sans antialiased text-gray-900">
    <x-header />

    <main class="py-8">
        @yield('content')
    </main>
</body>
</html>
