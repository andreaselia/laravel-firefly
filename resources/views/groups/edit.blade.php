@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex">
            <h1 class="mb-0">{{ __('Edit Group') }}</h1>
        </div>

        @if (Auth::check())
            <a class="btn btn-sm btn-secondary" href="{{ route('firefly.group.show', $group) }}">{{ __('Back to Group') }}</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firefly.group.update', $group) }}" method="POST">
                @method('PUT')
                @csrf
                
                <div class="form-group">
                    <label for="title">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $group->name) }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="title">{{ __('Color') }}</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $group->color) }}" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" required>

                    @if ($errors->has('color'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('color') }}</strong>
                        </span>
                    @endif
                </div>

                @if (config('firefly.private_groups'))
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="is_private" value="1" name="is_private" class="custom-control-input"{{ $group->is_private ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_private">Is Private?</label>
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
