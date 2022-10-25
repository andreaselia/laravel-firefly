<div {{ $attributes->class(['overflow-visible mb-10'=>\Firefly\Features::enabled('reactions')])->merge(['class' => 'w-full sm:mx-auto bg-white shadow overflow-hidden rounded-md px-6 py-4']) }}>
    {{ $slot }}
</div>
