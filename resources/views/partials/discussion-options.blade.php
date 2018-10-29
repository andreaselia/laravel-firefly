<div class="dropdown">
    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Manage Discussion') }}
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @can ('stick', $discussion)
            <a class="dropdown-item" href="{{ route('firefly.discussion.stick', [$discussion->id, $discussion->slug]) }}" onclick="event.preventDefault(); document.getElementById('stick-discussion-form').submit();">{{ __('Stick') }}</a>

            <form id="stick-discussion-form" action="{{ route('firefly.discussion.stick', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                @method('PUT')
                @csrf
            </form>
        @endcan

        @can ('unstick', $discussion)
            <a class="dropdown-item" href="{{ route('firefly.discussion.unstick', [$discussion->id, $discussion->slug]) }}" onclick="event.preventDefault(); document.getElementById('unstick-discussion-form').submit();">{{ __('Unstick') }}</a>

            <form id="unstick-discussion-form" action="{{ route('firefly.discussion.unstick', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                @method('PUT')
                @csrf
            </form>
        @endcan

        @can ('lock', $discussion)
            <a class="dropdown-item" href="{{ route('firefly.discussion.lock', [$discussion->id, $discussion->slug]) }}" onclick="event.preventDefault(); document.getElementById('lock-discussion-form').submit();">{{ __('Lock') }}</a>

            <form id="lock-discussion-form" action="{{ route('firefly.discussion.lock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                @method('PUT')
                @csrf
            </form>
        @endcan

        @can ('unlock', $discussion)
            <a class="dropdown-item" href="{{ route('firefly.discussion.unlock', [$discussion->id, $discussion->slug]) }}" onclick="event.preventDefault(); document.getElementById('unlock-discussion-form').submit();">{{ __('Unlock') }}</a>

            <form id="unlock-discussion-form" action="{{ route('firefly.discussion.unlock', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                @method('PUT')
                @csrf
            </form>
        @endcan

        @can ('update', $discussion)
            <a class="dropdown-item" href="{{ route('firefly.discussion.edit', [$discussion->id, $discussion->slug]) }}">{{ __('Edit') }}</a>
        @endcan

        @can ('delete', $discussion)
            <a class="dropdown-item text-danger" href="{{ route('firefly.discussion.delete', [$discussion->id, $discussion->slug]) }}" onclick="event.preventDefault(); document.getElementById('delete-discussion-form').submit();">{{ __('Delete') }}</a>

            <form id="delete-discussion-form" action="{{ route('firefly.discussion.delete', [$discussion->id, $discussion->slug]) }}" method="POST" style="display: none;">
                @method('DELETE')
                @csrf
            </form>
        @endcan
    </div>
</div>
