<div class="d-flex">
    @can ('stick', $discussion)
        <form action="{{ route('firefly.discussion.stick', [$discussion->id, $discussion->slug]) }}" method="POST">
            @method('PUT')
            @csrf

            <button class="btn btn-sm btn-success mr-3">{{ __('Stick') }}</button>
        </form>
    @endcan

    @can ('unstick', $discussion)
        <form action="{{ route('firefly.discussion.unstick', [$discussion->id, $discussion->slug]) }}" method="POST">
            @method('PUT')
            @csrf

            <button class="btn btn-sm btn-success mr-3">{{ __('Unstick') }}</button>
        </form>
    @endcan

    @can ('lock', $discussion)
        <form action="{{ route('firefly.discussion.lock', [$discussion->id, $discussion->slug]) }}" method="POST">
            @method('PUT')
            @csrf

            <button class="btn btn-sm btn-success mr-3">{{ __('Lock') }}</button>
        </form>
    @endcan

    @can ('unlock', $discussion)
        <form action="{{ route('firefly.discussion.unlock', [$discussion->id, $discussion->slug]) }}" method="POST">
            @method('PUT')
            @csrf

            <button class="btn btn-sm btn-success mr-3">{{ __('Unlock') }}</button>
        </form>
    @endcan

    @can ('update', $discussion)
        <a href="{{ route('firefly.discussion.edit', [$discussion->id, $discussion->slug]) }}" class="btn btn-sm btn-info mr-3">{{ __('Edit') }}</a>
    @endcan

    @can ('delete', $discussion)
        <form action="{{ route('firefly.discussion.delete', [$discussion->id, $discussion->slug]) }}" method="POST">
            @method('DELETE')
            @csrf

            <button class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
        </form>
    @endcan
</div>
