<div class="space-y-5">
    @foreach ($discussions as $discussion)
        <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}" class="shadow-md rounded-lg">
            <div class="card-body">
                <div class="discussion-item flex justify-between items-center">
                    <div>
                        <h3 class="mb-0">{{ $discussion->title }}</h3>

                        <div class="discussion-item-meta">
                            {{ $discussion->user->name }}
                            <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                            {{ $discussion->reply_count }}
                        </div>
                    </div>

                    <div class="d-flex">
                        @if ($discussion->pinned_at)
                            <i class="icon icon-pinned mr-2" data-toggle="tooltip" title="{{ __('Pinned') }}"></i>
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
</div>
