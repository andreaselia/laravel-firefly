@extends('firefly::layouts.app')

@section('content')
@if (Auth::check())
    <div class="container mx-auto">
        <a href="{{ route('firefly.discussion.show', [$post->discussion->id, $post->discussion->slug]) }}">
            {{ __('Back to Discussion') }}
        </a>
    </div>
@endif

<x-card>
    <x-slot name="title">
        {{ __('Edit Post') }}
    </x-slot>

    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('firefly.post.update', [$post->discussion->id, $post->discussion->slug, $post]) }}">
        @method('PUT')
        @csrf

        <!-- Content -->
        <div>
            <x-label for="content" :value="__('Content')" />

            <x-textarea id="content" class="block mt-1 w-full" type="text" name="content" required autofocus>{{ old('content', $post->content) }}</x-textarea>
        </div>

        <div class="mt-4">
            <x-button>
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection
