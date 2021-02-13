@extends('firefly::layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-2">
            <div class="text-2xl font-bold">{{ $discussion->title }}</div>

            @foreach ($discussion->groups as $group)
                <a href="{{ route('firefly.group.show', $group) }}" class="rounded-full text-white font-medium text-xs px-2 py-1" style="background-color: {{ $group->color }};">
                    {{ $group->name }}
                </a>
            @endforeach

            <div class="flex space-x-1">
                @if ($discussion->pinned_at)
                    <x-pin-icon />
                @endif

                @if ($discussion->locked_at)
                    <x-lock-icon />
                @endif
            </div>
        </div>

        @if (Auth::check())
            @include('firefly::partials.discussion-options')
        @endif
    </div>

    @foreach ($posts as $post)
        <x-card max-width="sm:max-w-none">
            <div class="flex justify-between items-center">
                <div class="text-sm">
                    {{ __('Posted by') }} <span class="font-semibold">{{ $post->user->name }}</span> - {{ $post->created_at->diffForHumans() }}
                </div>

                <div class="flex space-x-1">
                    @can ('update', $post)
                        <a href="{{ route('firefly.post.edit', $post) }}">
                            <x-button>
                                {{ __('Edit') }}
                            </x-button>
                        </a>
                    @endcan

                    @can ('delete', $post)
                        <x-button onclick="event.preventDefault(); document.getElementById('delete-post-{{ $post->id }}-form').submit();">
                            {{ __('Delete') }}
                        </x-button>

                        <form id="delete-post-{{ $post->id }}-form" action="{{ route('firefly.post.delete', [$discussion->id, $discussion->slug, $post]) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    @endcan
                </div>
            </div>

            <div>
                {!! nl2br(e($post->content)) !!}
            </div>
        </x-card>
    @endforeach

    @can ('reply', $discussion)
        <x-card max-width="sm:max-w-none">
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('firefly.post.store', [$discussion->id, $discussion->slug]) }}" method="POST">
                @csrf

                <div>
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
    @endcan
</div>
@endsection
