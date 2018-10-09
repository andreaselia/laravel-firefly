@if (! count($discussions))
    <div class="notification notification-yellow">
        {{ __('Uh oh, there are no discussions.') }}
    </div>
@endif

<ul class="discussion-list">
    @foreach ($discussions as $discussion)
        <li class="list-item">
            <a href="{{ route('discussion.show', $discussion) }}" class="list-item-title">{{ $discussion->title }}</a>

            <div class="list-item-data">
                <a href="#" class="list-item-author">{{ $discussion->user->name }}</a>
                <span class="list-item-date">{{ $discussion->created_at->diffForHumans() }}</span>
                <span class="list-item-count">3 {{ __('posts') }}</span>
            </div>
        </li>
    @endforeach
</ul>

<div class="pagination">
    {!! $discussions->links() !!}
</div>
