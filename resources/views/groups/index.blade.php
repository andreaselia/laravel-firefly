@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Groups') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Group::class))
            <button type="button" class="btn btn-primary" @click.prevent="toggleModal('newGroup')">
                {{ __('New Group') }}
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
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="group-item d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-0">
                                    <a href="{{ route('firefly.group.show', $group) }}">
                                        {{ $group->name }}
                                    </a>
                                </h3>

                                <div class="group-item-meta">
                                    {{ count($group->discussions) }} {{ __('discussions') }}
                                </div>
                            </div>

                            <div class="group-display rounded-circle mb-0" style="background: {{ $group->color }};"></div>
                        </div>
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
