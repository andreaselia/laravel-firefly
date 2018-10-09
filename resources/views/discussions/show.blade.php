@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            @foreach ($posts as $post)
                <div class="list-group-item list-group-item-action">
                    <p>{{ $post->user->name }} {{ $post->created_at->diffForHumans() }}</p>

                    <p>{{ $post->content }}</p>
                </div>
            @endforeach

            {{-- TODO: move to modal or keep inline? --}}
            <div class="mt-5">
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
</div>
@endsection
