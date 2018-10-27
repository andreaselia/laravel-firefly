@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">{{ __('Groups') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Group::class))
            <button type="button" class="btn btn-yellow" @click.prevent="toggleModal('newGroup')">
                {{ __('Add Group') }}
            </button>
        @endif
    </div>

    @if (! count($groups))
        <div class="alert alert-yellow text-center" role="alert">
            {{ __('Uh oh, there are no groups.') }}
        </div>
    @endif

    <div class="row">
        @foreach ($groups as $group)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="group-item d-flex align-items-center">
                    <span class="group-color mr-3" style="background-color: {{ $group->color }};"></span>

                    <div>
                        <a href="{{ route('firefly.group.show', $group) }}" class="list-item-head">{{ $group->name }}</a>
                        <div class="list-item-meta">32 discussions</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {!! $groups->links() !!}
</div>
@endsection

@section('modals')
@include('firefly::modals.new-group')
@endsection
