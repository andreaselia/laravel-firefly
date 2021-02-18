<div x-data="{ mobileMenuOpen: false }" class="relative bg-white">
    <div class="relative z-20">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-5 sm:px-6 sm:py-4 lg:px-8 md:justify-start md:space-x-10">
            <div>
                <a href="{{ route(config('firefly.web.name').'index') }}" class="flex">
                    <span class="sr-only">Firefly</span>
                    <img class="h-8 w-auto sm:h-10" src="{{ config('firefly.logo') }}" alt="">
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button @click="mobileMenuOpen = true" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <nav class="flex space-x-10">
                    @auth
                        <a class="text-base font-medium text-gray-500 hover:text-gray-900" href="{{ route('firefly.index') }}">
                            {{ __('Discussions') }}
                        </a>
                        <a class="text-base font-medium text-gray-500 hover:text-gray-900" href="{{ route('firefly.group.index') }}">
                            {{ __('Groups') }}
                        </a>
                    @endauth
                </nav>
                <div class="flex items-center md:ml-12">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                {{ __('Login') }}
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @else
                        @if (Route::has('logout'))
                            <a href="{{ route('logout') }}" class="text-base font-medium text-gray-500 hover:text-gray-900" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <div x-description="Mobile menu, show/hide based on mobile menu state." x-show="mobileMenuOpen" x-transition:enter="duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-30 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 pb-6 px-5 sm:pb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <img class="h-8 w-auto" src="{{ config('firefly.logo') }}" alt="Firefly">
                    </div>
                    <div class="-mr-2">
                        <button @click="mobileMenuOpen = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-6 sm:mt-8">
                    <nav>
                        <div class="grid gap-7 sm:grid-cols-2 sm:gap-y-8 sm:gap-x-4">
                            @guest
                                @if (Route::has('login'))
                                    <a class="-m-3 p-3 rounded-lg text-base font-medium text-gray-900 hover:bg-gray-50" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="-m-3 p-3 rounded-lg text-base font-medium text-gray-900 hover:bg-gray-50" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @else
                                <a class="-m-3 p-3 rounded-lg text-base font-medium text-gray-900 hover:bg-gray-50" href="{{ route('firefly.index') }}">
                                    {{ __('Discussions') }}
                                </a>
                                <a class="-m-3 p-3 rounded-lg text-base font-medium text-gray-900 hover:bg-gray-50" href="{{ route('firefly.group.index') }}">
                                    {{ __('Groups') }}
                                </a>
                                @if (Route::has('logout'))
                                    <a class="-m-3 p-3 rounded-lg text-base font-medium text-gray-900 hover:bg-gray-50" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
