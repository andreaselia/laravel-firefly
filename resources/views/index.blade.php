@extends('firefly::layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
        {{ __('Discussions') }}
    </h2>

    @if (! $discussions->count())
        <x-no-results>
            {{ __('There are no groups; You could be the first to create one.') }}
        </x-no-results>
    @endif

    <div class="mt-4 space-y-5">
        @foreach ($discussions as $discussion)
            <x-discussion-item :discussion="$discussion" />
        @endforeach
    </div>

    {!! $discussions->links(config('firefly.pagination.view')) !!}
</div>
@endsection
