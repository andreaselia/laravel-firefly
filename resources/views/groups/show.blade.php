@extends('firefly::layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <h1 class="mb-0">{{ $group->name }}</h1>

            <div class="group-display group-display-clear rounded-circle mb-0 ml-3" style="background: {{ $group->color }};"></div>

            @if ($group->is_private)
                <i class="icon icon-private ml-2" data-toggle="tooltip" title="{{ __('Private') }}"></i>
            @endif
        </div>

        @if (Auth::check() && Auth::user()->can('create', Firefly\Models\Discussion::class))
            <div class="d-flex">
                <a href="{{ route('firefly.discussion.create', $group) }}" class="btn btn-sm btn-primary mr-3">
                    {{ __('New Discussion') }}
                </a>

                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Manage Group') }}
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @can ('update', $group)
                            <a class="dropdown-item" href="{{ route('firefly.group.edit', $group) }}">{{ __('Edit') }}</a>
                        @endcan

                        @can ('delete', $group)
                            <a class="dropdown-item text-danger" href="{{ route('firefly.group.delete', $group) }}" onclick="event.preventDefault(); document.getElementById('delete-group-form').submit();">Delete</a>

                            <form id="delete-group-form" action="{{ route('firefly.group.delete', $group) }}" method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endcan
                    </div>
                </div>
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
