@extends('firefly::layouts.app')

@section('hero')
<header class="hero">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ __('Groups') }}</h1>

            @if (Auth::check() && Auth::user()->can('create', Firefly\Group::class))
                <button type="button" class="btn btn-yellow" @click.prevent="toggleModal('newGroup')">
                    {{ __('Add Group') }}
                </button>
            @endif
        </div>

        <p>{{ __('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis quos aut sequi totam ducimus nihil, vitae repellendus expedita quas.') }}</p>
    </div>
</header>
@endsection

@section('content')
<section class="gradient">
    <div class="container">
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
                            <a href="{{ route('firefly.group.show', $group) }}" class="list-item-name">{{ $group->name }}</a>
                            <small class="text-muted">32 discussions</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {!! $groups->links() !!}
    </div>
</section>
@endsection

@section('modals')
@include('firefly::modals.new-group')
@endsection
