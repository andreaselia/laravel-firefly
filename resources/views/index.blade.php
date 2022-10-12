@extends('firefly::layouts.app')

@section('content')
<h2 class="mb-4 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
    {{ __('Discussions') }}
</h2>

<x-search :search="$search"></x-search>

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
@endsection
