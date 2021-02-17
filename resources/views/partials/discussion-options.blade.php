<div class="flex space-x-1">
    @can ('pin', $discussion)
        <x-button onclick="event.preventDefault(); document.getElementById('pin-discussion-form').submit();">
            {{ __('Pin') }}
        </x-button>

        <form id="pin-discussion-form" action="{{ route('firefly.discussion.pin', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
            @method('PUT')
            @csrf
        </form>
    @endcan

    @can ('unpin', $discussion)
        <x-button onclick="event.preventDefault(); document.getElementById('unpin-discussion-form').submit();">
            {{ __('Unpin') }}
        </x-button>

        <form id="unpin-discussion-form" action="{{ route('firefly.discussion.unpin', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
            @method('PUT')
            @csrf
        </form>
    @endcan

    @can ('lock', $discussion)
        <x-button onclick="event.preventDefault(); document.getElementById('lock-discussion-form').submit();">
            {{ __('Lock') }}
        </x-button>

        <form id="lock-discussion-form" action="{{ route('firefly.discussion.lock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
            @method('PUT')
            @csrf
        </form>
    @endcan

    @can ('unlock', $discussion)
        <x-button onclick="event.preventDefault(); document.getElementById('unlock-discussion-form').submit();">
            {{ __('Unlock') }}
        </x-button>

        <form id="unlock-discussion-form" action="{{ route('firefly.discussion.unlock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
            @method('PUT')
            @csrf
        </form>
    @endcan

    @can ('update', $discussion)
        <a href="{{ route('firefly.discussion.edit', [$discussion->id, $discussion->slug]) }}">
            <x-button>
                {{ __('Edit') }}
            </x-button>
        </a>
    @endcan

    @can ('delete', $discussion)
        <x-button onclick="event.preventDefault(); document.getElementById('delete-discussion-form').submit();">
            {{ __('Delete') }}
        </x-button>

        <form id="delete-discussion-form" action="{{ route('firefly.discussion.delete', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
            @method('DELETE')
            @csrf
        </form>
    @endcan
</div>
