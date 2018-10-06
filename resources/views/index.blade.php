@extends('firefly::layouts.app')

@section('content')
@if (count($groups))
    <a href="{{ route('discussion.create') }}" class="btn btn-primary">{{ __('New Discussion') }}</a>
@endif

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
    
<h1>{{ __('Discussions') }}</h1>

<ul class="list-group list-group-flush">
    @if (! count($discussions))
        <li class="list-group-item">
            {{ __('Uh oh, there are no discussions.') }}
        </li>
    @endif

    @each('firefly::partials.discussion', $discussions, 'discussion')
</ul>

{!! $discussions->links() !!}
@endsection
