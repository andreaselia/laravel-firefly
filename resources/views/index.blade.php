@extends('firefly::layouts.app')

@section('hero')
<header class="hero">
    <div class="container">
        <h1>{{ __('Discussions') }}</h1>

        <p>{{ __('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis quos aut sequi totam ducimus nihil, vitae repellendus expedita quas.') }}</p>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    @include('firefly::partials.discussion-list')
</div>
@endsection
