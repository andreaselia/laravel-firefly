@props(['group'])

<a class="block" href="{{ route('firefly.group.show', $group) }}">
    <x-card max-width="sm:max-w-none">
        <div class="flex">
            <div class="flex-1">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $group->name }}</h3>

                <div class="text-sm">
                    {{ $group->discussions->count() }} {{ $group->discussions->count() > 1 ? __('discussions') : __('discussion') }}
                </div>
            </div>

            <div class="flex items-center">
                @if ($group->is_private)
                    <x-icon name="private" />
                @endif

                <x-tag :group="$group" />
            </div>
        </div>
    </x-card>
</a>
