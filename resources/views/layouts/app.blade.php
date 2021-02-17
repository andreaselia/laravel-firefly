<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Firefly') }}</title>

    <!-- Tailwind -->
    <link href="https://tailwindcss-forms.vercel.app/dist/forms.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="{{ route(config('firefly.web.name').'index') }}">
                Firefly
            </a>

            <div>
                <ul class="flex items-center space-x-5">
                    @guest
                        <li>
                            @if (Route::has('login'))
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                        </li>
                        <li>
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        </li>
                    @else
                        <li>
                            <a class="{{ Route::currentRouteName() == 'firefly.index' ? ' active' : '' }}" href="{{ route('firefly.index') }}">
                                {{ __('Discussions') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Route::currentRouteName() == 'firefly.group.index' ? ' active' : '' }}" href="{{ route('firefly.group.index') }}">
                                {{ __('Groups') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>
</body>
</html>
