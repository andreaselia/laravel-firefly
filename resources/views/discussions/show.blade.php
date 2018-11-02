@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <h1 class="mb-0">{{ $discussion->title }}</h1>

            @if ($discussion->stickied_at)
                <i class="icon icon-stuck ml-2" data-toggle="tooltip" title="{{ __('Stickied') }}"></i>
            @endif

            @if ($discussion->locked_at)
                <i class="icon icon-locked ml-2" data-toggle="tooltip" title="{{ __('Locked') }}"></i>
            @endif
        </div>

        @if (Auth::check())
            @include('firefly::partials.discussion-options')
        @endif
    </div>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <div class="post-item">
                    <div class="post-item-meta d-flex justify-content-between">
                        {{ $post->created_at->diffForHumans() }}

                        <div>
                            @can ('update', $post)
                                <a href="{{ route('firefly.post.edit', $post) }}">
                                    {{ __('Edit') }}
                                </a>
                            @endcan

                            @can ('delete', $post)
                                <a class="ml-2" href="{{ route('firefly.post.delete', [$discussion->id, $discussion->slug, $post]) }}" onclick="event.preventDefault(); document.getElementById('delete-post-{{ $post->id }}-form').submit();">{{ __('Delete') }}</a>

                                <form id="delete-post-{{ $post->id }}-form" action="{{ route('firefly.post.delete', [$discussion->id, $discussion->slug, $post]) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div><strong>{{ $post->user->name }}</strong> {{ $post->content }}</div>
                </div>
            </div>
        </div>
    @endforeach

    @can ('create', Firefly\Post::class)
        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('firefly.post.store', [$discussion->id, $discussion->slug]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="content">{{ __('Content') }}</label>
                        <textarea name="content" id="content" class="form-control" rows="3">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-blue">
                        {{ __('Submit') }}
                    </button>
                </form>
            </div>
        </div>
    @endcan
</div>
@endsection
