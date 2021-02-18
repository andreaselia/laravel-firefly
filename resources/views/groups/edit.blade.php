@extends('firefly::layouts.app')

@section('content')
@if (Auth::check())
    <a class="flex items-center font-medium text-sm" href="{{ route('firefly.group.show', $group) }}">
        <svg class="mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        {{ __('Back to Group') }}
    </a>
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
