@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('Groups') }}</h1>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Group::class))
            <a href="{{ route('firefly.group.create') }}" class="btn btn-sm btn-primary">
                {{ __('New Group') }}
            </a>
        @endif
    </div>

    <div class="row">
        @if (! count($groups))
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-yellow mb-0" role="alert">
                            <strong>{{ __('Holy guacamole!') }}</strong><br>
                            {{ __('There are no groups; You could be the first to create one.') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($groups as $group)
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <a href="{{ route('firefly.group.show', $group) }}" class="card">
                    <div class="card-body">
                        <div class="group-item d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-0">{{ $group->name }}</h3>

                                <div class="group-item-meta">
                                    {{ count($group->discussions) }} {{ __('discussions') }}
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                @if ($group->is_private)
                                    <i class="icon icon-private mr-2" data-toggle="tooltip" title="{{ __('Private') }}"></i>
                                @endif

                                <div class="group-display rounded-circle mb-0" style="background: {{ $group->color }};"></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {!! $groups->links(config('firefly.pagination.view')) !!}
</div>
@endsection
