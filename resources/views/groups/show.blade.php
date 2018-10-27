@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">{{ $group->name }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Discussion::class))
            <button type="button" class="btn btn-yellow" @click.prevent="toggleModal('newDiscussion')">
                {{ __('New Discussion') }}
            </button>
        @endif
    </div>

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
