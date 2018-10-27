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
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="title">{{ __('Color') }}</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
