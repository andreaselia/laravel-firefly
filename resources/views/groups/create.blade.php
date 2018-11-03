@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('New Group') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('firefly.group.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="title">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="color">{{ __('Color') }}</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}" required>

                    @if ($errors->has('color'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('color') }}</strong>
                        </span>
                    @endif
                </div>

                @if (config('firefly.private_groups'))
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="is_private" value="1" name="is_private" class="custom-control-input">
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
