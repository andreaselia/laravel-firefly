@props(['maxWidth' => 'sm:max-w-md'])

<div class="w-full {{ $maxWidth }} sm:mx-auto bg-white shadow overflow-hidden rounded-md px-6 py-4">
    @isset ($title)
        <div class="text-xl font-medium mb-4">
            {{ $title }}
        </div>
    @endisset

    {{ $slot }}
</div>
