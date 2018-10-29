@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Discussions') }}</h1>

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

    {!! $discussions->links(config('firefly.pagination.view')) !!}
</div>
@endsection
