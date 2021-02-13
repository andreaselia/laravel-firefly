<div class="w-full sm:max-w-md sm:mx-auto mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    @isset ($title)
        <div class="text-xl font-medium mb-4">
            {{ $title }}
        </div>
    @endisset

    {{ $slot }}
</div>
