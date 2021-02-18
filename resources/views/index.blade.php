@extends('firefly::layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
        {{ __('Discussions') }}
    </h2>

    @if (! $discussions->count())
        <div class="flex flex-col text-sm bg-blue-50 border border-blue-500 rounded-lg px-3 py-2">
            <span class="font-bold">{{ __('Holy guacamole!') }}</span>
            <p>{{ __('There are no discussions.') }}</p>
        </div>
    @endif

    <div class="mt-4 space-y-5">
        @foreach ($discussions as $discussion)
            <x-discussion-item :discussion="$discussion" />
        @endforeach
    </div>

    {!! $discussions->links(config('firefly.pagination.view')) !!}
</div>
@endsection
