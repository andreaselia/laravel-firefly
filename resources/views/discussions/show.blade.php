@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex">
            <h1 class="mb-0">{{ $discussion->title }}</h1>
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
                        <a href="#">hide</a>
                    </div>

                    <div><strong>{{ $post->user->name }}</strong> {{ $post->content }}</div>
                </div>
            </div>
        </div>
    @endforeach

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
</div>
@endsection
