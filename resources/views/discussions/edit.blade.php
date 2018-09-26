@extends('firefly::layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">{{ __('Edit Discussion') }}</div>

            <form action="/" method="POST">
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="title">{{ __('Title') }}:</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $discussion->title) }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="content">{{ __('Content') }}:</label>
                    <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $discussion->content) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
            </form>

            <form action="/" method="POST">
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger">{{ __('Delete Discussion') }}</button>
            </form>
        </div>
    </div>
@endsection
