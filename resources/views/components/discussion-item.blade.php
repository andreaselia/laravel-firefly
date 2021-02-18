@props(['discussion', 'showGroups' => true])

<a class="block" href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
    <x-card max-width="sm:max-w-none">
        <div class="flex flex-col sm:flex-row flex-grow justify-between sm:items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $discussion->title }}</h3>

                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    {{ __('Posted by') }} {{ $discussion->user->name }} &#8226; {{ $discussion->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="mt-2 sm:mt-0 flex space-x-2 text-sm">
                @if ($discussion->is_private)
                    <x-icon name="private" />
                @endif

                @if ($discussion->pinned_at)
                    <x-icon name="pin" />
                @endif

                @if ($discussion->locked_at)
                    <x-icon name="lock" />
                @endif

                @if ($showGroups)
                    @foreach ($discussion->groups as $group)
                        <x-tag :group="$group" />
                    @endforeach
                @endif

                <span class="inline-flex items-center px-2.5 py-1 rounded-full border text-xs font-medium bg-white text-gray-700">
                    {{ $discussion->reply_count }} {{ $discussion->reply_count > 1 ? __('replies') : __('reply') }}
                </span>
            </div>
        </div>
    </x-card>
</a>
