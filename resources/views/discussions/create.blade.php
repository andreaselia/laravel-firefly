@extends('firefly::layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">{{ __('New Discussion') }}</div>

            <form role="form">
                <div class="form-group">
                    <label for="title">{{ __('Title') }}:</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="content">{{ __('Content') }}:</label>
                    <textarea name="content" id="content" class="form-control" rows="12">{{ old('content') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
@endsection
