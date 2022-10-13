@props(['search' => ''])

@if (\Firefly\Features::enabled('search'))
    <form method="GET">
        <div>
            <label for="search" class="block text-lg font-medium text-gray-700 hidden">Quick search</label>
            <div class="relative mt-1 flex items-center">
                <input
                    type="search"
                    name="search"
                    id="search"
                    value="{{ $search }}"
                    placeholder="Search"
                    accesskey="k"
                    class="block w-full rounded-md border-gray-300 pr-12 shadow-sm focus:border-gray-700 focus:ring-gray-700 sm:text-lg"
                />
                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                    <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400">k</kbd>
                </div>
            </div>
        </div>
    </form>
@endif
