<div class="space-y-5">
    @foreach ($discussions as $discussion)
        <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
            <x-card max-width="sm:max-w-none">
                <div class="flex flex-grow justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $discussion->title }}</div>

                        <div class="text-sm">
                            {{ $discussion->user->name }}
                            <span class="mx-2">{{ $discussion->created_at->diffForHumans() }}</span>
                            {{ $discussion->reply_count }}
                        </div>
                    </div>

                    <div class="flex space-x-4 text-sm">
                        @if ($discussion->pinned_at)
                            <x-pin-icon />
                        @endif

                        @if ($discussion->locked_at)
                            <x-lock-icon />
                        @endif

                        @foreach ($discussion->groups as $group)
                            <div class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
                                {{ $group->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-card>
        </a>
    @endforeach
</div>
