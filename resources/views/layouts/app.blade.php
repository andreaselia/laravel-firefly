<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Firefly') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('/vendor/firefly/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><circle stroke="#121212" stroke-width="3" cx="16" cy="16" r="14.5"/><path d="M14.554 11.033l6.79 4.514a1 1 0 0 1 .002 1.664l-6.79 4.541A1 1 0 0 1 13 20.921v-9.055a1 1 0 0 1 1.554-.833z" fill="#121212"/></g></svg>
                </a>

                <div class="navbar-items">
                    <ul>
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('firefly.group.index') }}" class="nav-link">{{ __('Groups') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('firefly.forum.index') }}" class="nav-link">{{ __('Discussions') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                            </li>
                        @endguest
                    </ul>

                    <ul>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Hello, {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        @yield('hero')

        <main class="py-4">
            @yield('content')
        </main>

        @yield('modals')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/vendor/firefly/js/app.js') }}" defer></script>
</body>
</html>
