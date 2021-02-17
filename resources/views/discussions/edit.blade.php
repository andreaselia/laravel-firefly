@extends('firefly::layouts.app')

@section('content')
@if (Auth::check())
    <div class="container mx-auto">
        <a href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">
            {{ __('Back to Discussion') }}
        </a>
    </div>
@endif

<x-card>
    <x-slot name="title">
        {{ __('Edit Discussion') }}
    </x-slot>

    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('firefly.discussion.update', [$discussion->id, $discussion->slug]) }}">
        @method('PUT')
        @csrf

        <!-- Title -->
        <div>
            <x-label for="title" :value="__('Title')" />

            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $discussion->title)" required autofocus />
        </div>

        <div class="mt-4">
            <x-button>
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection
