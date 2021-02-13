@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1>{{ __('Groups') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', \Firefly\Models\Group::class))
            <a href="{{ route('firefly.group.create') }}">
                <x-button type="button">
                    {{ __('New Group') }}
                </x-button>
            </a>
        @endif
    </div>

    <div class="row">
        @if (! count($groups))
            <x-alert>
                <strong>{{ __('Holy guacamole!') }}</strong><br>
                {{ __('There are no groups; You could be the first to create one.') }}
            </x-alert>
        @endif

        @foreach ($groups as $group)
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <a href="{{ route('firefly.group.show', $group) }}" class="flex bg-white shadow-md rounded-lg p-5">
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
                </a>
            </div>
        @endforeach
    </div>

    {!! $groups->links(config('firefly.pagination.view')) !!}
</div>
@endsection
