@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex">
            <h1 class="mb-0">{{ __('Edit Discussion') }}</h1>
        </div>

        @if (Auth::check())
            <a class="btn btn-sm btn-secondary" href="{{ route('firefly.discussion.show', [$discussion->id, $discussion->slug]) }}">{{ __('Back to Discussion') }}</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firefly.discussion.update', [$discussion->id, $discussion->slug]) }}" method="POST">
                @method('PUT')
                @csrf
                
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $discussion->title) }}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" required autofocus>

                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
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
