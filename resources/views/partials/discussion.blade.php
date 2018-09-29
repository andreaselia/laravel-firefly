<a href="{{ route('forum.discussions.show', $discussion->slug) }}" class="list-group-item list-group-item-action">
    <h3>{{ $discussion->title }} @include('firefly::partials.groups')</h3>

    <p class="mb-0">{{ __('Posted by') }} {{ $discussion->user->name }}, {{ $discussion->created_at->diffForHumans() }}</p>
</a>
