@extends('firefly::layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">{{ __('Discussions') }}</div>
        </div>

        <ul class="list-group list-group-flush">
            @if (count($discussions))
                @each('firefly::partials.discussion', $discussions, 'discussion')
            @else
                <li class="list-group-item">
                    {{ __('Uh oh, there are no discussions.') }}
                </li>
            @endif
        </ul>

        {!! $discussions->links() !!}
    </div>
@endsection
