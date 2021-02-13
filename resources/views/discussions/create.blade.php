@extends('firefly::layouts.app')

@section('content')
<x-card>
    <x-slot name="title">
        {{ __('New Discussion') }}
    </x-slot>

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

            <x-textarea id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required />
        </div>

        <div class="mt-4">
            <x-button>
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection
