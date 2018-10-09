@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            @foreach ($posts as $post)
                <li class="list-group-item list-group-item-action">
                    <p>{{ __('Posted by') }} {{ $post->user->name }}, {{ $post->created_at->diffForHumans() }}</p>

                    <p class="mb-0">{{ $post->content }}</p>
                </li>
            @endforeach

            {{-- TODO: move to modal or keep inline? --}}
            <form action="{{ route('post.store', [$discussion->id, $discussion->slug]) }}" method="POST">
                <div class="form-group">
                    <label for="content">{{ __('Content') }}</label>
                    <textarea name="content" id="content" class="form-control" rows="3">{{ old('content') }}</textarea>
                </div>

                <button type="submit" class="btn btn-blue">{{ __('Submit Reply') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
