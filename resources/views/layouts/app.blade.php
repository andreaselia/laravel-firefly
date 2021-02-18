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
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <nav class="container mx-auto mt-10 flex justify-between items-center">
        <a href="{{ route(config('firefly.web.name').'index') }}">
            <img class="w-32" src="{{ config('firefly.logo') }}" alt="Firefly">
        </a>

        <div>
            <ul class="flex items-center space-x-8">
                @guest
                    @if (Route::has('login'))
                        <li>
                            <a class="font-semibold hover:text-gray-600" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li>
                            <a class="font-semibold hover:text-gray-600" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li>
                        <a class="font-semibold hover:text-gray-600" href="{{ route('firefly.index') }}">
                            {{ __('Discussions') }}
                        </a>
                    </li>
                    <li>
                        <a class="font-semibold hover:text-gray-600" href="{{ route('firefly.group.index') }}">
                            {{ __('Groups') }}
                        </a>
                    </li>
                    @if (Route::has('logout'))
                        <li>
                            <a class="font-semibold hover:text-gray-600" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>
</body>
</html>
