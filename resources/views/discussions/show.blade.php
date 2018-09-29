@extends('firefly::layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">{{ $discussion->title }}</div>
        </div>


        <ul class="list-group list-group-flush">
            @foreach ($posts as $post)
                <li class="list-group-item list-group-item-action">
                    <p>{{ __('Posted by') }} {{ $post->user->name }}, {{ $post->created_at->diffForHumans() }}</p>

                    <p class="mb-0">{{ $post->content }}</p>
                </li>
            @endforeach
        </ul>

        <div class="card-body">
            <form action="{{ route('post.store') }}" method="POST">
                <div class="form-group">
                    <label for="content">{{ __('Content') }}</label>
                    <textarea name="content" id="content" class="form-control" rows="3">{{ old('content') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Submit Reply') }}</button>
            </form>
        </div>
    </div>
@endsection
