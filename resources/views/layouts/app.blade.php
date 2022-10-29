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
    @if (Firefly\Features::enabled('wysiwyg'))
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.{{ Firefly\Features::option('wysiwyg', 'theme') }}.css" rel="stylesheet">
    @endif
    @if (Firefly\Features::enabled('reactions'))
    <script src="{{ asset('vendor/firefly/js/emojis.js') }}"></script>
    @endif
</head>
<body class="bg-white font-sans antialiased text-gray-900">
    <x-header />

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
