@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Edit Post') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firefly.post.update', [$post->discussion->id, $post->discussion->slug, $post]) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="content">{{ __('Content') }}</label>
                    <textarea name="content" id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" rows="3" required>{{ old('content', $post->content) }}</textarea>

                    @if ($errors->has('content'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
