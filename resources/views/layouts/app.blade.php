<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Firefly') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('/vendor/firefly/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('/vendor/firefly/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><circle stroke="#000" stroke-width="3" cx="16" cy="16" r="14.5"/><path d="M14.554 11.033l6.79 4.514a1 1 0 0 1 .002 1.664l-6.79 4.541A1 1 0 0 1 13 20.921v-9.055a1 1 0 0 1 1.554-.833z" fill="#000"/></g></svg>

                {{ config('app.name', 'Firefly') }}
            </a>

            <div class="navbar-items">
                <ul>
                    <li><a href="{{ route('group.index') }}">{{ __('Groups') }}</a></li>
                    <li><a href="{{ route('forum.index') }}">{{ __('Discussions') }}</a></li>
                </ul>

                <ul>
                    @guest
                        <li><a href="{{ route('login') }}">{{ __('Log in') }}</a></li>

                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-green">{{ __('Sign up') }}</a></li>
                        @endif
                    @else
                        <li>
                            <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
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
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('hero')

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
