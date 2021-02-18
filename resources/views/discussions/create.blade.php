@extends('firefly::layouts.app')

@section('content')
<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
    {{ __('New Discussion') }}
</h2>

<x-card class="mt-4">
    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('firefly.discussion.store', $group) }}">
        @csrf

        <!-- Title -->
        <div>
            <x-label for="title" :value="__('Title')" />

            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
        </div>

        <!-- Content -->
        <div class="mt-4">
            <x-label for="content" :value="__('Content')" />

            <x-textarea id="content" class="block mt-1 w-full" type="text" name="content" required>{{ old('content') }}</x-textarea>
        </div>

        <div class="mt-4">
            <x-button>
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection
