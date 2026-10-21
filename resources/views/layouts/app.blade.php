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
    @php
        $quillTheme = Firefly\Features::option('wysiwyg', 'theme');
        $quillThemeIntegrity = [
            'snow' => 'sha384-07UbSXbd8HpaOfxZsiO6Y8H1HTX6v0J96b5qP6PKSpYEuSZSYD4GFFHlLRjvjVrL',
            'bubble' => 'sha384-EFILVeQLf5FN6Mknf4s9cz/Upt8wQP42bkrcljW75Y9IEwTtbfqjW553SooU4HW1',
        ][$quillTheme] ?? null;
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js" integrity="sha384-AOnYUgW6MQR78EvTqtkbNavz7dVI7dtLm7QdcIMBoy06adLIzNT40hHPYl9Rr5m5" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.{{ $quillTheme }}.css" rel="stylesheet" @if ($quillThemeIntegrity) integrity="{{ $quillThemeIntegrity }}" crossorigin="anonymous" @endif>
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
