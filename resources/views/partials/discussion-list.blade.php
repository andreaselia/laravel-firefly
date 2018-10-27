@foreach ($discussions as $discussion)
    <div class="discussion-item d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-0">
                <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
                    {{ $discussion->title }}
                </a>
            </h3>

            <div class="discussion-item-meta">
                {{ $discussion->user->name }}
                <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                {{ count($discussion->posts) }} {{ __('replies') }}
            </div>
        </div>

        <div class="d-flex">
            @if (isset($group))
                @php $parent = $group; @endphp
            @endif

            @foreach ($discussion->groups as $group)
                @if (isset($parent) && $parent->id == $group->id)
                    @continue
                @endif
                
                <div class="group-display rounded-circle mb-0" data-toggle="tooltip" data-placement="top" title="{{ $group->name }}" style="background: {{ $group->color }};"></div>
            @endforeach
        </div>
    </div>
@endforeach
