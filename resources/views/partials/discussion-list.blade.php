@foreach ($discussions as $discussion)
    <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}" class="card mb-3">
        <div class="card-body">
            <div class="discussion-item d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0">{{ $discussion->title }}</h3>

                    <div class="discussion-item-meta">
                        {{ $discussion->user->name }}
                        <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                        {{ $discussion->reply_count }}
                    </div>
                </div>

                <div class="d-flex">
                    @if ($discussion->stickied_at)
                        <i class="icon icon-stuck mr-2" data-toggle="tooltip" title="{{ __('Pinned') }}"></i>
                    @endif

                    @if ($discussion->locked_at)
                        <i class="icon icon-locked mr-2" data-toggle="tooltip" title="{{ __('Locked') }}"></i>
                    @endif

                    @foreach ($discussion->groups as $group)
                        <div class="group-display rounded-circle mb-0" data-toggle="tooltip" title="{{ $group->name }}" style="background: {{ $group->color }};"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </a>
@endforeach
