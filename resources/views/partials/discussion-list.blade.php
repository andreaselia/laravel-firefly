@if (! count($discussions))
    <div class="alert alert-yellow text-center" role="alert">
        {{ __('Uh oh, there are no discussions.') }}
    </div>
@endif

<ul class="list-unstyled discussion-list">
    @foreach ($discussions as $discussion)
        <li class="list-item">
            <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}" class="list-item-title">
                {{ $discussion->title }}
            </a>

            <div class="list-item-meta">
                {{ __('Posted by') }} <a href="#" class="author">{{ $discussion->user->name }}</a>
                <span class="date">{{ $discussion->created_at->diffForHumans() }}</span>
                <span class="count">3 {{ __('replies') }}</span>
            </div>
        </li>
    @endforeach
</ul>

{!! $discussions->links() !!}
