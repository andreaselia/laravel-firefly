@extends('firefly::layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-4">
            <a href="{{ route('discussion.create') }}" class="btn btn-primary">{{ __('New Discussion') }}</a>

            <ul class="list-group">
                @if (! count($groups))
                    <li class="list-group-item">
                        {{ __('Uh oh, there are no groups.') }}
                    </li>
                @endif

                @foreach ($groups as $group)
                    <a href="{{ route('group.show', $group) }}" class="list-group-item" style="background-color: {{ $group->color }};">{{ $group->name }}</a>
                @endforeach
            </ul>
        </div>

        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">{{ __('Discussions') }}</div>
                </div>

                <ul class="list-group list-group-flush">
                    @if (! count($discussions))
                        <li class="list-group-item">
                            {{ __('Uh oh, there are no discussions.') }}
                        </li>
                    @endif

                    @each('firefly::partials.discussion', $discussions, 'discussion')
                </ul>

                {!! $discussions->links() !!}
            </div>
        </div>
    </div>
@endsection
