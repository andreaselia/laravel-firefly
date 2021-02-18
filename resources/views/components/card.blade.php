@props(['maxWidth' => 'sm:max-w-md'])

<div class="w-full {{ $maxWidth }} sm:mx-auto mt-6 px-6 py-4 bg-white shadow-md border border-gray-100 overflow-hidden sm:rounded-lg">
    @isset ($title)
        <div class="text-xl font-medium mb-4">
            {{ $title }}
        </div>
    @endisset

    {{ $slot }}
</div>
