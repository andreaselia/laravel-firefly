@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex">
            <h1 class="mb-0">{{ $group->name }}</h1>
            <div class="group-display group-display-clear rounded-circle mb-0 ml-3" style="background: {{ $group->color }};"></div>
        </div>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Discussion::class))
            <div class="d-flex">
                <a href="{{ route('firefly.discussion.create', $group) }}" class="btn btn-sm btn-primary mr-3">
                    {{ __('New Discussion') }}
                </a>

                <a href="#" class="btn btn-sm btn-outline-primary mr-3">Edit</a>
                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
            </div>
        @endif
    </div>

    @if (! count($discussions))
        <div class="card">
            <div class="card-body">
                <div class="alert alert-yellow mb-0" role="alert">
                    <strong>{{ __('Holy guacamole!') }}</strong><br>
                    {{ __('There are no discussions; You could be the first to create one.') }}
                </div>
            </div>
        </div>
    @endif

    @include('firefly::partials.discussion-list')
</div>
@endsection
