@extends('firefly::layouts.app')

@section('content')
@if (Auth::check())
    <div class="container mx-auto">
        <a href="{{ route('firefly.group.show', $group) }}">
            {{ __('Back to Group') }}
        </a>
    </div>
@endif

<x-card>
    <x-slot name="title">
        {{ __('Edit Group') }}
    </x-slot>

    <x-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('firefly.group.update', $group) }}">
        @method('PUT')
        @csrf

        <!-- Name -->
        <div>
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $group->name)" required autofocus />
        </div>

        <!-- Color -->
        <div class="mt-4">
            <x-label for="color" :value="__('Color')" />

            <x-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color', $group->color)" required />
        </div>

        @if (config('firefly.private_groups'))
            <!-- Is Private? -->
            <div class="block mt-4">
                <label for="is_private" class="inline-flex items-center">
                    <input id="is_private" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_private">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Is Private?') }}</span>
                </label>
            </div>
        @endif

        <div class="mt-4">
            <x-button>
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection
