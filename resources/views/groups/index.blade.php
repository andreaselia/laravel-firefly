@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <div class="text-2xl font-bold">{{ __('Groups') }}</div>

        @if (Auth::check() && Auth::user()->can('create', \Firefly\Models\Group::class))
            <a href="{{ route('firefly.group.create') }}">
                <x-button type="button">
                    {{ __('New Group') }}
                </x-button>
            </a>
        @endif
    </div>

    @if (! count($groups))
        <x-alert>
            <strong>{{ __('Holy guacamole!') }}</strong><br>
            {{ __('There are no groups; You could be the first to create one.') }}
        </x-alert>
    @endif

    @foreach ($groups as $group)
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
                            <x-private-icon />
                        @endif

                        <div class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
                            {{ $group->name }}
                        </div>
                    </div>
                </div>
            </x-card>
        </a>
    @endforeach

    {!! $groups->links(config('firefly.pagination.view')) !!}
</div>
@endsection
