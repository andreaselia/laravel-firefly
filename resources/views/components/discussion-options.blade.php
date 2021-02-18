@props(['discussion'])

<div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
    <div>
        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="true">
            {{ __('Manage') }}
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
    >
        <div class="p-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            @can ('update', $discussion)
                <a
                    href="{{ route('firefly.discussion.edit', [$discussion->id, $discussion->slug]) }}"
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                >
                    {{ __('Edit') }}
                </a>
            @endcan

            @can ('pin', $discussion)
                <button
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('pin-discussion-form').submit();"
                >
                    {{ __('Pin') }}
                </button>

                <form id="pin-discussion-form" action="{{ route('firefly.discussion.pin', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                    @method('PUT')
                    @csrf
                </form>
            @endcan

            @can ('unpin', $discussion)
                <button
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('unpin-discussion-form').submit();"
                >
                    {{ __('Unpin') }}
                </button>

                <form id="unpin-discussion-form" action="{{ route('firefly.discussion.unpin', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                    @method('PUT')
                    @csrf
                </form>
            @endcan

            @can ('lock', $discussion)
                <button
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('lock-discussion-form').submit();"
                >
                    {{ __('Lock') }}
                </button>

                <form id="lock-discussion-form" action="{{ route('firefly.discussion.lock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                    @method('PUT')
                    @csrf
                </form>
            @endcan

            @can ('unlock', $discussion)
                <button
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('unlock-discussion-form').submit();"
                >
                    {{ __('Unlock') }}
                </button>

                <form id="unlock-discussion-form" action="{{ route('firefly.discussion.unlock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                    @method('PUT')
                    @csrf
                </form>
            @endcan

            @can ('delete', $discussion)
                <button
                    class="block w-full text-left rounded-md px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('delete-discussion-form').submit();"
                >
                    {{ __('Delete') }}
                </button>

                <form id="delete-discussion-form" action="{{ route('firefly.discussion.delete', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>
    </div>
</div>
