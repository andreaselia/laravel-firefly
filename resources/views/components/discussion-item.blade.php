@props(['discussion', 'showGroups' => true])

<a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
    <x-card max-width="sm:max-w-none">
        <div class="flex flex-grow justify-between items-center">
            <div>
                <div class="text-xl font-semibold">{{ $discussion->title }}</div>

                <div class="mt-1 text-xs text-gray-500">
                    {{ __('Posted by') }} {{ $discussion->user->name }} &#8226; {{ $discussion->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="flex space-x-2 text-sm">
                @if ($discussion->pinned_at)
                    <x-icon name="pin" />
                @endif

                @if ($discussion->locked_at)
                    <x-icon name="lock" />
                @endif

                @if ($showGroups)
                    @foreach ($discussion->groups as $group)
                        <div class="rounded-full text-white font-medium text-xs px-3 py-1" style="background-color: {{ $group->color }};">
                            {{ $group->name }}
                        </div>
                    @endforeach
                @endif

                <div class="rounded-full text-gray-500 font-medium text-xs px-3 py-1 bg-white border">
                    {{ $discussion->post_count }}
                </div>
            </div>
        </div>
    </x-card>
</a>
