@props(['group'])

<a href="{{ route('firefly.group.show', $group) }}">
    <x-card max-width="sm:max-w-none">
        <div class="flex">
            <div class="flex-1">
                <div class="font-medium">{{ $group->name }}</div>

                <div class="text-sm">
                    {{ count($group->discussions) }} {{ __('discussions') }}
                </div>
            </div>

            <div class="flex items-center">
                @if ($group->is_private)
                    <x-icon name="private" />
                @endif

                <div class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
                    {{ $group->name }}
                </div>
            </div>
        </div>
    </x-card>
</a>
