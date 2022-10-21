@extends('firefly::layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div class="flex items-center space-x-5">
        <div class="text-3xl font-bold">{{ $group->name }}</div>

        <div class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
            {{ $group->name }}
        </div>

        @if ($group->is_private)
            <x-icon name="private" />
        @endif
    </div>

    @if (Auth::check() && Auth::user()->can('create', \Firefly\Models\Discussion::class))
        <div class="flex space-x-2">
            <a href="{{ route('firefly.discussion.create', $group) }}">
                <x-button>
                    {{ __('New Discussion') }}
                </x-button>
            </a>

            <x-group-options :group="$group" />
        </div>
    @endif
</div>

@if (! $discussions->count())
    <x-no-results>
        {{ __('There are no discussions; You could be the first to create one.') }}
    </x-no-results>
@endif

<div class="space-y-5">
    <x-search :search="$search" />

    @foreach ($discussions as $discussion)
        <x-discussion-item :discussion="$discussion" :show-groups="false" />
    @endforeach
</div>
@endsection
