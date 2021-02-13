@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ __('Discussions') }}</h1>

    @if (! $discussions->count())
        <div class="flex flex-col text-sm bg-blue-50 border border-blue-500 rounded-lg px-3 py-2">
            <span class="font-bold">{{ __('Holy guacamole!') }}</span>
            <p>{{ __('There are no discussions.') }}</p>
        </div>
    @endif

    @include('firefly::partials.discussion-list')

    {!! $discussions->links(config('firefly.pagination.view')) !!}
</div>
@endsection
