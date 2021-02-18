@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <div class="text-3xl font-bold">{{ __('Groups') }}</div>

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

    <div class="space-y-5">
        @foreach ($groups as $group)
            <x-group-item :group="$group" />
        @endforeach
    </div>

    {!! $groups->links(config('firefly.pagination.view')) !!}
</div>
@endsection
