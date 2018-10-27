@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-0">{{ __('Discussions') }}</h1>

    @include('firefly::partials.discussion-list')
</div>
@endsection
