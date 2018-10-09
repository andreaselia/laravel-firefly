@extends('firefly::layouts.app')

@section('hero')
<header class="hero">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>{{ $group->name }}</h1>

                    {{-- TODO: auth/policy check --}}
                    <a href="#" class="btn btn-yellow" @click.prevent="toggleModal('newDiscussion')">New Discussion</a>
                </div>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis quos aut sequi totam ducimus nihil, vitae repellendus expedita quas nemo.</p>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @include('firefly::partials.discussion-list')
        </div>
    </div>
</div>
@endsection

@section('modals')
@include('firefly::modals.new-discussion')
@endsection
