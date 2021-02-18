@extends('firefly::layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
        {{ __('Groups') }}
    </h2>

    @if (Auth::check() && Auth::user()->can('create', \Firefly\Models\Group::class))
        <a href="{{ route('firefly.group.create') }}">
            <x-button type="button">
                {{ __('New Group') }}
            </x-button>
        </a>
    @endif
</div>

@if (! $groups->count())
    <x-no-results>
        {{ __('There are no groups; You could be the first to create one.') }}
    </x-no-results>
@endif

<div class="mt-4 grid gap-5 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    @foreach ($groups as $group)
        <x-group-item :group="$group" />
    @endforeach
</div>

{!! $groups->links(config('firefly.pagination.view')) !!}
@endsection
